<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard — {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Administrator dashboard panel.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0d0d1a;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .topbar {
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            backdrop-filter: blur(12px);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35);
        }

        .brand-icon svg { width: 18px; height: 18px; fill: #fff; }

        .brand-name {
            font-size: 15px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.3px;
        }

        .brand-sub {
            font-size: 11px;
            font-weight: 500;
            color: rgba(241,245,249,0.4);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 100px;
            padding: 6px 14px 6px 6px;
        }

        .avatar {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #fff;
        }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: rgba(241,245,249,0.8);
        }

        .logout-form { display: inline; }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            padding: 8px 16px;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s, transform 0.15s;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.18);
            border-color: rgba(239, 68, 68, 0.45);
            transform: translateY(-1px);
        }

        /* ── Layout ── */
        .app-body {
            display: flex;
            flex: 1;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 220px;
            flex-shrink: 0;
            background: rgba(255,255,255,0.02);
            border-right: 1px solid rgba(255,255,255,0.06);
            padding: 24px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-section {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(248,250,252,0.25);
            padding: 4px 12px 8px;
            margin-top: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            color: rgba(248,250,252,0.55);
            transition: background 0.15s, color 0.15s;
        }

        .nav-link svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: rgba(248,250,252,0.9);
        }

        .nav-link.active {
            background: rgba(99,102,241,0.15);
            color: #a5b4fc;
            font-weight: 600;
        }

        /* ── Main content ── */
        main {
            flex: 1;
            padding: 40px 36px;
            overflow-x: hidden;
        }

        .page-header {
            margin-bottom: 40px;
            animation: fadeInDown 0.5s ease both;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 800;
            color: #f8fafc;
            letter-spacing: -0.8px;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .page-header p {
            color: rgba(248,250,252,0.45);
            font-size: 15px;
        }

        .greeting-accent {
            background: linear-gradient(90deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Stats grid ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 18px;
            padding: 24px;
            transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
            animation: cardIn 0.5s ease both;
            text-decoration: none;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(99,102,241,0.3);
            box-shadow: 0 12px 32px rgba(0,0,0,0.3), 0 0 0 1px rgba(99,102,241,0.1) inset;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .stat-icon svg { width: 22px; height: 22px; }
        .stat-icon.indigo { background: rgba(99,102,241,0.15); }
        .stat-icon.indigo svg { fill: #818cf8; }
        .stat-icon.purple { background: rgba(168,85,247,0.15); }
        .stat-icon.purple svg { fill: #c084fc; }
        .stat-icon.emerald { background: rgba(16,185,129,0.15); }
        .stat-icon.emerald svg { fill: #6ee7b7; }

        .stat-value {
            font-size: 36px;
            font-weight: 800;
            color: #f8fafc;
            line-height: 1;
            margin-bottom: 6px;
            letter-spacing: -1px;
        }

        .stat-label {
            font-size: 13px;
            color: rgba(248,250,252,0.45);
            font-weight: 500;
        }

        /* ── Quick actions ── */
        .section-title {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(248,250,252,0.35);
            margin-bottom: 16px;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 40px;
            animation: cardIn 0.5s 0.35s ease both;
        }

        .qa-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 14px;
            padding: 18px 20px;
            text-decoration: none;
            color: rgba(248,250,252,0.7);
            font-size: 13.5px;
            font-weight: 500;
            transition: background 0.15s, border-color 0.15s, transform 0.15s, color 0.15s;
        }

        .qa-card svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .qa-card:hover {
            background: rgba(99,102,241,0.08);
            border-color: rgba(99,102,241,0.25);
            color: #a5b4fc;
            transform: translateY(-2px);
        }

        /* ── Info panel ── */
        .info-panel {
            background: rgba(99,102,241,0.05);
            border: 1px solid rgba(99,102,241,0.18);
            border-radius: 18px;
            padding: 28px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            animation: cardIn 0.5s 0.4s ease both;
        }

        .info-icon-wrap {
            background: rgba(99,102,241,0.15);
            border-radius: 12px;
            padding: 10px;
            flex-shrink: 0;
        }

        .info-icon-wrap svg { width: 22px; height: 22px; fill: #818cf8; }

        .info-text h3 {
            font-size: 15px;
            font-weight: 600;
            color: #c7d2fe;
            margin-bottom: 6px;
        }

        .info-text p {
            font-size: 13px;
            color: rgba(199,210,254,0.6);
            line-height: 1.6;
        }

        .info-text a {
            color: #818cf8;
            text-decoration: none;
        }

        .info-text a:hover { text-decoration: underline; }

        /* ── Flash alerts ── */
        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 24px;
            animation: fadeInDown 0.3s ease both;
        }

        .flash.success {
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.25);
            color: #6ee7b7;
        }

        .flash.error {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5;
        }

        .flash svg { width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; }
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
                <div class="brand-name">{{ config('app.name', 'Laravel') }}</div>
                <div class="brand-sub">Admin Panel</div>
            </div>
        </div>

        <div class="topbar-right">
            <div class="user-pill">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>

            <form class="logout-form" method="POST" action="{{ route('admin.logout') }}" id="admin-logout-form">
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
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="flash success" role="alert">
                    <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash error" role="alert">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v2z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="page-header">
                <h1>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, <span class="greeting-accent">{{ auth()->user()->name }}</span> 👋</h1>
                <p>Welcome to the administration portal for the DAL system.</p>
            </div>

            {{-- Stats --}}
            <div class="stats-grid">

                <a href="{{ route('admin.users.index') }}" class="stat-card">
                    <div class="stat-icon indigo">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">Total Users</div>
                </a>

                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="stat-card">
                    <div class="stat-icon purple">
                        <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 4.9c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 13c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                    </div>
                    <div class="stat-value">{{ $adminUsers }}</div>
                    <div class="stat-label">Admin Users</div>
                </a>

                <a href="{{ route('admin.users.index', ['role' => 'regular']) }}" class="stat-card">
                    <div class="stat-icon emerald">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div class="stat-value">{{ $regularUsers }}</div>
                    <div class="stat-label">Regular Users</div>
                </a>

            </div>

            {{-- Quick actions --}}
            <div class="section-title">Quick Actions</div>
            <div class="quick-actions">
                <a href="{{ route('admin.users.index') }}" class="qa-card" id="qa-manage-users">
                    <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    Manage Users
                </a>
                <a href="{{ route('admin.sso.show') }}" class="qa-card" id="qa-sso-settings">
                    <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    Azure AD SSO
                </a>
                <a href="{{ route('admin.email.show') }}" class="qa-card" id="qa-email-settings">
                    <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    Email &amp; Notifications
                </a>
                <a href="{{ route('admin.audit-log') }}" class="qa-card" id="qa-view-audit">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zm-2 9H7v-2h4v2zm4-4H7v-2h8v2zm0-4H7V8h2v2h6z"/></svg>
                    Audit Trail Log
                </a>
            </div>

            {{-- Info panel --}}
            <div class="info-panel">
                <div class="info-icon-wrap">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                </div>
                <div class="info-text">
                    <h3>Admin Panel Active</h3>
                    <p>
                        You are logged in as an administrator. Use the
                        <a href="{{ route('admin.users.index') }}">Users &amp; Access</a>
                        section to manage user accounts and roles.
                        To promote a user via Tinker:
                        <br><br>
                        <code style="background:rgba(0,0,0,0.3);padding:6px 10px;border-radius:6px;font-size:12px;display:inline-block;">
                            User::where('email', 'user@example.com')->update(['is_admin' => true]);
                        </code>
                    </p>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
