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
        $setting = static::first();
        if (!$setting) {
            $setting = static::create([
                'enabled' => filled(env('MICROSOFT_CLIENT_ID')),
            ]);
        }

        return $setting;
    }

    /**
     * Return effective Tenant ID (DB override -> .env config -> fallback).
     */
    public function effectiveTenantId(): string
    {
        return $this->tenant_id
            ?: config('services.azure.tenant')
            ?: env('MICROSOFT_TENANT_ID', 'common');
    }

    /**
     * Return effective Client ID (DB override -> .env config).
     */
    public function effectiveClientId(): ?string
    {
        return $this->client_id
            ?: config('services.azure.client_id')
            ?: env('MICROSOFT_CLIENT_ID');
    }

    /**
     * Return effective Client Secret (DB override -> .env config).
     */
    public function effectiveClientSecret(): ?string
    {
        return $this->client_secret
            ?: config('services.azure.client_secret')
            ?: env('MICROSOFT_CLIENT_SECRET');
    }

    /**
     * Return the effective redirect URI, falling back to the auto-generated URL.
     */
    public function effectiveRedirectUri(): string
    {
        return $this->redirect_uri
            ?: config('services.azure.redirect')
            ?: env('MICROSOFT_REDIRECT_URI')
            ?: url('/auth/sso/callback');
    }

    /**
     * Check if SSO is enabled. Active if enabled in DB or configured in .env.
     */
    public function isEnabled(): bool
    {
        if ($this->exists && !is_null($this->enabled)) {
            // If explicitly enabled in DB
            if ($this->enabled) {
                return true;
            }
        }

        // Enabled by default if environment credentials exist
        return filled(env('MICROSOFT_CLIENT_ID'));
    }

    /**
     * True if all required fields are filled and SSO is active.
     */
    public function isReady(): bool
    {
        return $this->isEnabled()
            && filled($this->effectiveTenantId())
            && filled($this->effectiveClientId())
            && filled($this->effectiveClientSecret());
    }
}
