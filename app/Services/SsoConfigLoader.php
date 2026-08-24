<?php

namespace App\Services;

use App\Models\SsoSetting;

class SsoConfigLoader
{
    /**
     * Read SSO settings from the database (with .env fallback) and push them into
     * the Socialite/Azure config at runtime so the system works seamlessly.
     *
     * Called from AppServiceProvider::boot().
     */
    public static function boot(): void
    {
        try {
            $sso = SsoSetting::current();

            config([
                'services.azure' => [
                    'client_id'     => $sso->effectiveClientId(),
                    'client_secret' => $sso->effectiveClientSecret(),
                    'redirect'      => $sso->effectiveRedirectUri(),
                    'tenant'        => $sso->effectiveTenantId(),
                    'proxy'         => null,
                ],
            ]);
        } catch (\Throwable) {
            // Fallback directly to env configuration
            config([
                'services.azure' => [
                    'client_id'     => env('MICROSOFT_CLIENT_ID'),
                    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
                    'redirect'      => env('MICROSOFT_REDIRECT_URI', url('/auth/sso/callback')),
                    'tenant'        => env('MICROSOFT_TENANT_ID', 'common'),
                    'proxy'         => null,
                ],
            ]);
        }
    }
}
