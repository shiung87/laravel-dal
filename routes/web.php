<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DalEntryController;
use App\Http\Controllers\Auth\SsoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// SSO routes — public (unauthenticated users need to reach these)
Route::get('/auth/sso/redirect', [SsoController::class, 'redirect'])->name('sso.redirect');
Route::get('/auth/sso/callback', [SsoController::class, 'callback'])->name('sso.callback');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	
		
	/*
    Route::get('/dal-list', function () {
		return view('dal-list');
	});

	Route::get('/dal-table', function () {
		return view('dal-table');
	});
    */

    // DAL Maintenance — view available to all authenticated users
    Route::get('/dal-manage', [DalEntryController::class, 'index'])->name('dal.manage.index');

    // Returns the next row number for a given type + section_title (used by create form JS)
    Route::get('/dal-manage/next-row-number', [DalEntryController::class, 'nextRowNumber'])->name('dal.manage.next-row-number');

    // DAL Maintenance — write operations restricted to admins only
    Route::middleware('admin')->group(function () {
        Route::get('/dal-manage/create', [DalEntryController::class, 'create'])->name('dal.manage.create');
        Route::post('/dal-manage', [DalEntryController::class, 'store'])->name('dal.manage.store');
        Route::get('/dal-manage/{dalEntry}/edit', [DalEntryController::class, 'edit'])->name('dal.manage.edit');
        Route::put('/dal-manage/{dalEntry}', [DalEntryController::class, 'update'])->name('dal.manage.update');
        Route::delete('/dal-manage/{dalEntry}', [DalEntryController::class, 'destroy'])->name('dal.manage.destroy');
    });
});

require __DIR__.'/auth.php';

