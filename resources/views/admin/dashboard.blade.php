<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard &amp; Analytics — {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Administrator dashboard and traffic analytics panel.">
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
            min-height: calc(100vh - 64px);
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
            transition: width 0.22s cubic-bezier(0.4, 0, 0.2, 1), padding 0.22s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.18s ease;
            white-space: nowrap;
            overflow-x: hidden;
            overflow-y: auto;
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
            width: 16px !important;
            height: 16px !important;
            min-width: 16px;
            min-height: 16px;
            max-width: 16px;
            max-height: 16px;
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
            padding: 32px 36px;
            overflow-x: hidden;
        }

        .page-header {
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: #f8fafc;
            letter-spacing: -0.6px;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .page-header p {
            color: rgba(248,250,252,0.45);
            font-size: 14px;
        }

        .greeting-accent {
            background: linear-gradient(90deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Date Filter Bar ── */
        .date-filter-bar {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .period-pills {
            display: flex;
            gap: 6px;
            background: rgba(0,0,0,0.3);
            padding: 4px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .period-pill {
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            color: rgba(248,250,252,0.6);
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .period-pill:hover {
            color: #f8fafc;
            background: rgba(255,255,255,0.06);
        }

        .period-pill.active {
            background: #6366f1;
            color: #ffffff;
            box-shadow: 0 2px 10px rgba(99,102,241,0.4);
        }

        .custom-range-form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .date-input {
            background: #16162c;
            border: 1px solid rgba(255,255,255,0.12);
            color: #f8fafc;
            padding: 7px 12px;
            border-radius: 8px;
            font-size: 12.5px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.15s;
            color-scheme: dark;
        }

        .date-input:focus {
            border-color: #818cf8;
        }

        .btn-apply-filter {
            background: rgba(99,102,241,0.2);
            border: 1px solid rgba(99,102,241,0.4);
            color: #c7d2fe;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-apply-filter:hover {
            background: #6366f1;
            color: #ffffff;
        }

        /* ── KPI Grid ── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .kpi-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, border-color 0.2s;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            border-color: rgba(255,255,255,0.15);
        }

        .kpi-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kpi-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kpi-icon svg { width: 18px; height: 18px; fill: currentColor; }

        .kpi-icon.blue   { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .kpi-icon.green  { background: rgba(34,197,94,0.15);  color: #4ade80; }
        .kpi-icon.amber  { background: rgba(245,158,11,0.15); color: #fbbf24; }
        .kpi-icon.purple { background: rgba(168,85,247,0.15); color: #c084fc; }

        .kpi-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .badge-today { background: rgba(34,197,94,0.15); color: #86efac; }
        .badge-info  { background: rgba(99,102,241,0.15); color: #a5b4fc; }

        .kpi-value {
            font-size: 26px;
            font-weight: 800;
            color: #f8fafc;
            letter-spacing: -0.5px;
        }

        .kpi-label {
            font-size: 12.5px;
            color: rgba(248,250,252,0.45);
            font-weight: 500;
        }

        /* ── Glass Panel ── */
        .glass-panel {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .panel-title {
            font-size: 15px;
            font-weight: 700;
            color: #f8fafc;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-subtitle {
            font-size: 12px;
            color: rgba(248,250,252,0.4);
        }

        /* ── Chart Styles ── */
        .chart-container {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: flex-end;
            gap: 10px;
            padding-top: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding-bottom: 8px;
        }

        .chart-bar-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            height: 100%;
            justify-content: flex-end;
            position: relative;
        }

        .chart-bar {
            width: 100%;
            max-width: 32px;
            background: linear-gradient(180deg, #6366f1 0%, rgba(99,102,241,0.3) 100%);
            border-radius: 6px 6px 0 0;
            transition: all 0.2s ease;
            position: relative;
            min-height: 4px;
        }

        .chart-bar-group:hover .chart-bar {
            background: linear-gradient(180deg, #818cf8 0%, rgba(129,140,248,0.5) 100%);
            box-shadow: 0 0 12px rgba(99,102,241,0.5);
        }

        .chart-bar-tooltip {
            position: absolute;
            bottom: calc(100% + 8px);
            background: #1e1e38;
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
            z-index: 10;
        }

        .chart-bar-group:hover .chart-bar-tooltip {
            opacity: 1;
        }

        .chart-label {
            font-size: 11px;
            color: rgba(248,250,252,0.4);
            font-weight: 500;
        }

        /* ── 2-Column Analytics Grid ── */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        @media (max-width: 900px) {
            .analytics-grid { grid-template-columns: 1fr; }
        }

        /* ── Progress Breakdown Item ── */
        .breakdown-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .breakdown-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .breakdown-info {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 500;
        }

        .breakdown-title { color: #f1f5f9; }
        .breakdown-count { color: rgba(248,250,252,0.5); font-size: 12px; }

        .progress-track {
            height: 7px;
            background: rgba(255,255,255,0.06);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fill-blue   { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .fill-purple { background: linear-gradient(90deg, #8b5cf6, #c084fc); }

        /* ── Search Pills Cloud ── */
        .search-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .search-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12.5px;
            color: #cbd5e1;
            transition: all 0.15s;
        }

        .search-pill:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.18);
            color: #f8fafc;
        }

        .search-badge {
            background: rgba(99,102,241,0.25);
            color: #a5b4fc;
            padding: 1px 6px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
        }

        /* ── Activity Table / Feed ── */
        .activity-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .activity-table th {
            text-align: left;
            padding: 10px 12px;
            color: rgba(248,250,252,0.35);
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .activity-table td {
            padding: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            vertical-align: middle;
        }

        .act-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .act-login  { background: rgba(59,130,246,0.15); color: #60a5fa; }
        .act-update { background: rgba(245,158,11,0.15); color: #fbbf24; }
        .act-create { background: rgba(34,197,94,0.15);  color: #4ade80; }
        .act-delete { background: rgba(239,68,68,0.15);  color: #f87171; }
        .act-other  { background: rgba(168,85,247,0.15); color: #c084fc; }

        /* ── Quick Links ── */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }

        .qa-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #e2e8f0;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.15s;
        }

        .qa-card svg {
            width: 18px;
            height: 18px;
            fill: #818cf8;
            flex-shrink: 0;
        }

        .qa-card:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(99,102,241,0.3);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    {{-- Topbar --}}
    <header class="topbar">
        <div class="topbar-brand">
            <button type="button" onclick="toggleAdminSidebar()" class="admin-sidebar-toggle-btn" title="Toggle Side Menu" id="btn-toggle-admin-sidebar">
                <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
            </button>
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
            </div>
            <div>
                <div class="brand-name">DAL Console</div>
                <div class="brand-sub">Administration &amp; Analytics</div>
            </div>
        </div>

        <div class="topbar-right">
            <div class="user-pill">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
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
                <div style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#86efac;border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:13.5px;">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:13.5px;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <div class="page-header">
                <div>
                    <h1>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, <span class="greeting-accent">{{ auth()->user()->name }}</span> 👋</h1>
                    <p>Showing traffic metrics and delegation analytics for: <strong style="color:#a5b4fc;">{{ $periodLabel }}</strong></p>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 8px #22c55e;"></span>
                    <span style="font-size:12.5px;color:#86efac;font-weight:600;">Live Tracking Active</span>
                </div>
            </div>

            {{-- ── DATE RANGE & PERIOD FILTER BAR ── --}}
            <div class="date-filter-bar">
                <div class="period-pills">
                    <a href="{{ route('admin.dashboard', ['period' => 'daily']) }}"
                       class="period-pill {{ $period === 'daily' ? 'active' : '' }}" id="filter-daily">
                        ☀️ Daily (Today)
                    </a>
                    <a href="{{ route('admin.dashboard', ['period' => 'weekly']) }}"
                       class="period-pill {{ $period === 'weekly' ? 'active' : '' }}" id="filter-weekly">
                        📅 Weekly (7d)
                    </a>
                    <a href="{{ route('admin.dashboard', ['period' => 'monthly']) }}"
                       class="period-pill {{ $period === 'monthly' ? 'active' : '' }}" id="filter-monthly">
                        🗓️ Monthly (30d)
                    </a>
                </div>

                {{-- Custom Date Range Form --}}
                <form method="GET" action="{{ route('admin.dashboard') }}" class="custom-range-form">
                    <input type="hidden" name="period" value="custom">
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-size:12px;color:rgba(248,250,252,0.5);">From:</span>
                        <input type="date" name="from_date" value="{{ $inputFromDate }}" class="date-input" required>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-size:12px;color:rgba(248,250,252,0.5);">To:</span>
                        <input type="date" name="to_date" value="{{ $inputToDate }}" class="date-input" required>
                    </div>
                    <button type="submit" class="btn-apply-filter" id="btn-apply-date-range">
                        Apply Range
                    </button>
                    @if($period === 'custom' || $period === 'daily' || $period === 'weekly')
                        <a href="{{ route('admin.dashboard', ['period' => 'monthly']) }}"
                           style="font-size:12px;color:#94a3b8;text-decoration:none;padding:4px 6px;">Reset</a>
                    @endif
                </form>
            </div>

            {{-- ── 1. KPI Cards Grid (Filtered) ── --}}
            <div class="kpi-grid">
                {{-- Period Hits --}}
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon blue">
                            <svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                        </div>
                        <span class="kpi-badge badge-today">+{{ $viewsToday }} today</span>
                    </div>
                    <div>
                        <div class="kpi-value">{{ number_format($periodViews) }}</div>
                        <div class="kpi-label">Matrix Views (in selected range)</div>
                    </div>
                </div>

                {{-- Period Unique Visitors --}}
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon green">
                            <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        </div>
                        <span class="kpi-badge badge-today">{{ $uniqueUsersToday }} active today</span>
                    </div>
                    <div>
                        <div class="kpi-value">{{ number_format($periodUniqueUsers) }}</div>
                        <div class="kpi-label">Active Users (in selected range)</div>
                    </div>
                </div>

                {{-- Searches Invocations --}}
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon amber">
                            <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        </div>
                        <span class="kpi-badge badge-info">{{ $period }}</span>
                    </div>
                    <div>
                        <div class="kpi-value">{{ number_format($periodSearches) }}</div>
                        <div class="kpi-label">Clause Searches Executed</div>
                    </div>
                </div>

                {{-- Total Registered Users --}}
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon purple">
                            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <span class="kpi-badge badge-info">{{ $ssoUsers }} SSO linked</span>
                    </div>
                    <div>
                        <div class="kpi-value">{{ $totalUsers }}</div>
                        <div class="kpi-label">Registered Accounts</div>
                    </div>
                </div>
            </div>

            {{-- ── 2. Filtered Traffic Trend Chart ── --}}
            <div class="glass-panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">
                            <svg style="width:18px;height:18px;fill:#818cf8;" viewBox="0 0 24 24"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/></svg>
                            Traffic &amp; Engagement Activity ({{ $periodLabel }})
                        </div>
                        <div class="panel-subtitle">Activity trend across the selected timeline</div>
                    </div>
                    <div style="font-size:12px;color:#94a3b8;display:flex;align-items:center;gap:12px;">
                        <span style="display:inline-flex;align-items:center;gap:4px;"><span style="width:10px;height:10px;border-radius:2px;background:#6366f1;display:inline-block;"></span> Page Views</span>
                    </div>
                </div>

                <div class="chart-container">
                    @forelse($chartData as $slot)
                        @php
                            $heightPct = round(($slot['views'] / $maxChartViews) * 100);
                            $heightPct = max(6, $heightPct);
                        @endphp
                        <div class="chart-bar-group">
                            <div class="chart-bar-tooltip">
                                <strong>{{ $slot['label'] }}</strong>: {{ $slot['views'] }} views ({{ $slot['users'] }} users, {{ $slot['searches'] }} searches)
                            </div>
                            <div class="chart-bar" style="height:{{ $heightPct }}%;"></div>
                            <div class="chart-label">{{ $slot['label'] }}</div>
                        </div>
                    @empty
                        <div style="color:#64748b;font-size:13px;text-align:center;width:100%;padding:40px 0;">No traffic logged in this period.</div>
                    @endforelse
                </div>
            </div>

            {{-- ── 3. Two-Column Analytics Grid (Filtered) ── --}}
            <div class="analytics-grid">

                {{-- Column 1: Categories & Department Traffic --}}
                <div style="display:flex;flex-direction:column;gap:24px;">

                    {{-- Category Traffic Distribution --}}
                    <div class="glass-panel" style="margin-bottom:0;">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">
                                    <svg style="width:18px;height:18px;fill:#60a5fa;" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                                    Category Traffic Breakdown
                                </div>
                                <div class="panel-subtitle">Access distribution for {{ $periodLabel }}</div>
                            </div>
                        </div>

                        <div class="breakdown-list">
                            @forelse($categoryBreakdown as $c)
                                <div class="breakdown-item">
                                    <div class="breakdown-info">
                                        <span class="breakdown-title">
                                            <strong>{{ $c['code'] }}</strong> {{ $c['name'] }}
                                        </span>
                                        <span class="breakdown-count">{{ $c['count'] }} views ({{ $c['pct'] }}%)</span>
                                    </div>
                                    <div class="progress-track">
                                        <div class="progress-fill fill-blue" style="width:{{ $c['pct'] }}%;"></div>
                                    </div>
                                </div>
                            @empty
                                <div style="color:#64748b;font-size:13px;text-align:center;padding:20px 0;">No category traffic recorded in this period.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Department Access Activity --}}
                    <div class="glass-panel" style="margin-bottom:0;">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">
                                    <svg style="width:18px;height:18px;fill:#c084fc;" viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                                    Department Access Activity
                                </div>
                                <div class="panel-subtitle">Traffic volume grouped by corporate unit</div>
                            </div>
                        </div>

                        <div class="breakdown-list">
                            @forelse($departmentBreakdown as $d)
                                <div class="breakdown-item">
                                    <div class="breakdown-info">
                                        <span class="breakdown-title">{{ $d['name'] }}</span>
                                        <span class="breakdown-count">{{ $d['count'] }} hits ({{ $d['pct'] }}%)</span>
                                    </div>
                                    <div class="progress-track">
                                        <div class="progress-fill fill-purple" style="width:{{ $d['pct'] }}%;"></div>
                                    </div>
                                </div>
                            @empty
                                <div style="color:#64748b;font-size:13px;text-align:center;padding:20px 0;">No department traffic recorded in this period.</div>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- Column 2: Search Queries, Devices & Country Filter --}}
                <div style="display:flex;flex-direction:column;gap:24px;">

                    {{-- Top Search Queries --}}
                    <div class="glass-panel" style="margin-bottom:0;">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">
                                    <svg style="width:18px;height:18px;fill:#fbbf24;" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                                    Top Search Terms &amp; Keywords
                                </div>
                                <div class="panel-subtitle">Popular clauses queried in this period</div>
                            </div>
                        </div>

                        <div class="search-cloud">
                            @forelse($topSearches as $s)
                                <div class="search-pill">
                                    <span>🔍 {{ $s->search_query }}</span>
                                    <span class="search-badge">{{ $s->count }}x</span>
                                </div>
                            @empty
                                <div style="color:#64748b;font-size:13px;padding:10px 0;">No search queries recorded in this period.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Device & Platform Distribution --}}
                    <div class="glass-panel" style="margin-bottom:0;">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">
                                    <svg style="width:18px;height:18px;fill:#4ade80;" viewBox="0 0 24 24"><path d="M4 6h16v10H4zm16 12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2H0v2h24v-2z"/></svg>
                                    Device &amp; Platform Distribution
                                </div>
                                <div class="panel-subtitle">Access by desktop, mobile and tablet devices</div>
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                            <div style="flex:1;">
                                <div style="display:flex;justify-content:space-between;font-size:12.5px;margin-bottom:6px;">
                                    <span style="color:#cbd5e1;">💻 Desktop ({{ $deviceBreakdown['desktop'] }}%)</span>
                                    <span style="color:#cbd5e1;">📱 Mobile ({{ $deviceBreakdown['mobile'] }}%)</span>
                                    <span style="color:#cbd5e1;">📟 Tablet ({{ $deviceBreakdown['tablet'] }}%)</span>
                                </div>
                                <div style="display:flex;height:10px;border-radius:10px;overflow:hidden;background:rgba(255,255,255,0.06);">
                                    <div style="width:{{ $deviceBreakdown['desktop'] }}%;background:#6366f1;" title="Desktop"></div>
                                    <div style="width:{{ $deviceBreakdown['mobile'] }}%;background:#10b981;" title="Mobile"></div>
                                    <div style="width:{{ $deviceBreakdown['tablet'] }}%;background:#f59e0b;" title="Tablet"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Country Filter Stats --}}
                        <div style="border-top:1px solid rgba(255,255,255,0.06);padding-top:14px;margin-top:14px;">
                            <div style="font-size:12px;font-weight:700;color:rgba(248,250,252,0.4);text-transform:uppercase;margin-bottom:10px;">
                                Country Filter Engagement
                            </div>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <span style="font-size:12px;padding:4px 10px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);color:#cbd5e1;">
                                    🇲🇾 Malaysia: <strong>{{ $countryUsage['MY'] ?? 0 }}</strong>
                                </span>
                                <span style="font-size:12px;padding:4px 10px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);color:#cbd5e1;">
                                    🇸🇬 Singapore: <strong>{{ $countryUsage['SG'] ?? 0 }}</strong>
                                </span>
                                <span style="font-size:12px;padding:4px 10px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);color:#cbd5e1;">
                                    🇦🇺 Australia: <strong>{{ $countryUsage['AU'] ?? 0 }}</strong>
                                </span>
                                <span style="font-size:12px;padding:4px 10px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);color:#cbd5e1;">
                                    🇻🇳 Vietnam: <strong>{{ $countryUsage['VN'] ?? 0 }}</strong>
                                </span>
                                <span style="font-size:12px;padding:4px 10px;border-radius:6px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);color:#cbd5e1;">
                                    🇯🇵 Japan: <strong>{{ $countryUsage['JP'] ?? 0 }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            {{-- ── 4. Recent Audit & Activity Stream ── --}}
            <div class="glass-panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title">
                            <svg style="width:18px;height:18px;fill:#86efac;" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zm-2 9H7v-2h4v2zm4-4H7v-2h8v2zm0-4H7V8h2v2h6z"/></svg>
                            Recent System Audit &amp; Administrative Actions
                        </div>
                        <div class="panel-subtitle">Live events log of user and master data updates</div>
                    </div>
                    <a href="{{ route('admin.audit-log') }}" style="font-size:12.5px;color:#a5b4fc;text-decoration:none;font-weight:600;">
                        View Full Audit Trail &rarr;
                    </a>
                </div>

                <div style="overflow-x:auto;">
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Actor</th>
                                <th>Action</th>
                                <th>Target / Resource</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $act)
                                @php
                                    $actionType = $act->action;
                                    $badgeClass = 'act-other';
                                    if (str_contains($actionType, 'login'))  $badgeClass = 'act-login';
                                    if (str_contains($actionType, 'update')) $badgeClass = 'act-update';
                                    if (str_contains($actionType, 'create')) $badgeClass = 'act-create';
                                    if (str_contains($actionType, 'delete')) $badgeClass = 'act-delete';
                                @endphp
                                <tr>
                                    <td style="color:#94a3b8;font-size:12px;white-space:nowrap;">
                                        {{ $act->created_at ? $act->created_at->diffForHumans() : '-' }}
                                    </td>
                                    <td style="font-weight:600;color:#f8fafc;">
                                        {{ $act->user_name ?: ($act->user_email ?: 'System') }}
                                    </td>
                                    <td>
                                        <span class="act-badge {{ $badgeClass }}">
                                            {{ str_replace('_', ' ', $act->action) }}
                                        </span>
                                    </td>
                                    <td style="color:#cbd5e1;font-size:12.5px;">
                                        {{ $act->subject_label ?: ($act->subject_type ? $act->subject_type . ' #' . $act->subject_id : '-') }}
                                    </td>
                                    <td style="color:#64748b;font-family:monospace;font-size:11.5px;">
                                        {{ $act->ip_address ?: '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center;color:#64748b;padding:24px 0;">No recent activity logs recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── 5. Quick Administrative Tools ── --}}
            <div class="panel-header" style="margin-bottom:14px;">
                <div class="panel-title" style="font-size:14px;color:rgba(248,250,252,0.6);">Quick Administration Actions</div>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.categories.index') }}" class="qa-card" id="qa-category-master">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    Category Master
                </a>
                <a href="{{ route('admin.departments.index') }}" class="qa-card" id="qa-department-master">
                    <svg viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                    Department Master
                </a>
                <a href="{{ route('admin.mappings.index') }}" class="qa-card" id="qa-dept-mapping">
                    <svg viewBox="0 0 24 24"><path d="M10.59 13.41c.41.39.41 1.03 0 1.42-.39.39-1.03.39-1.42 0a5.003 5.003 0 0 1 0-7.07l3.54-3.54a5.003 5.003 0 0 1 7.07 0 5.003 5.003 0 0 1 0 7.07l-1.49 1.49c.01-.82-.12-1.64-.4-2.42l.47-.48a2.982 2.982 0 0 0 0-4.24 2.982 2.982 0 0 0-4.24 0l-3.53 3.53a2.982 2.982 0 0 0 0 4.24zm2.82-2.82c-.41-.39-.41-1.03 0-1.42.39-.39 1.03-.39 1.42 0a5.003 5.003 0 0 1 0 7.07l-3.54 3.54a5.003 5.003 0 0 1-7.07 0 5.003 5.003 0 0 1 0-7.07l1.49-1.49c-.01.82.12 1.64.4 2.43l-.47.47a2.982 2.982 0 0 0 0 4.24 2.982 2.982 0 0 0 4.24 0l3.53-3.53a2.982 2.982 0 0 0 0-4.24z"/></svg>
                    Dept ↔ DAL Matrix
                </a>
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
                    Email Settings
                </a>
            </div>
        </main>
    </div>

</body>
</html>
