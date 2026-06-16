<style>
    .pf-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        letter-spacing: 0.03em;
    }
    .pf-input {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        padding: 10px 14px;
        color: #1e293b;
        background: #f8fafc;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .pf-input:focus {
        border-color: #0b3b63;
        box-shadow: 0 0 0 3px rgba(11,59,99,0.09);
        background: #fff;
    }
    .pf-error { color: #dc2626; font-size: 12px; margin-top: 4px; }
    .pf-group { margin-bottom: 18px; }
    .pf-btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #0b3b63, #1e5f94);
        color: #f7d768;
        border: none; border-radius: 10px;
        font-family: inherit; font-size: 14px; font-weight: 700;
        padding: 10px 24px; cursor: pointer;
        box-shadow: 0 4px 12px rgba(11,59,99,0.25);
        transition: opacity 0.2s, transform 0.15s;
    }
    .pf-btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
    .pf-saved {
        font-size: 13px; color: #166534;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 8px; padding: 6px 14px;
    }
</style>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" id="profile-info-form">
    @csrf
    @method('patch')

    <div class="pf-group">
        <label class="pf-label" for="name">Full Name</label>
        <input id="name" name="name" type="text" class="pf-input {{ $errors->has('name') ? 'border-red-400' : '' }}"
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" placeholder="Your full name">
        @error('name') <p class="pf-error">{{ $message }}</p> @enderror
    </div>

    <div class="pf-group">
        <label class="pf-label" for="email">Email Address</label>
        <input id="email" name="email" type="email" class="pf-input {{ $errors->has('email') ? 'border-red-400' : '' }}"
               value="{{ old('email', $user->email) }}" required autocomplete="username" placeholder="your@email.com">
        @error('email') <p class="pf-error">{{ $message }}</p> @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div style="margin-top:10px;padding:10px 14px;background:#fef3c7;border:1px solid #fde68a;border-radius:10px;font-size:13px;color:#92400e;">
                ⚠ Your email address is unverified.
                <button form="send-verification"
                        style="margin-left:6px;color:#0b3b63;font-weight:700;background:none;border:none;cursor:pointer;font-size:13px;text-decoration:underline;">
                    Resend verification email
                </button>
                @if (session('status') === 'verification-link-sent')
                    <p style="margin-top:6px;color:#166534;font-weight:600;">✓ Verification link sent.</p>
                @endif
            </div>
        @endif
    </div>

    <div style="display:flex;align-items:center;gap:14px;margin-top:6px;">
        <button type="submit" class="pf-btn-primary" id="save-profile-btn">
            <svg style="width:14px;height:14px;fill:currentColor;" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            Save Changes
        </button>
        @if (session('status') === 'profile-updated')
            <span class="pf-saved">✓ Profile updated.</span>
        @endif
    </div>
</form>
