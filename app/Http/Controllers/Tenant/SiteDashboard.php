<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteDashboard extends Controller
{
    public function index()
    {
        return view('site.dashboard');
    }
}
