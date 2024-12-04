<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreManagementController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Login and Logout Routes
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Store Management
    Route::post('/store-management/store', [StoreManagementController::class, 'store'])->name('storeManagement.store');
    Route::post('/store-management/update-store', [StoreManagementController::class, 'updateStore'])->name('storeManagement.updateStore');
    Route::get('/store-management/get-stores', [StoreManagementController::class, 'getStores'])->name('storeManagement.getStores');
    Route::post('/store-management/view-store', [StoreManagementController::class, 'viewStore'])->name('storeManagement.viewStore');
    Route::get('/store-management', [StoreManagementController::class, 'index'])->name('storeManagement.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
