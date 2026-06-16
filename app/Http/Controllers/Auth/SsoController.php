<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SsoSetting;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SsoController extends Controller
{
    /**
     * Redirect to Microsoft Azure AD login page.
     */
    public function redirect(): RedirectResponse
    {
        $sso = SsoSetting::current();

        if (!$sso->isReady()) {
            return redirect()->route('login')
                ->with('error', 'SSO is not configured. Please contact your administrator.');
        }

        return Socialite::driver('azure')->redirect();
    }

    /**
     * Handle the Azure AD callback.
     * Auto-creates the user account if it does not exist yet.
     */
    public function callback(): RedirectResponse
    {
        try {
            $azureUser = Socialite::driver('azure')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->with('error', 'SSO authentication failed. Please try again or use email/password login.');
        }

        $email = $azureUser->getEmail();

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Microsoft did not return an email address. Ensure your Azure app has User.Read permission.');
        }

        // Find existing user or auto-create from Azure profile
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name'              => $azureUser->getName() ?? $azureUser->getNickname() ?? $email,
                'password'          => bcrypt(Str::random(32)), // random password — SSO users don't need one
                'email_verified_at' => now(),                   // Azure email is already verified
            ]
        );

        Auth::login($user, remember: true);

        AuditLogger::log('sso_login', $user);

        return redirect()->intended(route('dashboard'));
    }
}
