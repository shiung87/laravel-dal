<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $fillable = [
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name',
        'notifications_enabled',
    ];

    protected function casts(): array
    {
        return [
            'password'              => 'encrypted',
            'port'                  => 'integer',
            'notifications_enabled' => 'boolean',
        ];
    }

    /**
     * Always return the single email settings row (creates one with defaults if missing).
     */
    public static function current(): static
    {
        return static::firstOrCreate([], [
            'mailer'                => 'smtp',
            'host'                  => env('MAIL_HOST', 'smtp.office365.com'),
            'port'                  => (int) env('MAIL_PORT', 587),
            'username'              => env('MAIL_USERNAME', ''),
            'encryption'            => env('MAIL_ENCRYPTION', 'tls'),
            'from_address'          => env('MAIL_FROM_ADDRESS', 'noreply@company.com'),
            'from_name'             => env('MAIL_FROM_NAME', config('app.name', 'DAL System')),
            'notifications_enabled' => true,
        ]);
    }

    /**
     * Check if minimum required settings are configured for sending mail.
     */
    public function isReady(): bool
    {
        if ($this->mailer === 'log') {
            return true;
        }

        return filled($this->host)
            && filled($this->port)
            && filled($this->from_address);
    }
}
