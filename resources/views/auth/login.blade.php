<x-guest-layout>
    <style>
        .auth-heading { font-size: 26px; font-weight: 800; color: #f8fafc; letter-spacing: -0.5px; margin-bottom: 6px; }
        .auth-sub { font-size: 14px; color: rgba(248,250,252,0.45); margin-bottom: 32px; }
        .auth-label { display: block; font-size: 13px; font-weight: 500; color: rgba(248,250,252,0.65); margin-bottom: 6px; }
        .auth-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: #f8fafc;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            padding: 12px 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .auth-input:focus { border-color: rgba(247,215,104,0.6); box-shadow: 0 0 0 3px rgba(247,215,104,0.1); }
        .auth-input::placeholder { color: rgba(248,250,252,0.2); }
        .form-group { margin-bottom: 18px; }
        .auth-error { color: #fca5a5; font-size: 12px; margin-top: 5px; }
        .auth-btn {
            width: 100%;
            background: linear-gradient(135deg, #0b3b63 0%, #1e5f94 100%);
            color: #f7d768;
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 700;
            padding: 13px;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 16px rgba(11,59,99,0.4);
            letter-spacing: 0.01em;
            margin-top: 8px;
        }
        .auth-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(11,59,99,0.55); }
        .auth-btn:active { transform: translateY(0); }
        .remember-row { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .remember-row input { accent-color: #f7d768; width: 15px; height: 15px; cursor: pointer; }
        .remember-row label { font-size: 13px; color: rgba(248,250,252,0.5); cursor: pointer; }
        .auth-link { color: #f7d768; text-decoration: none; font-size: 13px; transition: opacity 0.2s; }
        .auth-link:hover { opacity: 0.75; }
        .auth-divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
        .auth-divider hr { flex: 1; border: none; border-top: 1px solid rgba(255,255,255,0.08); }
        .auth-divider span { font-size: 12px; color: rgba(248,250,252,0.25); }
        .bottom-link { text-align: center; margin-top: 20px; font-size: 13px; color: rgba(248,250,252,0.4); }
        .session-status { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #86efac; border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
        .sso-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5; border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 16px; }
        /* Microsoft SSO button */
        .btn-microsoft {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; padding: 12px 16px;
            background: #2f2f2f; color: #fff;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px; cursor: pointer;
            font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 600;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.25);
        }
        .btn-microsoft:hover { background: #3d3d3d; transform: translateY(-1px); }
        .btn-microsoft:active { transform: translateY(0); }
    </style>

    <x-auth-session-status class="session-status" :status="session('status')" />

    @if(session('error'))
        <div class="sso-error">{{ session('error') }}</div>
    @endif

    <h1 class="auth-heading">Sign in</h1>
    <p class="auth-sub">Access the Delegation of Authority system</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="auth-label" for="email">Email address</label>
            <input id="email" class="auth-input" type="email" name="email"
                value="{{ old('email') }}" placeholder="you@company.com"
                required autofocus autocomplete="username">
            @error('email')<p class="auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <label class="auth-label" style="margin:0" for="password">Password</label>
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <input id="password" class="auth-input" type="password" name="password"
                placeholder="••••••••" required autocomplete="current-password">
            @error('password')<p class="auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="remember-row">
            <input type="checkbox" id="remember_me" name="remember">
            <label for="remember_me">Keep me signed in</label>
        </div>

        <button type="submit" class="auth-btn" id="login-submit-btn">Sign In →</button>
    </form>

    @php
        try {
            $ssoReady = \App\Models\SsoSetting::current()->isReady();
        } catch (\Throwable) {
            $ssoReady = false;
        }
    @endphp

    @if($ssoReady)
        <div class="auth-divider"><hr><span>or</span><hr></div>

        <a href="{{ route('sso.redirect') }}" class="btn-microsoft" id="sso-microsoft-btn">
            {{-- Official Microsoft Fabric logo --}}
            <svg width="20" height="20" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                <rect x="1"  y="1"  width="9" height="9" fill="#f25022"/>
                <rect x="11" y="1"  width="9" height="9" fill="#7fba00"/>
                <rect x="1"  y="11" width="9" height="9" fill="#00a4ef"/>
                <rect x="11" y="11" width="9" height="9" fill="#ffb900"/>
            </svg>
            Sign in with Microsoft
        </a>
    @endif

    <div class="bottom-link">
        Need an account? Please contact your system administrator to request access.
    </div>
</x-guest-layout>
