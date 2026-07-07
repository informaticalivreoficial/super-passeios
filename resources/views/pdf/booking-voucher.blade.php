<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        .page {
            padding: 40px 45px;
        }

        /* Header */
        .header {
            background-color: #1e40af;
            padding: 30px 45px;
            color: #ffffff;
        }
        .header table {
            width: 100%;
        }
        .logo {
            height: 42px;
        }
        .header .tag {
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #bfdbfe;
        }

        /* Title block */
        .tour-title {
            font-size: 22px;
            font-weight: bold;
            color: #111827;
            margin: 0 0 4px 0;
        }
        .tour-subtitle {
            color: #6b7280;
            font-size: 11px;
            margin: 0 0 20px 0;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
        }
        .status-confirmed { background-color: #16a34a; }
        .status-pending   { background-color: #d97706; }
        .status-cancelled { background-color: #dc2626; }

        /* Info grid via table (dompdf-safe) */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .info-table td {
            width: 50%;
            padding: 10px 0;
            vertical-align: top;
        }
        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9ca3af;
            display: block;
            margin-bottom: 3px;
        }
        .info-value {
            font-size: 13px;
            font-weight: bold;
            color: #111827;
        }

        /* Divider */
        .divider {
            border-top: 1px dashed #d1d5db;
            margin: 25px 0;
        }

        /* Code + QR box */
        .code-box {
            background-color: #f3f4f6;
            border-radius: 8px;
            padding: 18px 22px;
        }
        .code-box table {
            width: 100%;
        }
        .booking-code {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #1e40af;
        }
        .qr-img {
            width: 78px;
            height: 78px;
        }

        /* Totals */
        .total-box {
            margin-top: 25px;
            text-align: right;
        }
        .total-label {
            font-size: 11px;
            color: #6b7280;
        }
        .total-value {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td style="width: 60%;">
                    <img class="logo" src="{{ public_path('theme/images/logo-pdf.png') }}">
                </td>
                <td style="width: 40%; text-align: right;">
                    <span class="tag">Voucher de reserva</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="page">

        <p class="tour-title">{{ $booking->tourDate->tour->title }}</p>
        <p class="tour-subtitle">
            @switch($booking->status->value)
                @case('CONFIRMED')
                    <span class="status-badge status-confirmed">CONFIRMADO</span>
                    @break
                @case('CANCELLED')
                    <span class="status-badge status-cancelled">CANCELADO</span>
                    @break
                @default
                    <span class="status-badge status-pending">{{ $booking->status->label() }}</span>
            @endswitch
        </p>

        <table class="info-table">
            <tr>
                <td>
                    <span class="info-label">Data do passeio</span>
                    <span class="info-value">{{ $booking->tourDate->date->format('d/m/Y') }}</span>
                </td>
                <td>
                    <span class="info-label">Horário</span>
                    <span class="info-value">{{ $booking->tourDate->start_time }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="info-label">Passageiros</span>
                    <span class="info-value">
                        {{ $booking->adults }} adulto(s)
                        @if($booking->children) + {{ $booking->children }} criança(s) @endif
                    </span>
                </td>
                <td>
                    <span class="info-label">Cliente</span>
                    <span class="info-value">{{ $booking->customer_name }}</span>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="code-box">
            <table>
                <tr>
                    <td style="width: 70%;">
                        <span class="info-label">Código da reserva</span>
                        <span class="booking-code">{{ strtoupper(substr($booking->uuid, 0, 8)) }}</span>
                    </td>
                    <td style="width: 30%; text-align: right;">
                        @if($qrCodeBase64)
                            <img class="qr-img" src="data:image/png;base64,{{ $qrCodeBase64 }}">
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="total-box">
            <span class="total-label">Total pago</span><br>
            <span class="total-value">R$ {{ number_format($booking->total, 2, ',', '.') }}</span>
        </div>

        <div class="footer">
            Apresente este voucher (impresso ou no celular) no momento do embarque.<br>
            Gerado em {{ now()->format('d/m/Y H:i') }} · {{ config('app.name') }}
        </div>

    </div>

</body>
</html>