{{-- 
    Footer - Passeios Náuticos
    Paleta Arctic Frost: #e8f0f8 / #b8d4e8 / #6ba3c8 / #2e6b8a
    Fundo escuro náutico com acentos gelados
--}}
<footer class="relative overflow-hidden text-slate-200"
    style="background: linear-gradient(180deg, #0a1929 0%, #0f2438 50%, #0a1929 100%);">

    {{-- Onda decorativa no topo --}}
    <div class="absolute top-0 left-0 right-0 leading-[0] rotate-180" aria-hidden="true">
        <svg class="relative block w-full h-[60px]" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" 
                fill="#0a1929" opacity="0.4"></path>
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" 
                fill="#0f2438"></path>
        </svg>
    </div>

    {{-- Brilhos decorativos --}}
    <div class="absolute top-1/4 -left-32 w-96 h-96 rounded-full blur-3xl opacity-20 pointer-events-none"
        style="background: radial-gradient(circle, #6ba3c8 0%, transparent 70%);"></div>
    <div class="absolute bottom-0 -right-32 w-96 h-96 rounded-full blur-3xl opacity-15 pointer-events-none"
        style="background: radial-gradient(circle, #b8d4e8 0%, transparent 70%);"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 pt-24 pb-8">

        {{-- Grid principal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">

            {{-- Brand --}}
            <div class="lg:col-span-4 space-y-6">
                <img src="{{ $config->getlogo() }}" alt="{{ $config->app_name ?? 'Logo' }}"
                        class="h-14 w-auto brightness-0 invert opacity-90">

                <p class="text-sm leading-relaxed" style="color: #b8d4e8;">
                    {{ Str::limit($config->information, 320) }}
                </p>

                {{-- Selos de confiança --}}
                <div class="flex flex-wrap gap-2 pt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border"
                        style="background: rgba(107,163,200,0.1); border-color: rgba(107,163,200,0.3); color: #b8d4e8;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Empresas verificadas
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border"
                        style="background: rgba(107,163,200,0.1); border-color: rgba(107,163,200,0.3); color: #b8d4e8;">
                        ⭐ 4.9/5 (2k+ avaliações)
                    </span>
                </div>

                {{-- Redes sociais --}}
                <div class="flex gap-3 pt-2">
                    @php
                        $socials = [
                            'instagram' => [
                                'url' => $config->instagram ?? null, 
                                'color' => '#E4405F',
                                'hoverColor' => 'hover:bg-[#E4405F]',
                                'svg' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>'
                            ],
                            'facebook' => [
                                'url' => $config->facebook ?? null,
                                'color' => '#1877F2',
                                'hoverColor' => 'hover:bg-[#1877F2]',
                                'svg' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>'
                            ],
                            'twitter' => [
                                'url' => $config->twitter ?? null,
                                'color' => '#000000',
                                'hoverColor' => 'hover:bg-black',
                                'svg' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'
                            ],
                            'youtube' => [
                                'url' => $config->youtube ?? null,
                                'color' => '#FF0000',
                                'hoverColor' => 'hover:bg-[#FF0000]',
                                'svg' => '<path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>'
                            ],
                            'linkedin' => [
                                'url' => $config->linkedin ?? null,
                                'color' => '#0A66C2',
                                'hoverColor' => 'hover:bg-[#0A66C2]',
                                'svg' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'
                            ],
                            'whatsapp' => [
                                'url' => $config->whatsapp ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $config->whatsapp) : null,
                                'color' => '#25D366',
                                'hoverColor' => 'hover:bg-[#25D366]',
                                'svg' => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>'
                            ],
                            'tiktok' => [
                                'url' => $config->tiktok ?? null,
                                'color' => '#000000',
                                'hoverColor' => 'hover:bg-black',
                                'svg' => '<path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.11-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>'
                            ]
                        ];
                    @endphp
                    
                    @foreach($socials as $name => $social)
                        @if($social['url'])
                            <a href="{{ $social['url'] }}" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            aria-label="{{ ucfirst($name) }}"
                            class="group w-10 h-10 rounded-xl flex items-center justify-center border transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:border-transparent {{ $social['hoverColor'] }}"
                            style="background: rgba(107,163,200,0.08); border-color: rgba(107,163,200,0.2);">
                                <svg class="w-4 h-4 transition-all duration-300 group-hover:text-white" 
                                    fill="currentColor" 
                                    viewBox="0 0 24 24"
                                    style="color: #b8d4e8;">
                                    {!! $social['svg'] !!}
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>            

            {{-- Empresa --}}
            <div class="lg:col-span-3">
                <h3 class="text-sm font-semibold uppercase tracking-wider mb-5" style="color: #e8f0f8;">
                    Portal
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="text-sm transition-all duration-300 hover:translate-x-1 inline-block"
                            style="color: #b8d4e8;"
                            onmouseover="this.style.color='#e8f0f8'" onmouseout="this.style.color='#b8d4e8'">
                            Sobre nós
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm transition-all duration-300 hover:translate-x-1 inline-block"
                            style="color: #b8d4e8;"
                            onmouseover="this.style.color='#e8f0f8'" onmouseout="this.style.color='#b8d4e8'">
                            Cadastre sua empresa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.site.companies') }}" class="text-sm transition-all duration-300 hover:translate-x-1 inline-block"
                            style="color: #b8d4e8;"
                            onmouseover="this.style.color='#e8f0f8'" onmouseout="this.style.color='#b8d4e8'">
                            Operadoras
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.site.tours') }}" class="text-sm transition-all duration-300 hover:translate-x-1 inline-block"
                            style="color: #b8d4e8;"
                            onmouseover="this.style.color='#e8f0f8'" onmouseout="this.style.color='#b8d4e8'">
                            Passeios
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.site.companies') }}" class="text-sm transition-all duration-300 hover:translate-x-1 inline-block"
                            style="color: #b8d4e8;"
                            onmouseover="this.style.color='#e8f0f8'" onmouseout="this.style.color='#b8d4e8'">
                            Dicas
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contato + Newsletter --}}
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-5" style="color: #e8f0f8;">
                        Atendimento
                    </h3>
                    <ul class="space-y-3 text-sm" style="color: #b8d4e8;">
                        @if($config->address)
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" style="color: #6ba3c8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $config->address }}</span>
                            </li>
                        @endif
                        @if($config->phone)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" style="color: #6ba3c8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:{{ $config->phone }}" class="hover:text-white transition-colors">{{ $config->phone }}</a>
                            </li>
                        @endif
                        @if($config->cell_phone)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" style="color: #6ba3c8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:{{ $config->cell_phone }}" class="hover:text-white transition-colors">{{ $config->cell_phone }}</a>
                            </li>
                        @endif
                        @if($config->whatsapp)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0 transition-colors group-hover:text-green-500" 
                                    style="color: #6ba3c8;" 
                                    fill="currentColor" 
                                    viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                <a href="tel:{{ $config->whatsapp }}" class="hover:text-white transition-colors">{{ $config->whatsapp }}</a>
                            </li>
                        @endif
                        @if($config->email)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" style="color: #6ba3c8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $config->email }}" class="hover:text-white transition-colors">{{ $config->email }}</a>
                            </li>
                        @endif
                        @if($config->additional_email)
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" style="color: #6ba3c8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $config->additional_email }}" class="hover:text-white transition-colors">{{ $config->additional_email }}</a>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Newsletter --}}
                <div class="p-5 rounded-2xl border backdrop-blur-sm"
                    style="background: rgba(107,163,200,0.06); border-color: rgba(107,163,200,0.2);">
                    <p class="text-sm font-medium mb-1" style="color: #e8f0f8;">
                        ⚓ Ofertas exclusivas
                    </p>
                    <p class="text-xs mb-4" style="color: #b8d4e8;">
                        Receba descontos em passeios e novidades da temporada.
                    </p>                   
                    <livewire:web.newsletter-form />
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="h-px w-full mb-8" 
            style="background: linear-gradient(90deg, transparent, rgba(107,163,200,0.3), transparent);"></div>

        {{-- Bottom bar --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs" style="color: rgba(184,212,232,0.6);">
                © {{ date('Y') }} {{ $config->app_name ?? 'Náutica' }}. Todos os direitos reservados.
                <span> Feito com <span class="text-red-500">🖤</span> por <a style="color:#fff;" target="_blank" href="{{env('DESENVOLVEDOR_URL')}}"> {{env('DESENVOLVEDOR')}}</a></span>
            </p>
            <div class="flex flex-wrap items-center gap-6">
                @if($config->privacy_policy)
                    <a href="#" class="text-xs transition-colors hover:text-white" style="color: rgba(184,212,232,0.6);">
                        Política de Privacidade
                    </a>
                @endif
                @if($config->terms_condicions)
                    <a href="#" class="text-xs transition-colors hover:text-white" style="color: rgba(184,212,232,0.6);">
                        Termos de Uso
                    </a>
                @endif
                @if($config->terms_condicions)
                    <a href="#" class="text-xs transition-colors hover:text-white" style="color: rgba(184,212,232,0.6);">
                        Preferências de cookies
                    </a>
                @endif
                <span class="text-xs flex items-center gap-1.5" style="color: rgba(184,212,232,0.6);">
                    <span class="w-2 h-2 rounded-full animate-pulse" style="background: #4ade80;"></span>
                    Reservas abertas
                </span>
            </div>
        </div>
    </div>
</footer>
