@extends("web.$config->template.master.master")


@section('content')

    {{-- HERO --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, #051e34 0%, #0a3358 60%, #0e4a7a 100%); padding: 60px 0 80px;">

        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, #16a3b7 0%, transparent 50%), radial-gradient(circle at 80% 20%, #fadd37 0%, transparent 40%);"></div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="line-height: 0;">
            <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display: block; width: 100%; height: 60px;">
                <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#fafaf8"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="badge badge-teal mb-4 inline-flex">🌊 Todos os passeios</span>
            <h1 class="font-display text-4xl font-800 text-white mb-3" style="font-family: 'Syne', sans-serif;">
                Encontre seu passeio ideal
            </h1>
            <p class="text-base" style="color: rgba(255,255,255,0.65);">
                {{ $tours->total() }} passeio{{ $tours->total() !== 1 ? 's' : '' }} disponível{{ $tours->total() !== 1 ? 'is' : '' }}
            </p>
        </div>

    </section>

    {{-- FILTROS --}}
    <section class="sticky top-16 z-40 bg-white" style="border-bottom: 1px solid #e8e4d8; box-shadow: 0 2px 8px rgba(5,30,52,0.06);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ request()->url() }}" class="flex flex-wrap items-center gap-3 py-4">

                {{-- Cidade --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <select
                        name="cidade"
                        class="border rounded-xl text-sm pl-9 pr-8 py-2.5 outline-none transition appearance-none bg-white"
                        style="border-color: #e8e4d8; color: #051e34; min-width: 160px;"
                        onfocus="this.style.borderColor='#16a3b7'"
                        onblur="this.style.borderColor='#e8e4d8'"
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
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg>
                    <select
                        name="tipo"
                        class="border rounded-xl text-sm pl-9 pr-8 py-2.5 outline-none transition appearance-none bg-white"
                        style="border-color: #e8e4d8; color: #051e34; min-width: 160px;"
                        onfocus="this.style.borderColor='#16a3b7'"
                        onblur="this.style.borderColor='#e8e4d8'"
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
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none" style="color: #b0a98a;">R$</span>
                    <input
                        type="number"
                        name="preco_min"
                        value="{{ request('preco_min') }}"
                        placeholder="Mín"
                        class="border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34; width: 100px;"
                        onfocus="this.style.borderColor='#16a3b7'"
                        onblur="this.style.borderColor='#e8e4d8'"
                    >
                </div>

                {{-- Preço máx --}}
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none" style="color: #b0a98a;">R$</span>
                    <input
                        type="number"
                        name="preco_max"
                        value="{{ request('preco_max') }}"
                        placeholder="Máx"
                        class="border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                        style="border-color: #e8e4d8; color: #051e34; width: 100px;"
                        onfocus="this.style.borderColor='#16a3b7'"
                        onblur="this.style.borderColor='#e8e4d8'"
                    >
                </div>

                {{-- Botões --}}
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition"
                    style="background: #16a3b7; color: white; box-shadow: 0 2px 0 #0e7a8a;"
                    onmouseover="this.style.background='#13919e'"
                    onmouseout="this.style.background='#16a3b7'"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    Filtrar
                </button>

                @if(request()->hasAny(['cidade', 'tipo', 'preco_min', 'preco_max']))
                    
                        href="{{ request()->url() }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition"
                        style="background: #f5f3ee; color: #051e34; border: 1px solid #e8e4d8;"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                        Limpar
                    </a>
                @endif

            </form>
        </div>
    </section>

    {{-- GRID --}}
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($tours->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 rounded-2xl" style="border: 2px dashed #e8e4d8;">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4" style="background: rgba(22,163,183,0.08);">
                        <svg class="w-8 h-8" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg>
                    </div>
                    <p class="font-bold text-base mb-1" style="color: #051e34;">Nenhum passeio encontrado</p>
                    <p class="text-sm mb-5" style="color: #87c2c0;">Tente ajustar os filtros para ver mais resultados.</p>
                    <a href="{{ request()->url() }}" class="btn-primary text-sm">Limpar filtros</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($tours as $tour)
                        
                        <a href="{{ route('web.site.tour', [$tour->company->slug, $tour->uuid]) }}"
                            class="card-tour block"
                        >
                            {{-- Imagem --}}
                            <div class="relative h-48 overflow-hidden">
                                <img
                                    src="{{ $tour->cover() }}"
                                    alt="{{ $tour->title }}"
                                    class="w-full h-full object-cover transition duration-500 hover:scale-105"
                                    loading="lazy"
                                >

                                {{-- Tipo --}}
                                @if($tour->tour_type)
                                    <div class="absolute top-3 left-3">
                                        <span class="badge badge-teal">{{ $tour->tour_type->label() }}</span>
                                    </div>
                                @endif

                                {{-- Preço --}}
                                <div class="absolute bottom-3 left-3">
                                    <span class="text-xs font-bold px-3 py-1.5 rounded-xl" style="background: #fadd37; color: #051e34; font-family: 'Syne', sans-serif;">
                                        R$ {{ number_format($tour->price, 2, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Views --}}
                                <div class="absolute top-3 right-3">
                                    <span class="text-xs px-2 py-1 rounded-lg flex items-center gap-1" style="background: rgba(5,30,52,0.7); color: white; backdrop-filter: blur(4px);">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        {{ number_format($tour->views) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="p-4">
                                <p class="text-xs font-500 mb-1 flex items-center gap-1" style="color: #16a3b7;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $tour->company->city }}, {{ $tour->company->state }}
                                </p>
                                <h3 class="font-display font-700 text-base leading-tight mb-3" style="font-family: 'Syne', sans-serif; color: #051e34;">
                                    {{ $tour->title }}
                                </h3>
                                <div class="flex items-center justify-between pt-3" style="border-top: 1px solid #f0ece4;">
                                    <div class="flex items-center gap-2">
                                        @if($tour->company->logo)
                                            <img src="{{ $tour->company->getlogo() }}" class="w-6 h-6 rounded-full object-cover" alt="{{ $tour->company->alias_name }}">
                                        @endif
                                        <span class="text-xs truncate" style="color: #87c2c0; max-width: 120px;">{{ $tour->company->alias_name }}</span>
                                    </div>
                                    @if($tour->duration)
                                        <span class="text-xs flex items-center gap-1 shrink-0" style="color: #87c2c0;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                            {{ $tour->duration }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- PAGINAÇÃO --}}
                <div class="mt-12">
                    {{ $tours->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection