<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f3ee;
            font-family: Georgia, 'Times New Roman', serif;
        }

        table { border-spacing: 0; border-collapse: collapse; }
        img { border: 0; max-width: 100%; }

        .wrapper {
            width: 100%;
            background-color: #f5f3ee;
            padding: 40px 16px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e8e4d8;
        }

        /* HEADER */
        .header {
            padding: 0;
            text-align: center;
            background: linear-gradient(135deg, #051e34 0%, #0a3358 60%, #0e4a7a 100%);
        }

        .header-inner {
            padding: 32px;
            position: relative;
        }

        .header-logo {
            display: block;
            margin: 0 auto 0 auto;
            max-height: 44px;
            width: auto;
        }

        .header-divider {
            height: 4px;
            background: linear-gradient(90deg, #16a3b7 0%, #fadd37 50%, #16a3b7 100%);
        }

        /* BODY */
        .body {
            padding: 40px 40px 32px;
            font-size: 15px;
            line-height: 1.8;
            color: #051e34;
            font-family: 'DM Sans', Arial, sans-serif;
        }

        .body p {
            margin: 0 0 16px;
            color: #374151;
        }

        .body h1, .body h2, .body h3 {
            font-family: Arial, sans-serif;
            font-weight: 800;
            color: #051e34;
            margin: 0 0 12px;
        }

        /* BOTÃO */
        .btn-wrap {
            text-align: center;
            padding: 8px 0 24px;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            background-color: #16a3b7;
            color: #ffffff !important;
            font-family: Arial, sans-serif;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            border-radius: 12px;
            border-bottom: 3px solid #0e7a8a;
        }

        /* PANEL (blocos de destaque) */
        .panel {
            background: #f5f3ee;
            border-left: 4px solid #16a3b7;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
            font-size: 14px;
            color: #374151;
        }

        /* DIVIDER */
        .divider {
            height: 1px;
            background-color: #e8e4d8;
            margin: 24px 0;
        }

        /* FOOTER */
        .footer {
            padding: 28px 40px;
            text-align: center;
            font-size: 12px;
            line-height: 1.6;
            color: #87c2c0;
            background-color: #051e34;
        }

        .footer a {
            color: #16a3b7;
            text-decoration: none;
        }

        .footer-brand {
            font-size: 14px;
            font-weight: 700;
            color: #fadd37;
            font-family: Arial, sans-serif;
            margin-bottom: 8px;
        }

        .footer-social {
            margin: 16px 0 12px;
        }

        .footer-social a {
            display: inline-block;
            margin: 0 6px;
            color: rgba(255,255,255,0.5) !important;
            font-size: 11px;
            text-decoration: none;
        }

        /* BADGE */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(22,163,183,0.1);
            border: 1px solid rgba(22,163,183,0.3);
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            color: #16a3b7;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 16px;
        }

        @media only screen and (max-width: 600px) {
            .wrapper  { padding: 16px 8px !important; }
            .body     { padding: 24px 20px !important; }
            .footer   { padding: 20px !important; }
        }
    </style>
</head>

<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">

    <table class="container" width="600" cellpadding="0" cellspacing="0" role="presentation">

        {{-- HEADER --}}
        <tr>
            <td class="header">
                <div class="header-inner">
                    @if(config('app.logomarca'))
                        <img
                            src="{{ config('app.logomarca') }}"
                            alt="{{ config('app.name') }}"
                            class="header-logo"
                            height="44"
                        >
                    @else
                        <span style="font-size: 22px; font-weight: 800; color: #ffffff; font-family: Arial, sans-serif; letter-spacing: -0.5px;">
                            {{ config('app.name') }}
                        </span>
                    @endif
                </div>
                <div class="header-divider"></div>
            </td>
        </tr>

        {{-- BODY --}}
        <tr>
            <td class="body" style="padding: 40px 40px 32px; font-size: 15px; line-height: 1.8; color: #374151; font-family: Arial, sans-serif;">
                {!! Illuminate\Mail\Markdown::parse($slot) !!}
                {!! $subcopy ?? '' !!}
            </td>
        </tr>

        {{-- FOOTER --}}
        <tr>
            <td class="footer">

                <div class="footer-brand">{{ config('app.name') }}</div>

                <p style="margin: 0 0 12px; color: rgba(255,255,255,0.4); font-size: 11px;">
                    Você está recebendo este email pois tem uma conta em nossa plataforma.
                    <br>
                    Se não reconhece este email, pode ignorá-lo com segurança.
                </p>

                <div class="footer-social">
                    <a href="{{ config('app.instagram') }}">Instagram</a>
                    <a href="{{ config('app.facebook') }}">Facebook</a>
                    <a href="tel:{{ config('app.telefone') }}">WhatsApp</a>
                </div>

                <p style="margin: 0; color: rgba(255,255,255,0.3); font-size: 11px;">
                    © {{ date('Y') }} {{ config('app.name') }} — Todos os direitos reservados.
                </p>

            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>