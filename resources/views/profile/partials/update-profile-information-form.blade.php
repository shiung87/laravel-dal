<style>
    .pf-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        letter-spacing: 0.03em;
    }
    .pf-input-readonly {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        padding: 10px 14px;
        color: #334155;
        background: #f8fafc;
        font-family: inherit;
        outline: none;
        cursor: not-allowed;
    }
    .pf-group { margin-bottom: 18px; }
</style>

<div>
    {{-- Full Name (Read-Only) --}}
    <div class="pf-group">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
            <label class="pf-label" style="margin-bottom:0;">Full Name</label>
            <span style="font-size:11px;color:#64748b;display:inline-flex;align-items:center;gap:3px;">
                <svg style="width:12px;height:12px;fill:currentColor;" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                Read Only
            </span>
        </div>
        <input type="text" class="pf-input-readonly" value="{{ $user->name }}" readonly>
    </div>

    {{-- Email Address (Read-Only) --}}
    <div class="pf-group">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
            <label class="pf-label" style="margin-bottom:0;">Email Address</label>
            <span style="font-size:11px;color:#64748b;display:inline-flex;align-items:center;gap:3px;">
                <svg style="width:12px;height:12px;fill:currentColor;" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                Read Only
            </span>
        </div>
        <input type="email" class="pf-input-readonly" value="{{ $user->email }}" readonly>
    </div>

    {{-- Metadata pills --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-top:20px;padding-top:16px;border-top:1px solid #f1f5f9;">
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;">
            <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">Authentication Method</div>
            <div style="font-size:13px;font-weight:700;color:#0b3b63;margin-top:4px;display:flex;align-items:center;gap:6px;">
                @if($user->isSso())
                    <svg width="14" height="14" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1"  y="1"  width="9" height="9" fill="#f25022"/>
                        <rect x="11" y="1"  width="9" height="9" fill="#7fba00"/>
                        <rect x="1"  y="11" width="9" height="9" fill="#00a4ef"/>
                        <rect x="11" y="11" width="9" height="9" fill="#ffb900"/>
                    </svg>
                    Microsoft Azure AD SSO
                @else
                    🔑 Local Enterprise Account
                @endif
            </div>
        </div>

        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;">
            <div style="font-size:11px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.04em;">System Access Role</div>
            <div style="font-size:13px;font-weight:700;color:#0b3b63;margin-top:4px;">
                @if($user->is_admin)
                    <span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:12px;font-size:11.5px;border:1px solid #fde68a;">⭐ Administrator</span>
                @else
                    <span style="background:#eff6ff;color:#1e40af;padding:2px 8px;border-radius:12px;font-size:11.5px;border:1px solid #bfdbfe;">Employee / Viewer</span>
                @endif
            </div>
        </div>
    </div>
</div>
