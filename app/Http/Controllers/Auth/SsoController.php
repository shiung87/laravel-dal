<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SsoSetting;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
                ->with('error', 'Microsoft Azure AD SSO is not configured or is currently disabled. Please contact your administrator.');
        }

        return Socialite::driver('azure')->redirect();
    }

    /**
     * Handle the Azure AD callback.
     * Auto-creates or authenticates the employee user account.
     */
    public function callback(): RedirectResponse
    {
        try {
            $azureUser = Socialite::driver('azure')->user();
        } catch (\Throwable $e) {
            Log::error('Azure AD SSO Authentication Failure', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')
                ->with('error', 'Azure AD authentication failed: ' . $e->getMessage());
        }

        // Azure AD can return email in different claims depending on tenant configuration
        $rawAttributes = (array) ($azureUser->user ?? []);
        $email = $azureUser->getEmail()
            ?: ($rawAttributes['mail'] ?? null)
            ?: ($rawAttributes['userPrincipalName'] ?? null)
            ?: ($rawAttributes['preferred_username'] ?? null);

        if (!$email) {
            return redirect()->route('login')
                ->with('error', 'Microsoft did not return a valid email address or UserPrincipalName. Ensure your Azure app registration has the "User.Read" API permission.');
        }

        $email = strtolower(trim($email));
        $name = $azureUser->getName()
            ?: ($rawAttributes['displayName'] ?? null)
            ?: ($azureUser->getNickname() ?? null)
            ?: explode('@', $email)[0];

        // Extract SSO Department claim
        $ssoDepartmentName = $rawAttributes['department']
            ?? ($rawAttributes['jobTitle'] ?? null);

        $department = \App\Models\Department::findOrSyncFromSso($ssoDepartmentName);

        // Find existing user or auto-provision employee profile
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name'              => $name,
                'email'             => $email,
                'password'          => bcrypt(Str::random(40)), // Secure unguessable hash for SSO users
                'email_verified_at' => now(),                    // Azure accounts are enterprise-verified
                'is_admin'          => false,
                'is_sso'            => true,
                'department_id'     => $department?->id,
                'department_name'   => $ssoDepartmentName,
            ]);
        } else {
            // Keep verified, mark as SSO, and update department & name if synced
            $user->is_sso = true;
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
            }
            if (empty($user->name) && !empty($name)) {
                $user->name = $name;
            }
            if ($department) {
                $user->department_id = $department->id;
                $user->department_name = $ssoDepartmentName;
            }
            $user->save();
        }

        Auth::login($user, remember: true);

        AuditLogger::log('sso_login', $user, [
            'provider'        => 'azure',
            'azure_id'        => $azureUser->getId(),
            'user_email'      => $email,
            'department_sync' => $ssoDepartmentName,
        ]);

        return redirect()->intended(route('dashboard'));
    }
}
