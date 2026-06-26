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
                {{ $tours->total() }} passeio{{ $tours->total() !== 1 ? 's' : '' }} disponível{{ $tours->total() !== 1 ? 'is' : '' }}
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($tours as $tour)
                        <a href="{{ route('web.site.tour', [$tour->company->slug, $tour->uuid]) }}"
                            class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 border border-blue-50"
                        >
                            {{-- Imagem --}}
                            <div class="relative h-48 overflow-hidden">
                                <img
                                    src="{{ $tour->cover() }}"
                                    alt="{{ $tour->title }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    loading="lazy"
                                >

                                {{-- Overlay gradiente no hover --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                {{-- Tipo --}}
                                @if($tour->tour_type)
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
                                            {{ $tour->tour_type->label() }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Preço --}}
                                <div class="absolute bottom-3 left-3">
                                    <span class="text-sm  px-3 py-1.5 rounded-xl bg-gradient-to-r from-amber-400 to-yellow-500 text-gray-900 shadow-lg">
                                        R$ {{ number_format($tour->price, 2, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Views --}}
                                <div class="absolute top-3 right-3">
                                    <span class="text-xs px-2.5 py-1.5 rounded-lg flex items-center gap-1 bg-black/50 backdrop-blur text-white font-medium">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        {{ number_format($tour->views) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="p-5">
                                <p class="text-xs font-bold mb-2 flex items-center gap-1 text-blue-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    {{ $tour->company->city }}, {{ $tour->company->state }}
                                </p>
                                
                                <h3 class="text-lg  leading-tight mb-4 text-gray-800 group-hover:text-blue-600 transition-colors duration-300">
                                    {{ $tour->title }}
                                </h3>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-2">
                                        @if($tour->company->logo)
                                            <img src="{{ $tour->company->getLogoUrl() }}" 
                                                class="w-7 h-7 rounded-lg object-cover ring-2 ring-blue-100" 
                                                alt="{{ $tour->company->alias_name }}">
                                        @endif
                                        <span class="text-xs font-semibold text-gray-500 truncate max-w-[120px]">
                                            {{ $tour->company->alias_name }}
                                        </span>
                                    </div>
                                    
                                    @if($tour->duration)
                                        <span class="text-xs font-bold flex items-center gap-1 text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                                            </svg>
                                            {{ $tour->duration }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- PAGINAÇÃO MODERNIZADA --}}
                <div class="mt-12">
                    {{ $tours->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection