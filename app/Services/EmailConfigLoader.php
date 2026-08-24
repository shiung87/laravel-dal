<?php

namespace App\Services;

use App\Models\EmailSetting;

class EmailConfigLoader
{
    /**
     * Read email settings from the database and apply them to Laravel's
     * mail configuration dynamically at runtime so admin UI changes apply immediately.
     */
    public static function boot(): void
    {
        try {
            $setting = EmailSetting::current();

            $mailer = $setting->mailer ?: 'smtp';

            $mailConfig = [
                'mail.default' => $mailer,
                'mail.from' => [
                    'address' => $setting->from_address ?: env('MAIL_FROM_ADDRESS', 'noreply@company.com'),
                    'name'    => $setting->from_name ?: env('MAIL_FROM_NAME', config('app.name', 'DAL System')),
                ],
            ];

            if ($mailer === 'smtp') {
                $mailConfig['mail.mailers.smtp'] = [
                    'transport'    => 'smtp',
                    'host'         => $setting->host ?: env('MAIL_HOST', '127.0.0.1'),
                    'port'         => $setting->port ?: (int) env('MAIL_PORT', 587),
                    'encryption'   => ($setting->encryption === 'none' || empty($setting->encryption)) ? null : $setting->encryption,
                    'username'     => $setting->username ?: env('MAIL_USERNAME'),
                    'password'     => $setting->password ?: env('MAIL_PASSWORD'),
                    'timeout'      => 10,
                    'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url((string) env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
                ];
            }

            config($mailConfig);
        } catch (\Throwable) {
            // Table not yet migrated or DB unavailable — ignore gracefully
        }
    }
}
