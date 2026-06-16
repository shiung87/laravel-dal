<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminAuditLogController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSsoController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for the admin panel. Guest routes handle the login form,
| while authenticated + admin-middleware routes protect the dashboard.
|
*/

// Admin guest routes (login page — only accessible when not logged in as admin)
Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login']);
});

// Admin protected routes (require auth + is_admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // User management
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::post('users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::post('users/{user}/send-password-reset', [AdminUserController::class, 'sendPasswordReset'])->name('users.send-password-reset');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    // Audit log
    Route::get('audit-log', [AdminAuditLogController::class, 'index'])->name('audit-log');
    // SSO Settings
    Route::get('sso', [AdminSsoController::class, 'show'])->name('sso.show');
    Route::post('sso', [AdminSsoController::class, 'update'])->name('sso.update');
});
