<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home');
});

// Registrasi
Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi');
Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi.store');
Route::post('/registrasi/check-subdomain', [RegistrasiController::class, 'checkSubdomain'])->name('registrasi.check-subdomain');
Route::get('/registrasi/success', [RegistrasiController::class, 'success'])->name('registrasi.success');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin (protected)
Route::middleware('auth')->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.users.status');
    Route::post('/admin/users/{id}/send-credentials', [AdminController::class, 'sendCredentials'])->name('admin.users.send-credentials');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    
    // Settings
    Route::get('/admin/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('admin.settings.update');
});
