@extends("web.$config->template.master.master")

@section('title', $tour->title . ' — ' . $company->alias_name)
@section('description', Str::limit($tour->description, 160))

@section('content')

    {{-- GALERIA --}}
    <x-gallery.hero :images="$tour->images" :title="$tour->title"/>
    <x-gallery.lightbox />

    {{-- CONTEÚDO PRINCIPAL --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" style="background: linear-gradient(180deg, #EEF4FB 0%, #F8FAFC 100%);">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm mb-8">
            <a href="{{ route('web.home') }}" class="text-blue-600 hover:text-blue-700 font-medium transition">Início</a>
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <a href="{{ route('web.site.company', $company->slug) }}" class="text-blue-600 hover:text-blue-700 font-medium transition">{{ $company->alias_name }}</a>
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span class="text-gray-800 font-semibold">{{ $tour->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- COLUNA ESQUERDA --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Título e badges --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 border border-blue-100">
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($tour->tour_type)
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
                                {{ $tour->tour_type->label() }}
                            </span>
                        @endif
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-amber-400 to-yellow-500 text-amber-900 shadow-md flex items-center gap-1">
                            🔥 {{ number_format($tour->views) }} visualizações
                        </span>
                    </div>

                    <h1 class="text-3xl lg:text-4xl  mb-4 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        {{ $tour->title }}
                    </h1>

                    {{-- Info rápida --}}
                    <div class="flex flex-wrap gap-5 text-sm text-gray-600">
                        @if($tour->duration)
                            <span class="flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                {{ $tour->duration }} hs
                            </span>
                        @endif
                        @if($tour->boarding_place)
                            <span class="flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $tour->boarding_place }}
                            </span>
                        @endif
                        @if($tour->vessel)
                            <span class="flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                Até {{ $tour->vessel->capacity }} pessoas
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Empresa --}}
                <a
                    href="{{ route('web.site.company', $company->slug) }}"
                    class="flex items-center gap-4 p-5 rounded-2xl bg-white shadow-lg border-2 border-blue-100 hover:border-blue-400 hover:shadow-xl transition-all duration-300 group cursor-pointer"
                >
                    <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 bg-gradient-to-br from-blue-100 to-indigo-100 p-0.5">
                        <img src="{{ $company->getLogoUrl() }}" alt="{{ $company->alias_name }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="flex-1">
                        <p class="text-xs mb-1 text-blue-500 font-medium">Operado por</p>
                        <p class="text-lg  text-gray-800">{{ $company->alias_name }}</p>
                        <p class="text-sm flex items-center gap-1 mt-1 text-gray-500">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $company->city }}, {{ $company->state }}
                        </p>
                    </div>
                    <svg class="w-6 h-6 text-blue-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                </a>

                {{-- Descrição --}}
                @if($tour->description)
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-blue-100">
                        <h2 class="text-xl  mb-4 flex items-center gap-2 text-gray-800">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Sobre o passeio
                        </h2>
                        <div class="text-gray-600 leading-relaxed prose max-w-none">
                            {!! nl2br(e($tour->description)) !!}
                        </div>
                    </div>
                @endif

                {{-- Embarcação --}}
                @if($tour->vessel)
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-blue-100">
                        <h2 class="text-xl  mb-5 flex items-center gap-2 text-gray-800">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
                            Embarcação
                        </h2>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="text-center p-4 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 hover:shadow-md transition-all duration-300">
                                <p class="text-2xl  mb-1 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $tour->vessel->capacity }}</p>
                                <p class="text-sm font-medium text-gray-600">Pessoas</p>
                            </div>
                            @if($tour->vessel->size)
                                <div class="text-center p-4 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 hover:shadow-md transition-all duration-300">
                                    <p class="text-2xl  mb-1 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $tour->vessel->size }}m</p>
                                    <p class="text-sm font-medium text-gray-600">Tamanho</p>
                                </div>
                            @endif
                            @if($tour->vessel->year)
                                <div class="text-center p-4 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 hover:shadow-md transition-all duration-300">
                                    <p class="text-2xl  mb-1 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $tour->vessel->year }}</p>
                                    <p class="text-sm font-medium text-gray-600">Ano</p>
                                </div>
                            @endif
                            @if($tour->vessel->bathroom)
                                <div class="text-center p-4 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 hover:shadow-md transition-all duration-300">
                                    <p class="text-2xl  mb-1 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">{{ $tour->vessel->bathroom }}</p>
                                    <p class="text-sm font-medium text-gray-600">Banheiro(s)</p>
                                </div>
                            @endif
                        </div>

                        {{-- Amenidades --}}
                        <div class="flex flex-wrap gap-2 mt-4">
                            @if($tour->vessel->barbecue)
                                <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-gradient-to-r from-orange-400 to-red-500 text-white shadow-md">🍖 Churrasqueira</span>
                            @endif
                            @if($tour->vessel->suite)
                                <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-gradient-to-r from-purple-400 to-pink-500 text-white shadow-md">🛏 Suíte</span>
                            @endif
                            @if($tour->vessel->sound_system)
                                <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-md">🎵 Som</span>
                            @endif
                            @if($tour->vessel->kitchen)
                                <span class="px-3 py-1.5 rounded-full text-sm font-semibold bg-gradient-to-r from-yellow-400 to-amber-500 text-white shadow-md">🍳 Cozinha</span>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Regras --}}
                @if($tour->rules)
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-blue-100">
                        <h2 class="text-xl  mb-4 flex items-center gap-2 text-gray-800">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Regras e informações
                        </h2>
                        <div class="text-gray-600 leading-relaxed">
                            {!! nl2br(e($tour->rules)) !!}
                        </div>
                    </div>
                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-5">

                {{-- Card de reserva --}}
                @include('livewire.web.components.tour-calendar')

                {{-- WhatsApp 
                @if($company->whatsapp)
                    <a
                        href="https://wa.me/55{{ preg_replace('/\D/', '', $company->whatsapp) }}?text=Olá! Tenho interesse no passeio {{ urlencode($tour->title) }}"
                        target="_blank"
                        class="flex items-center justify-center gap-3 w-full py-4 rounded-2xl font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
                        style="background: linear-gradient(135deg, #22c55e, #16a34a);"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Perguntar no WhatsApp
                    </a>
                @endif
                --}}
            </div>
        </div>
    </div>

    <div
        x-data="tourGallery()"
        @open-gallery.window="open($event.detail.index)"
    >

        <div
            x-show="opened"
            x-transition.opacity
            class="fixed inset-0 z-[9999] bg-black/95"
            x-cloak
        >

            <button
                @click="close()"
                class="absolute top-6 right-6 text-white text-4xl z-50 hover:opacity-70"
            >
                ✕
            </button>

            <button
                @click="prev()"
                class="absolute left-6 top-1/2 -translate-y-1/2 text-white text-5xl"
            >
                ‹
            </button>

            <button
                @click="next()"
                class="absolute right-6 top-1/2 -translate-y-1/2 text-white text-5xl"
            >
                ›
            </button>

            <div class="h-screen flex items-center justify-center">

                <img
                    :src="images[current]"
                    class="max-h-[90vh] max-w-[90vw] object-contain"
                >

            </div>

            <div
                class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white"
            >
                <span x-text="current+1"></span>
                /
                <span x-text="images.length"></span>
            </div>

        </div>

    </div>
@endsection