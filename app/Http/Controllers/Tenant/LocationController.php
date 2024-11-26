<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationStoreRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Location;
use App\RolesEnum;
use App\UserStatus;
use Illuminate\Validation\Rules;
use App\Http\Requests\DriverStoreRequest;
use App\Http\Requests\DriverUpdateRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

use Hash;

class LocationController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $locations = Location::orderBy( 'created_at', 'desc')->get();
        return view('site.location.index', compact('locations'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        return view('site.location.create');
    }

    public function store(LocationStoreRequest $request)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        Location::create($request->all());
        return redirect()->route('locations.index')->with('success', 'Location created successfully!');
    }

    public function edit(Location $location)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        return view('site.location.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $location->update($request->all());

        return redirect()->route('locations.index')->with('success', 'Location updated successfully!');
    }

    public function destroy(Location $location)
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location deleted successfully!');
    }
}
