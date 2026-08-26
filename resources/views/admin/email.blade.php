<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Notification Settings — {{ config('app.name', 'DAL System') }}</title>
    <meta name="description" content="Configure and test outgoing email notifications.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0d0d1a; color: #e2e8f0; min-height: 100vh; display: flex; flex-direction: column; }
        select, option { background-color: #1a1a32 !important; color: #f8fafc !important; }
        select:focus, select:active { background-color: #1f1f3d !important; border-color: #818cf8 !important; }

        /* ── Topbar ── */
        .topbar { background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.07); backdrop-filter: blur(12px); padding: 0 32px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .topbar-brand { display: flex; align-items: center; gap: 10px; }
        .brand-icon { width: 34px; height: 34px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 9px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(99,102,241,0.35); }
        .brand-icon svg { width: 18px; height: 18px; fill: #fff; }
        .brand-name { font-size: 15px; font-weight: 700; color: #f1f5f9; letter-spacing: -0.3px; }
        .brand-sub { font-size: 11px; font-weight: 500; color: rgba(241,245,249,0.4); letter-spacing: 0.08em; text-transform: uppercase; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .user-pill { display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 100px; padding: 6px 14px 6px 6px; }
        .avatar { width: 28px; height: 28px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #fff; }
        .user-name { font-size: 13px; font-weight: 500; color: rgba(241,245,249,0.8); }
        .btn-logout { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #fca5a5; border-radius: 10px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; padding: 8px 16px; cursor: pointer; transition: background 0.2s; }
        .btn-logout:hover { background: rgba(239,68,68,0.18); }

        /* ── Layout ── */
        .app-body { display: flex; flex: 1; }

        /* ── Sidebar ── */
        .sidebar { width: 220px; flex-shrink: 0; background: rgba(255,255,255,0.02); border-right: 1px solid rgba(255,255,255,0.06); padding: 24px 12px; display: flex; flex-direction: column; gap: 4px; }
        .sidebar-section { font-size: 10px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(248,250,252,0.25); padding: 4px 12px 8px; margin-top: 8px; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; text-decoration: none; font-size: 13.5px; font-weight: 500; color: rgba(248,250,252,0.55); transition: background 0.15s, color 0.15s; }
        .nav-link svg { width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: rgba(248,250,252,0.9); }
        .nav-link.active { background: rgba(99,102,241,0.15); color: #a5b4fc; font-weight: 600; }

        /* ── Main ── */
        main { flex: 1; padding: 40px 36px; overflow-x: hidden; max-width: 900px; }

        @keyframes fadeInDown { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes cardIn    { from { opacity:0; transform:translateY(16px); }  to { opacity:1; transform:translateY(0); } }

        .page-header { margin-bottom: 28px; animation: fadeInDown 0.4s ease both; }
        .page-header h1 { font-size: 26px; font-weight: 800; color: #f8fafc; letter-spacing: -0.6px; }
        .page-header p  { font-size: 14px; color: rgba(248,250,252,0.4); margin-top: 4px; }

        /* ── Cards ── */
        .card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 18px; padding: 28px 32px; margin-bottom: 24px; animation: cardIn 0.4s ease both; }
        .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; padding-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .card-header-left { display: flex; align-items: center; gap: 12px; }
        .card-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .card-icon svg { width: 18px; height: 18px; fill: currentColor; }
        .card-title { font-size: 15px; font-weight: 700; color: #f1f5f9; }
        .card-subtitle { font-size: 12px; color: rgba(248,250,252,0.4); margin-top: 2px; }

        /* ── Preset buttons ── */
        .preset-bar { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .preset-label { font-size: 12px; font-weight: 600; color: rgba(248,250,252,0.4); }
        .preset-btn {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            color: rgba(248,250,252,0.75); border-radius: 8px; padding: 6px 12px;
            font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600;
            cursor: pointer; transition: all 0.15s;
        }
        .preset-btn:hover { background: rgba(99,102,241,0.2); border-color: rgba(99,102,241,0.4); color: #a5b4fc; }

        /* ── Form fields ── */
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-grid-3 { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 18px; }
        .field-group { margin-bottom: 18px; }
        .field-group label { display: block; font-size: 12.5px; font-weight: 600; color: rgba(248,250,252,0.7); margin-bottom: 7px; }
        .field-input, .field-select {
            width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px; color: #e2e8f0; font-family: 'Inter', sans-serif; font-size: 13.5px;
            padding: 10px 14px; outline: none; transition: border-color 0.2s, background 0.2s;
        }
        .field-select { cursor: pointer; }
        .field-select option { background: #16162a; color: #e2e8f0; }
        .field-input::placeholder { color: rgba(248,250,252,0.25); }
        .field-input:focus, .field-select:focus { border-color: rgba(99,102,241,0.5); background: rgba(99,102,241,0.04); }
        .field-hint { font-size: 11.5px; color: rgba(248,250,252,0.3); margin-top: 5px; }

        /* ── Toggle ── */
        .toggle-wrap { display: flex; align-items: center; gap: 14px; }
        .toggle-label { font-size: 13.5px; font-weight: 600; color: rgba(248,250,252,0.8); }
        .toggle { position: relative; width: 46px; height: 26px; }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; inset: 0; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.12); border-radius: 26px; cursor: pointer; transition: background 0.25s; }
        .toggle-slider:before { content: ''; position: absolute; height: 18px; width: 18px; left: 3px; top: 3px; background: rgba(248,250,252,0.5); border-radius: 50%; transition: transform 0.25s, background 0.25s; }
        .toggle input:checked + .toggle-slider { background: rgba(99,102,241,0.6); border-color: rgba(99,102,241,0.5); }
        .toggle input:checked + .toggle-slider:before { transform: translateX(20px); background: #a5b4fc; }

        /* ── Status badge ── */
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-on  { background: rgba(16,185,129,0.12); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.2); }
        .status-off { background: rgba(100,116,139,0.12); color: #94a3b8; border: 1px solid rgba(100,116,139,0.2); }
        .status-warn{ background: rgba(245,158,11,0.12); color: #fcd34d; border: 1px solid rgba(245,158,11,0.2); }

        /* ── Buttons ── */
        .btn-primary { display: inline-flex; align-items: center; gap: 7px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; border-radius: 10px; color: #fff; font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 700; padding: 11px 26px; cursor: pointer; transition: opacity 0.2s, transform 0.15s; box-shadow: 0 4px 14px rgba(99,102,241,0.3); }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }

        .btn-test { display: inline-flex; align-items: center; gap: 7px; background: linear-gradient(135deg, #0ea5e9, #2563eb); border: none; border-radius: 10px; color: #fff; font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 700; padding: 11px 22px; cursor: pointer; transition: opacity 0.2s, transform 0.15s; box-shadow: 0 4px 14px rgba(14,165,233,0.3); white-space: nowrap; }
        .btn-test:hover { opacity: 0.9; transform: translateY(-1px); }

        /* ── Alerts ── */
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: #6ee7b7; border-radius: 10px; padding: 12px 16px; font-size: 13.5px; display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.2);  color: #fca5a5; border-radius: 10px; padding: 12px 16px; font-size: 13.5px; display: flex; align-items: flex-start; gap: 8px; margin-bottom: 20px; line-height: 1.5; }
        .alert-error svg, .alert-success svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }

        .guide-box { background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; padding: 20px 24px; font-size: 12.5px; color: rgba(248,250,252,0.55); line-height: 1.6; }
        .guide-box code { background: rgba(99,102,241,0.15); color: #a5b4fc; border-radius: 4px; padding: 1px 5px; font-size: 11.5px; }
    </style>
</head>
<body>

    {{-- ── Topbar ── --}}
    <header class="topbar">
        <div class="topbar-brand">
            <div class="brand-icon">
                <svg viewBox="0 0 20 20"><path d="M10 1l2.39 4.84L18 6.82l-4 3.9.94 5.5L10 13.77l-4.94 2.45L6 10.72 2 6.82l5.61-.98L10 1z"/></svg>
            </div>
            <div>
                <div class="brand-name">{{ config('app.name', 'DAL System') }}</div>
                <div class="brand-sub">Admin Panel</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="user-pill">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout" id="admin-logout-btn">Sign out</button>
            </form>
        </div>
    </header>

    <div class="app-body">
        {{-- ── Unified Sidebar ── --}}
        @include('admin.partials.sidebar')

        {{-- ── Main ── --}}
        <main>
            <div class="page-header">
                <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
                    <div>
                        <h1>Email Notification Settings</h1>
                        <p>Configure outgoing SMTP mail server and test email delivery in real-time.</p>
                    </div>
                    <div style="margin-left:auto;">
                        @if($setting->notifications_enabled && $setting->isReady())
                            <span class="status-badge status-on">● Notifications Active</span>
                        @elseif(!$setting->notifications_enabled)
                            <span class="status-badge status-off">○ Notifications Disabled</span>
                        @else
                            <span class="status-badge status-warn">⚠ Configuration Incomplete</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Settings save alerts --}}
            @if(session('success'))
                <div class="alert-success">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Test email alerts --}}
            @if(session('success_test'))
                <div class="alert-success">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success_test') }}
                </div>
            @endif

            @if(session('error_test'))
                <div class="alert-error">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <div>
                        <strong>Email Delivery Check Failed:</strong><br>
                        {{ session('error_test') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <div>
                        <strong>Please resolve the following errors:</strong>
                        <ul style="margin: 4px 0 0 16px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- ── Live Test Email Card ── --}}
            <div class="card" style="border-color: rgba(14,165,233,0.3); background: rgba(14,165,233,0.03);">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background: rgba(14,165,233,0.15); color: #38bdf8;">
                            <svg viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                        </div>
                        <div>
                            <div class="card-title">Live Email Connectivity Test</div>
                            <div class="card-subtitle">Send a test notification message to verify your SMTP server & credentials</div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.email.test') }}" id="email-test-form">
                    @csrf
                    <div style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
                        <div style="flex:1; min-width: 260px;">
                            <label style="display:block; font-size:12.5px; font-weight:600; color:rgba(248,250,252,0.7); margin-bottom:7px;">Recipient Email Address</label>
                            <input type="email" name="test_email" class="field-input" placeholder="admin@company.com"
                                   value="{{ old('test_email', auth()->user()->email) }}" required>
                        </div>
                        <button type="submit" class="btn-test" id="btn-send-test-email">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                            Send Test Email
                        </button>
                    </div>
                </form>
            </div>

            {{-- ── Main Configuration Card ── --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon" style="background: rgba(99,102,241,0.15); color: #818cf8;">
                            <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </div>
                        <div>
                            <div class="card-title">SMTP Server Configuration</div>
                            <div class="card-subtitle">Mail transport credentials and delivery settings</div>
                        </div>
                    </div>
                </div>

                {{-- Quick Presets --}}
                <div class="preset-bar">
                    <span class="preset-label">Quick Presets:</span>
                    <button type="button" class="preset-btn" onclick="applyPreset('m365')">Microsoft 365 / O365</button>
                    <button type="button" class="preset-btn" onclick="applyPreset('gmail')">Google Workspace / Gmail</button>
                    <button type="button" class="preset-btn" onclick="applyPreset('mailpit')">Local Mailpit / Dev</button>
                    <button type="button" class="preset-btn" onclick="applyPreset('log')">Log to File Driver</button>
                </div>

                <form method="POST" action="{{ route('admin.email.update') }}" id="email-settings-form">
                    @csrf

                    {{-- Notifications Enabled Toggle --}}
                    <div class="field-group" style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 12px; margin-bottom: 24px;">
                        <div class="toggle-wrap">
                            <label class="toggle">
                                <input type="hidden" name="notifications_enabled" value="0">
                                <input type="checkbox" name="notifications_enabled" value="1" id="notifications_enabled"
                                       {{ $setting->notifications_enabled ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                            <div>
                                <span class="toggle-label">Enable DAL Email Notifications</span>
                                <div class="field-hint">When turned off, outgoing notification emails are temporarily silenced.</div>
                            </div>
                        </div>
                    </div>

                    {{-- Mail Driver --}}
                    <div class="field-group">
                        <label for="mailer">Mail Transport Driver</label>
                        <select name="mailer" id="mailer" class="field-select" onchange="toggleDriverFields(this.value)">
                            <option value="smtp" {{ $setting->mailer === 'smtp' ? 'selected' : '' }}>SMTP (Recommended for production: Microsoft 365, Amazon SES, SendGrid)</option>
                            <option value="log" {{ $setting->mailer === 'log' ? 'selected' : '' }}>Log (Writes emails to storage/logs for testing)</option>
                            <option value="sendmail" {{ $setting->mailer === 'sendmail' ? 'selected' : '' }}>Sendmail (System binary)</option>
                        </select>
                    </div>

                    <div id="smtp-fields">
                        {{-- Host, Port, Encryption --}}
                        <div class="form-grid-3">
                            <div class="field-group">
                                <label for="host">SMTP Host</label>
                                <input type="text" name="host" id="host" class="field-input" placeholder="smtp.office365.com"
                                       value="{{ old('host', $setting->host) }}">
                            </div>

                            <div class="field-group">
                                <label for="port">SMTP Port</label>
                                <input type="number" name="port" id="port" class="field-input" placeholder="587"
                                       value="{{ old('port', $setting->port) }}">
                            </div>

                            <div class="field-group">
                                <label for="encryption">Encryption</label>
                                <select name="encryption" id="encryption" class="field-select">
                                    <option value="tls" {{ $setting->encryption === 'tls' ? 'selected' : '' }}>STARTTLS / TLS</option>
                                    <option value="ssl" {{ $setting->encryption === 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                                    <option value="none" {{ empty($setting->encryption) ? 'selected' : '' }}>None (Port 25 / Local)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Username & Password --}}
                        <div class="form-grid-2">
                            <div class="field-group">
                                <label for="username">SMTP Username / Account</label>
                                <input type="text" name="username" id="username" class="field-input" placeholder="notifications@yourcompany.com"
                                       value="{{ old('username', $setting->username) }}" autocomplete="off">
                            </div>

                            <div class="field-group">
                                <label for="password">
                                    SMTP Password
                                    @if(filled($setting->password))
                                        <span style="color:#6ee7b7; font-weight:400; font-size:11px;">(Encrypted & saved)</span>
                                    @endif
                                </label>
                                <input type="password" name="password" id="password" class="field-input"
                                       placeholder="{{ filled($setting->password) ? '•••••••••••• (Leave blank to keep unchanged)' : 'Enter SMTP password or App Secret' }}"
                                       autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    {{-- Sender Profile --}}
                    <div class="form-grid-2" style="margin-top: 10px;">
                        <div class="field-group">
                            <label for="from_address">Sender From Email Address</label>
                            <input type="email" name="from_address" id="from_address" class="field-input" placeholder="noreply@yourcompany.com"
                                   value="{{ old('from_address', $setting->from_address) }}" required>
                            <div class="field-hint">The "From" address visible to email recipients.</div>
                        </div>

                        <div class="field-group">
                            <label for="from_name">Sender From Display Name</label>
                            <input type="text" name="from_name" id="from_name" class="field-input" placeholder="DAL Governance System"
                                   value="{{ old('from_name', $setting->from_name) }}">
                            <div class="field-hint">The corporate name displayed in the recipient's email client.</div>
                        </div>
                    </div>

                    <div style="display:flex; justify-content:flex-end; margin-top:20px;">
                        <button type="submit" class="btn-primary" id="btn-save-email-settings">
                            Save Email Settings
                        </button>
                    </div>
                </form>
            </div>

            {{-- ── Guidance Box ── --}}
            <div class="guide-box">
                <strong style="color: #f1f5f9; display:block; margin-bottom: 6px;">💡 Microsoft 365 / Exchange Online SMTP Guidance:</strong>
                For Office 365, ensure SMTP AUTH is enabled for the mailbox in the Microsoft 365 Admin Center, or create an Exchange Online SMTP Relay Connector. Host is <code>smtp.office365.com</code>, Port <code>587</code>, Encryption <code>STARTTLS</code>. If Multi-Factor Authentication (MFA) is active on the account, create an <strong>App Password</strong>.
            </div>
        </main>
    </div>

    <script>
        function toggleDriverFields(mailer) {
            const smtpFields = document.getElementById('smtp-fields');
            if (mailer === 'log') {
                smtpFields.style.display = 'none';
            } else {
                smtpFields.style.display = 'block';
            }
        }

        function applyPreset(preset) {
            const mailerEl = document.getElementById('mailer');
            const hostEl = document.getElementById('host');
            const portEl = document.getElementById('port');
            const encryptionEl = document.getElementById('encryption');

            if (preset === 'm365') {
                mailerEl.value = 'smtp';
                hostEl.value = 'smtp.office365.com';
                portEl.value = 587;
                encryptionEl.value = 'tls';
            } else if (preset === 'gmail') {
                mailerEl.value = 'smtp';
                hostEl.value = 'smtp.gmail.com';
                portEl.value = 587;
                encryptionEl.value = 'tls';
            } else if (preset === 'mailpit') {
                mailerEl.value = 'smtp';
                hostEl.value = '127.0.0.1';
                portEl.value = 1025;
                encryptionEl.value = 'none';
            } else if (preset === 'log') {
                mailerEl.value = 'log';
            }
            toggleDriverFields(mailerEl.value);
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleDriverFields(document.getElementById('mailer').value);
        });
    </script>
</body>
</html>
