<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Department Master — {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0d0d1a; color: #e2e8f0; min-height: 100vh; display: flex; flex-direction: column; }
        select, option { background-color: #1a1a32 !important; color: #f8fafc !important; }
        select:focus, select:active { background-color: #1f1f3d !important; border-color: #818cf8 !important; }
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
        .btn-primary { background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none; color: #fff; font-weight: 600; font-size: 13.5px; padding: 10px 18px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
        .btn-secondary { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); color: #e2e8f0; font-weight: 500; font-size: 13px; padding: 8px 14px; border-radius: 8px; cursor: pointer; text-decoration: none; }
        .table { width: 100%; border-collapse: collapse; font-size: 13px; text-align: left; }
        .table th { background: rgba(255,255,255,0.03); color: rgba(248,250,252,0.5); padding: 12px 16px; font-weight: 600; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .table td { padding: 14px 16px; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
        .table tr:hover td { background: rgba(255,255,255,0.02); }
        .badge { display: inline-block; padding: 3px 9px; border-radius: 12px; font-size: 11px; font-weight: 700; letter-spacing: 0.03em; }
        .badge-active { background: rgba(34,197,94,0.15); color: #86efac; border: 1px solid rgba(34,197,94,0.25); }
        .badge-inactive { background: rgba(239,68,68,0.15); color: #fca5a5; border: 1px solid rgba(239,68,68,0.25); }
        .pill-cat { display: inline-block; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); color: #c7d2fe; margin-right: 4px; margin-bottom: 4px; }
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); z-index: 200; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal-card { background: #131326; border: 1px solid rgba(255,255,255,0.12); border-radius: 16px; width: 100%; max-width: 540px; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 12px; font-weight: 600; color: rgba(248,250,252,0.7); margin-bottom: 6px; }
        .form-control { width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; padding: 9px 12px; color: #fff; font-size: 13.5px; outline: none; }
        .form-control:focus { border-color: #818cf8; box-shadow: 0 0 0 3px rgba(99,102,241,0.2); }
    </style>
</head>
<body>
    <header class="topbar">
        <div style="display:flex;align-items:center;">
            <button type="button" onclick="toggleAdminSidebar()" class="admin-sidebar-toggle-btn" title="Toggle Side Menu">
                <svg viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
                <div class="brand-icon"><svg viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg></div>
                <div>
                    <div class="brand-name">{{ config('app.name', 'Laravel') }}</div>
                    <div class="brand-sub">Admin Console</div>
                </div>
            </a>
        </div>
        <div class="topbar-right">
            <div class="user-pill">
                <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-secondary" style="font-size:12px;">Back to App &rarr;</a>
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
                    <h1 style="font-size:22px;font-weight:800;letter-spacing:-0.4px;">Department Master</h1>
                    <p style="font-size:13px;color:rgba(248,250,252,0.5);margin-top:4px;">Manage corporate departments and sync profiles from Microsoft Azure AD SSO.</p>
                </div>
                <button type="button" class="btn-primary" onclick="openCreateModal()">
                    <svg style="width:16px;height:16px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Add Department
                </button>
            </div>

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
            @if($errors->any())
                <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#fca5a5;border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:13.5px;">
                    ❌ {{ $errors->first() }}
                </div>
            @endif

            <div class="card" style="padding:0;overflow:hidden;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:100px;">Code</th>
                            <th>Department Name &amp; Description</th>
                            <th>Mapped DAL Categories</th>
                            <th style="text-align:center;">Users</th>
                            <th style="text-align:center;">Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $dept)
                            <tr>
                                <td>
                                    <span style="display:inline-block;padding:3px 8px;border-radius:6px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:#cbd5e1;font-weight:800;font-size:12px;">
                                        {{ $dept->code }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:700;color:#f8fafc;font-size:14px;margin-bottom:3px;">{{ $dept->name }}</div>
                                    <div style="font-size:12px;color:rgba(248,250,252,0.45);line-height:1.4;">{{ $dept->description ?: 'No description.' }}</div>
                                </td>
                                <td>
                                    @if($dept->dalCategories->isNotEmpty())
                                        @foreach($dept->dalCategories as $cat)
                                            <span class="pill-cat">{{ $cat->code }} {{ $cat->name }}</span>
                                        @endforeach
                                    @else
                                        <span style="font-size:12px;color:rgba(248,250,252,0.3);">No categories mapped</span>
                                    @endif
                                </td>
                                <td style="text-align:center;font-weight:600;color:#94a3b8;">
                                    {{ $dept->users_count }}
                                </td>
                                <td style="text-align:center;">
                                    <form method="POST" action="{{ route('admin.departments.toggle-active', $dept) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;">
                                            <span class="badge {{ $dept->is_active ? 'badge-active' : 'badge-inactive' }}">
                                                {{ $dept->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align:right;white-space:nowrap;">
                                    <button type="button" class="btn-secondary" style="font-size:12px;padding:6px 10px;"
                                            onclick='openEditModal(@json($dept), @json($dept->dalCategories->pluck("id")) )'>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" style="display:inline;"
                                          onsubmit="return confirm('Are you sure you want to delete department {{ $dept->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-secondary" style="font-size:12px;padding:6px 10px;color:#fca5a5;margin-left:4px;">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    {{-- Create Modal --}}
    <div class="modal-overlay" id="createModal">
        <div class="modal-card">
            <h2 style="font-size:17px;font-weight:800;margin-bottom:18px;color:#f8fafc;">Add New Department</h2>
            <form method="POST" action="{{ route('admin.departments.store') }}">
                @csrf
                <div class="form-group">
                    <label>Department Code * (e.g. FIN, HR, LEGAL)</label>
                    <input type="text" name="code" class="form-control" placeholder="FIN" required>
                </div>
                <div class="form-group">
                    <label>Department Name * (e.g. Finance & Treasury)</label>
                    <input type="text" name="name" class="form-control" placeholder="Finance & Treasury" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Responsibilities and scope..."></textarea>
                </div>
                <div class="form-group">
                    <label>Map to DAL Categories</label>
                    <div style="max-height:160px;overflow-y:auto;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:8px;padding:10px;">
                        @foreach($categories as $cat)
                            <label style="display:flex;align-items:center;gap:8px;padding:4px 0;font-size:13px;color:#cbd5e1;cursor:pointer;">
                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}">
                                <span><strong>{{ $cat->code }}</strong> {{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;">
                    <button type="button" class="btn-secondary" onclick="closeModal('createModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Save Department</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal-overlay" id="editModal">
        <div class="modal-card">
            <h2 style="font-size:17px;font-weight:800;margin-bottom:18px;color:#f8fafc;">Edit Department</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Department Code *</label>
                    <input type="text" id="edit_code" name="code" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Department Name *</label>
                    <input type="text" id="edit_name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea id="edit_description" name="description" class="form-control" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label>Mapped DAL Categories</label>
                    <div style="max-height:160px;overflow-y:auto;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:8px;padding:10px;">
                        @foreach($categories as $cat)
                            <label style="display:flex;align-items:center;gap:8px;padding:4px 0;font-size:13px;color:#cbd5e1;cursor:pointer;">
                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}" id="edit_cat_{{ $cat->id }}" class="edit-cat-checkbox">
                                <span><strong>{{ $cat->code }}</strong> {{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;">
                    <button type="button" class="btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                    <button type="submit" class="btn-primary">Update Department</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const deptUpdateUrlTemplate = "{{ route('admin.departments.update', '__ID__') }}";

        function openCreateModal() {
            document.getElementById('createModal').classList.add('open');
        }
        function openEditModal(dept, mappedCatIds) {
            document.getElementById('editForm').action = deptUpdateUrlTemplate.replace('__ID__', dept.id);
            document.getElementById('edit_code').value = dept.code;
            document.getElementById('edit_name').value = dept.name;
            document.getElementById('edit_description').value = dept.description || '';

            document.querySelectorAll('.edit-cat-checkbox').forEach(cb => {
                cb.checked = mappedCatIds.includes(parseInt(cb.value));
            });

            document.getElementById('editModal').classList.add('open');
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }
    </script>
</body>
</html>
