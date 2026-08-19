<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f7f7f8 0%, #eef2f1 100%);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .box {
            text-align: center;
            max-width: 440px;
            width: 100%;
            background: #fff;
            border-radius: 20px;
            padding: 48px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        }
        .icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            border-radius: 16px;
            background: #ecfdf5;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon svg {
            width: 32px;
            height: 32px;
            color: #10b981;
        }
        .code {
            font-size: 64px;
            font-weight: 800;
            color: #10b981;
            line-height: 1;
            margin-bottom: 8px;
            letter-spacing: -2px;
        }
        h1 {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 12px;
            color: #111827;
        }
        p {
            color: #6b7280;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        a.btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #10b981;
            color: #fff;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        a.btn:hover {
            background: #059669;
            transform: translateY(-1px);
        }
        a.btn svg {
            width: 16px;
            height: 16px;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="icon">{!! $icon ?? '' !!}</div>
        <div class="code">{{ $code }}</div>
        <h1>{{ $title }}</h1>
        <p>{{ $message }}</p>
        <a class="btn" href="{{ url('/') }}">
            Voltar para o início
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</body>
</html>