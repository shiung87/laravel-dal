<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestNotificationMail;
use App\Models\EmailSetting;
use App\Services\AuditLogger;
use App\Services\EmailConfigLoader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminEmailController extends Controller
{
    /**
     * Display the email configuration panel and test interface.
     */
    public function show()
    {
        $setting = EmailSetting::current();
        return view('admin.email', compact('setting'));
    }

    /**
     * Update the email / notification settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mailer'                => ['required', 'string', 'in:smtp,log,sendmail'],
            'host'                  => ['nullable', 'string', 'max:255'],
            'port'                  => ['required', 'integer', 'between:1,65535'],
            'username'              => ['nullable', 'string', 'max:255'],
            'password'              => ['nullable', 'string', 'max:500'],
            'encryption'            => ['nullable', 'string', 'in:tls,ssl,none'],
            'from_address'          => ['required', 'email', 'max:255'],
            'from_name'             => ['nullable', 'string', 'max:255'],
            'notifications_enabled' => ['boolean'],
        ]);

        $data['notifications_enabled'] = $request->boolean('notifications_enabled', true);

        // Map 'none' encryption to null
        if (($data['encryption'] ?? '') === 'none') {
            $data['encryption'] = null;
        }

        $setting = EmailSetting::current();

        // Only overwrite password if a new non-empty password was submitted
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $oldValues = $setting->only(['mailer', 'host', 'port', 'encryption', 'from_address', 'from_name', 'notifications_enabled']);
        $setting->update($data);

        // Reload runtime configuration immediately
        EmailConfigLoader::boot();

        AuditLogger::log(
            action:    'email_settings_updated',
            subject:   null,
            oldValues: $oldValues,
            newValues: $setting->only(['mailer', 'host', 'port', 'encryption', 'from_address', 'from_name', 'notifications_enabled']),
        );

        return back()->with('success', 'Email notification settings saved and updated successfully.');
    }

    /**
     * Send a real-time test notification email to verify connectivity.
     */
    public function testEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => ['required', 'email', 'max:255'],
        ]);

        $recipient = strtolower(trim($request->input('test_email')));
        $setting = EmailSetting::current();

        // Ensure runtime configuration is loaded
        EmailConfigLoader::boot();

        try {
            // Send synchronously so we capture any transport / authentication errors immediately
            Mail::to($recipient)->send(new TestNotificationMail([
                'sent_by'   => auth()->user()?->name ?? 'Administrator',
                'recipient' => $recipient,
                'mailer'    => $setting->mailer,
                'host'      => $setting->host,
                'port'      => $setting->port,
            ]));

            AuditLogger::log(
                action:    'email_test_sent',
                subject:   null,
                newValues: ['recipient' => $recipient, 'mailer' => $setting->mailer, 'host' => $setting->host],
            );

            return back()->with('success_test', "Test email successfully sent to {$recipient}. Please check your inbox / spam folder (or storage/logs if using log driver).");
        } catch (\Throwable $e) {
            Log::error('Email notification test failed', [
                'recipient' => $recipient,
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            return back()->with('error_test', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
