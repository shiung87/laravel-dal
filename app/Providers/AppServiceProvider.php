<?php

namespace App\Providers;

use App\Models\DalEntry;
use App\Observers\DalEntryObserver;
use App\Services\EmailConfigLoader;
use App\Services\SsoConfigLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DalEntry::observe(DalEntryObserver::class);

        // Load Azure SSO credentials from the database into config at runtime
        SsoConfigLoader::boot();

        // Load Email notification settings from the database into config at runtime
        EmailConfigLoader::boot();

        // Register the SocialiteProviders event listener for the Azure driver
        Event::listen(
            \SocialiteProviders\Manager\SocialiteWasCalled::class,
            \SocialiteProviders\Azure\AzureExtendSocialite::class
        );
    }
}
