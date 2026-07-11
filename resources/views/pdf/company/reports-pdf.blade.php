<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #051e34; }
        h1 { font-size: 20px; margin-bottom: 4px; }
        h2 { font-size: 14px; margin-top: 24px; margin-bottom: 8px; border-bottom: 1px solid #e8e4d8; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { text-align: left; padding: 6px 8px; border-bottom: 1px solid #f5f2ec; font-size: 11px; }
        th { color: #87c2c0; font-weight: bold; }
        .text-right { text-align: right; }
        .muted { color: #87c2c0; }
        .box { display: inline-block; width: 30%; margin-right: 2%; padding: 10px; border: 1px solid #e8e4d8; border-radius: 6px; }
    </style>
</head>
<body>
    <h1>Relatório — {{ $company->alias_name ?? $company->social_name }}</h1>
    <p class="muted">{{ $period_label }}</p>

    <h2>Vendas</h2>
    <div class="box"><strong>R$ {{ number_format($sales['total_revenue'], 2, ',', '.') }}</strong><br><span class="muted">Faturamento</span></div>
    <div class="box"><strong>{{ $sales['total_paid_count'] }}</strong><br><span class="muted">Reservas pagas</span></div>
    <div class="box"><strong>R$ {{ number_format($sales['average_ticket'], 2, ',', '.') }}</strong><br><span class="muted">Ticket médio</span></div>

    <h2>Desempenho por passeio</h2>
    <table>
        <thead>
            <tr><th>Passeio</th><th class="text-right">Reservas</th><th class="text-right">Faturamento</th><th class="text-right">Ocupação</th></tr>
        </thead>
        <tbody>
            @foreach($tours as $tour)
                <tr>
                    <td>{{ $tour['title'] }}</td>
                    <td class="text-right">{{ $tour['bookings'] }}</td>
                    <td class="text-right">R$ {{ number_format($tour['revenue'], 2, ',', '.') }}</td>
                    <td class="text-right">{{ $tour['occupancy'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Financeiro</h2>
    <table>
        <tr><td>Saldo disponível</td><td class="text-right">R$ {{ number_format($financial['available_balance'], 2, ',', '.') }}</td></tr>
        <tr><td>Saldo pendente</td><td class="text-right">R$ {{ number_format($financial['pending_balance'], 2, ',', '.') }}</td></tr>
        <tr><td>Comissão no período</td><td class="text-right">R$ {{ number_format($financial['commission_period'], 2, ',', '.') }}</td></tr>
        <tr><td>Sacado no período</td><td class="text-right">R$ {{ number_format($financial['withdrawn_period'], 2, ',', '.') }}</td></tr>
    </table>

    <h2>Clientes</h2>
    <p>Total: {{ $clients['total'] }} · Novos: {{ $clients['new'] }} · Recorrentes: {{ $clients['returning'] }}</p>
</body>
</html>