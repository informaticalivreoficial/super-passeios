@extends("web.$config->template.master.master")

@section('content')
{{-- HERO --}}
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, var(--navy) 0%, #0a3358 100%); min-height: 320px;">

    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 50%, var(--teal) 0%, transparent 50%);"></div>

    <div class="absolute top-12 right-12 opacity-5 hidden lg:block">
        <svg class="w-32 h-32" fill="white" viewBox="0 0 24 24">
            <path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.38 0 2.74-.35 4-.99 2.52 1.29 5.48 1.29 8 0 1.26.64 2.62.99 4 .99h2v-2h-2zM3.95 19H4c1.6 0 3.02-.88 4-2 .98 1.12 2.4 2 4 2s3.02-.88 4-2c.98 1.12 2.4 2 4 2h.05l1.89-6.68c.08-.26.06-.54-.06-.78s-.34-.42-.6-.5L20 10.62V6c0-1.1-.9-2-2-2h-3V1H9v3H6c-1.1 0-2 .9-2 2v4.62l-1.29.42c-.26.08-.48.26-.6.5s-.15.52-.06.78L3.95 19zM6 6h12v3.97L12 8 6 9.97V6z"/>
        </svg>
    </div>

    <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="line-height: 0;">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display: block; width: 100%; height: 80px;">
            <path d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,20 1440,40 L1440,80 L0,80 Z" fill="#fafaf8" opacity="0.5"/>
            <path d="M0,50 C480,90 960,10 1440,50 L1440,80 L0,80 Z" fill="#fafaf8"/>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-28">

        <nav class="flex items-center gap-2 text-xs mb-10" style="color: rgba(255,255,255,0.5);">
            <a href="{{ route('web.home') }}" class="hover:text-white transition flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-2 0h2"/>
                </svg>
                Início
            </a>
            <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span style="color: rgba(255,255,255,0.8);">Empresas</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">

            <div class="max-w-2xl">
                <h1 class="text-4xl lg:text-5xl font-800 text-white mb-4 leading-tight" style="font-family: 'Syne', sans-serif;">
                    Empresas de <br>
                    <span style="color: var(--teal);">Passeios Náuticos</span>
                </h1>
                <p class="text-base leading-relaxed" style="color: rgba(255,255,255,0.65); max-width: 480px;">
                    Encontre as melhores operadoras de passeios náuticos. Compare, escolha e reserve com segurança.
                </p>
            </div>

            <div class="flex items-center gap-6 shrink-0">
                <div class="text-center">
                    <p class="text-3xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                        {{ $companies->total() }}
                    </p>
                    <p class="text-xs mt-1" style="color: rgba(255,255,255,0.5);">Empresas</p>
                </div>
                <div class="w-px h-10 opacity-20" style="background: white;"></div>
                <div class="text-center">
                    <p class="text-3xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                        {{ $companies->sum('active_tours_count') }}
                    </p>
                    <p class="text-xs mt-1" style="color: rgba(255,255,255,0.5);">Passeios ativos</p>
                </div>
                <div class="w-px h-10 opacity-20" style="background: white;"></div>
                <div class="text-center">
                    <p class="text-3xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                        {{ $companies->sum('bookings_count') }}
                    </p>
                    <p class="text-xs mt-1" style="color: rgba(255,255,255,0.5);">Reservas</p>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- LISTAGEM --}}
<section class="py-12" style="background-color: #fafaf8;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($companies->isEmpty())
            <div class="py-24 text-center rounded-2xl" style="border: 2px dashed #e8e4d8;">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: rgba(135,194,192,0.1);">
                    <svg class="w-10 h-10" style="color: #c5bfb2;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M3 17l4-8 4 4 4-6 4 10"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2" style="color: var(--navy);">Nenhuma empresa encontrada</h3>
                <p class="text-sm" style="color: #87c2c0;">Tente ajustar seus filtros ou volte mais tarde.</p>
            </div>
        @else
            <div id="companies-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @include('web.'.$config->template.'.companies.partials.company-card', ['companies' => $companies])
            </div>

            @if($companies->hasMorePages())
                <div class="mt-12 text-center">
                    <button
                        id="load-more-btn"
                        type="button"
                        class="inline-flex items-center gap-2 px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
                        style="background: var(--navy); color: white;"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Carregar mais empresas
                    </button>
                </div>
            @endif
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentPage = 2;
        let loading = false;
        const btn = document.getElementById('load-more-btn');
        const grid = document.getElementById('companies-grid');

        if (!btn || !grid) return;

        btn.addEventListener('click', function () {
            if (loading) return;
            loading = true;

            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-dasharray="30" stroke-dashoffset="10"/>
                </svg>
                Carregando...
            `;
            btn.disabled = true;

            fetch('{{ route("web.site.companies.load-more") }}?page=' + currentPage, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                grid.insertAdjacentHTML('beforeend', data.html);

                currentPage++;

                if (!data.has_more) {
                    btn.remove();
                } else {
                    btn.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Carregar mais empresas
                    `;
                    btn.disabled = false;
                }

                loading = false;
            })
            .catch(() => {
                btn.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Carregar mais empresas
                `;
                btn.disabled = false;
                loading = false;
            });
        });
    });
</script>
@endpush
