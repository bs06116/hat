<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use App\RolesEnum;
use App\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Requests\TenantStoreRequest;
use Hash;


class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Fetch all tenants from the database
       $tenants = Tenant::with(['user', 'domain'])->get();
       return view('tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(view: 'tenants/create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantStoreRequest $request)
    {  
         // Create Tenant
         $tenant = Tenant::create([
            //'id' => uniqid(), // Or use auto-incrementing ID
            'name' => $request->site_name,
        ]);
        // Associate Domain
        $tenant->domains()->create(['domain' => $request->domain_name.'.'.config('app.domain')]);

        // Create Site Manager User
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $tenant->id,
        ]);
        // Assign Role
        $user->assignRole(RolesEnum::SITEMANAGER);
        return redirect()->back()->with('success', value: 'Site created successfully.');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
       // Optional: Delete related data like users or domains if needed
         $tenant->user()->delete(); 
         $tenant->domain()->delete();
        // Delete the tenant
        $tenant->delete();

        // Redirect back with success message
        return redirect()->route('tenants.index')->with('message', 'Tenant deleted successfully');
    }
    public function toggleStatus(Request $request)
    {
        $user = User::findOrFail($request->user_id);
    
        // Toggle status
        if ($user->status === UserStatus::ACTIVE->value) {
            $user->status = UserStatus::DEACTIVE->value;
        } else {
            $user->status = UserStatus::ACTIVE->value;
        }
    
        $user->save();
    
        return response()->json([
            'success' => true,
            //'message' => 'Status changed successfully!',
            'message' => " Status changed successfully!"
        ]);
    }
    
}
