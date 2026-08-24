<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Notification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0d0d1a; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #e2e8f0; line-height: 1.6;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed; background-color: #0d0d1a; padding: 40px 10px;">
        <tr>
            <td align="center">
                <!-- Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; background: #16162a; border-radius: 16px; border: 1px solid rgba(255,255,255,0.08); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 32px 40px 24px 40px; background: linear-gradient(135deg, #1e1e38 0%, #16162a 100%); border-bottom: 1px solid rgba(255,255,255,0.06);">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <div style="display: inline-block; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 10px; width: 36px; height: 36px; text-align: center; line-height: 36px; color: #ffffff; font-weight: bold; font-size: 16px;">
                                            ✉️
                                        </div>
                                        <span style="font-size: 18px; font-weight: 700; color: #f8fafc; margin-left: 12px; vertical-align: middle;">
                                            {{ config('app.name', 'DAL System') }}
                                        </span>
                                    </td>
                                    <td align="right">
                                        <span style="display: inline-block; background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                            Test Successful
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 36px 40px;">
                            <h1 style="font-size: 22px; font-weight: 700; color: #f8fafc; margin: 0 0 14px 0;">
                                Email Notification Test Dispatched
                            </h1>
                            <p style="font-size: 14px; color: #94a3b8; margin: 0 0 24px 0;">
                                This is a test email sent from your Delegation of Authority (DAL) Admin Control Panel to verify that your outgoing email configuration (SMTP / Transport) is working correctly.
                            </p>

                            <!-- Metadata Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; margin-bottom: 26px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; padding: 4px 0;">Dispatched By</td>
                                                <td style="font-size: 13px; color: #e2e8f0; font-weight: 500; text-align: right; padding: 4px 0;">{{ $testData['sent_by'] ?? 'Administrator' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; padding: 4px 0;">Recipient Target</td>
                                                <td style="font-size: 13px; color: #a5b4fc; font-weight: 500; text-align: right; padding: 4px 0;">{{ $testData['recipient'] ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; padding: 4px 0;">Mailer Transport</td>
                                                <td style="font-size: 13px; color: #e2e8f0; font-weight: 500; text-align: right; padding: 4px 0;">{{ strtoupper($testData['mailer'] ?? 'SMTP') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; padding: 4px 0;">Host & Port</td>
                                                <td style="font-size: 13px; color: #e2e8f0; font-weight: 500; text-align: right; padding: 4px 0;">{{ $testData['host'] ?? 'N/A' }}:{{ $testData['port'] ?? '587' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; padding: 4px 0;">Timestamp</td>
                                                <td style="font-size: 13px; color: #e2e8f0; font-weight: 500; text-align: right; padding: 4px 0;">{{ now()->toDayDateTimeString() }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 13px; color: #64748b; margin: 0;">
                                If you received this email, your notification engine is ready to broadcast DAL matrix revisions, workflow approvals, and system alerts to employees.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px 40px; background: rgba(0,0,0,0.2); border-top: 1px solid rgba(255,255,255,0.05); text-align: center;">
                            <p style="font-size: 12px; color: #475569; margin: 0;">
                                {{ config('app.name', 'DAL System') }} &bull; Enterprise Delegation of Authority Governance
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
