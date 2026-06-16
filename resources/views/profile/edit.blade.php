<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:18px;font-weight:700;color:#0b3b63;">Profile Settings</h2>
        <p style="font-size:13px;color:#94a3b8;margin-top:2px;">Manage your account information and security.</p>
    </x-slot>

    <div style="max-width:680px;display:flex;flex-direction:column;gap:20px;">

        {{-- Update Profile Information --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:16px;height:16px;fill:#0b3b63;" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div>
                    <div style="font-size:14px;font-weight:700;color:#0b3b63;">Profile Information</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:1px;">Update your name and email address.</div>
                </div>
            </div>
            <div style="padding:24px;">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <div style="padding:18px 24px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:9px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:16px;height:16px;fill:#166534;" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </div>
                <div>
                    <div style="font-size:14px;font-weight:700;color:#166534;">Update Password</div>
                    <div style="font-size:12px;color:#94a3b8;margin-top:1px;">Use a long, random password to stay secure.</div>
                </div>
            </div>
            <div style="padding:24px;">
                @include('profile.partials.update-password-form')
            </div>
        </div>


    </div>
</x-app-layout>
