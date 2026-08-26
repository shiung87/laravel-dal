<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dept ↔ DAL Mapping Matrix — {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0d0d1a; color: #e2e8f0; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: rgba(255,255,255,0.03); border-bottom: 1px solid rgba(255,255,255,0.07); backdrop-filter: blur(12px); padding: 0 32px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
        .topbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .brand-icon { width: 34px; height: 34px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 9px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(99,102,241,0.35); }
        .brand-icon svg { width: 18px; height: 18px; fill: #fff; }
        .brand-name { font-size: 15px; font-weight: 700; color: #f1f5f9; letter-spacing: -0.3px; }
        .brand-sub { font-size: 11px; font-weight: 500; color: rgba(241,245,249,0.4); letter-spacing: 0.08em; text-transform: uppercase; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .user-pill { display: flex; align-items: center; gap: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 100px; padding: 6px 14px 6px 6px; }
        .avatar { width: 28px; height: 28px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #fff; }
        .user-name { font-size: 13px; font-weight: 500; color: rgba(241,245,249,0.8); }
        .btn-logout { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.25); color: #fca5a5; border-radius: 10px; font-size: 13px; font-weight: 500; padding: 8px 16px; cursor: pointer; }
        .app-body { display: flex; flex: 1; }
        .sidebar { width: 230px; flex-shrink: 0; background: rgba(255,255,255,0.02); border-right: 1px solid rgba(255,255,255,0.06); padding: 24px 12px; display: flex; flex-direction: column; gap: 4px; }
        .sidebar-section { font-size: 10px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(248,250,252,0.25); padding: 4px 12px 8px; margin-top: 8px; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 500; color: rgba(248,250,252,0.55); transition: all 0.15s; }
        .nav-link svg { width: 16px; height: 16px; fill: currentColor; flex-shrink: 0; }
        .nav-link:hover { background: rgba(255,255,255,0.05); color: rgba(248,250,252,0.9); }
        .nav-link.active { background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); color: #a5b4fc; font-weight: 600; }
        .main-content { flex: 1; padding: 32px; overflow-y: auto; }
        .card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07); border-radius: 16px; padding: 24px; margin-bottom: 24px; }
        .btn-primary { background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; color: #fff; font-weight: 600; font-size: 13.5px; padding: 10px 20px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .matrix-table { width: 100%; border-collapse: collapse; font-size: 12.5px; }
        .matrix-table th { background: rgba(255,255,255,0.04); color: #e2e8f0; padding: 12px 10px; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); border-right: 1px solid rgba(255,255,255,0.05); }
        .matrix-table td { padding: 12px 10px; border-bottom: 1px solid rgba(255,255,255,0.05); border-right: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }
        .matrix-table tr:hover td { background: rgba(255,255,255,0.02); }
        .custom-cb { width: 18px; height: 18px; cursor: pointer; accent-color: #6366f1; }
    </style>
</head>
<body>
    <header class="topbar">
        <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
            <div class="brand-icon"><svg viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg></div>
            <div>
                <div class="brand-name">{{ config('app.name', 'Laravel') }}</div>
                <div class="brand-sub">Admin Console</div>
            </div>
        </a>
        <div class="topbar-right">
            <div class="user-pill">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-secondary" style="font-size:12px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);color:#e2e8f0;font-weight:500;padding:8px 14px;border-radius:8px;text-decoration:none;">Back to App &rarr;</a>
            <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </header>

    <div class="app-body">
        @include('admin.partials.sidebar')

        <main class="main-content">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
                <div>
                    <h1 style="font-size:22px;font-weight:800;letter-spacing:-0.4px;">Department ↔ DAL Category Mapping Matrix</h1>
                    <p style="font-size:13px;color:rgba(248,250,252,0.5);margin-top:4px;">Configure which DAL categories are recommended and prioritized when users log in from each corporate department.</p>
                </div>
            </div>

            @if(session('success'))
                <div style="background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#86efac;border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:13.5px;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.mappings.update') }}">
                @csrf
                <div class="card" style="padding:0;overflow-x:auto;">
                    <table class="matrix-table">
                        <thead>
                            <tr>
                                <th style="text-align:left;min-width:260px;position:sticky;left:0;background:#151528;z-index:2;">
                                    Corporate Department
                                </th>
                                @foreach($categories as $cat)
                                    <th style="text-align:center;min-width:130px;" title="{{ $cat->full_title }}">
                                        <div style="font-size:11px;color:#818cf8;font-weight:800;">{{ $cat->code }}</div>
                                        <div style="font-size:12px;color:#f8fafc;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;">{{ $cat->name }}</div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $dept)
                                @php
                                    $mappedCatIds = $dept->dalCategories->pluck('id')->toArray();
                                @endphp
                                <tr>
                                    <td style="position:sticky;left:0;background:#131326;z-index:1;font-weight:600;color:#f8fafc;">
                                        <div style="font-size:13px;">{{ $dept->name }}</div>
                                        <div style="font-size:11px;color:rgba(248,250,252,0.4);font-weight:700;">{{ $dept->code }}</div>
                                    </td>
                                    @foreach($categories as $cat)
                                        @php
                                            $isChecked = in_array($cat->id, $mappedCatIds, true);
                                        @endphp
                                        <td style="text-align:center;">
                                            <input type="checkbox"
                                                   name="mappings[{{ $dept->id }}][]"
                                                   value="{{ $cat->id }}"
                                                   class="custom-cb"
                                                   {{ $isChecked ? 'checked' : '' }}>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:20px;">
                    <button type="submit" class="btn-primary">
                        <svg style="width:16px;height:16px;fill:currentColor;" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        Save All Mappings
                    </button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
