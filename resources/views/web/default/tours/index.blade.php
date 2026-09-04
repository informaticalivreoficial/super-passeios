@extends("web.$config->template.master.master")

@section('content')

    {{-- HERO MODERNIZADO --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 40%, #3b82f6 100%); padding: 80px 0 100px;">

        {{-- Partículas decorativas --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-200 rounded-full blur-3xl"></div>
        </div>

        {{-- Onda decorativa inferior --}}
        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="line-height: 0;">
            <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display: block; width: 100%; height: 80px;">
                <path d="M0,40 C320,80 640,0 960,40 C1280,80 1440,20 1440,20 L1440,80 L0,80 Z" fill="#EEF4FB"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur border border-white/30 text-white text-sm font-semibold mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 17l4-8 4 4 4-6 4 10"/>
                </svg>
                🌊 Todos os passeios
            </div>
            
            <h1 class="text-4xl lg:text-5xl  text-white mb-4 tracking-tight">
                Encontre seu <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-300">passeio ideal</span>
            </h1>
            
            <p class="text-lg text-blue-100 mb-2">
                {{ $tours->total() }} passeio{{ $tours->total() !== 1 ? 's' : '' }} disponíve{{ $tours->total() !== 1 ? 'is' : 'l' }}
            </p>
        </div>
    </section>

    {{-- FILTROS MODERNIZADOS --}}
    <section class="sticky top-16 z-40 bg-white/95 backdrop-blur shadow-lg border-b border-blue-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap items-center gap-3 py-4">

                {{-- Cidade --}}
                <div class="relative group">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    <select
                        name="cidade"
                        class="border-2 border-gray-200 rounded-xl text-sm pl-9 pr-8 py-2.5 outline-none transition-all duration-300 appearance-none bg-white text-gray-700 font-medium min-w-[180px] hover:border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >
                        <option value="">Todas as cidades</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('cidade') === $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipo --}}
                <div class="relative group">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 17l4-8 4 4 4-6 4 10"/>
                    </svg>
                    <select
                        name="tipo"
                        class="border-2 border-gray-200 rounded-xl text-sm pl-9 pr-8 py-2.5 outline-none transition-all duration-300 appearance-none bg-white text-gray-700 font-medium min-w-[180px] hover:border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >
                        <option value="">Todos os tipos</option>
                        @foreach(\App\Enums\TourTypeEnum::cases() as $type)
                            <option value="{{ $type->value }}" {{ request('tipo') === $type->value ? 'selected' : '' }}>
                                {{ $type->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Preço mín --}}
                <div class="relative group">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-blue-500">R$</span>
                    <input
                        type="number"
                        name="preco_min"
                        value="{{ request('preco_min') }}"
                        placeholder="Mín"
                        class="border-2 border-gray-200 rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition-all duration-300 bg-white text-gray-700 font-medium w-28 hover:border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >
                </div>

                {{-- Preço máx --}}
                <div class="relative group">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-blue-500">R$</span>
                    <input
                        type="number"
                        name="preco_max"
                        value="{{ request('preco_max') }}"
                        placeholder="Máx"
                        class="border-2 border-gray-200 rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition-all duration-300 bg-white text-gray-700 font-medium w-28 hover:border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                    >
                </div>

                {{-- Botão Filtrar --}}
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    Filtrar
                </button>

                {{-- Botão Limpar --}}
                @if(request()->hasAny(['cidade', 'tipo', 'preco_min', 'preco_max']))
                    <a
                        href="{{ request()->url() }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 bg-gradient-to-r from-gray-100 to-gray-50 text-gray-700 border-2 border-gray-200 hover:border-red-300 hover:text-red-600 hover:bg-red-50"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                        Limpar
                    </a>
                @endif

            </form>
        </div>
    </section>

    {{-- GRID DE PASSEIOS --}}
    <section class="py-12" style="background: linear-gradient(180deg, #EEF4FB 0%, #F8FAFC 100%);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($tours->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 rounded-3xl bg-white shadow-xl border-2 border-dashed border-blue-200">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center mb-6 bg-gradient-to-br from-blue-100 to-indigo-100">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 17l4-8 4 4 4-6 4 10"/>
                        </svg>
                    </div>
                    <p class=" text-2xl mb-2 text-gray-800">Nenhum passeio encontrado</p>
                    <p class="text-gray-500 mb-6">Tente ajustar os filtros para ver mais resultados.</p>
                    <a href="{{ request()->url() }}" 
                        class="px-6 py-3 rounded-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        Limpar filtros
                    </a>
                </div>
            @else
                <div id="tours-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @include('web.'.$config->template.'.tours.partials.tour-card', ['tours' => $tours])
                </div>

                @if($tours->hasMorePages())
                    <div class="mt-12 text-center">
                        <button
                            id="load-more-btn"
                            type="button"
                            class="inline-flex items-center gap-2 px-8 py-3 rounded-xl text-sm font-bold transition-all duration-300 transform hover:scale-105 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg hover:shadow-xl"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Carregar mais passeios
                        </button>
                    </div>
                @endif
            @endif

        </div>
    </section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentPage = 2;
        let loading = false;
        const btn = document.getElementById('load-more-btn');
        const grid = document.getElementById('tours-grid');

        if (!btn || !grid) return;

        const params = new URLSearchParams(window.location.search);

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

            params.set('page', currentPage);

            fetch('{{ route("web.site.tours.load-more") }}?' + params.toString(), {
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
                        Carregar mais passeios
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
                    Carregar mais passeios
                `;
                btn.disabled = false;
                loading = false;
            });
        });
    });
</script>
@endpush

@endsection