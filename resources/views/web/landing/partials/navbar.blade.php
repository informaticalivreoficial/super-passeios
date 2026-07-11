<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
    :class="scrolled 
        ? 'bg-white/80 backdrop-blur-xl shadow-lg border-b border-slate-200/50' 
        : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">

    <div class="max-w-7xl mx-auto h-20 px-4 sm:px-6 flex items-center justify-between">
        
        {{-- Logo --}}
        <a href="/" class="flex items-center gap-3 group">
            <div class="relative">
                <img src="{{ $config->getlogo() }}" class="h-10 lg:h-11 w-auto transition-all duration-300 group-hover:scale-105" alt="Logo">
                <!-- Efeito de brilho na logo -->
                <div class="absolute -inset-2 rounded-full bg-brand-500/0 group-hover:bg-brand-500/5 blur-xl transition-all duration-500"></div>
            </div>
            {{-- Nome da empresa (opcional) --}}
            {{-- <span class="text-xl font-black text-slate-900 hidden sm:block">{{ $config->getNome() }}</span> --}}
        </a>

        {{-- Navegação Desktop --}}
        <nav class="hidden lg:flex items-center gap-1">
            <a href="#beneficios" 
               class="relative px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-brand-600 transition-all duration-300 hover:bg-brand-50/50 group">
                <span>Benefícios</span>
                <span class="absolute inset-x-4 -bottom-1 h-0.5 bg-brand-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
            </a>
            <a href="#funciona" 
               class="relative px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-brand-600 transition-all duration-300 hover:bg-brand-50/50 group">
                <span>Como funciona</span>
                <span class="absolute inset-x-4 -bottom-1 h-0.5 bg-brand-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
            </a>
            <a href="#faq" 
               class="relative px-4 py-2 rounded-xl text-sm font-medium text-slate-600 hover:text-brand-600 transition-all duration-300 hover:bg-brand-50/50 group">
                <span>FAQ</span>
                <span class="absolute inset-x-4 -bottom-1 h-0.5 bg-brand-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
            </a>
        </nav>

        {{-- Ações Desktop --}}
        <div class="hidden lg:flex items-center gap-3">
            <a href="{{ route('register.company') }}"
               class="group relative px-6 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-semibold text-sm shadow-lg shadow-brand-500/25 hover:shadow-brand-500/40 transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
                <span class="relative z-10 flex items-center gap-2">
                    Cadastrar empresa
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </span>
                <!-- Efeito de brilho -->
                <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></span>
            </a>
        </div>

        {{-- Botão Mobile --}}
        <button @click="open=!open" 
                class="lg:hidden relative w-10 h-10 rounded-xl hover:bg-slate-100 transition-all duration-300 flex items-center justify-center group">
            <span class="sr-only">Abrir menu</span>
            <div class="relative w-6 h-5">
                <span class="absolute block w-full h-0.5 bg-slate-700 rounded-full transition-all duration-300"
                      :class="open ? 'rotate-45 top-2' : 'top-0'"></span>
                <span class="absolute block w-full h-0.5 bg-slate-700 rounded-full transition-all duration-300 top-2"
                      :class="open ? 'opacity-0' : 'opacity-100'"></span>
                <span class="absolute block w-full h-0.5 bg-slate-700 rounded-full transition-all duration-300"
                      :class="open ? '-rotate-45 top-2' : 'top-4'"></span>
            </div>
        </button>

    </div>

    {{-- Menu Mobile --}}
    <div x-show="open" 
         x-transition:enter="transition-all duration-300 ease-out"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition-all duration-200 ease-in"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden absolute top-20 left-0 right-0 bg-white/95 backdrop-blur-xl border-b border-slate-200/50 shadow-xl">

        <div class="max-w-7xl mx-auto px-6 py-6 space-y-2">
            <a href="#beneficios" 
               @click="open=false"
               class="block px-4 py-3 rounded-xl text-slate-600 hover:text-brand-600 hover:bg-brand-50/50 transition-all duration-300 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Benefícios
                </div>
            </a>
            <a href="#funciona" 
               @click="open=false"
               class="block px-4 py-3 rounded-xl text-slate-600 hover:text-brand-600 hover:bg-brand-50/50 transition-all duration-300 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                    Como funciona
                </div>
            </a>
            <a href="#faq" 
               @click="open=false"
               class="block px-4 py-3 rounded-xl text-slate-600 hover:text-brand-600 hover:bg-brand-50/50 transition-all duration-300 font-medium">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    FAQ
                </div>
            </a>
            
            <div class="pt-4 mt-2 border-t border-slate-200/50 space-y-3">
                <a href="{{ route('register.company') }}"
                   @click="open=false"
                   class="block w-full px-4 py-3 text-center rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-semibold shadow-lg shadow-brand-500/25 transition-all duration-300">
                    Cadastrar empresa
                </a>
            </div>
        </div>
    </div>

</header>

{{-- Espaçador para o conteúdo não ficar atrás do header --}}
<div class="h-20"></div>