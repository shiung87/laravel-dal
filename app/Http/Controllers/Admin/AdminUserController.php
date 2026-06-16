<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class AdminUserController extends Controller
{
    /**
     * Display a paginated list of users with optional search & role filter.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $role   = $request->input('role', 'all');

        $query = User::query()->orderBy('created_at', 'desc');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role === 'admin') {
            $query->where('is_admin', true);
        } elseif ($role === 'regular') {
            $query->where('is_admin', false);
        }

        $users        = $query->paginate(15)->withQueryString();
        $totalUsers   = User::count();
        $adminUsers   = User::where('is_admin', true)->count();
        $regularUsers = $totalUsers - $adminUsers;

        return view('admin.users.index', compact(
            'users', 'search', 'role', 'totalUsers', 'adminUsers', 'regularUsers'
        ));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin'          => ['boolean'],
            'send_verification' => ['boolean'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => $request->boolean('is_admin'),
        ]);

        if ($request->boolean('send_verification') && $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }

        AuditLogger::log(
            action:    'user_create',
            subject:   $user,
            newValues: ['name' => $user->name, 'email' => $user->email, 'is_admin' => $user->is_admin],
        );

        return redirect()->route('admin.users.index')
            ->with('success', "User \"{$user->name}\" created successfully.");
    }

    /**
     * Toggle the is_admin flag for a user.
     */
    public function toggleAdmin(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own admin status.');
        }

        $wasAdmin    = $user->is_admin;
        $user->is_admin = !$wasAdmin;
        $user->save();

        $action = $wasAdmin ? 'user_demote' : 'user_promote';
        $label  = $wasAdmin ? 'demoted to Regular User' : 'promoted to Admin';

        AuditLogger::log(
            action:    $action,
            subject:   $user,
            oldValues: ['is_admin' => $wasAdmin],
            newValues: ['is_admin' => $user->is_admin],
        );

        return back()->with('success', "\"{$user->name}\" has been {$label}.");
    }

    /**
     * Send a password-reset link email to the user.
     */
    public function sendPasswordReset(User $user)
    {
        $status = Password::sendResetLink(['email' => $user->email]);

        if ($status === Password::RESET_LINK_SENT) {
            AuditLogger::log(
                action:  'password_reset_sent',
                subject: $user,
            );

            return back()->with('success', "Password reset email sent to \"{$user->email}\".");
        }

        return back()->with('error', 'Failed to send password reset email: ' . __($status));
    }

    /**
     * Delete a user account.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;

        AuditLogger::log(
            action:    'user_delete',
            subject:   $user,
            oldValues: ['name' => $user->name, 'email' => $user->email, 'is_admin' => $user->is_admin],
        );

        $user->delete();

        return back()->with('success', "User \"{$name}\" has been deleted.");
    }
}
