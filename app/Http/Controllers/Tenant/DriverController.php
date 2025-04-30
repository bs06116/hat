<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use App\RolesEnum;
use App\UserStatus;
use Illuminate\Validation\Rules;
use App\Http\Requests\DriverStoreRequest;
use App\Http\Requests\DriverUpdateRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use Illuminate\Support\Facades\Log;

use Hash;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        if (!Auth::user() || !Auth::user()->hasRole(RolesEnum::SITEDRIVER->value)) {
            abort(code: 403);
        }
        $driver = auth()->user(); // Assuming the driver is authenticated
        $driverDepartmentIds = $driver->departments->pluck('id'); // Get department IDs for the driver
        // Fetch all tenants from the database
        $totalAvailableJobs = Job::where('tenant_id', tenant('id'))->whereIn('id', function ($query) use ($driverDepartmentIds) {
            $query->select('job_id')
                ->from('department_job')
                ->whereIn('department_id', $driverDepartmentIds); // Filter by department IDs
        })->whereDoesntHave('bidders')
            ->count();
        $totalWonJobs = Job::where('tenant_id', tenant('id'))->whereIn('id', function ($query) use ($driverDepartmentIds) {
            $query->select('job_id')
                ->from('department_job')
                ->whereIn('department_id', $driverDepartmentIds); // Filter by department IDs
        })->whereHas('bids', function ($query) use ($driver) {
            $query->where('driver_id', $driver->id)
                ->where('assigned', 1); // Only include assigned bids
        })->count();
        return view('site.driver.dashboard', compact('totalAvailableJobs', 'totalWonJobs'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        // Fetch all tenants from the database
        $drivers = User::with('departments')->whereHas('roles', function ($query) {
            $query->where('name', RolesEnum::SITEDRIVER); // Only include users with the driver role
        })
            ->orderBy('created_at', 'desc')  // Order by latest
            ->paginate(10);
        return view('site.driver.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $departments = Department::all();
        return view('site.driver.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverStoreRequest $request)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        // Create Site Manager User
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'vehicle_type' => $request->vehicle_type,
            'address' => $request->address,
            'phone' => $request->phone,
            'driver_number' => $request->driver_number,
            'rating' => $request->rating,
            'note' => $request->note,
            'password' => Hash::make($request->password),
        ]);
        $user->departments()->attach($request->departments);
        // Assign Role
        $user->assignRole(RolesEnum::SITEDRIVER);
        return redirect()->route('drivers.index')->with('success', value: 'Driver created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $driver)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        // Fetch all tenants from the database

        // Fetch related departments (if applicable)
        $departments = Department::all(); // Assumes you have a departments table     
        return view('site.driver.edit', compact('driver', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DriverUpdateRequest $request, User $driver)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        // Update user details
        $driver->first_name = $request->input('first_name');
        $driver->last_name = $request->input('last_name');
        $driver->vehicle_type = $request->input('vehicle_type');
        $driver->email = $request->input('email');
        // Update the password only if provided
        if ($request->filled('password')) {
            $driver->password = Hash::make($request->input('password'));
        }
        $driver->save();
        // Sync departments if provided (assuming a many-to-many relationship)
        if ($request->has('departments')) {
            $driver->departments()->sync($request->departments);
        }
        // Redirect with a success message
        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }

        try {
            // Retrieve the user by ID
            $user = User::findOrFail($id);

            // Log the user details
            Log::info('Deleting user: ', ['user' => $user->toArray()]);

            // Ensure relationships are correctly defined in the User model
            if (method_exists($user, 'departments')) {
                Log::info('Detaching departments for user: ', ['user_id' => $user->id, 'departments' => $user->departments->pluck('id')->toArray()]);
                $user->departments()->detach();
            }
            if (method_exists($user, 'jobsBids')) {
                Log::info('Detaching job bids for user: ', ['user_id' => $user->id, 'jobsBids' => $user->jobsBids->pluck('id')->toArray()]);
                $user->jobsBids()->detach();
            }

            // Delete the user
            $user->delete();

            // Redirect back with success message
            return redirect()->route('drivers.index')->with('message', 'Driver deleted successfully');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Failed to delete driver: ' . $e->getMessage());

            // Handle the exception and redirect back with an error message
            return redirect()->route('drivers.index')->with('error', 'Failed to delete driver: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Request $request)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value, RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $user = User::findOrFail($request->driver_id);
        // Toggle status
        if ($user->status === UserStatus::ACTIVE) {
            $user->status = UserStatus::DEACTIVE;
        } else {
            $user->status = UserStatus::ACTIVE;
        }
        // Save the user
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Status changed successfully!'
        ]);
    }

}
