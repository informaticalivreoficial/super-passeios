<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-ship mr-2"></i> Relatório de Embarcações</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Relatório de Embarcações</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($totalVessels, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Ativas</p>
                <p class="text-lg font-black text-green-600">{{ number_format($activeVessels, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Inativas</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($inactiveVessels, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-indigo-100 p-4">
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Capacidade Total</p>
                <p class="text-lg font-black text-indigo-600">{{ number_format($totalCapacity, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1">Passeios Vinculados</p>
                <p class="text-lg font-black text-emerald-600">{{ number_format($totalTours, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome..."
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
                <option value="">Ativas e inativas</option>
                <option value="active">Somente ativas</option>
                <option value="inactive">Somente inativas</option>
            </select>
        </div>

        {{-- GRÁFICO --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
            <h3 class="text-sm font-bold text-slate-700 mb-4">Embarcações por tipo</h3>
            <div style="position: relative; height: 240px;">
                <canvas id="vesselsReportChart"></canvas>
            </div>
        </div>

        {{-- TABELA --}}
        @if($vessels->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Embarcação</th>
                                <th class="px-4 py-3">Empresa</th>
                                <th class="px-4 py-3 text-center">Tipo</th>
                                <th class="px-4 py-3 text-center">Capacidade</th>
                                <th class="px-4 py-3 text-center">Passeios</th>
                                <th class="px-4 py-3 text-center">Passeios c/ reservas</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($vessels as $vessel)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-slate-800 max-w-[200px] truncate">{{ $vessel->name }}</p>
                                        @if($vessel->year)
                                            <p class="text-xs text-slate-400">{{ $vessel->year }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs font-semibold text-slate-600 max-w-[160px] truncate">{{ $vessel->company?->alias_name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                            {{ $vessel->type ?: '—' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center font-black text-slate-700">{{ $vessel->capacity ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center font-black text-slate-700">{{ number_format($vessel->tours_count ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center font-black text-indigo-600">{{ number_format($vessel->tours_with_bookings ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $vessel->active ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $vessel->active ? 'Ativa' : 'Inativa' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $vessels->links() }}</div>
        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhuma embarcação encontrada!</p>
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
        const ctx = document.getElementById('vesselsReportChart');
        if (!ctx) return;

        if (chart) {
            chart.destroy();
            chart = null;
        }

        chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#06b6d4'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 10, padding: 16, font: { size: 12 } } }
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