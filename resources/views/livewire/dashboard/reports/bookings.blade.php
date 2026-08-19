<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-ticket-alt mr-2"></i> Relatório de Reservas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Relatório de Reservas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-8 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($totalBookings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Pagas</p>
                <p class="text-lg font-black text-green-600">{{ number_format($paidBookings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-amber-100 p-4">
                <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-1">Pendentes</p>
                <p class="text-lg font-black text-amber-600">{{ number_format($pendingBookings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-red-100 p-4">
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Canceladas</p>
                <p class="text-lg font-black text-red-600">{{ number_format($cancelledBookings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Reembolsadas</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($refundedBookings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1">Receita</p>
                <p class="text-lg font-black text-emerald-600">R$ {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-purple-100 p-4">
                <p class="text-[10px] font-bold text-purple-500 uppercase tracking-widest mb-1">Comissão</p>
                <p class="text-lg font-black text-purple-600">R$ {{ number_format($totalCommission, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-indigo-100 p-4">
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Ticket Médio</p>
                <p class="text-lg font-black text-indigo-600">R$ {{ number_format($averageTicket, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por cliente, e-mail ou código..."
                    class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:border-blue-400 transition">
            </div>

            <select wire:model.live="period"
                class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                <option value="7">Últimos 7 dias</option>
                <option value="30">Últimos 30 dias</option>
                <option value="90">Últimos 90 dias</option>
                <option value="365">Últimos 12 meses</option>
            </select>

            <select wire:model.live="statusFilter"
                class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                <option value="">Todos os status</option>
                @foreach(\App\Enums\BookingStatusEnum::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </select>

            <select wire:model.live="paymentFilter"
                class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                <option value="">Todos os pagamentos</option>
                @foreach(\App\Enums\PaymentStatusEnum::cases() as $payment)
                    <option value="{{ $payment->value }}">{{ $payment->label() }}</option>
                @endforeach
            </select>

            <select wire:model.live="companyFilter"
                class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                <option value="">Todas as empresas</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->alias_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- GRÁFICO --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
            <h3 class="text-sm font-bold text-slate-700 mb-4">Reservas por dia</h3>
            <div style="position: relative; height: 260px;">
                <canvas id="bookingsReportChart"></canvas>
            </div>
        </div>

        {{-- TABELA --}}
        @if($bookings->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Código</th>
                                <th class="px-4 py-3">Cliente</th>
                                <th class="px-4 py-3">Passeio</th>
                                <th class="px-4 py-3">Empresa</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Pagamento</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-right">Criada em</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($bookings as $booking)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs font-bold text-slate-500">{{ strtoupper(substr($booking->uuid, 0, 8)) }}</td>
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-slate-800 max-w-[160px] truncate">{{ $booking->customer_name }}</p>
                                        <p class="text-xs text-slate-400 max-w-[160px] truncate">{{ $booking->customer_email }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-xs font-semibold text-slate-600 max-w-[180px] truncate">{{ $booking->tour?->title ?? '—' }}</td>
                                    <td class="px-4 py-3 text-xs text-slate-500 max-w-[140px] truncate">{{ $booking->company?->alias_name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $statusBadge = match($booking->status) {
                                                \App\Enums\BookingStatusEnum::CONFIRMED => 'bg-green-50 text-green-600',
                                                \App\Enums\BookingStatusEnum::CANCELLED => 'bg-red-50 text-red-600',
                                                \App\Enums\BookingStatusEnum::COMPLETED => 'bg-blue-50 text-blue-600',
                                                \App\Enums\BookingStatusEnum::NO_SHOW => 'bg-slate-100 text-slate-500',
                                                default => 'bg-amber-50 text-amber-600',
                                            };
                                        @endphp
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusBadge }}">
                                            {{ $booking->status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $paymentBadge = match($booking->payment_status) {
                                                \App\Enums\PaymentStatusEnum::PAID => 'bg-green-50 text-green-600',
                                                \App\Enums\PaymentStatusEnum::REFUSED => 'bg-red-50 text-red-600',
                                                \App\Enums\PaymentStatusEnum::REFUNDED => 'bg-slate-100 text-slate-500',
                                                \App\Enums\PaymentStatusEnum::EXPIRED => 'bg-slate-100 text-slate-500',
                                                default => 'bg-amber-50 text-amber-600',
                                            };
                                        @endphp
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $paymentBadge }}">
                                            {{ $booking->payment_status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-black text-slate-700">R$ {{ number_format($booking->total, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $bookings->links() }}</div>
        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhuma reserva encontrada!</p>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
document.addEventListener('livewire:init', function () {
    let chart;

    function initChart(labels, data) {
        const ctx = document.getElementById('bookingsReportChart');
        if (!ctx) return;

        if (chart) {
            chart.destroy();
            chart = null;
        }

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Reservas',
                    data: data,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.08)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    initChart(@json($labels), @json($data));

    Livewire.on('updateChart', (event) => {
        const payload = event[0];
        initChart(payload.labels, payload.data);
    });
});
</script>
@endpush