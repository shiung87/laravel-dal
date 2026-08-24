<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div>
                <h2 style="font-size:20px;font-weight:800;color:#0b3b63;letter-spacing:-0.4px;">My Account Profile</h2>
                <p style="font-size:13px;color:#64748b;margin-top:2px;">View your account details and authentication credentials.</p>
            </div>
            @if($user->isSso())
                <span style="display:inline-flex;align-items:center;gap:6px;background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;font-size:12px;font-weight:700;padding:5px 12px;border-radius:20px;">
                    <svg width="14" height="14" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1"  y="1"  width="9" height="9" fill="#f25022"/>
                        <rect x="11" y="1"  width="9" height="9" fill="#7fba00"/>
                        <rect x="1"  y="11" width="9" height="9" fill="#00a4ef"/>
                        <rect x="11" y="11" width="9" height="9" fill="#ffb900"/>
                    </svg>
                    Azure AD SSO Active
                </span>
            @endif
        </div>
    </x-slot>

    {{-- Flash messages --}}
    @if(session('error'))
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
            <svg style="width:16px;height:16px;fill:currentColor;flex-shrink:0;" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if(session('status') === 'password-updated')
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
            <svg style="width:16px;height:16px;fill:currentColor;flex-shrink:0;" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            Password updated successfully.
        </div>
    @endif

    <div style="max-width:700px;display:flex;flex-direction:column;gap:20px;">

        {{-- Single Sign-On Notice (If SSO User) --}}
        @if($user->isSso())
            <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:14px;padding:16px 20px;display:flex;align-items:flex-start;gap:12px;">
                <div style="width:32px;height:32px;border-radius:8px;background:#dbeafe;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#1d4ed8;">
                    <svg style="width:18px;height:18px;fill:currentColor;" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
                <div>
                    <h4 style="font-size:13.5px;font-weight:700;color:#1e40af;margin-bottom:3px;">Managed via Microsoft Azure AD Single Sign-On</h4>
                    <p style="font-size:12.5px;color:#3b82f6;line-height:1.5;margin:0;">
                        Your account credentials, full name, email address, and security policies are centrally managed by your organization's directory. Name, email, and password changes must be performed through your organization's IT department.
                    </p>
                </div>
            </div>
        @else
            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:10px;font-size:12.5px;color:#64748b;">
                <svg style="width:16px;height:16px;fill:#64748b;flex-shrink:0;" viewBox="0 0 24 24"><path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z"/></svg>
                Full name and email address are provisioned by administrators. You can update your local login password below.
            </div>
        @endif

        {{-- Profile Information Card (Read-Only) --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:34px;height:34px;border-radius:9px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:16px;height:16px;fill:#0b3b63;" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#0b3b63;">Account Information</div>
                        <div style="font-size:12px;color:#94a3b8;margin-top:1px;">Identity and authorization details.</div>
                    </div>
                </div>
                <span style="font-size:11px;font-weight:700;color:#64748b;background:#f1f5f9;padding:3px 10px;border-radius:12px;">
                    View Only
                </span>
            </div>
            <div style="padding:24px;">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password Card (Only for Non-SSO users) --}}
        @if(!$user->isSso())
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                    <div style="width:34px;height:34px;border-radius:9px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:16px;height:16px;fill:#166534;" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#166534;">Change Password</div>
                        <div style="font-size:12px;color:#94a3b8;margin-top:1px;">Ensure your account uses a strong, complex password.</div>
                    </div>
                </div>
                <div style="padding:24px;">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
