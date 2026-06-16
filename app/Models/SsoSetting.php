<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SsoSetting extends Model
{
    protected $fillable = [
        'tenant_id',
        'client_id',
        'client_secret',
        'redirect_uri',
        'enabled',
    ];

    protected function casts(): array
    {
        return [
            'client_secret' => 'encrypted',
            'enabled'       => 'boolean',
        ];
    }

    /**
     * Always return the single settings row (creates one if missing).
     */
    public static function current(): static
    {
        return static::firstOrCreate([], [
            'enabled' => false,
        ]);
    }

    /**
     * Return the effective redirect URI, falling back to the auto-generated URL.
     */
    public function effectiveRedirectUri(): string
    {
        return $this->redirect_uri ?: url('/auth/sso/callback');
    }

    /**
     * True if all required fields are filled and SSO is enabled.
     */
    public function isReady(): bool
    {
        return $this->enabled
            && filled($this->tenant_id)
            && filled($this->client_id)
            && filled($this->client_secret);
    }
}
