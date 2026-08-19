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
            font-size: 11px;
        }
        .page {
            padding: 30px 40px;
        }

        /* Header */
        .header {
            background-color: #1e40af;
            padding: 25px 40px;
            color: #ffffff;
        }
        .header table {
            width: 100%;
        }
        .logo {
            height: 38px;
        }
        .header .tag {
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #bfdbfe;
        }

        /* Title block */
        .company-title {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
            margin: 0 0 4px 0;
        }
        .company-subtitle {
            color: #6b7280;
            font-size: 11px;
            margin: 0 0 18px 0;
        }

        /* Section */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 4px;
            margin: 22px 0 10px 0;
        }

        /* Info grid via table (dompdf-safe) */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            width: 33.33%;
            padding: 6px 0;
            vertical-align: top;
        }
        .info-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9ca3af;
            display: block;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 12px;
            font-weight: bold;
            color: #111827;
        }

        /* Metrics */
        .metrics-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .metrics-table td {
            width: 20%;
            background-color: #f3f4f6;
            border-radius: 6px;
            padding: 10px 12px;
            text-align: center;
        }
        .metric-value {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            display: block;
        }
        .metric-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            display: block;
            margin-top: 2px;
        }

        /* Data table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        .data-table th {
            background-color: #1e40af;
            color: #ffffff;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 6px 8px;
            text-align: left;
        }
        .data-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f9fafb;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 12px;
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
                    <span class="tag">Relatório de empresa</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="page">

        <p class="company-title">{{ $company->alias_name }}</p>
        <p class="company-subtitle">
            {{ $company->social_name ?? '—' }} · Cadastro em {{ $company->created_at->format('d/m/Y') }}
            · {{ $company->status ? 'Ativa' : 'Inativa' }}
        </p>

        {{-- MÉTRICAS --}}
        <div class="section-title">Resumo financeiro</div>
        <table class="metrics-table">
            <tr>
                <td>
                    <span class="metric-value">R$ {{ number_format($metrics['revenue'], 0, ',', '.') }}</span>
                    <span class="metric-label">Receita (pagas)</span>
                </td>
                <td>
                    <span class="metric-value">R$ {{ number_format($metrics['commission'], 0, ',', '.') }}</span>
                    <span class="metric-label">Comissão</span>
                </td>
                <td>
                    <span class="metric-value">R$ {{ number_format($metrics['available'], 0, ',', '.') }}</span>
                    <span class="metric-label">Saldo disponível</span>
                </td>
                <td>
                    <span class="metric-value">R$ {{ number_format($metrics['pending'], 0, ',', '.') }}</span>
                    <span class="metric-label">Saldo pendente</span>
                </td>
                <td>
                    <span class="metric-value">R$ {{ number_format($metrics['withdrawn'], 0, ',', '.') }}</span>
                    <span class="metric-label">Já sacado</span>
                </td>
            </tr>
        </table>

        <div class="section-title">Operação</div>
        <table class="metrics-table">
            <tr>
                <td>
                    <span class="metric-value">{{ $metrics['vessels'] }}</span>
                    <span class="metric-label">Embarcações</span>
                </td>
                <td>
                    <span class="metric-value">{{ $metrics['tours'] }}</span>
                    <span class="metric-label">Passeios</span>
                </td>
                <td>
                    <span class="metric-value">{{ $metrics['activeTours'] }}</span>
                    <span class="metric-label">Passeios ativos</span>
                </td>
                <td>
                    <span class="metric-value">{{ $metrics['bookings'] }}</span>
                    <span class="metric-label">Reservas</span>
                </td>
                <td>
                    <span class="metric-value">{{ $metrics['customers'] }}</span>
                    <span class="metric-label">Clientes</span>
                </td>
            </tr>
        </table>

        {{-- DADOS CADASTRAIS --}}
        <div class="section-title">Dados cadastrais</div>
        <table class="info-table">
            <tr>
                <td>
                    <span class="info-label">CNPJ</span>
                    <span class="info-value">{{ $company->document_company ?? '—' }}</span>
                </td>
                <td>
                    <span class="info-label">Cadastur</span>
                    <span class="info-value">{{ $company->cadastur ?? '—' }}</span>
                </td>
                <td>
                    <span class="info-label">Comissão</span>
                    <span class="info-value">{{ $company->commission_rate ?? 0 }}%</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="info-label">Responsável</span>
                    <span class="info-value">{{ $company->responsable_name ?? '—' }}</span>
                </td>
                <td>
                    <span class="info-label">E-mail</span>
                    <span class="info-value">{{ $company->email ?? '—' }}</span>
                </td>
                <td>
                    <span class="info-label">Telefone</span>
                    <span class="info-value">{{ $company->phone ?? '—' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="info-label">Endereço</span>
                    <span class="info-value">{{ $company->street ?? '—' }}, {{ $company->number ?? '—' }}</span>
                </td>
                <td>
                    <span class="info-label">Bairro</span>
                    <span class="info-value">{{ $company->neighborhood ?? '—' }}</span>
                </td>
                <td>
                    <span class="info-label">Cidade / UF</span>
                    <span class="info-value">{{ $company->city ?? '—' }} - {{ $company->state ?? '—' }}</span>
                </td>
            </tr>
        </table>

        {{-- EMBARCAÇÕES --}}
        <div class="section-title">Embarcações ({{ $company->vessels->count() }})</div>
        @if($company->vessels->count() > 0)
            <table class="data-table">
                <tr>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Capacidade</th>
                    <th>Passeios</th>
                    <th>Status</th>
                </tr>
                @foreach($company->vessels as $vessel)
                    <tr>
                        <td>{{ $vessel->name }}</td>
                        <td>{{ $vessel->type ?: '—' }}</td>
                        <td>{{ $vessel->capacity ?? '—' }}</td>
                        <td>{{ $vessel->tours->count() }}</td>
                        <td>{{ $vessel->active ? 'Ativa' : 'Inativa' }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <p style="color: #6b7280;">Nenhuma embarcação cadastrada.</p>
        @endif

        {{-- PASSEIOS --}}
        <div class="section-title">Passeios ({{ $company->tours->count() }})</div>
        @if($company->tours->count() > 0)
            <table class="data-table">
                <tr>
                    <th>Passeio</th>
                    <th>Tipo</th>
                    <th>Embarcação</th>
                    <th>Preço</th>
                    <th>Status</th>
                </tr>
                @foreach($company->tours as $tour)
                    <tr>
                        <td>{{ $tour->title }}</td>
                        <td>{{ $tour->tour_type?->label() ?? '—' }}</td>
                        <td>{{ $tour->vessel?->name ?? '—' }}</td>
                        <td>R$ {{ number_format($tour->price, 2, ',', '.') }}</td>
                        <td>{{ $tour->active ? 'Ativo' : 'Inativo' }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <p style="color: #6b7280;">Nenhum passeio cadastrado.</p>
        @endif

        {{-- RESERVAS RECENTES --}}
        <div class="section-title">Reservas recentes</div>
        @if($recentBookings->count() > 0)
            <table class="data-table">
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Passeio</th>
                    <th>Status</th>
                    <th>Pagamento</th>
                    <th>Total</th>
                </tr>
                @foreach($recentBookings as $booking)
                    <tr>
                        <td>{{ strtoupper(substr($booking->uuid, 0, 8)) }}</td>
                        <td>{{ $booking->customer_name }}</td>
                        <td>{{ $booking->tour?->title ?? '—' }}</td>
                        <td>{{ $booking->status->label() }}</td>
                        <td>{{ $booking->payment_status->label() }}</td>
                        <td>R$ {{ number_format($booking->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <p style="color: #6b7280;">Nenhuma reserva encontrada.</p>
        @endif

        <div class="footer">
            Relatório gerado em {{ now()->format('d/m/Y H:i') }} · {{ config('app.name') }}
        </div>

    </div>

</body>
</html>