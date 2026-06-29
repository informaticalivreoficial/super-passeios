@extends("web.$config->template.master.master")

@section('content')

{{-- 1. HERO SECTION --}}
<section class="relative h-[600px] flex items-center justify-center overflow-hidden">
    {{-- Imagem de Fundo com Overlay --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('theme/images/hero-nautical.jpg') }}" class="w-full h-full object-cover scale-105 animate-slow-zoom" alt="Passeios Náuticos">
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-slate-900/80"></div>
    </div>

    <div class="relative z-10 max-w-5xl w-full px-6 text-center">
        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tight drop-shadow-lg">
            Sua próxima aventura   
começa no <span class="text-blue-400">mar.</span>
        </h1>
        <p class="text-lg text-white/90 mb-10 font-medium max-w-2xl mx-auto drop-shadow-md">
            Reserve os melhores passeios de lancha, escuna e experiências náuticas em todo o Brasil.
        </p>

        {{-- Barra de Busca Flutuante --}}
        <div class="bg-white p-2 rounded-[2.5rem] shadow-2xl max-w-4xl mx-auto flex flex-col md:flex-row items-center gap-2 border border-white/20 backdrop-blur-sm">
            <div class="flex-1 flex items-center px-6 py-3 w-full">
                <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                <select class="w-full bg-transparent border-none focus:ring-0 text-slate-700 font-bold appearance-none cursor-pointer">
                    <option value="">Para onde você quer ir?</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="hidden md:block w-px h-10 bg-slate-100"></div>
            <div class="flex-1 flex items-center px-6 py-3 w-full">
                <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <input type="text" placeholder="Quando?" class="w-full bg-transparent border-none focus:ring-0 text-slate-700 font-bold placeholder:text-slate-400">
            </div>
            <button class="w-full md:w-auto px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-[2rem] transition-all shadow-lg shadow-blue-200 uppercase tracking-widest text-xs">
                Buscar
            </button>
        </div>
    </div>
</section>

{{-- 2. DESTINOS EM DESTAQUE --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Destinos Populares</h2>
                <p class="text-slate-500 mt-2 font-medium">As cidades mais procuradas para navegar.</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($cities->take(6) as $city)
                <a href="#" class="group relative h-40 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                    <img src="https://source.unsplash.com/400x400/?{{ $city }},ocean" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <span class="text-white font-black uppercase tracking-widest text-xs">{{ $city }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- 3. PASSEIOS MAIS PROCURADOS --}}
<section class="py-20 bg-slate-50/50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Experiências em Alta</h2>
                <p class="text-slate-500 mt-2 font-medium">Os passeios mais reservados da semana.</p>
            </div>
            <a href="{{ route('web.site.tours') }}" class="text-blue-600 font-bold text-sm hover:underline">Ver todos</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($tours as $tour )
                <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                    <div class="relative h-56">
                        <img src="{{ $tour->cover() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full shadow-sm">
                            <span class="text-[10px] font-black text-blue-600 uppercase">R$ {{ number_format($tour->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-2">{{ $tour->company->city }}</p>
                        <h3 class="text-lg font-black text-slate-800 mb-2 line-clamp-1">{{ $tour->title }}</h3>
                        <div class="flex items-center gap-2 text-slate-400 text-xs mb-4">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span>4.9 (120 avaliações)</span>
                        </div>
                        <a href="#" class="block text-center py-3 bg-slate-50 hover:bg-blue-600 hover:text-white text-slate-700 font-bold rounded-xl transition-all text-sm">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 4. AGÊNCIAS EM DESTAQUE --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 text-center mb-16">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Navegue com os Melhores</h2>
        <p class="text-slate-500 mt-2 font-medium">Agências verificadas e certificadas por nossa equipe.</p>
    </div>

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
        @foreach($companies as $company)
            <a href="#" class="group">
                <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-slate-50 group-hover:border-blue-100 transition-all shadow-sm">
                    <img src="{{ $company->getLogoUrl() }}" class="w-full h-full object-cover">
                </div>
                <h4 class="text-sm font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $company->name }}</h4>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $company->city }}</p>
            </a>
        @endforeach
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