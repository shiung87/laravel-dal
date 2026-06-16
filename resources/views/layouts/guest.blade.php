<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DAL') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #0a0f1e;
            display: flex;
        }

        /* ── Left branding panel ── */
        .brand-panel {
            display: none;
            position: relative;
            flex: 0 0 42%;
            background: linear-gradient(145deg, #0b3b63 0%, #1a1a4e 50%, #0f2744 100%);
            overflow: hidden;
            padding: 48px;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (min-width: 768px) {
            .brand-panel { display: flex; }
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 30% 20%, rgba(99,102,241,0.25) 0%, transparent 55%),
                radial-gradient(ellipse at 70% 80%, rgba(14,165,233,0.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .brand-logo {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-box {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #f7d768, #f59e0b);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 18px; color: #0b3b63;
            box-shadow: 0 4px 20px rgba(247,215,104,0.35);
        }

        .logo-text { color: #fff; }
        .logo-text .main { font-size: 18px; font-weight: 700; letter-spacing: -0.3px; }
        .logo-text .sub  { font-size: 11px; color: rgba(255,255,255,0.5); font-weight: 400; margin-top: 1px; }

        .brand-hero {
            position: relative;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-hero h1 {
            font-size: clamp(26px, 2.8vw, 38px);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -0.8px;
            margin-bottom: 16px;
        }

        .brand-hero h1 span {
            background: linear-gradient(90deg, #f7d768, #fb923c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-hero p {
            color: rgba(255,255,255,0.55);
            font-size: 14px;
            line-height: 1.7;
            max-width: 320px;
        }

        .feature-pills {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 36px;
        }

        .pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: rgba(255,255,255,0.8);
            font-size: 13px;
            font-weight: 500;
        }

        .pill-icon {
            width: 32px; height: 32px;
            background: rgba(247,215,104,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .brand-footer {
            position: relative;
            color: rgba(255,255,255,0.25);
            font-size: 12px;
        }

        /* ── Right form panel ── */
        .form-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 32px 24px;
            background: #0d1117;
            min-height: 100vh;
        }

        .form-box {
            width: 100%;
            max-width: 420px;
        }

        /* Mobile logo */
        .mobile-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 32px;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .mobile-logo { display: none; }
        }

        .mobile-logo .logo-box {
            width: 38px; height: 38px; font-size: 16px; border-radius: 10px;
        }

        .mobile-logo .main { font-size: 16px; font-weight: 700; color: #f8fafc; }
    </style>
</head>
<body>

    {{-- Left brand panel --}}
    <div class="brand-panel">
        <div class="brand-logo">
            <div class="logo-box">D</div>
            <div class="logo-text">
                <div class="main">DAL System</div>
                <div class="sub">Delegation of Authority</div>
            </div>
        </div>

        <div class="brand-hero">
            <h1>Manage Authority,<br><span>Empower Decisions</span></h1>
            <p>A centralised Delegation of Authority platform for structured approval workflows across regions and levels.</p>

            <div class="feature-pills">
                <div class="pill"><div class="pill-icon">🌏</div> Multi-currency thresholds (RM, SGD, AUD, USD, JPY)</div>
                <div class="pill"><div class="pill-icon">🔐</div> Role-based approval matrix</div>
                <div class="pill"><div class="pill-icon">📋</div> Capital & Non-Capital expenditure tracking</div>
            </div>
        </div>

        <div class="brand-footer">© {{ date('Y') }} {{ config('app.name', 'DAL System') }}. All rights reserved.</div>
    </div>

    {{-- Right form panel --}}
    <div class="form-panel">
        <div class="form-box">
            {{-- Mobile logo --}}
            <div class="mobile-logo">
                <div class="logo-box">D</div>
                <div class="logo-text">
                    <div class="main">DAL System</div>
                </div>
            </div>

            {{ $slot }}
        </div>
    </div>

</body>
</html>
