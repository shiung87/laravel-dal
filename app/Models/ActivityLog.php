<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public $timestamps = false; // we only have created_at, set via useCurrent()

    protected $fillable = [
        'user_id', 'user_name', 'user_email',
        'action', 'subject_type', 'subject_id', 'subject_label',
        'old_values', 'new_values',
        'ip_address', 'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'old_values'  => 'array',
            'new_values'  => 'array',
            'created_at'  => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Human-readable action labels for the UI.
     */
    public static array $actionLabels = [
        'login'              => ['label' => 'Login',               'color' => 'blue'],
        'logout'             => ['label' => 'Logout',              'color' => 'slate'],
        'admin_login'        => ['label' => 'Admin Login',         'color' => 'indigo'],
        'admin_logout'       => ['label' => 'Admin Logout',        'color' => 'slate'],
        'dal_create'         => ['label' => 'DAL Created',         'color' => 'green'],
        'dal_update'         => ['label' => 'DAL Updated',         'color' => 'amber'],
        'dal_delete'         => ['label' => 'DAL Deleted',         'color' => 'red'],
        'user_create'        => ['label' => 'User Created',        'color' => 'green'],
        'user_delete'        => ['label' => 'User Deleted',        'color' => 'red'],
        'user_promote'       => ['label' => 'Promoted to Admin',   'color' => 'purple'],
        'user_demote'        => ['label' => 'Demoted to Regular',  'color' => 'orange'],
        'password_reset_sent'=> ['label' => 'PW Reset Sent',       'color' => 'cyan'],
        'sso_login'          => ['label' => 'SSO Login',            'color' => 'blue'],
        'sso_enabled'        => ['label' => 'SSO Enabled',          'color' => 'green'],
        'sso_disabled'       => ['label' => 'SSO Disabled',         'color' => 'slate'],
        'email_settings_updated' => ['label' => 'Email Config Updated', 'color' => 'amber'],
        'email_test_sent'        => ['label' => 'Email Test Sent',      'color' => 'cyan'],
    ];
}
