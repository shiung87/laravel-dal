{{-- Unified Admin Sidebar with Collapse / Hide capability --}}
<nav class="sidebar" id="admin-sidebar" aria-label="Admin navigation">
    <div class="sidebar-section">Overview</div>

    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
       id="sidebar-dashboard">
        <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
        <span class="nav-text">Dashboard</span>
    </a>

    <div class="sidebar-section">DAL Masters</div>

    <a href="{{ route('admin.categories.index') }}"
       class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
       id="sidebar-categories">
        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
        <span class="nav-text">Category Master</span>
    </a>

    <a href="{{ route('admin.departments.index') }}"
       class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"
       id="sidebar-departments">
        <svg viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
        <span class="nav-text">Department Master</span>
    </a>

    <a href="{{ route('admin.mappings.index') }}"
       class="nav-link {{ request()->routeIs('admin.mappings.*') ? 'active' : '' }}"
       id="sidebar-mappings">
        <svg viewBox="0 0 24 24"><path d="M10.59 13.41c.41.39.41 1.03 0 1.42-.39.39-1.03.39-1.42 0a5.003 5.003 0 0 1 0-7.07l3.54-3.54a5.003 5.003 0 0 1 7.07 0 5.003 5.003 0 0 1 0 7.07l-1.49 1.49c.01-.82-.12-1.64-.4-2.42l.47-.48a2.982 2.982 0 0 0 0-4.24 2.982 2.982 0 0 0-4.24 0l-3.53 3.53a2.982 2.982 0 0 0 0 4.24zm2.82-2.82c-.41-.39-.41-1.03 0-1.42.39-.39 1.03-.39 1.42 0a5.003 5.003 0 0 1 0 7.07l-3.54 3.54a5.003 5.003 0 0 1-7.07 0 5.003 5.003 0 0 1 0-7.07l1.49-1.49c-.01.82.12 1.64.4 2.43l-.47.47a2.982 2.982 0 0 0 0 4.24 2.982 2.982 0 0 0 4.24 0l3.53-3.53a2.982 2.982 0 0 0 0-4.24z"/></svg>
        <span class="nav-text">Dept ↔ DAL Mapping</span>
    </a>

    <div class="sidebar-section">Administration</div>

    <a href="{{ route('admin.users.index') }}"
       class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
       id="sidebar-users">
        <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
        <span class="nav-text">Users &amp; Roles</span>
    </a>

    <a href="{{ route('admin.audit-log') }}"
       class="nav-link {{ request()->routeIs('admin.audit-log') ? 'active' : '' }}"
       id="sidebar-audit-log">
        <svg viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zm-2 9H7v-2h4v2zm4-4H7v-2h8v2zm0-4H7V8h2v2h6z"/></svg>
        <span class="nav-text">Audit Trail</span>
    </a>

    <div class="sidebar-section">Settings</div>

    <a href="{{ route('admin.sso.show') }}"
       class="nav-link {{ request()->routeIs('admin.sso.*') ? 'active' : '' }}"
       id="sidebar-sso">
        <svg viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
        <span class="nav-text">SSO Settings</span>
    </a>

    <a href="{{ route('admin.email.show') }}"
       class="nav-link {{ request()->routeIs('admin.email.*') ? 'active' : '' }}"
       id="sidebar-email">
        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
        <span class="nav-text">Email &amp; Notifications</span>
    </a>

    <div class="sidebar-section">Application</div>

    <a href="{{ route('dal.manage.index') }}" class="nav-link" id="sidebar-dal-matrix">
        <svg viewBox="0 0 24 24"><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12z"/></svg>
        <span class="nav-text">DAL Matrix</span>
    </a>

    <a href="{{ route('dashboard') }}" class="nav-link" id="sidebar-user-dashboard">
        <svg viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
        <span class="nav-text">User Dashboard</span>
    </a>

    {{-- Bottom Collapse/Hide Sidebar Button --}}
    <div style="margin-top:auto;padding-top:16px;border-top:1px solid rgba(255,255,255,0.06);">
        <button type="button" onclick="toggleAdminSidebar()" class="nav-link" id="admin-sidebar-collapse-btn"
                style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.05);width:100%;cursor:pointer;color:rgba(248,250,252,0.45);font-family:inherit;justify-content:flex-start;">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:currentColor;"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            <span class="nav-text">Hide Side Menu</span>
        </button>
    </div>
</nav>

<style>
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

    html.admin-sidebar-collapsed .sidebar,
    body.admin-sidebar-collapsed .sidebar {
        width: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        border-right-color: transparent !important;
        overflow: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
        visibility: hidden !important;
    }

    .admin-sidebar-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #e2e8f0;
        cursor: pointer;
        transition: all 0.15s;
        margin-right: 12px;
    }

    .admin-sidebar-toggle-btn:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.25);
        color: #fff;
    }
    .admin-sidebar-toggle-btn svg { width: 18px; height: 18px; fill: currentColor; }
</style>

<script>
    (function() {
        try {
            if (localStorage.getItem('admin_sidebar_collapsed') === 'true') {
                document.documentElement.classList.add('admin-sidebar-collapsed');
                document.body.classList.add('admin-sidebar-collapsed');
            }
        } catch(e) {}
    })();

    function toggleAdminSidebar() {
        const isCollapsed = document.documentElement.classList.toggle('admin-sidebar-collapsed');
        document.body.classList.toggle('admin-sidebar-collapsed', isCollapsed);
        try {
            localStorage.setItem('admin_sidebar_collapsed', isCollapsed ? 'true' : 'false');
        } catch(e) {}
    }
</script>
