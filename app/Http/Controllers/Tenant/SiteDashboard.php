<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\RolesEnum;
use Illuminate\Support\Facades\Auth;

class SiteDashboard extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasRole([RolesEnum::SITEMANAGER->value,RolesEnum::SITEUSER->value])) {
            abort(code: 403);
        }
        $totalSiteUser = User::whereHas('roles', function ($query) {
            $query->where('name', RolesEnum::SITEUSER); // Only include users with the driver role
            })
            ->count();
            $totalSiteDriver = User::whereHas('roles', function ($query) {
                $query->where('name', RolesEnum::SITEDRIVER); // Only include users with the driver role
                })
                ->count();    
        return view('site.dashboard',compact('totalSiteUser','totalSiteDriver'));
    }
}
