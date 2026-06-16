<style>
    .pw-label {
        display: block; font-size: 12px; font-weight: 600;
        color: #475569; margin-bottom: 6px; letter-spacing: 0.03em;
    }
    .pw-input {
        width: 100%;
        border: 1px solid #e2e8f0; border-radius: 10px;
        font-size: 14px; padding: 10px 14px;
        color: #1e293b; background: #f8fafc;
        font-family: inherit; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .pw-input:focus {
        border-color: #166534;
        box-shadow: 0 0 0 3px rgba(22,101,52,0.09);
        background: #fff;
    }
    .pw-error { color: #dc2626; font-size: 12px; margin-top: 4px; }
    .pw-group { margin-bottom: 18px; }
    .pw-btn {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #166534, #15803d);
        color: #fff; border: none; border-radius: 10px;
        font-family: inherit; font-size: 14px; font-weight: 700;
        padding: 10px 24px; cursor: pointer;
        box-shadow: 0 4px 12px rgba(22,101,52,0.2);
        transition: opacity 0.2s, transform 0.15s;
    }
    .pw-btn:hover { opacity: 0.9; transform: translateY(-1px); }
    .pw-saved {
        font-size: 13px; color: #166534;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 8px; padding: 6px 14px;
    }
</style>

<form method="post" action="{{ route('password.update') }}" id="update-password-form">
    @csrf
    @method('put')

    <div class="pw-group">
        <label class="pw-label" for="update_password_current_password">Current Password</label>
        <input id="update_password_current_password" name="current_password"
               type="password" class="pw-input"
               autocomplete="current-password" placeholder="Enter current password">
        @error('current_password', 'updatePassword')
            <p class="pw-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="pw-group">
        <label class="pw-label" for="update_password_password">New Password</label>
        <input id="update_password_password" name="password"
               type="password" class="pw-input"
               autocomplete="new-password" placeholder="Min. 8 characters">
        @error('password', 'updatePassword')
            <p class="pw-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="pw-group">
        <label class="pw-label" for="update_password_password_confirmation">Confirm New Password</label>
        <input id="update_password_password_confirmation" name="password_confirmation"
               type="password" class="pw-input"
               autocomplete="new-password" placeholder="Repeat new password">
        @error('password_confirmation', 'updatePassword')
            <p class="pw-error">{{ $message }}</p>
        @enderror
    </div>

    <div style="display:flex;align-items:center;gap:14px;margin-top:6px;">
        <button type="submit" class="pw-btn" id="save-password-btn">
            <svg style="width:14px;height:14px;fill:currentColor;" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
            Update Password
        </button>
        @if (session('status') === 'password-updated')
            <span class="pw-saved">✓ Password updated.</span>
        @endif
    </div>
</form>
