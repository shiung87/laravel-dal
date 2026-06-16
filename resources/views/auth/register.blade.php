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
        .form-group { margin-bottom: 16px; }
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
        .auth-link { color: #f7d768; text-decoration: none; font-size: 13px; transition: opacity 0.2s; }
        .auth-link:hover { opacity: 0.75; }
        .bottom-link { text-align: center; margin-top: 20px; font-size: 13px; color: rgba(248,250,252,0.4); }
        .name-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    </style>

    <h1 class="auth-heading">Create account</h1>
    <p class="auth-sub">Join the Delegation of Authority system</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="auth-label" for="name">Full name</label>
            <input id="name" class="auth-input" type="text" name="name"
                value="{{ old('name') }}" placeholder="Your full name"
                required autofocus autocomplete="name">
            @error('name')<p class="auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="auth-label" for="reg_email">Work email</label>
            <input id="reg_email" class="auth-input" type="email" name="email"
                value="{{ old('email') }}" placeholder="you@company.com"
                required autocomplete="username">
            @error('email')<p class="auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="auth-label" for="reg_password">Password</label>
            <input id="reg_password" class="auth-input" type="password" name="password"
                placeholder="Min. 8 characters"
                required autocomplete="new-password">
            @error('password')<p class="auth-error">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="auth-label" for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" class="auth-input" type="password"
                name="password_confirmation"
                placeholder="Repeat your password"
                required autocomplete="new-password">
            @error('password_confirmation')<p class="auth-error">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="auth-btn" id="register-submit-btn">Create Account →</button>
    </form>

    <div class="bottom-link">
        Already have an account? <a class="auth-link" href="{{ route('login') }}">Sign in</a>
    </div>
</x-guest-layout>
