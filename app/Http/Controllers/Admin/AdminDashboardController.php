<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $totalUsers = User::count();
        $adminUsers = User::where('is_admin', true)->count();
        $regularUsers = $totalUsers - $adminUsers;

        return view('admin.dashboard', compact('totalUsers', 'adminUsers', 'regularUsers'));
    }
}
