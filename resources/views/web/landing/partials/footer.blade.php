<footer class="relative bg-slate-900 text-white overflow-hidden">
    
    <!-- Elementos decorativos -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-400/30 to-transparent"></div>
    <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-brand-500/5 blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-sky-500/5 blur-3xl"></div>
    
    <!-- Grid pattern sutil -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.02"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 pt-16 lg:pt-20 pb-8">
        
        {{-- Grid Principal --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 lg:gap-12">
            
            {{-- Coluna 1 - Logo e Descrição --}}
            <div class="col-span-2 md:col-span-4 lg:col-span-2">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <img src="{{ $config->getlogo() }}" class="h-11 w-auto brightness-0 invert" alt="Logo">
                </a>
                
                <p class="mt-4 text-sm text-slate-400 leading-relaxed max-w-sm text-justify">
                    {{ Str::limit($config->information, 320) }}
                </p>
                
                {{-- Redes Sociais --}}
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
                <div class="flex items-center gap-3 mt-6">
                    @foreach($socials as $name => $social)
                        @if($social['url'])
                            <a href="{{ $social['url'] }}" 
                            target="_blank" 
                            aria-label="{{ ucfirst($name) }}"
                            class="w-10 h-10 rounded-xl bg-white/5 hover:bg-brand-500/20 border border-white/10 hover:border-brand-400/30 flex items-center justify-center text-slate-400 hover:text-brand-400 transition-all duration-300 group"
                            >
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                    {!! $social['svg'] !!}
                                </svg>
                            </a>
                        @endif
                    @endforeach                    
                </div>
            </div>

            {{-- Coluna 2 - Produto --}}
            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">
                    Produto
                </h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="#beneficios" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Benefícios
                        </a>
                    </li>
                    <li>
                        <a href="#funciona" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Como funciona
                        </a>
                    </li>
                    <li>
                        <a href="#faq" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            FAQ
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Coluna 3 - Empresa --}}
            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">
                    Empresa
                </h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('web.blog.page', ['slug' => 'quem-somos']) }}" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Sobre nós
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.blog.index') }}" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Blog
                        </a>
                    </li>
                    {{--  
                    <li>
                        <a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Carreiras
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Contato
                        </a>
                    </li>
                    --}}
                </ul>
            </div>

            {{-- Coluna 4 - Suporte 
            <div>
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">
                    Suporte
                </h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Central de ajuda
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Tutoriais
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Comunidade
                        </a>
                    </li>
                    <li>
                        <a href="mailto:suporte@plataforma.com" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            suporte@plataforma.com
                        </a>
                    </li>
                </ul>
            </div>
            --}}
            {{-- Coluna 5 - Legal --}}
            <div class="col-span-2 md:col-span-1">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">
                    Legal
                </h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('web.terms') }}" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Termos de uso
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.privacy') }}" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Política de privacidade
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.cookies') }}" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Cookies
                        </a>
                    </li>
                    {{--  
                    <li>
                        <a href="#" class="text-sm text-slate-400 hover:text-brand-400 transition-colors duration-300 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-brand-500/0 group-hover:bg-brand-500 transition-all duration-300"></span>
                            Segurança
                        </a>
                    </li>
                    --}}
                </ul>
            </div>

        </div>       

        {{-- Bottom Bar --}}
        <div class="mt-8 pt-6 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">
                &copy; {{ date('Y') }} {{ $config->app_name ?? 'Plataforma de Passeios' }}. Todos os direitos reservados.
            </p>
            
            <div class="flex items-center gap-6">
                <span class="flex items-center gap-2 text-xs text-slate-500">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Pagamento 100% seguro
                </span>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500">Feito com</span>
                    <svg class="w-4 h-4 text-red-500 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span class="text-xs text-slate-500">por {{ config('app.desenvolvedor') }}</span>
                </div>
            </div>
        </div>

    </div>
</footer>