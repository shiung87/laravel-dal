<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' — ' : '' }}{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ────────────────────────────────────────
           TOPBAR
        ──────────────────────────────────────── */
        .app-topbar {
            position: sticky;
            top: 0;
            z-index: 200;
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px 0 0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0;
        }

        /* Hamburger — visible on mobile */
        .sidebar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            margin-left: 8px;
            border-radius: 8px;
            transition: background 0.15s;
        }
        .sidebar-toggle:hover { background: #f1f5f9; }
        .sidebar-toggle svg { width: 20px; height: 20px; fill: currentColor; }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 220px;      /* matches sidebar width */
            padding-left: 20px;
            text-decoration: none;
        }

        .brand-icon {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #0b3b63, #1e5f94);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 3px 8px rgba(11,59,99,0.3);
            flex-shrink: 0;
        }
        .brand-icon svg { width: 16px; height: 16px; fill: #f7d768; }

        .brand-name {
            font-size: 14px;
            font-weight: 700;
            color: #0b3b63;
            letter-spacing: -0.3px;
            line-height: 1.1;
        }
        .brand-sub {
            font-size: 10px;
            color: #94a3b8;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* User dropdown */
        .user-menu-wrap { position: relative; }

        .user-btn {
            display: flex; align-items: center; gap: 9px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 100px;
            padding: 5px 14px 5px 5px;
            cursor: pointer;
            transition: background 0.15s, border-color 0.15s;
        }
        .user-btn:hover { background: #f1f5f9; border-color: #cbd5e1; }

        .user-avatar {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, #0b3b63, #1e5f94);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #f7d768;
        }
        .user-btn-name { font-size: 13px; font-weight: 600; color: #334155; }
        .user-btn-chevron { width: 14px; height: 14px; fill: #94a3b8; transition: transform 0.2s; }
        .user-btn[aria-expanded="true"] .user-btn-chevron { transform: rotate(180deg); }

        .user-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 200px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
            display: none;
            z-index: 300;
        }
        .user-dropdown.open { display: block; animation: dropIn 0.15s ease; }

        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .dropdown-header {
            padding: 14px 16px 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .dropdown-header-name { font-size: 13px; font-weight: 700; color: #1e293b; }
        .dropdown-header-email { font-size: 12px; color: #94a3b8; margin-top: 2px; }

        .dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px;
            font-size: 13px; font-weight: 500; color: #475569;
            text-decoration: none;
            transition: background 0.12s;
        }
        .dropdown-item svg { width: 15px; height: 15px; fill: currentColor; flex-shrink: 0; }
        .dropdown-item:hover { background: #f8fafc; color: #0b3b63; }
        .dropdown-item.danger { color: #dc2626; }
        .dropdown-item.danger:hover { background: #fef2f2; }
        .dropdown-divider { height: 1px; background: #f1f5f9; margin: 4px 0; }

        /* ────────────────────────────────────────
           BODY WRAPPER
        ──────────────────────────────────────── */
        .app-body {
            display: flex;
            flex: 1;
            min-height: 0;
        }

        /* ────────────────────────────────────────
           SIDEBAR
        ──────────────────────────────────────── */
        .app-sidebar {
            width: 220px;
            flex-shrink: 0;
            background: #fff;
            border-right: 1px solid #e2e8f0;
            padding: 20px 10px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            overflow-y: auto;
            transition: transform 0.25s;
        }

        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #cbd5e1;
            padding: 10px 12px 6px;
            margin-top: 6px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            color: #64748b;
            transition: background 0.13s, color 0.13s;
        }
        .sidebar-link svg {
            width: 16px; height: 16px;
            fill: currentColor;
            flex-shrink: 0;
        }
        .sidebar-link:hover {
            background: #f1f5f9;
            color: #0b3b63;
        }
        .sidebar-link.active {
            background: #eff6ff;
            color: #0b3b63;
            font-weight: 700;
        }
        .sidebar-link.active svg {
            color: #0b3b63;
        }

        /* Admin-only indicator */
        .sidebar-badge {
            margin-left: auto;
            background: #fef3c7;
            color: #92400e;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* ────────────────────────────────────────
           MAIN CONTENT
        ──────────────────────────────────────── */
        .app-main {
            flex: 1;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .app-page-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 32px;
        }

        .app-content {
            padding: 28px 32px;
            flex: 1;
        }

        /* ────────────────────────────────────────
           MOBILE — sidebar overlay
        ──────────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar-toggle { display: flex; }
            .brand-wrap { width: auto; }

            .app-sidebar {
                position: fixed;
                top: 60px; left: 0; bottom: 0;
                z-index: 150;
                transform: translateX(-100%);
                box-shadow: 4px 0 20px rgba(0,0,0,0.12);
            }
            .app-sidebar.open { transform: translateX(0); }

            .sidebar-overlay {
                display: none;
                position: fixed; inset: 0;
                background: rgba(0,0,0,0.3);
                z-index: 140;
                top: 60px;
            }
            .sidebar-overlay.open { display: block; }

            .app-page-header { padding: 14px 16px; }
            .app-content     { padding: 16px; }
        }
    </style>
</head>
<body>

    {{-- ── Topbar ── --}}
    <header class="app-topbar">
        <div class="topbar-left">
            <button class="sidebar-toggle" id="sidebar-toggle-btn" aria-label="Toggle sidebar" aria-expanded="false">
                <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
            </button>
            <a href="{{ route('dashboard') }}" class="brand-wrap">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg>
                </div>
                <div>
                    <div class="brand-name">{{ config('app.name', 'Laravel') }}</div>
                    <div class="brand-sub">Portal</div>
                </div>
            </a>
        </div>

        <div class="topbar-right">
            <div class="user-menu-wrap">
                <button class="user-btn" id="user-menu-btn" aria-expanded="false" aria-haspopup="true">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <span class="user-btn-name">{{ Auth::user()->name }}</span>
                    <svg class="user-btn-chevron" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>
                </button>

                <div class="user-dropdown" id="user-dropdown" role="menu">
                    <div class="dropdown-header">
                        <div class="dropdown-header-name">{{ Auth::user()->name }}</div>
                        <div class="dropdown-header-email">{{ Auth::user()->email }}</div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="dropdown-item" role="menuitem" id="dd-profile">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Profile Settings
                    </a>

                    @if(Auth::user()->is_admin)
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item" role="menuitem" id="dd-admin">
                        <svg viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg>
                        Admin Panel
                    </a>
                    @endif

                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" id="user-logout-form">
                        @csrf
                        <button type="submit" class="dropdown-item danger" style="width:100%;border:none;background:none;cursor:pointer;text-align:left;" id="dd-logout">
                            <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile overlay --}}
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="app-body">

        {{-- ── Sidebar ── --}}
        <nav class="app-sidebar" id="app-sidebar" aria-label="Main navigation">

            <div class="sidebar-section-label">Main</div>

            <a href="{{ route('dashboard') }}"
               class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               id="nav-dashboard">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                Dashboard
            </a>

            <div class="sidebar-section-label">DAL Categories</div>

            @foreach(\App\Models\DalEntry::$categories as $sidebarCatKey => $sidebarCat)
                @php
                    $isCatActive = request()->routeIs('dal.manage.*') && (request()->query('category', 'finance') === $sidebarCatKey);
                @endphp
                <a href="{{ route('dal.manage.index', ['category' => $sidebarCatKey]) }}"
                   class="sidebar-link {{ $isCatActive ? 'active' : '' }}"
                   style="font-size:12.5px;padding:7px 12px;"
                   id="nav-dal-{{ $sidebarCatKey }}">
                    <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:{{ $isCatActive ? '#f7d768' : '#cbd5e1' }};margin-right:2px;flex-shrink:0;"></span>
                    <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $sidebarCat['full_title'] }}</span>
                </a>
            @endforeach

            @if(Auth::user()->is_admin)
            <div class="sidebar-section-label">Admin</div>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link"
               id="nav-admin-panel">
                <svg viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg>
                Admin Panel
                <span class="sidebar-badge">Admin</span>
            </a>
            @endif

        </nav>

        {{-- ── Main Content ── --}}
        <div class="app-main">
            @isset($header)
                <div class="app-page-header">
                    {{ $header }}
                </div>
            @endisset

            <div class="app-content">
                {{ $slot }}
            </div>
        </div>

    </div>

    <script>
        // ── User dropdown ──
        const userBtn      = document.getElementById('user-menu-btn');
        const userDropdown = document.getElementById('user-dropdown');

        userBtn.addEventListener('click', () => {
            const isOpen = userDropdown.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', isOpen);
        });

        document.addEventListener('click', (e) => {
            if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('open');
                userBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // ── Sidebar toggle (mobile) ──
        const toggleBtn     = document.getElementById('sidebar-toggle-btn');
        const sidebar       = document.getElementById('app-sidebar');
        const overlay       = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('open');
            toggleBtn.setAttribute('aria-expanded', 'true');
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
            toggleBtn.setAttribute('aria-expanded', 'false');
        }

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });
        overlay.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeSidebar(); });
    </script>
</body>
</html>
