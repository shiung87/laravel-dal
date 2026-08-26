<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminAuditLogController;
use App\Http\Controllers\Admin\AdminDalCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\Admin\AdminEmailController;
use App\Http\Controllers\Admin\AdminMappingController;
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

    // DAL Category Master
    Route::get('categories', [AdminDalCategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [AdminDalCategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{category}', [AdminDalCategoryController::class, 'update'])->name('categories.update');
    Route::post('categories/{category}/toggle-active', [AdminDalCategoryController::class, 'toggleActive'])->name('categories.toggle-active');
    Route::delete('categories/{category}', [AdminDalCategoryController::class, 'destroy'])->name('categories.destroy');

    // Department Master
    Route::get('departments', [AdminDepartmentController::class, 'index'])->name('departments.index');
    Route::post('departments', [AdminDepartmentController::class, 'store'])->name('departments.store');
    Route::put('departments/{department}', [AdminDepartmentController::class, 'update'])->name('departments.update');
    Route::post('departments/{department}/toggle-active', [AdminDepartmentController::class, 'toggleActive'])->name('departments.toggle-active');
    Route::delete('departments/{department}', [AdminDepartmentController::class, 'destroy'])->name('departments.destroy');

    // Category - Department Mapping Matrix
    Route::get('mappings', [AdminMappingController::class, 'index'])->name('mappings.index');
    Route::post('mappings', [AdminMappingController::class, 'update'])->name('mappings.update');

    // User management
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::post('users/{user}/update-department', [AdminUserController::class, 'updateDepartment'])->name('users.update-department');
    Route::post('users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::post('users/{user}/send-password-reset', [AdminUserController::class, 'sendPasswordReset'])->name('users.send-password-reset');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Audit log
    Route::get('audit-log', [AdminAuditLogController::class, 'index'])->name('audit-log');

    // SSO Settings
    Route::get('sso', [AdminSsoController::class, 'show'])->name('sso.show');
    Route::post('sso', [AdminSsoController::class, 'update'])->name('sso.update');

    // Email Notification Settings & Test
    Route::get('email', [AdminEmailController::class, 'show'])->name('email.show');
    Route::post('email', [AdminEmailController::class, 'update'])->name('email.update');
    Route::post('email/test', [AdminEmailController::class, 'testEmail'])->name('email.test');
});
