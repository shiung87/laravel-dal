<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Audit Log — {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Full activity and audit trail log.">
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
        .btn-logout { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #fca5a5; border-radius: 10px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; padding: 8px 16px; cursor: pointer; transition: background 0.2s, border-color 0.2s, transform 0.15s; }
        .btn-logout:hover { background: rgba(239,68,68,0.18); border-color: rgba(239,68,68,0.45); transform: translateY(-1px); }

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
        main { flex: 1; padding: 40px 36px; overflow-x: hidden; }

        @keyframes fadeInDown { from { opacity:0; transform:translateY(-12px); } to { opacity:1; transform:translateY(0); } }
        @keyframes cardIn { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }

        /* ── Page header ── */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; animation: fadeInDown 0.4s ease both; flex-wrap: wrap; gap: 12px; }
        .page-header-left h1 { font-size: 26px; font-weight: 800; color: #f8fafc; letter-spacing: -0.6px; }
        .page-header-left p  { font-size: 14px; color: rgba(248,250,252,0.4); margin-top: 4px; }

        /* ── Controls ── */
        .controls-bar { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; animation: cardIn 0.4s 0.1s ease both; }
        .search-wrap { position: relative; flex: 1; min-width: 180px; }
        .search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; fill: rgba(248,250,252,0.3); pointer-events: none; }
        .search-input { width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.09); border-radius: 10px; color: #e2e8f0; font-family: 'Inter', sans-serif; font-size: 13.5px; padding: 9px 14px 9px 36px; outline: none; transition: border-color 0.2s, background 0.2s; }
        .search-input::placeholder { color: rgba(248,250,252,0.3); }
        .search-input:focus { border-color: rgba(99,102,241,0.45); background: rgba(99,102,241,0.04); }

        .action-select { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.09); border-radius: 10px; color: #e2e8f0; font-family: 'Inter', sans-serif; font-size: 13px; padding: 9px 14px; outline: none; cursor: pointer; min-width: 160px; }
        .action-select option { background: #1e1e3a; }
        .action-select:focus { border-color: rgba(99,102,241,0.45); }

        .btn-filter { display: inline-flex; align-items: center; gap: 6px; background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); color: #a5b4fc; border-radius: 10px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; padding: 9px 18px; cursor: pointer; transition: background 0.15s; }
        .btn-filter:hover { background: rgba(99,102,241,0.25); }

        /* ── Table ── */
        .table-wrap { background: rgba(255,255,255,0.025); border: 1px solid rgba(255,255,255,0.07); border-radius: 18px; overflow: hidden; animation: cardIn 0.5s 0.15s ease both; }
        table { width: 100%; border-collapse: collapse; }
        thead { border-bottom: 1px solid rgba(255,255,255,0.06); }
        th { text-align: left; padding: 13px 18px; font-size: 11px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: rgba(248,250,252,0.3); }
        td { padding: 12px 18px; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: top; font-size: 13px; }
        tr:last-child td { border-bottom: none; }
        tbody tr { transition: background 0.13s; }
        tbody tr:hover { background: rgba(255,255,255,0.02); }

        /* ── Action badges ── */
        .action-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; white-space: nowrap; }
        .badge-blue   { background: rgba(59,130,246,0.15);  color: #93c5fd; border: 1px solid rgba(59,130,246,0.25); }
        .badge-slate  { background: rgba(100,116,139,0.15); color: #94a3b8; border: 1px solid rgba(100,116,139,0.2); }
        .badge-indigo { background: rgba(99,102,241,0.15);  color: #a5b4fc; border: 1px solid rgba(99,102,241,0.25); }
        .badge-green  { background: rgba(16,185,129,0.12);  color: #6ee7b7; border: 1px solid rgba(16,185,129,0.2); }
        .badge-amber  { background: rgba(245,158,11,0.12);  color: #fcd34d; border: 1px solid rgba(245,158,11,0.2); }
        .badge-red    { background: rgba(239,68,68,0.12);   color: #fca5a5; border: 1px solid rgba(239,68,68,0.2); }
        .badge-purple { background: rgba(168,85,247,0.12);  color: #c084fc; border: 1px solid rgba(168,85,247,0.2); }
        .badge-orange { background: rgba(249,115,22,0.12);  color: #fdba74; border: 1px solid rgba(249,115,22,0.2); }
        .badge-cyan   { background: rgba(6,182,212,0.12);   color: #67e8f9; border: 1px solid rgba(6,182,212,0.2); }

        /* ── Diff viewer ── */
        .diff-toggle { background: none; border: 1px solid rgba(255,255,255,0.1); border-radius: 6px; color: rgba(248,250,252,0.4); font-family: 'Inter', sans-serif; font-size: 11px; padding: 3px 8px; cursor: pointer; transition: border-color 0.15s, color 0.15s; }
        .diff-toggle:hover { border-color: rgba(99,102,241,0.4); color: #a5b4fc; }
        .diff-panel { display: none; margin-top: 8px; background: rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; padding: 12px; }
        .diff-panel.open { display: block; }
        .diff-row { display: flex; gap: 8px; margin-bottom: 6px; font-size: 11.5px; }
        .diff-row:last-child { margin-bottom: 0; }
        .diff-key { color: rgba(248,250,252,0.4); min-width: 120px; flex-shrink: 0; }
        .diff-old { color: #fca5a5; text-decoration: line-through; margin-right: 8px; }
        .diff-new { color: #6ee7b7; }

        /* ── User cell ── */
        .user-cell { display: flex; align-items: center; gap: 8px; }
        .mini-avatar { width: 26px; height: 26px; border-radius: 7px; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #fff; flex-shrink: 0; }
        .user-cell-name  { font-size: 13px; font-weight: 600; color: #f1f5f9; }
        .user-cell-email { font-size: 11.5px; color: rgba(248,250,252,0.4); margin-top: 1px; }

        /* ── Meta ── */
        .meta-ip { font-size: 11.5px; color: rgba(248,250,252,0.35); font-family: monospace; }
        .meta-time { font-size: 12px; color: rgba(248,250,252,0.4); white-space: nowrap; }

        /* ── Pagination ── */
        .pagination-wrap { display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border-top: 1px solid rgba(255,255,255,0.05); flex-wrap: wrap; gap: 10px; }
        .pagination-info { font-size: 12.5px; color: rgba(248,250,252,0.35); }
        .pagination-links { display: flex; gap: 4px; }
        .page-btn { min-width: 32px; height: 32px; border-radius: 8px; border: none; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; padding: 0 8px; color: rgba(248,250,252,0.5); background: rgba(255,255,255,0.04); transition: background 0.15s, color 0.15s; }
        .page-btn:hover { background: rgba(255,255,255,0.08); color: #f1f5f9; }
        .page-btn.active { background: rgba(99,102,241,0.2); color: #a5b4fc; font-weight: 700; }
        .page-btn.disabled { opacity: 0.3; pointer-events: none; }

        /* ── Empty state ── */
        .empty-state { display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 60px 20px; color: rgba(248,250,252,0.3); }
        .empty-state svg { width: 44px; height: 44px; fill: currentColor; opacity: 0.35; }
        .empty-state p { font-size: 14px; }
    </style>
</head>
<body>

    {{-- Topbar --}}
    <header class="topbar">
        <div class="topbar-brand">
            <button type="button" onclick="toggleAdminSidebar()" class="admin-sidebar-toggle-btn" title="Toggle Side Menu">
                <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
            </button>
            <div class="brand-icon"><svg viewBox="0 0 20 20"><path d="M10 1l2.39 4.84L18 6.82l-4 3.9.94 5.5L10 13.77l-4.94 2.45L6 10.72 2 6.82l5.61-.98L10 1z"/></svg></div>
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
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout" id="admin-logout-btn">Sign out</button>
            </form>
        </div>
    </header>

    <div class="app-body">
        {{-- Unified Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main --}}
        <main>
            <div class="page-header">
                <div class="page-header-left">
                    <h1>Audit Log</h1>
                    <p>{{ number_format($logs->total()) }} event{{ $logs->total() !== 1 ? 's' : '' }} recorded</p>
                </div>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('admin.audit-log') }}" id="audit-filter-form">
                <div class="controls-bar">
                    <div class="search-wrap">
                        <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        <input type="text" name="search" id="audit-search" class="search-input"
                               placeholder="Search by user, subject, IP…"
                               value="{{ $search }}" autocomplete="off">
                    </div>

                    <select name="action" class="action-select" id="audit-action-filter" onchange="this.form.submit()">
                        <option value="">All Actions</option>
                        @foreach($actions as $key => $meta)
                            <option value="{{ $key }}" {{ $action === $key ? 'selected' : '' }}>{{ $meta['label'] }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-filter">
                        <svg style="width:13px;height:13px;fill:currentColor;" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        Search
                    </button>

                    @if($search || $action)
                        <a href="{{ route('admin.audit-log') }}" style="font-size:13px;color:rgba(248,250,252,0.4);text-decoration:none;" id="clear-audit-filter">✕ Clear</a>
                    @endif
                </div>
            </form>

            {{-- Log table --}}
            <div class="table-wrap" id="audit-log-table">
                @if($logs->isEmpty())
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zm-2 9H7v-2h4v2zm4-4H7v-2h8v2zm0-4H7V8h2v2h6z"/></svg>
                        <p>No audit events found{{ $search || $action ? ' for the current filter' : '' }}.</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>When</th>
                                <th>Actor</th>
                                <th>Action</th>
                                <th>Subject</th>
                                <th>Changes</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            @php
                                $meta  = \App\Models\ActivityLog::$actionLabels[$log->action] ?? ['label' => $log->action, 'color' => 'slate'];
                                $color = $meta['color'];
                                $idx   = $loop->index;
                            @endphp
                            <tr>
                                {{-- Timestamp --}}
                                <td>
                                    <div class="meta-time" title="{{ $log->created_at->toDateTimeString() }}">
                                        {{ $log->created_at->format('d M Y') }}<br>
                                        <span style="color:rgba(248,250,252,0.3);font-size:11px;">{{ $log->created_at->format('H:i:s') }}</span>
                                    </div>
                                </td>

                                {{-- Actor --}}
                                <td>
                                    @if($log->user_name)
                                        <div class="user-cell">
                                            <div class="mini-avatar">{{ strtoupper(substr($log->user_name, 0, 1)) }}</div>
                                            <div>
                                                <div class="user-cell-name">{{ $log->user_name }}</div>
                                                <div class="user-cell-email">{{ $log->user_email }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span style="color:rgba(248,250,252,0.25);font-size:12px;">System</span>
                                    @endif
                                </td>

                                {{-- Action badge --}}
                                <td>
                                    <span class="action-badge badge-{{ $color }}">{{ $meta['label'] }}</span>
                                </td>

                                {{-- Subject --}}
                                <td style="max-width:200px;">
                                    @if($log->subject_label)
                                        <div style="font-size:12.5px;color:#e2e8f0;line-height:1.4;">{{ $log->subject_label }}</div>
                                        @if($log->subject_type)
                                            <div style="font-size:11px;color:rgba(248,250,252,0.3);margin-top:2px;">{{ $log->subject_type }} #{{ $log->subject_id }}</div>
                                        @endif
                                    @else
                                        <span style="color:rgba(248,250,252,0.2);font-size:12px;">—</span>
                                    @endif
                                </td>

                                {{-- Changes (diff) --}}
                                <td>
                                    @if($log->old_values || $log->new_values)
                                        <button class="diff-toggle" onclick="toggleDiff({{ $idx }})" id="diff-btn-{{ $idx }}">
                                            View changes ▾
                                        </button>
                                        <div class="diff-panel" id="diff-panel-{{ $idx }}">
                                            @php
                                                $allKeys = array_unique(array_merge(
                                                    array_keys($log->old_values ?? []),
                                                    array_keys($log->new_values ?? [])
                                                ));
                                            @endphp
                                            @foreach($allKeys as $key)
                                                @php
                                                    $old = $log->old_values[$key] ?? null;
                                                    $new = $log->new_values[$key] ?? null;
                                                @endphp
                                                <div class="diff-row">
                                                    <span class="diff-key">{{ $key }}</span>
                                                    @if($old !== null)
                                                        <span class="diff-old">{{ is_bool($old) ? ($old ? 'true' : 'false') : $old }}</span>
                                                    @endif
                                                    @if($new !== null)
                                                        <span class="diff-new">{{ is_bool($new) ? ($new ? 'true' : 'false') : $new }}</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span style="color:rgba(248,250,252,0.2);font-size:12px;">—</span>
                                    @endif
                                </td>

                                {{-- IP --}}
                                <td>
                                    <div class="meta-ip">{{ $log->ip_address ?? '—' }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if($logs->hasPages())
                    <div class="pagination-wrap">
                        <div class="pagination-info">
                            Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ number_format($logs->total()) }} events
                        </div>
                        <div class="pagination-links">
                            @if($logs->onFirstPage())
                                <span class="page-btn disabled"><svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg></span>
                            @else
                                <a href="{{ $logs->previousPageUrl() }}" class="page-btn"><svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg></a>
                            @endif

                            @foreach($logs->getUrlRange(max(1, $logs->currentPage()-2), min($logs->lastPage(), $logs->currentPage()+2)) as $page => $url)
                                @if($page === $logs->currentPage())
                                    <span class="page-btn active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if($logs->hasMorePages())
                                <a href="{{ $logs->nextPageUrl() }}" class="page-btn"><svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg></a>
                            @else
                                <span class="page-btn disabled"><svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:currentColor;"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg></span>
                            @endif
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </main>
    </div>

    <script>
        function toggleDiff(idx) {
            const panel = document.getElementById('diff-panel-' + idx);
            const btn   = document.getElementById('diff-btn-' + idx);
            const isOpen = panel.classList.toggle('open');
            btn.textContent = isOpen ? 'Hide changes ▴' : 'View changes ▾';
        }

        // Search debounce
        const auditSearch = document.getElementById('audit-search');
        let auditTimer;
        auditSearch.addEventListener('input', () => {
            clearTimeout(auditTimer);
            auditTimer = setTimeout(() => document.getElementById('audit-filter-form').submit(), 500);
        });
    </script>
</body>
</html>
