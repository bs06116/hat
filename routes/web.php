<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
    Route::get('/', function () {
        return view('welcome');
    });

// Route::get('/AdminDashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('tenants', controller: TenantController::class);
   // Route::patch('/tenants/{tenant}/toggle-status', [TenantController::class, 'toggleStatus'])->name('tenants.toggleStatus');
   Route::post('/tenants/toggle-status', [TenantController::class, 'toggleStatus'])->name('tenants.toggleStatus');

});

require __DIR__.'/auth.php';
