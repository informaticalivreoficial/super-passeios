<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-chart-bar mr-2"></i> Relatório de Posts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Relatório de Posts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Posts</p>
                <p class="text-lg font-black text-slate-900">{{ number_format($totalPosts, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-blue-100 p-4">
                <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1">Artigos</p>
                <p class="text-lg font-black text-blue-600">{{ number_format($totalArtigos, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Notícias</p>
                <p class="text-lg font-black text-green-600">{{ number_format($totalNoticias, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-purple-100 p-4">
                <p class="text-[10px] font-bold text-purple-500 uppercase tracking-widest mb-1">Views</p>
                <p class="text-lg font-black text-purple-600">{{ number_format($totalViews, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
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

            <select wire:model.live="type"
                class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                <option value="all">Todos os tipos</option>
                <option value="artigo">Artigos</option>
                <option value="noticia">Notícias</option>
            </select>
        </div>

        {{-- GRÁFICO --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-6 mb-6">
            <h3 class="text-sm font-bold text-slate-700 mb-4">Posts publicados por dia</h3>
            <div style="position: relative; height: 260px;">
                <canvas id="postsReportChart"></canvas>
            </div>
        </div>

        {{-- TABELA --}}
        @if($posts->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Título</th>
                                <th class="px-4 py-3 text-center">Tipo</th>
                                <th class="px-4 py-3 text-right">Views</th>
                                <th class="px-4 py-3 text-right">Publicado em</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($posts as $post)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-800 max-w-[320px] truncate">{{ $post->title }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $post->type === 'noticia' ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-blue-600' }}">
                                            {{ $post->type === 'noticia' ? 'Notícia' : 'Artigo' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-black text-slate-700">{{ number_format($post->views, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $posts->links() }}</div>
        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhum post encontrado no período!</p>
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
        const ctx = document.getElementById('postsReportChart');
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
                    label: 'Posts publicados',
                    data: data,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.08)',
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