<div 
    x-data="{
        openLightbox(src) {
            basicLightbox.create(`<img src='${src}' style='max-width:90vw; max-height:90vh;'>`).show()
        }
    }"
    class="bg-slate-50 min-h-screen -m-4 p-4 lg:p-6"
>
    @section('title', $title)

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Painel de Controle</h1>
        <nav class="text-sm text-slate-400 font-medium">
            <a href="javascript:void(0)" class="hover:text-slate-600">Início</a>
            <span class="mx-1.5">/</span>
            <span class="text-slate-600">Painel de Controle</span>
        </nav>
    </div>

    {{-- ============ VISÃO GERAL ============ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('admin.companies.index') }}" class="group bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-blue-50 text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Empresas</p>
                    <p class="text-xl font-black text-slate-900 leading-tight">{{ $companyCount }}</p>
                    <p class="text-[10px] text-slate-400 font-medium">{{ now()->year }}: {{ $companyYearCount }}</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.tours.index') }}" class="group bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-green-50 text-green-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Passeios</p>
                    <p class="text-xl font-black text-slate-900 leading-tight">{{ $toursActiveCount }}</p>
                    <p class="text-[10px] text-slate-400 font-medium">{{ $toursInactiveCount }} inativos</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.bookings.index') }}" class="group bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-indigo-50 text-indigo-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Reservas</p>
                    <p class="text-xl font-black text-slate-900 leading-tight">{{ $bookingsThisMonthCount }}</p>
                    <p class="text-[10px] text-slate-400 font-medium">{{ $bookingsTodayCount }} hoje</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.withdrawals.index') }}" class="group bg-white rounded-2xl border border-slate-100 p-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-emerald-50 text-emerald-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Receita</p>
                    <p class="text-xl font-black text-slate-900 leading-tight">R$ {{ number_format($totalPaidGross, 0, ',', '.') }}</p>
                    <p class="text-[10px] text-slate-400 font-medium">R$ {{ number_format($commissionEarned, 0, ',', '.') }} comissão</p>
                </div>
            </div>
        </a>
    </div>

    {{-- ============ RESERVAS ============ --}}
    <h2 class="text-sm font-black text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Reservas
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 mb-8">
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Hoje</p>
            <p class="text-lg font-black text-slate-900">{{ $bookingsTodayCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">No Mês</p>
            <p class="text-lg font-black text-slate-900">{{ $bookingsThisMonthCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-amber-100 p-4">
            <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-1">Pendentes</p>
            <p class="text-lg font-black text-amber-600">{{ $bookingsPendingCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-red-100 p-4">
            <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Canceladas</p>
            <p class="text-lg font-black text-red-600">{{ $bookingsCancelledThisMonthCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ticket Médio</p>
            <p class="text-lg font-black text-slate-900">R$ {{ number_format($averageTicket, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Conversão</p>
            <p class="text-lg font-black text-slate-900">{{ $conversionRate }}%</p>
        </div>
    </div>

    {{-- ============ FINANCEIRO ============ --}}
    <h2 class="text-sm font-black text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
        Financeiro
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3 mb-8">
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Pago</p>
            <p class="text-lg font-black text-slate-900">R$ {{ number_format($totalPaidGross, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pago no Mês</p>
            <p class="text-lg font-black text-slate-900">R$ {{ number_format($totalPaidThisMonth, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-blue-100 p-4">
            <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1">Comissão</p>
            <p class="text-lg font-black text-blue-600">R$ {{ number_format($commissionEarned, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-amber-100 p-4">
            <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-1">Pendente</p>
            <p class="text-lg font-black text-amber-600">R$ {{ number_format($pendingPayout, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl border border-green-100 p-4">
            <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">A Sacar</p>
            <p class="text-lg font-black text-green-600">R$ {{ number_format($availableForWithdraw, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- ============ PASSEIOS ============ --}}
    <h2 class="text-sm font-black text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Passeios
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-8">
        <div class="bg-white rounded-xl border border-green-100 p-4">
            <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Ativos</p>
            <p class="text-lg font-black text-green-600">{{ $toursActiveCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-4">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Inativos</p>
            <p class="text-lg font-black text-slate-900">{{ $toursInactiveCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-red-100 p-4">
            <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Sem Datas</p>
            <p class="text-lg font-black text-red-600">{{ $toursWithoutDatesCount }}</p>
        </div>
    </div>

    {{-- ============ CONTEÚDO ============ --}}
    <h2 class="text-sm font-black text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Conteúdo
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-8">
        <div class="bg-white rounded-xl border border-teal-100 p-4">
            <p class="text-[10px] font-bold text-teal-500 uppercase tracking-widest mb-1">Notícias</p>
            <p class="text-lg font-black text-teal-600">{{ $noticiasCount }}</p>
            <p class="text-[10px] text-slate-400 font-medium">{{ now()->year }}: {{ $noticiasYearCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-purple-100 p-4">
            <p class="text-[10px] font-bold text-purple-500 uppercase tracking-widest mb-1">Artigos</p>
            <p class="text-lg font-black text-purple-600">{{ $articlesCount }}</p>
            <p class="text-[10px] text-slate-400 font-medium">{{ now()->year }}: {{ $articlesYearCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-amber-100 p-4">
            <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-1">Sem Passeios</p>
            <p class="text-lg font-black text-amber-600">{{ $companiesWithNoToursCount }}</p>
            <p class="text-[10px] text-slate-400 font-medium">Operadoras</p>
        </div>
    </div>

    {{-- ============ GRÁFICOS ============ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 p-6">
            <h3 class="text-sm font-bold text-slate-700 mb-4">Faturamento — últimos 30 dias</h3>
            <div style="position: relative; height: 280px;">
                <canvas id="revenueChart" role="img" aria-label="Gráfico de linha mostrando o faturamento diário dos últimos 30 dias">Faturamento diário dos últimos 30 dias.</canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-6">
            <h3 class="text-sm font-bold text-slate-700 mb-4">Reservas do mês</h3>
            <div style="position: relative; height: 280px;">
                <canvas id="bookingsChart" role="img" aria-label="Gráfico de rosca mostrando reservas pagas, pendentes e canceladas no mês">Reservas do mês por status.</canvas>
            </div>
        </div>
    </div>

    <livewire:dashboard.reports.dashboard-stats />
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const revenueData = @json($revenueChartData);
            const bookingsData = @json($bookingsStatusChartData);

            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: revenueData.labels,
                    datasets: [{
                        label: 'Faturamento',
                        data: revenueData.values,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.08)',
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { callback: (v) => 'R$ ' + v.toLocaleString('pt-BR') }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('bookingsChart'), {
                type: 'doughnut',
                data: {
                    labels: bookingsData.labels,
                    datasets: [{
                        data: bookingsData.values,
                        backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, padding: 16, font: { size: 12 } } } }
                }
            });
        });

        @if (session()->has('toast'))
            document.addEventListener('DOMContentLoaded', function () {
                showToast(
                    "{{ session('toast.type') }}",
                    "{{ session('toast.message') }}"
                );
            });
        @endif
    </script>
@endpush