<?php

namespace App\Mail;

use App\Models\EmailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $testData
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $setting = EmailSetting::current();
        $fromAddress = $setting->from_address ?: config('mail.from.address', 'noreply@company.com');
        $fromName = $setting->from_name ?: config('mail.from.name', 'DAL Notification System');

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: '✅ Test Notification — ' . config('app.name', 'DAL System') . ' Email Delivery Check',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test-notification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
