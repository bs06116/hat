<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use App\RolesEnum;
use App\UserStatus;
use Illuminate\Validation\Rules;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

use Hash;

class UserController extends Controller
{
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        }
       // Fetch all tenants from the database
       $users = User::whereHas('roles', function ($query) {
                 $query->where('name', RolesEnum::SITEUSER); // Exclude tenant admin role
             })
             ->orderBy('created_at', 'desc')  // Order by latest
             ->get();      
       return view('site.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        }
        return view(view: 'site.user.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    { 
        if (!Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        } 
        // Create Site Manager User
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // Assign Role
        $user->assignRole(RolesEnum::SITEUSER);
        return redirect()->route('users.index')->with('success', value: 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (!Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        }
              // Fetch all tenants from the database
        return view('site.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        if (!Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        }
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
    return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        }
        $user->delete();

        // Redirect back with success message
        return redirect()->route('users.index')->with('message', 'User deleted successfully');
    }
    public function toggleStatus(Request $request)
    {
        if (!Auth::user()->hasRole(RolesEnum::SITEMANAGER->value)) {
            abort(code: 403);
        }
        $user = User::findOrFail($request->user_id);
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
