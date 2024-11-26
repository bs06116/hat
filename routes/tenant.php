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
use App\Http\Controllers\Tenant\InvoiceController;

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
Route::get('/', function () {
    return redirect(env('APP_URL'));
})->name('login');
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
         Route::get('user/profile', [UserController::class, 'profileEdit'])->name('user.profile.edit');
         Route::patch('user/profile', [UserController::class, 'profileUpdate'])->name('user.profile.update');

         // Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        // Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
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
        Route::get('/departments/{id}/job-titles',  [JobController::class, 'getJobTitles'])->name('get.job.title');;

        // Driver Dashboard
        Route::get('DriverDashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
        // Route::get('/jobs/completed/invoice', action: [InvoiceController::class, 'index'])->name('jobs.completed.invoice');
        Route::get('invoice', action: [InvoiceController::class, 'index'])->name('invoice.index');
        Route::post('/invoices/toggle-approval', [InvoiceController::class, 'toggleApproval'])->name('invoices.toggleApproval');
        Route::get('/invoices/driver/approved', [InvoiceController::class, 'approvedInvoice'])->name('invoices.dirver.approved');

    });
  
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
});
