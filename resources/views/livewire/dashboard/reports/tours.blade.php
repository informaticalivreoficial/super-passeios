<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hiking mr-2"></i> Relatório de Passeios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Relatório de Passeios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($totalTours, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Ativos</p>
                <p class="text-lg font-black text-green-600">{{ number_format($activeTours, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Inativos</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($inactiveTours, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-red-100 p-4">
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Sem Datas</p>
                <p class="text-lg font-black text-red-600">{{ number_format($withoutDates, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-indigo-100 p-4">
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Reservas Pagas</p>
                <p class="text-lg font-black text-indigo-600">{{ number_format($totalBookings, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1">Faturamento</p>
                <p class="text-lg font-black text-emerald-600">R$ {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por título..."
                    class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:border-blue-400 transition">
            </div>

            <select wire:model.live="period"
                class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                <option value="7">Últimos 7 dias</option>
                <option value="30">Últimos 30 dias</option>
                <option value="90">Últimos 90 dias</option>
                <option value="365">Últimos 12 meses</option>
            </select>

            <select wire:model.live="companyFilter"
                class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                <option value="">Todas as empresas</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->alias_name }}</option>
                @endforeach
            </select>

            <select wire:model.live="statusFilter"
                class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                <option value="">Ativos e inativos</option>
                <option value="active">Somente ativos</option>
                <option value="inactive">Somente inativos</option>
            </select>
        </div>

        {{-- GRÁFICO --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
            <h3 class="text-sm font-bold text-slate-700 mb-4">Passeios criados por mês</h3>
            <div style="position: relative; height: 240px;">
                <canvas id="toursReportChart"></canvas>
            </div>
        </div>

        {{-- TABELA --}}
        @if($tours->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Passeio</th>
                                <th class="px-4 py-3">Empresa</th>
                                <th class="px-4 py-3 text-center">Embarcação</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Reservas</th>
                                <th class="px-4 py-3 text-right">Faturamento</th>
                                <th class="px-4 py-3 text-right">Criado em</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($tours as $tour)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-slate-800 max-w-[220px] truncate">{{ $tour->title }}</p>
                                        <p class="text-xs text-slate-400">{{ $tour->tour_type?->label() }} · {{ $tour->price ? 'R$ ' . number_format($tour->price, 2, ',', '.') : 'Grátis' }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-xs font-semibold text-slate-600 max-w-[160px] truncate">{{ $tour->company?->alias_name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center text-xs text-slate-500">{{ $tour->vessel?->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $tour->active ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $tour->active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center font-black text-slate-700">{{ number_format($tour->bookings_count ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-black text-emerald-600">R$ {{ number_format($tour->revenue ?? 0, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">{{ $tour->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $tours->links() }}</div>
        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhum passeio encontrado!</p>
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
        const ctx = document.getElementById('toursReportChart');
        if (!ctx) return;

        if (chart) {
            chart.destroy();
            chart = null;
        }

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Passeios criados',
                    data: data,
                    backgroundColor: 'rgba(37, 99, 235, 0.7)',
                    borderRadius: 6,
                    borderSkipped: false,
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