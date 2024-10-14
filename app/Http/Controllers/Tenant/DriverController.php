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
use App\Http\Requests\UpdateUserRequest;

use Hash;

class DriverController extends Controller
{
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Fetch all tenants from the database
       $drivers = User::whereHas('roles', function ($query) {
        $query->where('name', RolesEnum::SITEDRIVER); // Only include users with the driver role
        })
        ->orderBy('created_at', 'desc')  // Order by latest
        ->get();
       return view('site.driver.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(view: 'site.driver.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverStoreRequest $request)
    {  
        // Create Site Manager User
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);
        // Assign Role
        $user->assignRole(RolesEnum::SITEDRIVER);
        return redirect()->back()->with('success', value: 'Driver created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
              // Fetch all tenants from the database
        return view('site.driver.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

    // Update user details
    $user->first_name = $request->input('first_name');
    $user->last_name = $request->input('last_name');
    $user->email = $request->input('email');
    // Update the password only if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    $user->save();

    // Redirect with a success message
    return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        // Redirect back with success message
        return redirect()->route('drivers.index')->with('message', 'Driver deleted successfully');
    }
    public function toggleStatus(Request $request)
    {
        $user = User::findOrFail($request->driver_id);
        // Toggle status
        if ($user->status === UserStatus::ACTIVE->value) {
            $user->status = UserStatus::DEACTIVE->value;
        } else {
            $user->status = UserStatus::ACTIVE->value;
        }
    
        return response()->json([
            'success' => true,
            //'message' => 'Status changed successfully!',
            'message' => " Status changed successfully!"
        ]);
    }
}
