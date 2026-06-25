@extends("web.$config->template.master.master")

@section('content')

    {{-- HERO DA EMPRESA --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, var(--navy) 0%, #0a3358 100%); min-height: 320px;">

        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 50%, var(--teal) 0%, transparent 50%);"></div>

        {{-- Onda --}}
        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="line-height: 0;">
            <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display: block; width: 100%; height: 60px;">
                <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#fafaf8"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-24">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs mb-8" style="color: rgba(255,255,255,0.5);">
                <a href="{{ route('web.home') }}" class="hover:text-white transition">Início</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                <span style="color: rgba(255,255,255,0.8);">{{ $company->alias_name }}</span>
            </nav>

            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">

                {{-- Logo --}}
                <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 shrink-0" style="border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.1);">
                    <img
                        src="{{ $company->getLogoUrl() }}"
                        alt="{{ $company->alias_name }}"
                        class="w-full h-full object-cover"
                    >
                </div>

                {{-- Info --}}
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3 mb-2">
                        <h1 class="font-display text-3xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                            {{ $company->alias_name }}
                        </h1>
                        <span class="badge badge-teal">Verificada</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-sm" style="color: rgba(255,255,255,0.65);">
                        @if($company->city)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $company->city }}, {{ $company->state }}
                            </span>
                        @endif
                        @if($company->whatsapp)
                            <a
                                href="https://wa.me/55{{ preg_replace('/\D/', '', $company->whatsapp) }}"
                                target="_blank"
                                class="flex items-center gap-1.5 transition hover:text-white"
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                {{ $company->whatsapp }}
                            </a>
                        @endif
                        @if($company->email)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                                {{ $company->email }}
                            </span>
                        @endif                        
                    </div>
                </div>

                {{-- Redes sociais --}}
                <div class="flex items-center gap-2">
                    @if($company->instagram)
                        <a href="{{ $company->instagram }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center transition hover:opacity-80" style="background: rgba(255,255,255,0.1); color: white;">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    @endif
                    @if($company->facebook)
                        <a href="{{ $company->facebook }}" target="_blank" class="w-10 h-10 rounded-xl flex items-center justify-center transition hover:opacity-80" style="background: rgba(255,255,255,0.1); color: white;">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                    @if($company->whatsapp)
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $company->whatsapp) }}" target="_blank" class="btn-gold text-sm px-4">
                            Falar no WhatsApp
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- CONTEÚDO --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- PASSEIOS --}}
            <div class="lg:col-span-2">

                <h2 class="section-title mb-8">
                    Passeios disponíveis
                    <span class="text-lg font-normal ml-2" style="color: #87c2c0;">({{ $tours->count() }})</span>
                </h2>

                @forelse($tours as $tour)
                    <a
                        href="{{ route('web.site.tour', [$company->slug, $tour->uuid]) }}"
                        class="card-tour flex flex-col sm:flex-row mb-5 block"
                    >
                        {{-- Imagem --}}
                        <div class="relative sm:w-56 h-48 sm:h-auto overflow-hidden shrink-0">
                            <img
                                src="{{ $tour->cover() }}"
                                alt="{{ $tour->title }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                            @if($tour->tour_type)
                                <div class="absolute top-3 left-3">
                                    <span class="badge badge-teal">{{ $tour->tour_type->label() }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="p-5 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="font-display font-700 text-lg mb-2" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                                    {{ $tour->title }}
                                </h3>
                                @if($tour->description)
                                    <p class="text-sm leading-relaxed line-clamp-2 mb-4" style="color: #87c2c0;">
                                        {{ Str::limit($tour->description, 120) }}
                                    </p>
                                @endif

                                <div class="flex flex-wrap gap-3 text-xs" style="color: #87c2c0;">
                                    @if($tour->duration)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                            {{ $tour->duration }}
                                        </span>
                                    @endif
                                    @if($tour->boarding_place)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg>
                                            {{ $tour->boarding_place }}
                                        </span>
                                    @endif
                                    @if($tour->vessel)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                            até {{ $tour->vessel->capacity }} pessoas
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-4 pt-4" style="border-top: 1px solid #f0ece4;">
                                <div>
                                    <p class="text-xs" style="color: #87c2c0;">A partir de</p>
                                    <p class="font-display font-800 text-xl" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                                        R$ {{ number_format($tour->price, 2, ',', '.') }}
                                    </p>
                                </div>
                                <span class="btn-primary text-sm">
                                    Ver passeio
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="py-20 text-center rounded-2xl" style="border: 2px dashed #e8e4d8;">
                        <p style="color: #87c2c0;">Nenhum passeio disponível no momento.</p>
                    </div>
                @endforelse

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-6">

                {{-- Sobre --}}
                @if($company->content)
                    <div class="bg-white rounded-2xl p-6" style="border: 1px solid #e8e4d8;">
                        <h3 class="font-display font-700 text-base mb-4" style="font-family: 'Syne', sans-serif; color: var(--navy);">Sobre a empresa</h3>
                        <p class="text-sm leading-relaxed" style="color: #87c2c0;">{!! $company->content !!}</p>
                    </div>
                @endif

                {{-- Contato --}}
                <div class="bg-white rounded-2xl p-6" style="border: 1px solid #e8e4d8;">
                    <h3 class="font-display font-700 text-base mb-4" style="font-family: 'Syne', sans-serif; color: var(--navy);">Contato</h3>
                    <ul class="space-y-3">
                        @if($company->whatsapp)
                            <li>
                                <a
                                    href="https://wa.me/55{{ preg_replace('/\D/', '', $company->whatsapp) }}"
                                    target="_blank"
                                    class="flex items-center gap-3 text-sm transition hover:opacity-80"
                                    style="color: var(--navy);"
                                >
                                    <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(35,197,94,0.1); color: #23c55e;">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </span>
                                    {{ $company->whatsapp }}
                                </a>
                            </li>
                        @endif
                        @if($company->phone)
                            <li class="flex items-center gap-3 text-sm" style="color: var(--navy);">
                                <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(22,163,183,0.1); color: var(--teal);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.63A2 2 0 012 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                                </span>
                                {{ $company->phone }}
                            </li>
                        @endif
                        @if($company->email)
                            <li class="flex items-center gap-3 text-sm" style="color: var(--navy);">
                                <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(22,163,183,0.1); color: var(--teal);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                                </span>
                                {{ $company->email }}
                            </li>
                        @endif
                        @if($company->additional_email)
                            <li class="flex items-center gap-3 text-sm" style="color: var(--navy);">
                                <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(22,163,183,0.1); color: var(--teal);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                                </span>
                                {{ $company->additional_email }}
                            </li>
                        @endif
                        @if($company->city)
                            <li class="flex items-center gap-3 text-sm" style="color: var(--navy);">
                                <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(22,163,183,0.1); color: var(--teal);">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </span>
                                {{ $company->city }}, {{ $company->state }}
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Mapa --}}
                @if($company->maps)
                    <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">
                        <div class="aspect-video">
                            {!! $company->maps !!}
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>

@endsection