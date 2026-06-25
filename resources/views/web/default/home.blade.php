@extends("web.$config->template.master.master")

@section('content')
 
    {{-- HERO --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, var(--navy) 0%, #0a3358 60%, #0e4a7a 100%); min-height: 580px;">
 
        {{-- Padrão decorativo --}}
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, var(--teal) 0%, transparent 50%), radial-gradient(circle at 80% 20%, var(--gold) 0%, transparent 40%);"></div>
 
        {{-- Ondas --}}
        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="line-height: 0;">
            <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display: block; width: 100%; height: 80px;">
                <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#fafaf8"/>
            </svg>
        </div>
 
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-28">
            <div class="max-w-3xl">
 
                <span class="badge badge-teal mb-6 inline-flex">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Marketplace náutico
                </span>
 
                <h1 class="font-display text-5xl md:text-6xl font-800 text-white mb-6 leading-tight" style="font-family: 'Syne', sans-serif; font-weight: 800;">
                    Descubra passeios<br>
                    <span style="color: var(--gold);">inesquecíveis</span> no mar
                </h1>
 
                <p class="text-lg mb-10 leading-relaxed" style="color: rgba(255,255,255,0.75); max-width: 520px;">
                    Encontre as melhores operações náuticas, compare passeios e reserve com segurança em poucos cliques.
                </p>
 
                {{-- BUSCA --}}
                <div class="bg-white rounded-2xl p-2 flex flex-col sm:flex-row gap-2 max-w-2xl" style="box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
 
                    {{-- Cidade --}}
                    <div class="flex-1 flex items-center gap-3 px-4 py-2">
                        <svg class="w-5 h-5 shrink-0" style="color: var(--teal);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <select
                            id="cidade-filter"
                            class="w-full outline-none text-sm bg-transparent"
                            style="color: var(--navy);"
                            onchange="filterCity(this.value)"
                        >
                            <option value="">Todas as cidades</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
 
                    <div class="hidden sm:block w-px my-2" style="background: #e8e4d8;"></div>
 
                    {{-- Busca --}}
                    <div class="flex-1 flex items-center gap-3 px-4 py-2">
                        <svg class="w-5 h-5 shrink-0" style="color: var(--teal);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input
                            type="text"
                            id="search-input"
                            placeholder="Buscar passeio..."
                            class="w-full outline-none text-sm bg-transparent"
                            style="color: var(--navy);"
                            oninput="filterSearch(this.value)"
                        >
                    </div>
 
                    <button class="btn-primary shrink-0 px-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        Buscar
                    </button>
 
                </div>
 
                {{-- Stats --}}
                <div class="flex items-center gap-8 mt-10">
                    <div>
                        <p class="text-2xl font-bold text-white" style="font-family: 'Syne', sans-serif;">{{ $tours->count() }}+</p>
                        <p class="text-xs" style="color: rgba(255,255,255,0.5);">Passeios</p>
                    </div>
                    <div class="w-px h-8" style="background: rgba(255,255,255,0.15);"></div>
                    <div>
                        <p class="text-2xl font-bold text-white" style="font-family: 'Syne', sans-serif;">{{ $companies->count() }}+</p>
                        <p class="text-xs" style="color: rgba(255,255,255,0.5);">Empresas</p>
                    </div>
                    <div class="w-px h-8" style="background: rgba(255,255,255,0.15);"></div>
                    <div>
                        <p class="text-2xl font-bold text-white" style="font-family: 'Syne', sans-serif;">{{ $cities->count() }}</p>
                        <p class="text-xs" style="color: rgba(255,255,255,0.5);">Cidades</p>
                    </div>
                </div>
 
            </div>
        </div>
    </section>
 
    {{-- FILTRO CIDADES --}}
    <section class="py-8" style="background: white; border-bottom: 1px solid #e8e4d8;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-hide">
                <button
                    onclick="filterCity('')"
                    class="city-btn active shrink-0 px-4 py-2 rounded-xl text-sm font-600 transition"
                    style="font-family: 'Syne', sans-serif; background: var(--navy); color: white;"
                >
                    Todas
                </button>
                @foreach($cities as $city)
                    <button
                        onclick="filterCity('{{ $city }}')"
                        class="city-btn shrink-0 px-4 py-2 rounded-xl text-sm font-600 transition"
                        style="font-family: 'Syne', sans-serif; background: var(--sand); color: var(--navy);"
                    >
                        {{ $city }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>
 
    {{-- PASSEIOS EM DESTAQUE --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
 
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="badge badge-teal mb-3 inline-flex">🔥 Mais populares</span>
                    <h2 class="section-title">Passeios em destaque</h2>
                </div>
            </div>
 
            <div id="tours-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($tours as $tour)
                    <a
                        href="{{ route('web.site.tour', [$tour->company->slug, $tour->uuid]) }}"
                        class="card-tour block"
                        data-city="{{ $tour->company->city }}"
                        data-title="{{ strtolower($tour->title) }}"
                    >
                        {{-- Imagem --}}
                        <div class="relative h-48 overflow-hidden">
                            <img
                                src="{{ $tour->cover() }}"
                                alt="{{ $tour->title }}"
                                class="w-full h-full object-cover transition duration-500 hover:scale-105"
                                loading="lazy"
                            >
                            {{-- Preço badge --}}
                            <div class="absolute bottom-3 left-3">
                                <span class="text-xs font-bold px-3 py-1.5 rounded-xl" style="background: var(--gold); color: var(--navy); font-family: 'Syne', sans-serif;">
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
                            <p class="text-xs font-500 mb-1 flex items-center gap-1" style="color: var(--teal);">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $tour->company->city }}, {{ $tour->company->state }}
                            </p>
                            <h3 class="font-display font-700 text-base leading-tight mb-2" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                                {{ $tour->title }}
                            </h3>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    @if($tour->company->logo)
                                        <img src="{{ $tour->company->getLogoUrl() }}" class="w-6 h-6 rounded-full object-cover" alt="{{ $tour->company->alias_name }}">
                                    @endif
                                    <span class="text-xs" style="color: #87c2c0;">{{ $tour->company->alias_name }}</span>
                                </div>
                                @if($tour->duration)
                                    <span class="text-xs flex items-center gap-1" style="color: #87c2c0;">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                        {{ $tour->duration }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-4 py-20 text-center">
                        <p style="color: #87c2c0;">Nenhum passeio disponível no momento.</p>
                    </div>
                @endforelse
            </div>
 
        </div>
    </section>
 
    {{-- EMPRESAS EM DESTAQUE --}}
    @if($companies->count() > 0)
    <section id="empresas" class="py-16" style="background: var(--sand);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
 
            <div class="mb-10">
                <span class="badge badge-gold mb-3 inline-flex">⭐ Destaque</span>
                <h2 class="section-title">Empresas parceiras</h2>
            </div>
 
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($companies as $company)
                    <a
                        href="{{ route('web.site.company', $company->slug) }}"
                        class="bg-white rounded-2xl overflow-hidden flex items-center gap-4 p-5 transition"
                        style="border: 1px solid #e8e4d8;"
                        onmouseover="this.style.boxShadow='0 8px 30px rgba(5,30,52,0.1)'; this.style.borderColor='var(--teal)'"
                        onmouseout="this.style.boxShadow='none'; this.style.borderColor='#e8e4d8'"
                    >
                        {{-- Logo --}}
                        <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 flex items-center justify-center" style="background: var(--sand);">
                            <img
                                src="{{ $company->getLogoUrl() }}"
                                alt="{{ $company->alias_name }}"
                                class="w-full h-full object-cover"
                            >
                        </div>
 
                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="font-display font-700 text-base truncate" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                                {{ $company->alias_name }}
                            </h3>
                            <p class="text-xs flex items-center gap-1 mt-0.5" style="color: var(--teal);">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $company->city }}, {{ $company->state }}
                            </p>
                            @if($company->content)
                                <p class="text-xs mt-1 line-clamp-2" style="color: #87c2c0;">{{ Str::limit($company->content, 80) }}</p>
                            @endif
                        </div>
 
                        <svg class="w-5 h-5 shrink-0" style="color: var(--teal);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                @endforeach
            </div>
 
        </div>
    </section>
    @endif
 
    {{-- CTA EMPRESA --}}
    <section class="py-20" style="background: var(--navy);">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="badge badge-gold mb-6 inline-flex">Para empresas</span>
            <h2 class="font-display text-4xl font-800 text-white mb-6" style="font-family: 'Syne', sans-serif;">
                Sua operação náutica<br>no maior marketplace do Brasil
            </h2>
            <p class="text-lg mb-10" style="color: rgba(255,255,255,0.65);">
                Cadastre sua empresa, publique seus passeios e comece a receber reservas online hoje mesmo.
            </p>
            <a href="{{--  --}}" class="btn-gold text-base px-8 py-3.5">
                Cadastrar minha empresa gratuitamente
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </section>
 
@endsection
 
@push('scripts')
<script>
    let activeCity = '';
    let activeSearch = '';
 
    function filterCity(city) {
        activeCity = city;
 
        // atualiza botões
        document.querySelectorAll('.city-btn').forEach(btn => {
            const isActive = btn.textContent.trim() === (city || 'Todas');
            btn.style.background = isActive ? 'var(--navy)' : 'var(--sand)';
            btn.style.color = isActive ? 'white' : 'var(--navy)';
        });
 
        // atualiza select do hero
        document.getElementById('cidade-filter').value = city;
 
        applyFilters();
    }
 
    function filterSearch(value) {
        activeSearch = value.toLowerCase();
        applyFilters();
    }
 
    function applyFilters() {
        const cards = document.querySelectorAll('#tours-grid [data-city]');
        cards.forEach(card => {
            const cityMatch = !activeCity || card.dataset.city === activeCity;
            const searchMatch = !activeSearch || card.dataset.title.includes(activeSearch);
            card.style.display = (cityMatch && searchMatch) ? 'block' : 'none';
        });
    }
</script>
@endpush