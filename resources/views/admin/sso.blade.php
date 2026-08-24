<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SSO Settings — {{ config('app.name') }}</title>
    <meta name="description" content="Configure Azure AD Single Sign-On for the application.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0d0d1a; color: #e2e8f0; min-height: 100vh; display: flex; flex-direction: column; }

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
        main { flex: 1; padding: 40px 36px; overflow-x: hidden; max-width: 860px; }

        @keyframes fadeInDown { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes cardIn    { from { opacity:0; transform:translateY(16px); }  to { opacity:1; transform:translateY(0); } }

        .page-header { margin-bottom: 28px; animation: fadeInDown 0.4s ease both; }
        .page-header h1 { font-size: 26px; font-weight: 800; color: #f8fafc; letter-spacing: -0.6px; }
        .page-header p  { font-size: 14px; color: rgba(248,250,252,0.4); margin-top: 4px; }

        /* ── Cards ── */
        .card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 18px; padding: 28px 32px; margin-bottom: 20px; animation: cardIn 0.4s ease both; }
        .card-header { display: flex; align-items: center; gap: 12px; margin-bottom: 22px; padding-bottom: 16px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .card-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .card-icon svg { width: 18px; height: 18px; fill: currentColor; }
        .card-title { font-size: 15px; font-weight: 700; color: #f1f5f9; }
        .card-subtitle { font-size: 12px; color: rgba(248,250,252,0.4); margin-top: 2px; }

        /* ── Form fields ── */
        .field-group { margin-bottom: 18px; }
        .field-group label { display: block; font-size: 12.5px; font-weight: 600; color: rgba(248,250,252,0.7); margin-bottom: 7px; }
        .field-input { width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; color: #e2e8f0; font-family: 'Inter', sans-serif; font-size: 13.5px; padding: 10px 14px; outline: none; transition: border-color 0.2s, background 0.2s; }
        .field-input::placeholder { color: rgba(248,250,252,0.25); }
        .field-input:focus { border-color: rgba(99,102,241,0.5); background: rgba(99,102,241,0.04); }
        .field-hint { font-size: 11.5px; color: rgba(248,250,252,0.3); margin-top: 5px; }
        .field-readonly { background: rgba(0,0,0,0.2); color: rgba(248,250,252,0.5); cursor: default; }

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

        /* ── Guide steps ── */
        .guide { background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; padding: 20px 24px; }
        .guide-title { font-size: 12px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(248,250,252,0.4); margin-bottom: 14px; }
        .guide-step { display: flex; gap: 12px; margin-bottom: 14px; }
        .guide-step:last-child { margin-bottom: 0; }
        .step-num { width: 22px; height: 22px; border-radius: 50%; background: rgba(99,102,241,0.2); border: 1px solid rgba(99,102,241,0.35); color: #a5b4fc; font-size: 11px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
        .step-body { font-size: 12.5px; color: rgba(248,250,252,0.55); line-height: 1.55; }
        .step-body strong { color: rgba(248,250,252,0.85); font-weight: 600; }
        .step-body code { background: rgba(99,102,241,0.15); color: #a5b4fc; border-radius: 4px; padding: 1px 5px; font-size: 11.5px; word-break: break-all; }

        /* ── Alerts ── */
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.2); color: #6ee7b7; border-radius: 10px; padding: 12px 16px; font-size: 13.5px; display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .alert-error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.2);  color: #fca5a5; border-radius: 10px; padding: 12px 16px; font-size: 13.5px; display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>

    {{-- Topbar --}}
    <header class="topbar">
        <div class="topbar-brand">
            <div class="brand-icon"><svg viewBox="0 0 20 20"><path d="M10 1l2.39 4.84L18 6.82l-4 3.9.94 5.5L10 13.77l-4.94 2.45L6 10.72 2 6.82l5.61-.98L10 1z"/></svg></div>
            <div>
                <div class="brand-name">{{ config('app.name') }}</div>
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
        {{-- Sidebar --}}
        <nav class="sidebar">
            <div class="sidebar-section">Navigation</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" id="sidebar-dashboard">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" id="sidebar-users">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                Users & Access
            </a>
            <a href="{{ route('admin.audit-log') }}" class="nav-link {{ request()->routeIs('admin.audit-log') ? 'active' : '' }}" id="sidebar-audit-log">
                <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zm-2 9H7v-2h4v2zm4-4H7v-2h8v2zm0-4H7V8h2v2h6z"/></svg>
                Audit Log
            </a>
            <div class="sidebar-section">Settings</div>
            <a href="{{ route('admin.sso.show') }}" class="nav-link active" id="sidebar-sso">
                <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                SSO Settings
            </a>
            <a href="{{ route('admin.email.show') }}" class="nav-link {{ request()->routeIs('admin.email.*') ? 'active' : '' }}" id="sidebar-email">
                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                Email & Notifications
            </a>
        </nav>

        {{-- Main --}}
        <main>
            <div class="page-header">
                <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
                    <div>
                        <h1>SSO Settings</h1>
                        <p>Configure Microsoft Azure AD Single Sign-On for your organisation.</p>
                    </div>
                    <div style="margin-left:auto;">
                        @if($sso->isReady())
                            <span class="status-badge status-on">● SSO Active</span>
                        @elseif($sso->enabled)
                            <span class="status-badge status-warn">⚠ Enabled but incomplete</span>
                        @else
                            <span class="status-badge status-off">○ SSO Disabled</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Flash --}}
            @if(session('success'))
                <div class="alert-success">✅ {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-error">❌ {{ $errors->first() }}</div>
            @endif

            {{-- Settings form --}}
            <form method="POST" action="{{ route('admin.sso.update') }}" id="sso-settings-form">
                @csrf

                {{-- Enable / Disable toggle --}}
                <div class="card" style="animation-delay:0.05s;">
                    <div class="card-header">
                        <div class="card-icon" style="background:rgba(99,102,241,0.15);color:#a5b4fc;">
                            <svg viewBox="0 0 24 24"><path d="M17 7H7C4.24 7 2 9.24 2 12s2.24 5 5 5h10c2.76 0 5-2.24 5-5s-2.24-5-5-5zm0 8H7c-1.66 0-3-1.34-3-3s1.34-3 3-3h10c1.66 0 3 1.34 3 3s-1.34 3-3 3zm-3-3c0 1.1.9 2 2 2s2-.9 2-2-.9-2-2-2-2 .9-2 2z"/></svg>
                        </div>
                        <div>
                            <div class="card-title">Enable Azure AD SSO</div>
                            <div class="card-subtitle">Allow users to sign in with their Microsoft account</div>
                        </div>
                    </div>
                    <div class="toggle-wrap">
                        <label class="toggle" for="sso_enabled" id="toggle-label">
                            <input type="hidden" name="enabled" value="0">
                            <input type="checkbox" id="sso_enabled" name="enabled" value="1" {{ $sso->enabled ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label" id="toggle-text">{{ $sso->enabled ? 'Enabled — users see the Microsoft login button' : 'Disabled — only email/password login is shown' }}</span>
                    </div>
                </div>

                {{-- Azure AD credentials --}}
                <div class="card" style="animation-delay:0.1s;">
                    <div class="card-header">
                        <div class="card-icon" style="background:rgba(37,99,235,0.15);color:#60a5fa;">
                            <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 4l5 2.18V11c0 3.5-2.33 6.79-5 7.93C9.33 17.79 7 14.5 7 11V7.18L12 5z"/></svg>
                        </div>
                        <div>
                            <div class="card-title">Azure AD App Registration</div>
                            <div class="card-subtitle">Credentials from your Azure Portal → App Registrations</div>
                        </div>
                    </div>

                    <div class="field-group">
                        <label for="tenant_id">Tenant ID (Directory ID)</label>
                        <input id="tenant_id" name="tenant_id" type="text" class="field-input"
                               placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
                               value="{{ old('tenant_id', $sso->tenant_id ?: env('MICROSOFT_TENANT_ID')) }}">
                        <p class="field-hint">Found in Azure Portal → Azure Active Directory → Properties → Tenant ID</p>
                    </div>

                    <div class="field-group">
                        <label for="client_id">Application (Client) ID</label>
                        <input id="client_id" name="client_id" type="text" class="field-input"
                               placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
                               value="{{ old('client_id', $sso->client_id ?: env('MICROSOFT_CLIENT_ID')) }}">
                        <p class="field-hint">Found in Azure Portal → App Registrations → your app → Overview</p>
                    </div>

                    <div class="field-group">
                        <label for="client_secret">Client Secret</label>
                        <div style="position:relative;">
                            <input id="client_secret" name="client_secret" type="password" class="field-input"
                                   placeholder="{{ ($sso->client_secret || env('MICROSOFT_CLIENT_SECRET')) ? '●●●●●●●● (configured — leave blank to keep)' : 'Paste your client secret value here' }}"
                                   style="padding-right:44px;"
                                   autocomplete="new-password">
                            <button type="button" id="toggle-secret"
                                    onclick="var i=document.getElementById('client_secret');i.type=i.type==='password'?'text':'password';this.textContent=i.type==='password'?'👁':'🙈'"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;font-size:16px;color:rgba(248,250,252,0.4);">👁</button>
                        </div>
                        <p class="field-hint">Azure Portal → App Registrations → Certificates &amp; secrets → New client secret. Leave blank to keep the active value.</p>
                    </div>

                    <div class="field-group">
                        <label for="redirect_uri">Redirect URI (auto-generated)</label>
                        <input id="redirect_uri" name="redirect_uri" type="text" class="field-input field-readonly"
                               value="{{ $sso->effectiveRedirectUri() }}" readonly>
                        <p class="field-hint">Copy this URL and paste it into Azure Portal → App Registrations → Authentication → Redirect URIs</p>
                    </div>
                </div>

                <div style="display:flex;gap:12px;align-items:center;margin-bottom:24px;">
                    <button type="submit" class="btn-primary" id="save-sso-btn">
                        <svg style="width:15px;height:15px;fill:currentColor;" viewBox="0 0 24 24"><path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/></svg>
                        Save Settings
                    </button>
                    @if($sso->isReady())
                        <a href="{{ route('sso.redirect') }}" target="_blank"
                           style="display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:rgba(248,250,252,0.7);border-radius:10px;font-size:13px;font-weight:600;padding:10px 20px;text-decoration:none;transition:background 0.15s;"
                           onmouseover="this.style.background='rgba(255,255,255,0.09)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                            <svg style="width:14px;height:14px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 19H5V5h7V3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/></svg>
                            Test SSO Login
                        </a>
                    @endif
                </div>
            </form>

            {{-- Azure App Registration Guide --}}
            <div class="card" style="animation-delay:0.15s;">
                <div class="card-header">
                    <div class="card-icon" style="background:rgba(245,158,11,0.12);color:#fcd34d;">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    </div>
                    <div>
                        <div class="card-title">Azure App Registration Guide</div>
                        <div class="card-subtitle">One-time setup in Microsoft Azure Portal</div>
                    </div>
                </div>
                <div class="guide">
                    <div class="guide-title">Setup Steps</div>
                    <div class="guide-step">
                        <div class="step-num">1</div>
                        <div class="step-body">Go to <strong>portal.azure.com</strong> → <strong>Azure Active Directory</strong> → <strong>App registrations</strong> → <strong>New registration</strong></div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">2</div>
                        <div class="step-body">Set <strong>Name</strong> (e.g. <em>Laravel DAL App</em>), choose <strong>Supported account types</strong> (single-tenant for your org), and set <strong>Redirect URI</strong> → Web → <code>{{ $sso->effectiveRedirectUri() }}</code></div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">3</div>
                        <div class="step-body">After creation, copy the <strong>Application (Client) ID</strong> and <strong>Directory (Tenant) ID</strong> from the Overview page and paste them above.</div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">4</div>
                        <div class="step-body">Go to <strong>Certificates &amp; secrets</strong> → <strong>New client secret</strong> → set an expiry → click <strong>Add</strong>. Copy the <strong>Value</strong> immediately (it's only shown once) and paste it in the Client Secret field above.</div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">5</div>
                        <div class="step-body">Go to <strong>API permissions</strong> → <strong>Add a permission</strong> → <strong>Microsoft Graph</strong> → <strong>Delegated permissions</strong> → add <strong>User.Read</strong> → click <strong>Grant admin consent</strong>.</div>
                    </div>
                    <div class="guide-step">
                        <div class="step-num">6</div>
                        <div class="step-body">Save settings above, toggle <strong>Enable SSO</strong>, then click <strong>Test SSO Login</strong> to verify the flow works end-to-end.</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const toggle = document.getElementById('sso_enabled');
        const text   = document.getElementById('toggle-text');
        toggle.addEventListener('change', () => {
            text.textContent = toggle.checked
                ? 'Enabled — users see the Microsoft login button'
                : 'Disabled — only email/password login is shown';
        });
    </script>
</body>
</html>
