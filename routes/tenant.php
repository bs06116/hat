<?php


use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\SiteDashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\UserController;
use App\Http\Controllers\Tenant\DriverController;
use App\Http\Controllers\Tenant\LocationController;
use App\Http\Controllers\Tenant\JobController;
use App\RolesEnum;


/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'siteLogin'])->name('site.login');
        Route::post('login', action: [AuthenticatedSessionController::class, 'store'])->name('site.login');
    });
    Route::middleware(['auth'])->group(function () {
        // Site Dashboard
        Route::get('SiteDashboard', [SiteDashboard::class, 'index'])->name('site.dashboard');
    
        // Profile Routes
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
        // User Management
        Route::resource('users', UserController::class);
        Route::post('/users/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    
        // Driver Management
        Route::resource('drivers', DriverController::class);
        Route::post('/drivers/toggle-status', [DriverController::class, 'toggleStatus'])->name('drivers.toggleStatus');
    
        // Location Management
        Route::resource('locations', LocationController::class);
    
        // Job Management
        Route::get('/jobs/available', [JobController::class, 'availableJobs'])->name('jobs.available');
        Route::get('/jobs/won',  [JobController::class, 'wonJobs'])->name('jobs.won');
        Route::get('/jobs/{job}/available',  [JobController::class, 'showAavailableJob'])->name('jobs.showAavailableJob');
        Route::post('/jobs/{job}/bid',  [JobController::class, 'submitBid'])->name('jobs.submitBid');
      // Route to assign a job to a driver
        Route::post('/jobs/{job}/assign/{driver}', [JobController::class, 'assignJob'])->name('job.assign');
        Route::resource('jobs', JobController::class);

        // Driver Dashboardphp
        Route::get('DriverDashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
    });
  
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
});
