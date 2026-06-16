<?php

namespace App\Services;

use App\Models\SsoSetting;
use SocialiteProviders\Manager\SocialiteWasCalled;

class SsoConfigLoader
{
    /**
     * Read SSO settings from the database and push them into the
     * Socialite/Azure config at runtime so the admin UI drives everything.
     *
     * Called from AppServiceProvider::boot() — safe to call even when the
     * sso_settings table doesn't exist yet (e.g. before migrations run).
     */
    public static function boot(): void
    {
        try {
            $sso = SsoSetting::current();

            config([
                'services.azure' => [
                    'client_id'     => $sso->client_id,
                    'client_secret' => $sso->client_secret,
                    'redirect'      => $sso->effectiveRedirectUri(),
                    'tenant'        => $sso->tenant_id ?: 'common',
                    'proxy'         => null,
                ],
            ]);
        } catch (\Throwable) {
            // Table not yet migrated — skip silently.
        }
    }
}
