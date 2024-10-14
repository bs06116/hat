<?php


use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\SiteDashboard;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\UserController;
use App\Http\Controllers\Tenant\DriverController;

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
        Route::get('SiteDashboard', [SiteDashboard::class, 'index'])->name('site.dashboard');
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::resource('users', controller: UserController::class);
        Route::post('/users/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::resource('drivers', controller: DriverController::class);
        Route::post('/drivers/toggle-status', [DriverController::class, 'toggleStatus'])->name('drivers.toggleStatus');
    });


    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
});
