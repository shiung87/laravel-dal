<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Secure administrator login portal.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated gradient background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(168, 85, 247, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(14, 165, 233, 0.08) 0%, transparent 60%);
            animation: bgShift 8s ease-in-out infinite alternate;
            pointer-events: none;
        }

        @keyframes bgShift {
            0%   { opacity: 0.8; transform: scale(1); }
            100% { opacity: 1;   transform: scale(1.05); }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }
        .orb-1 { width: 400px; height: 400px; background: rgba(99, 102, 241, 0.2); top: -100px; left: -100px; animation-delay: 0s; }
        .orb-2 { width: 300px; height: 300px; background: rgba(168, 85, 247, 0.15); bottom: -80px; right: -80px; animation-delay: -3s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50%       { transform: translateY(-20px) scale(1.03); }
        }

        .login-card {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1); }
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #a5b4fc;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 100px;
            margin-bottom: 24px;
        }

        .admin-badge svg { width: 12px; height: 12px; fill: currentColor; }

        h1 {
            color: #f8fafc;
            font-size: 28px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: rgba(248, 250, 252, 0.45);
            font-size: 14px;
            margin-bottom: 36px;
        }

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            color: rgba(248, 250, 252, 0.7);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
            letter-spacing: 0.02em;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #f8fafc;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            padding: 13px 16px;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: rgba(99, 102, 241, 0.6);
            background: rgba(99, 102, 241, 0.06);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        input::placeholder { color: rgba(248, 250, 252, 0.25); }

        .error-msg {
            color: #f87171;
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 28px;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: #6366f1;
            cursor: pointer;
        }

        .remember-row label {
            margin: 0;
            color: rgba(248, 250, 252, 0.55);
            font-size: 13px;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 600;
            padding: 14px;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.35);
            letter-spacing: 0.01em;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(99, 102, 241, 0.5);
        }

        .btn-login:active { transform: translateY(0); opacity: 0.9; }

        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            color: rgba(248, 250, 252, 0.4);
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link a:hover { color: rgba(248, 250, 252, 0.7); }

        .session-status {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #86efac;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="login-card">
        <div class="admin-badge">
            <svg viewBox="0 0 20 20"><path d="M10 1l2.39 4.84L18 6.82l-4 3.9.94 5.5L10 13.77l-4.94 2.45L6 10.72 2 6.82l5.61-.98L10 1z"/></svg>
            Admin Portal
        </div>

        <h1>Welcome back</h1>
        <p class="subtitle">Sign in to access the admin dashboard</p>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif

        {{-- Error Alert --}}
        @if (session('error'))
            <div class="error-msg" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);border-radius:10px;padding:10px 14px;margin-bottom:20px;font-size:13px;color:#fca5a5;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="admin_email">Email address</label>
                <input id="admin_email" type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@example.com"
                    required autofocus autocomplete="username">
                @error('email')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="admin_password">Password</label>
                <input id="admin_password" type="password" name="password"
                    placeholder="••••••••"
                    required autocomplete="current-password">
                @error('password')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="remember-row">
                <input type="checkbox" id="admin_remember" name="remember">
                <label for="admin_remember">Keep me signed in</label>
            </div>

            <button type="submit" class="btn-login" id="admin-login-btn">
                Sign in to Admin
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">← Back to user login</a>
        </div>
    </div>
</body>
</html>
