<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users & Access — {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Manage user accounts and admin roles.">
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

        .topbar-brand { display: flex; align-items: center; gap: 10px; }

        .brand-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        }
        .brand-icon svg { width: 18px; height: 18px; fill: #fff; }
        .brand-name { font-size: 15px; font-weight: 700; color: #f1f5f9; letter-spacing: -0.3px; }
        .brand-sub { font-size: 11px; font-weight: 500; color: rgba(241,245,249,0.4); letter-spacing: 0.08em; text-transform: uppercase; }

        .topbar-right { display: flex; align-items: center; gap: 16px; }

        .user-pill {
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 100px;
            padding: 6px 14px 6px 6px;
        }
        .avatar {
            width: 28px; height: 28px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff;
        }
        .user-name { font-size: 13px; font-weight: 500; color: rgba(241,245,249,0.8); }
        .logout-form { display: inline; }
        .btn-logout {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            color: #fca5a5;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 13px; font-weight: 500;
            padding: 8px 16px; cursor: pointer;
            transition: background 0.2s, border-color 0.2s, transform 0.15s;
        }
        .btn-logout:hover { background: rgba(239,68,68,0.18); border-color: rgba(239,68,68,0.45); transform: translateY(-1px); }

        /* ── Layout ── */
        .app-body { display: flex; flex: 1; }

        /* ── Sidebar ── */
        .sidebar {
            width: 220px; flex-shrink: 0;
            background: rgba(255,255,255,0.02);
            border-right: 1px solid rgba(255,255,255,0.06);
            padding: 24px 12px;
            display: flex; flex-direction: column; gap: 4px;
        }
        .sidebar-section {
            font-size: 10px; font-weight: 600;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: rgba(248,250,252,0.25);
            padding: 4px 12px 8px; margin-top: 8px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 10px;
            text-decoration: none;
            font-size: 13.5px; font-weight: 500;
            color: rgba(248,250,252,0.55);
            transition: background 0.15s, color 0.15s;
        }
        .nav-link svg { width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: rgba(248,250,252,0.9); }
        .nav-link.active { background: rgba(99,102,241,0.15); color: #a5b4fc; font-weight: 600; }

        /* ── Main ── */
        main { flex: 1; padding: 40px 36px; overflow-x: hidden; }

        /* ── Flash ── */
        .flash {
            display: flex; align-items: center; gap: 10px;
            border-radius: 12px; padding: 12px 18px;
            font-size: 13.5px; font-weight: 500;
            margin-bottom: 24px;
            animation: fadeInDown 0.3s ease both;
        }
        .flash.success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); color: #6ee7b7; }
        .flash.error   { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #fca5a5; }
        .flash svg { width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; }

        @keyframes fadeInDown { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes cardIn { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }

        /* ── Page header ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 32px;
            animation: fadeInDown 0.5s ease both;
        }
        .page-header-left h1 { font-size: 26px; font-weight: 800; color: #f8fafc; letter-spacing: -0.6px; }
        .page-header-left p  { font-size: 14px; color: rgba(248,250,252,0.4); margin-top: 4px; }

        /* ── Add user button ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: #fff; border: none; border-radius: 12px;
            font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 600;
            padding: 10px 20px; cursor: pointer;
            box-shadow: 0 4px 16px rgba(99,102,241,0.35);
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            text-decoration: none;
        }
        .btn-primary svg { width: 16px; height: 16px; fill: currentColor; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.45); }

        /* ── Controls bar ── */
        .controls-bar {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            animation: cardIn 0.4s 0.1s ease both;
        }

        .search-wrap {
            position: relative; flex: 1; min-width: 200px;
        }
        .search-wrap svg {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            width: 15px; height: 15px; fill: rgba(248,250,252,0.3);
            pointer-events: none;
        }
        .search-input {
            width: 100%; background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 10px; color: #e2e8f0;
            font-family: 'Inter', sans-serif; font-size: 13.5px;
            padding: 9px 14px 9px 38px;
            transition: border-color 0.2s, background 0.2s;
            outline: none;
        }
        .search-input::placeholder { color: rgba(248,250,252,0.3); }
        .search-input:focus { border-color: rgba(99,102,241,0.45); background: rgba(99,102,241,0.04); }

        .filter-tabs {
            display: flex; gap: 4px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px; padding: 4px;
        }
        .filter-tab {
            padding: 6px 14px; border-radius: 7px; border: none;
            font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 500;
            cursor: pointer; color: rgba(248,250,252,0.45);
            background: transparent;
            transition: background 0.15s, color 0.15s;
            text-decoration: none; display: inline-block;
        }
        .filter-tab:hover { color: rgba(248,250,252,0.8); }
        .filter-tab.active { background: rgba(99,102,241,0.2); color: #a5b4fc; }

        /* ── Table ── */
        .table-wrap {
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 18px;
            overflow: hidden;
            animation: cardIn 0.5s 0.15s ease both;
        }

        table { width: 100%; border-collapse: collapse; }

        thead { border-bottom: 1px solid rgba(255,255,255,0.06); }

        th {
            text-align: left; padding: 14px 20px;
            font-size: 11px; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase;
            color: rgba(248,250,252,0.3);
        }

        td { padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }

        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: rgba(255,255,255,0.02); }

        /* ── User cell ── */
        .user-cell { display: flex; align-items: center; gap: 12px; }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff;
        }
        .user-avatar.alt { background: linear-gradient(135deg, #0ea5e9, #6366f1); }
        .user-info-name { font-size: 13.5px; font-weight: 600; color: #f1f5f9; }
        .user-info-email { font-size: 12px; color: rgba(248,250,252,0.4); margin-top: 1px; }
        .self-badge {
            display: inline-block;
            background: rgba(99,102,241,0.15); color: #a5b4fc;
            font-size: 10px; font-weight: 700; letter-spacing: 0.06em;
            padding: 2px 7px; border-radius: 6px; margin-left: 6px; text-transform: uppercase;
        }

        /* ── Role badge ── */
        .role-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 11px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
        }
        .role-badge svg { width: 11px; height: 11px; fill: currentColor; }
        .role-badge.admin   { background: rgba(168,85,247,0.15); color: #c084fc; border: 1px solid rgba(168,85,247,0.25); }
        .role-badge.regular { background: rgba(100,116,139,0.15); color: #94a3b8;  border: 1px solid rgba(100,116,139,0.2); }

        /* ── Verified badge ── */
        .verified-dot {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12px; font-weight: 500;
        }
        .verified-dot svg { width: 13px; height: 13px; fill: currentColor; }
        .verified-dot.yes { color: #6ee7b7; }
        .verified-dot.no  { color: rgba(248,250,252,0.3); }

        /* ── Actions ── */
        .actions { display: flex; align-items: center; gap: 6px; }

        .action-btn {
            display: inline-flex; align-items: center; gap: 5px;
            border: none; border-radius: 8px; cursor: pointer;
            font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 500;
            padding: 6px 11px;
            transition: background 0.15s, color 0.15s, transform 0.12s;
        }
        .action-btn svg { width: 13px; height: 13px; fill: currentColor; }
        .action-btn:hover { transform: translateY(-1px); }

        .action-btn.promote  { background: rgba(168,85,247,0.12); color: #c084fc; }
        .action-btn.promote:hover { background: rgba(168,85,247,0.22); }
        .action-btn.demote   { background: rgba(100,116,139,0.12); color: #94a3b8; }
        .action-btn.demote:hover  { background: rgba(100,116,139,0.22); }
        .action-btn.reset    { background: rgba(14,165,233,0.1);  color: #7dd3fc; }
        .action-btn.reset:hover   { background: rgba(14,165,233,0.2); }
        .action-btn.delete   { background: rgba(239,68,68,0.1);   color: #fca5a5; }
        .action-btn.delete:hover  { background: rgba(239,68,68,0.2); }
        .action-btn:disabled { opacity: 0.35; cursor: default; transform: none; }

        /* ── Pagination ── */
        .pagination-wrap {
            display: flex; align-items: center; justify-content: space-between;
            padding: 18px 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            flex-wrap: wrap; gap: 12px;
        }
        .pagination-info { font-size: 12.5px; color: rgba(248,250,252,0.35); }
        .pagination-links { display: flex; gap: 4px; align-items: center; }
        .page-btn {
            min-width: 32px; height: 32px; border-radius: 8px; border: none;
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
            cursor: pointer; display: inline-flex; align-items: center; justify-content: center;
            text-decoration: none; padding: 0 8px;
            color: rgba(248,250,252,0.5);
            background: rgba(255,255,255,0.04);
            transition: background 0.15s, color 0.15s;
        }
        .page-btn:hover { background: rgba(255,255,255,0.08); color: #f1f5f9; }
        .page-btn.active { background: rgba(99,102,241,0.2); color: #a5b4fc; font-weight: 700; }
        .page-btn.disabled { opacity: 0.3; pointer-events: none; }

        /* ── Empty state ── */
        .empty-state {
            display: flex; flex-direction: column; align-items: center;
            gap: 12px; padding: 64px 20px;
            color: rgba(248,250,252,0.3);
        }
        .empty-state svg { width: 48px; height: 48px; fill: currentColor; opacity: 0.4; }
        .empty-state p { font-size: 14px; }

        /* ── Modal overlay ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(6px);
            z-index: 200;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity 0.2s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }

        .modal {
            background: #131325;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 32px;
            width: 100%; max-width: 480px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.6);
            transform: translateY(16px) scale(0.98);
            transition: transform 0.25s, opacity 0.2s;
        }
        .modal-overlay.open .modal { transform: translateY(0) scale(1); }

        .modal-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
        }
        .modal-title { font-size: 18px; font-weight: 700; color: #f8fafc; }
        .modal-close {
            background: rgba(255,255,255,0.06); border: none;
            width: 32px; height: 32px; border-radius: 8px;
            cursor: pointer; color: rgba(248,250,252,0.5);
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s, color 0.15s;
        }
        .modal-close:hover { background: rgba(255,255,255,0.1); color: #f1f5f9; }
        .modal-close svg { width: 16px; height: 16px; fill: currentColor; }

        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block; font-size: 12.5px; font-weight: 600;
            color: rgba(248,250,252,0.55); margin-bottom: 7px;
            letter-spacing: 0.04em;
        }
        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 10px; color: #e2e8f0;
            font-family: 'Inter', sans-serif; font-size: 14px;
            padding: 10px 14px; outline: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .form-input::placeholder { color: rgba(248,250,252,0.25); }
        .form-input:focus { border-color: rgba(99,102,241,0.45); background: rgba(99,102,241,0.04); }
        .form-input.is-error { border-color: rgba(239,68,68,0.5); }

        .form-error { font-size: 12px; color: #fca5a5; margin-top: 5px; }

        .form-checkbox-row {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px; cursor: pointer;
            transition: background 0.15s;
        }
        .form-checkbox-row:hover { background: rgba(255,255,255,0.05); }
        .form-checkbox-row input[type="checkbox"] { accent-color: #6366f1; width: 16px; height: 16px; cursor: pointer; }
        .form-checkbox-label { font-size: 13px; color: rgba(248,250,252,0.7); cursor: pointer; }

        .modal-actions { display: flex; gap: 10px; margin-top: 24px; justify-content: flex-end; }
        .btn-cancel {
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.09);
            color: rgba(248,250,252,0.6); border-radius: 10px;
            font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 500;
            padding: 10px 20px; cursor: pointer;
            transition: background 0.15s, color 0.15s;
        }
        .btn-cancel:hover { background: rgba(255,255,255,0.09); color: #f1f5f9; }
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

        {{-- ── Sidebar ── --}}
        <nav class="sidebar">
            <div class="sidebar-section">Navigation</div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               id="sidebar-dashboard">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
               id="sidebar-users">
                <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                Users & Access
            </a>

            <a href="{{ route('admin.audit-log') }}"
               class="nav-link {{ request()->routeIs('admin.audit-log') ? 'active' : '' }}"
               id="sidebar-audit-log">
                <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zm-2 9H7v-2h4v2zm4-4H7v-2h8v2zm0-4H7V8h2v2h6z"/></svg>
                Audit Log
            </a>
        </nav>

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
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page header --}}
            <div class="page-header">
                <div class="page-header-left">
                    <h1>Users &amp; Access</h1>
                    <p>{{ $totalUsers }} total · {{ $adminUsers }} admin{{ $adminUsers !== 1 ? 's' : '' }} · {{ $regularUsers }} regular</p>
                </div>
                <button class="btn-primary" id="open-create-modal" type="button">
                    <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Add User
                </button>
            </div>

            {{-- Controls bar --}}
            <form method="GET" action="{{ route('admin.users.index') }}" id="filter-form">
                <div class="controls-bar">
                    <div class="search-wrap">
                        <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        <input
                            type="text"
                            name="search"
                            id="search-input"
                            class="search-input"
                            placeholder="Search by name or email…"
                            value="{{ $search }}"
                            autocomplete="off"
                        >
                    </div>

                    <div class="filter-tabs" role="group" aria-label="Filter by role">
                        @foreach(['all' => 'All', 'admin' => 'Admins', 'regular' => 'Regular'] as $key => $label)
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => $key, 'page' => 1])) }}"
                               class="filter-tab {{ $role === $key ? 'active' : '' }}"
                               id="filter-{{ $key }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
            </form>

            {{-- Users table --}}
            <div class="table-wrap" id="users-table-wrap">
                @if($users->isEmpty())
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        <p>No users found{{ $search ? ' for "'.e($search).'"' : '' }}.</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Role</th>
                                <th>Verified</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr id="user-row-{{ $user->id }}">
                                {{-- User info --}}
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar {{ $loop->even ? 'alt' : '' }}">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="user-info-name">
                                                {{ $user->name }}
                                                @if($user->id === auth()->id())
                                                    <span class="self-badge">You</span>
                                                @endif
                                            </div>
                                            <div class="user-info-email">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Role --}}
                                <td>
                                    @if($user->is_admin)
                                        <span class="role-badge admin">
                                            <svg viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg>
                                            Admin
                                        </span>
                                    @else
                                        <span class="role-badge regular">
                                            <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                            Regular
                                        </span>
                                    @endif
                                </td>

                                {{-- Verified --}}
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="verified-dot yes">
                                            <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                            Verified
                                        </span>
                                    @else
                                        <span class="verified-dot no">
                                            <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                                            Unverified
                                        </span>
                                    @endif
                                </td>

                                {{-- Joined --}}
                                <td style="color:rgba(248,250,252,0.4);font-size:13px;">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="actions">

                                        {{-- Promote / Demote --}}
                                        <form method="POST"
                                              action="{{ route('admin.users.toggle-admin', $user) }}"
                                              id="toggle-form-{{ $user->id }}"
                                              onsubmit="return confirmToggle(this, '{{ addslashes($user->name) }}', {{ $user->is_admin ? 'true' : 'false' }})">
                                            @csrf
                                            @if($user->is_admin)
                                                <button type="submit"
                                                        class="action-btn demote"
                                                        {{ $user->id === auth()->id() ? 'disabled title=Cannot change your own role' : '' }}
                                                        id="demote-btn-{{ $user->id }}">
                                                    <svg viewBox="0 0 24 24"><path d="M7 11v2h10v-2H7zm5-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                                                    Demote
                                                </button>
                                            @else
                                                <button type="submit"
                                                        class="action-btn promote"
                                                        {{ $user->id === auth()->id() ? 'disabled title=Cannot change your own role' : '' }}
                                                        id="promote-btn-{{ $user->id }}">
                                                    <svg viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg>
                                                    Promote
                                                </button>
                                            @endif
                                        </form>

                                        {{-- Send password reset --}}
                                        <form method="POST"
                                              action="{{ route('admin.users.send-password-reset', $user) }}"
                                              id="reset-form-{{ $user->id }}"
                                              onsubmit="return confirmReset('{{ addslashes($user->email) }}')">
                                            @csrf
                                            <button type="submit" class="action-btn reset" id="reset-btn-{{ $user->id }}"
                                                    title="Send password reset email">
                                                <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                                                Reset PW
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form method="POST"
                                              action="{{ route('admin.users.destroy', $user) }}"
                                              id="delete-form-{{ $user->id }}"
                                              onsubmit="return confirmDelete('{{ addslashes($user->name) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="action-btn delete"
                                                    {{ $user->id === auth()->id() ? 'disabled title=Cannot delete your own account' : '' }}
                                                    id="delete-btn-{{ $user->id }}">
                                                <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if($users->hasPages())
                    <div class="pagination-wrap">
                        <div class="pagination-info">
                            Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
                        </div>
                        <div class="pagination-links" role="navigation" aria-label="Pagination">
                            {{-- Previous --}}
                            @if($users->onFirstPage())
                                <span class="page-btn disabled" aria-disabled="true">
                                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                                </span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" class="page-btn" aria-label="Previous page">
                                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                                </a>
                            @endif

                            {{-- Page numbers --}}
                            @foreach($users->getUrlRange(max(1, $users->currentPage()-2), min($users->lastPage(), $users->currentPage()+2)) as $page => $url)
                                @if($page === $users->currentPage())
                                    <span class="page-btn active" aria-current="page">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="page-btn" aria-label="Next page">
                                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                </a>
                            @else
                                <span class="page-btn disabled" aria-disabled="true">
                                    <svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif

                @endif
            </div>
        </main>
    </div>

    {{-- ── Create User Modal ── --}}
    <div class="modal-overlay" id="create-user-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title" id="modal-title">Add New User</div>
                <button class="modal-close" id="close-create-modal" type="button" aria-label="Close">
                    <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" id="create-user-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="create-name">Full Name</label>
                    <input type="text" name="name" id="create-name"
                           class="form-input {{ $errors->has('name') ? 'is-error' : '' }}"
                           value="{{ old('name') }}" placeholder="John Doe" required autocomplete="name">
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="create-email">Email Address</label>
                    <input type="email" name="email" id="create-email"
                           class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                           value="{{ old('email') }}" placeholder="john@example.com" required autocomplete="email">
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="create-password">Password</label>
                    <input type="password" name="password" id="create-password"
                           class="form-input {{ $errors->has('password') ? 'is-error' : '' }}"
                           placeholder="Min. 8 characters" required autocomplete="new-password">
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="create-password-confirm">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="create-password-confirm"
                           class="form-input"
                           placeholder="Repeat password" required autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label class="form-checkbox-row" for="create-is-admin">
                        <input type="checkbox" name="is_admin" id="create-is-admin" value="1"
                               {{ old('is_admin') ? 'checked' : '' }}>
                        <span class="form-checkbox-label">Grant admin privileges</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-checkbox-row" for="create-send-verification">
                        <input type="checkbox" name="send_verification" id="create-send-verification" value="1"
                               {{ old('send_verification', true) ? 'checked' : '' }}>
                        <span class="form-checkbox-label">Send email verification link</span>
                    </label>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="cancel-create-modal">Cancel</button>
                    <button type="submit" class="btn-primary" id="create-user-submit">
                        <svg viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ── Modal open/close ──
        const overlay     = document.getElementById('create-user-modal');
        const openBtn     = document.getElementById('open-create-modal');
        const closeBtn    = document.getElementById('close-create-modal');
        const cancelBtn   = document.getElementById('cancel-create-modal');

        function openModal() { overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeModal() { overlay.classList.remove('open'); document.body.style.overflow = ''; }

        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

        // Auto-open if there are validation errors (form was submitted)
        @if($errors->any())
            openModal();
        @endif

        // Auto-open if hash is #create-user
        if (window.location.hash === '#create-user') { openModal(); }

        // ── Search debounce ──
        const searchInput = document.getElementById('search-input');
        let searchTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                const url = new URL(window.location.href);
                url.searchParams.set('search', searchInput.value);
                url.searchParams.set('page', '1');
                window.location.href = url.toString();
            }, 500);
        });

        // ── Confirm dialogs ──
        function confirmToggle(form, name, isAdmin) {
            const action = isAdmin ? 'demote' : 'promote';
            const role   = isAdmin ? 'Regular User' : 'Admin';
            return confirm(`${action.charAt(0).toUpperCase() + action.slice(1)} "${name}" to ${role}?`);
        }

        function confirmReset(email) {
            return confirm(`Send a password reset email to "${email}"?`);
        }

        function confirmDelete(name) {
            return confirm(`Permanently delete "${name}"? This action cannot be undone.`);
        }
    </script>
</body>
</html>
