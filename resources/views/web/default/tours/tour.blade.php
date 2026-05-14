@extends("web.$config->template.master.master")

@section('title', $tour->title . ' — ' . $company->alias_name)
@section('description', Str::limit($tour->description, 160))

@section('content')

    {{-- GALERIA HERO --}}
    <section class="relative bg-black" style="max-height: 520px; overflow: hidden;">

        @php $images = $tour->images; @endphp

        @if($images->count() > 0)
            <div class="grid h-[520px]" style="{{ $images->count() >= 3 ? 'grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr;' : '' }}">

                {{-- Imagem principal --}}
                <div class="{{ $images->count() >= 3 ? 'row-span-2' : '' }} overflow-hidden">
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::url($images->first()->path) }}"
                        alt="{{ $tour->title }}"
                        class="w-full h-full object-cover"
                    >
                </div>

                @if($images->count() >= 3)
                    <div class="overflow-hidden">
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($images->skip(1)->first()->path) }}"
                            alt="{{ $tour->title }}"
                            class="w-full h-full object-cover"
                        >
                    </div>
                    <div class="overflow-hidden relative">
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($images->skip(2)->first()->path) }}"
                            alt="{{ $tour->title }}"
                            class="w-full h-full object-cover"
                        >
                        @if($images->count() > 3)
                            <div class="absolute inset-0 flex items-center justify-center" style="background: rgba(5,30,52,0.6);">
                                <span class="text-white font-display font-700 text-lg" style="font-family: 'Syne', sans-serif;">
                                    +{{ $images->count() - 3 }} fotos
                                </span>
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        @else
            <div class="h-72 flex items-center justify-center" style="background: var(--sand);">
                <svg class="w-16 h-16" style="color: #d4cfc3;" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
        @endif

    </section>

    {{-- CONTEÚDO PRINCIPAL --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs mb-8" style="color: #87c2c0;">
            <a href="{{ route('site.home') }}" class="hover:text-teal-500 transition">Início</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <a href="{{ route('site.company', $company->slug) }}" class="hover:text-teal-500 transition">{{ $company->alias_name }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span style="color: var(--navy);">{{ $tour->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- COLUNA ESQUERDA --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Título e badges --}}
                <div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($tour->tour_type)
                            <span class="badge badge-teal">{{ $tour->tour_type->label() }}</span>
                        @endif
                        <span class="badge" style="background: rgba(250,221,55,0.15); border: 1px solid rgba(250,221,55,0.4); color: #c4a800;">
                            🔥 {{ number_format($tour->views) }} visualizações
                        </span>
                    </div>

                    <h1 class="font-display text-4xl font-800 mb-4" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                        {{ $tour->title }}
                    </h1>

                    {{-- Info rápida --}}
                    <div class="flex flex-wrap gap-5 text-sm" style="color: #87c2c0;">
                        @if($tour->duration)
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" style="color: var(--teal);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                {{ $tour->duration }}
                            </span>
                        @endif
                        @if($tour->boarding_place)
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" style="color: var(--teal);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $tour->boarding_place }}
                            </span>
                        @endif
                        @if($tour->vessel)
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" style="color: var(--teal);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                Até {{ $tour->vessel->capacity }} pessoas
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Empresa --}}
                <a
                    href="{{ route('site.company', $company->slug) }}"
                    class="flex items-center gap-4 p-4 rounded-2xl transition"
                    style="border: 1px solid #e8e4d8; background: white;"
                    onmouseover="this.style.borderColor='var(--teal)'"
                    onmouseout="this.style.borderColor='#e8e4d8'"
                >
                    <div class="w-14 h-14 rounded-xl overflow-hidden shrink-0" style="background: var(--sand);">
                        <img src="{{ $company->getlogo() }}" alt="{{ $company->alias_name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-xs mb-0.5" style="color: #87c2c0;">Operado por</p>
                        <p class="font-display font-700 text-base" style="font-family: 'Syne', sans-serif; color: var(--navy);">{{ $company->alias_name }}</p>
                        <p class="text-xs flex items-center gap-1 mt-0.5" style="color: var(--teal);">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $company->city }}, {{ $company->state }}
                        </p>
                    </div>
                    <svg class="w-5 h-5 ml-auto" style="color: var(--teal);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                </a>

                {{-- Descrição --}}
                @if($tour->description)
                    <div class="bg-white rounded-2xl p-6" style="border: 1px solid #e8e4d8;">
                        <h2 class="font-display font-700 text-lg mb-4" style="font-family: 'Syne', sans-serif; color: var(--navy);">Sobre o passeio</h2>
                        <div class="text-sm leading-relaxed prose max-w-none" style="color: #87c2c0;">
                            {!! nl2br(e($tour->description)) !!}
                        </div>
                    </div>
                @endif

                {{-- Embarcação --}}
                @if($tour->vessel)
                    <div class="bg-white rounded-2xl p-6" style="border: 1px solid #e8e4d8;">
                        <h2 class="font-display font-700 text-lg mb-5" style="font-family: 'Syne', sans-serif; color: var(--navy);">Embarcação</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="text-center p-3 rounded-xl" style="background: var(--sand);">
                                <p class="text-xl font-bold mb-1" style="color: var(--navy); font-family: 'Syne', sans-serif;">{{ $tour->vessel->capacity }}</p>
                                <p class="text-xs" style="color: #87c2c0;">Pessoas</p>
                            </div>
                            @if($tour->vessel->size)
                                <div class="text-center p-3 rounded-xl" style="background: var(--sand);">
                                    <p class="text-xl font-bold mb-1" style="color: var(--navy); font-family: 'Syne', sans-serif;">{{ $tour->vessel->size }}m</p>
                                    <p class="text-xs" style="color: #87c2c0;">Tamanho</p>
                                </div>
                            @endif
                            @if($tour->vessel->year)
                                <div class="text-center p-3 rounded-xl" style="background: var(--sand);">
                                    <p class="text-xl font-bold mb-1" style="color: var(--navy); font-family: 'Syne', sans-serif;">{{ $tour->vessel->year }}</p>
                                    <p class="text-xs" style="color: #87c2c0;">Ano</p>
                                </div>
                            @endif
                            @if($tour->vessel->bathroom)
                                <div class="text-center p-3 rounded-xl" style="background: var(--sand);">
                                    <p class="text-xl font-bold mb-1" style="color: var(--navy); font-family: 'Syne', sans-serif;">{{ $tour->vessel->bathroom }}</p>
                                    <p class="text-xs" style="color: #87c2c0;">Banheiro(s)</p>
                                </div>
                            @endif
                        </div>

                        {{-- Amenidades --}}
                        <div class="flex flex-wrap gap-2 mt-4">
                            @if($tour->vessel->barbecue)
                                <span class="badge badge-teal">🍖 Churrasqueira</span>
                            @endif
                            @if($tour->vessel->suite)
                                <span class="badge badge-teal">🛏 Suíte</span>
                            @endif
                            @if($tour->vessel->sound_system)
                                <span class="badge badge-teal">🎵 Som</span>
                            @endif
                            @if($tour->vessel->kitchen)
                                <span class="badge badge-teal">🍳 Cozinha</span>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Regras --}}
                @if($tour->rules)
                    <div class="bg-white rounded-2xl p-6" style="border: 1px solid #e8e4d8;">
                        <h2 class="font-display font-700 text-lg mb-4" style="font-family: 'Syne', sans-serif; color: var(--navy);">Regras e informações</h2>
                        <div class="text-sm leading-relaxed" style="color: #87c2c0;">
                            {!! nl2br(e($tour->rules)) !!}
                        </div>
                    </div>
                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-5">

                {{-- Card de reserva --}}
                <div class="sticky top-24 bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8; box-shadow: 0 8px 40px rgba(5,30,52,0.08);">

                    <div class="p-6" style="border-bottom: 1px solid #f0ece4;">
                        <p class="text-xs mb-1" style="color: #87c2c0;">A partir de</p>
                        <p class="font-display font-800 text-3xl" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                            R$ {{ number_format($tour->price, 2, ',', '.') }}
                        </p>
                        <p class="text-xs mt-1" style="color: #87c2c0;">por pessoa</p>
                    </div>

                    <div class="p-6">
                        <h3 class="font-display font-700 text-sm mb-4" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                            Datas disponíveis
                        </h3>

                        @forelse($dates as $date)
                            <a
                                href="#"
                                class="flex items-center justify-between p-3 rounded-xl mb-2 transition"
                                style="border: 1px solid #e8e4d8;"
                                onmouseover="this.style.borderColor='var(--teal)'; this.style.background='rgba(22,163,183,0.04)'"
                                onmouseout="this.style.borderColor='#e8e4d8'; this.style.background='transparent'"
                            >
                                <div>
                                    <p class="text-sm font-600" style="color: var(--navy); font-family: 'Syne', sans-serif;">
                                        {{ $date->date->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs mt-0.5" style="color: #87c2c0;">
                                        {{ $date->start_time }}
                                        @if($date->end_time) — {{ $date->end_time }} @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold" style="color: var(--navy);">
                                        R$ {{ number_format($date->price, 2, ',', '.') }}
                                    </p>
                                    <p class="text-xs" style="color: #87c2c0;">
                                        {{ $date->attributes['available_slots'] }} vagas
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="py-6 text-center">
                                <p class="text-sm" style="color: #87c2c0;">Nenhuma data disponível.</p>
                            </div>
                        @endforelse

                        @if($dates->count() > 0)
                            <button class="btn-primary w-full justify-center mt-4 py-3">
                                Reservar agora
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </button>
                        @endif

                    </div>

                </div>

                {{-- WhatsApp --}}
                @if($company->whatsapp)
                    <a
                        href="https://wa.me/55{{ preg_replace('/\D/', '', $company->whatsapp) }}?text=Olá! Tenho interesse no passeio {{ urlencode($tour->title) }}"
                        target="_blank"
                        class="flex items-center justify-center gap-3 w-full py-3.5 rounded-2xl font-600 text-sm transition"
                        style="background: #23c55e; color: white; box-shadow: 0 2px 0 #15803d;"
                        onmouseover="this.style.background='#1aad52'"
                        onmouseout="this.style.background='#23c55e'"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Perguntar no WhatsApp
                    </a>
                @endif

            </div>
        </div>
    </div>

@endsection