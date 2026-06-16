<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:18px;font-weight:700;color:#0b3b63;">Dashboard</h2>
        <p style="font-size:13px;color:#94a3b8;margin-top:2px;">Welcome back, {{ Auth::user()->name }}!</p>
    </x-slot>

    {{-- Flash messages --}}
    @if(session('error'))
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
            <svg style="width:16px;height:16px;fill:currentColor;flex-shrink:0;" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
            <svg style="width:16px;height:16px;fill:currentColor;flex-shrink:0;" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Quick links --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px;">

        <a href="{{ route('dal.manage.index') }}" id="card-dal-manage"
           style="display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;text-decoration:none;transition:box-shadow 0.2s,transform 0.15s;box-shadow:0 1px 4px rgba(0,0,0,0.05);"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(11,59,99,0.12)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 1px 4px rgba(0,0,0,0.05)'">
            <div style="width:42px;height:42px;border-radius:11px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;fill:#0b3b63;" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#0b3b63;">DAL Manage</div>
                <div style="font-size:12px;color:#94a3b8;margin-top:2px;">Delegation of Authority entries</div>
            </div>
        </a>

        <a href="{{ route('profile.edit') }}" id="card-profile"
           style="display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;text-decoration:none;transition:box-shadow 0.2s,transform 0.15s;box-shadow:0 1px 4px rgba(0,0,0,0.05);"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(11,59,99,0.12)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 1px 4px rgba(0,0,0,0.05)'">
            <div style="width:42px;height:42px;border-radius:11px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;fill:#166534;" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#166534;">My Profile</div>
                <div style="font-size:12px;color:#94a3b8;margin-top:2px;">Edit your account settings</div>
            </div>
        </a>

        @if(Auth::user()->is_admin)
        <a href="{{ route('admin.dashboard') }}" id="card-admin"
           style="display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px;text-decoration:none;transition:box-shadow 0.2s,transform 0.15s;box-shadow:0 1px 4px rgba(0,0,0,0.05);"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(99,102,241,0.15)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 1px 4px rgba(0,0,0,0.05)'">
            <div style="width:42px;height:42px;border-radius:11px;background:#f5f3ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;fill:#6d28d9;" viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg>
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#6d28d9;">Admin Panel</div>
                <div style="font-size:12px;color:#94a3b8;margin-top:2px;">Manage users &amp; access</div>
            </div>
        </a>
        @endif

    </div>

    {{-- Info card --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
            <div style="width:36px;height:36px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                <svg style="width:18px;height:18px;fill:#0b3b63;" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            </div>
            <span style="font-size:14px;font-weight:700;color:#0b3b63;">You're logged in!</span>
            @if(Auth::user()->is_admin)
                <span style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;">⭐ Admin</span>
            @endif
        </div>
        <p style="font-size:13px;color:#64748b;line-height:1.6;">
            Use the sidebar on the left to navigate. Head to <a href="{{ route('dal.manage.index') }}" style="color:#0b3b63;font-weight:600;">DAL Manage</a> to view Delegation of Authority entries.
            @if(Auth::user()->is_admin)
                As an admin, you can also create, edit, and delete entries.
            @endif
        </p>
    </div>

</x-app-layout>
