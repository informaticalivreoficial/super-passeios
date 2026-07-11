<section class="relative overflow-hidden">
    <!-- Background com gradiente mais dinâmico -->
    <div class="absolute inset-0 bg-gradient-to-br from-brand-50 via-white to-sky-50/30"></div>
    
    <!-- Elementos decorativos melhorados -->
    <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-gradient-to-br from-brand-200/40 to-brand-400/20 blur-3xl animate-pulse-slow"></div>
    <div class="absolute -bottom-48 -left-48 w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-sky-200/40 to-indigo-200/20 blur-3xl animate-pulse-slow animation-delay-1000"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-brand-100/10 blur-3xl"></div>
    
    <!-- Grid pattern sutil -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.04"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 pt-20 pb-16 min-h-screen flex items-center">
        <div class="grid lg:grid-cols-2 gap-16 lg:gap-20 items-center">
            {{-- Texto --}}
            <div class="space-y-8">
                <!-- Badge com ícone -->
                <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-100 to-brand-50 border border-brand-200/50 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                    </span>
                    <span class="text-brand-700 font-semibold text-sm">
                        🚀 Plataforma para empresas de passeios
                    </span>
                </div>

                <!-- Título com destaque animado -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black leading-[1.1] tracking-tight">
                    Venda mais passeios
                    <span class="relative inline-block">
                        <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-brand-600">
                            com menos esforço.
                        </span>
                        <!-- Linha decorativa -->
                        <svg class="absolute -bottom-2 left-0 w-full h-3 text-brand-200/60" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q25 10 50 5 Q75 0 100 5" stroke="currentColor" stroke-width="3" fill="none"/>
                        </svg>
                    </span>
                </h1>

                <!-- Descrição com melhor legibilidade -->
                <p class="text-lg sm:text-xl text-slate-600 leading-relaxed max-w-lg">
                    Gerencie reservas, clientes, agenda e pagamentos em uma única plataforma moderna, 
                    <span class="text-brand-600 font-medium">rápida</span> e feita para 
                    <span class="text-brand-600 font-medium">empresas de turismo náutico</span>.
                </p>

                <!-- Botões com hover mais refinado -->
                <div class="flex flex-wrap gap-4 pt-2">
                    <a
                        href="{{ route('register.company') }}"
                        class="group relative h-14 px-10 rounded-2xl bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-bold inline-flex items-center gap-2 transition-all duration-300 shadow-lg shadow-brand-500/25 hover:shadow-brand-500/40 hover:-translate-y-0.5">
                        <span>Começar agora</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a
                        href="#beneficios"
                        class="h-14 px-10 rounded-2xl border-2 border-slate-200 hover:border-brand-400 hover:bg-brand-50/50 inline-flex items-center font-semibold text-slate-700 hover:text-brand-600 transition-all duration-300 hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Conhecer recursos
                    </a>
                </div>

                <!-- Stats com ícones -->
                <div class="grid grid-cols-3 gap-4 pt-4 border-t border-slate-200/60">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-black text-2xl leading-none">100%</p>
                            <p class="text-slate-500 text-sm">Online</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-black text-2xl leading-none">24h</p>
                            <p class="text-slate-500 text-sm">Disponível</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-purple-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-black text-2xl leading-none">∞</p>
                            <p class="text-slate-500 text-sm">Passeios</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mockup melhorado --}}
            <div class="relative">
                <!-- Card de destaque flutuante -->
                <div class="absolute -top-6 -right-6 z-20 animate-float">
                    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl px-5 py-3 border border-brand-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-white font-bold text-sm">
                            ★
                        </div>
                        <div>
                            <p class="font-semibold text-sm">4.9/5</p>
                            <p class="text-xs text-slate-500">Avaliação média</p>
                        </div>
                    </div>
                </div>

                <!-- Card principal -->
                <div class="relative rounded-3xl border bg-white/80 backdrop-blur-sm shadow-2xl p-8 lg:p-10 hover:shadow-3xl transition-shadow duration-500">
                    <!-- Badge "Ativo agora" -->
                    <div class="absolute -top-3 left-8 bg-green-500 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-lg shadow-green-500/30 flex items-center gap-2">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        Ativo agora
                    </div>

                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 text-sm font-medium tracking-wide uppercase">
                                Saldo disponível
                            </p>
                            <h2 class="text-4xl lg:text-5xl font-black text-brand-500 mt-1">
                                R$ 18.450
                            </h2>
                            <p class="text-xs text-green-600 font-medium mt-1">
                                ↑ +12% este mês
                            </p>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center shadow-inner">
                            <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Gráfico simples -->
                    <div class="mt-6 flex items-end h-16 gap-1.5">
                        <div class="flex-1 bg-brand-200 rounded-t-lg h-8 transition-all hover:h-12 cursor-pointer"></div>
                        <div class="flex-1 bg-brand-300 rounded-t-lg h-12 transition-all hover:h-14 cursor-pointer"></div>
                        <div class="flex-1 bg-brand-400 rounded-t-lg h-10 transition-all hover:h-14 cursor-pointer"></div>
                        <div class="flex-1 bg-brand-500 rounded-t-lg h-16 transition-all hover:h-20 cursor-pointer"></div>
                        <div class="flex-1 bg-brand-300 rounded-t-lg h-11 transition-all hover:h-14 cursor-pointer"></div>
                        <div class="flex-1 bg-brand-200 rounded-t-lg h-7 transition-all hover:h-12 cursor-pointer"></div>
                        <div class="flex-1 bg-brand-400 rounded-t-lg h-14 transition-all hover:h-16 cursor-pointer"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100/50 p-5 hover:from-slate-100 hover:to-slate-200/50 transition-colors group cursor-pointer">
                            <div class="flex items-center justify-between">
                                <p class="text-slate-400 text-sm font-medium">Reservas</p>
                                <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-0.5 rounded-full">+23</span>
                            </div>
                            <p class="font-black text-3xl mt-1 group-hover:text-brand-500 transition-colors">
                                152
                            </p>
                        </div>

                        <div class="rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100/50 p-5 hover:from-slate-100 hover:to-slate-200/50 transition-colors group cursor-pointer">
                            <div class="flex items-center justify-between">
                                <p class="text-slate-400 text-sm font-medium">Clientes</p>
                                <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">+12</span>
                            </div>
                            <p class="font-black text-3xl mt-1 group-hover:text-brand-500 transition-colors">
                                89
                            </p>
                        </div>
                    </div>

                    <!-- Footer do card -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>Última atualização: hoje, 14:32</span>
                        <span class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                            Sincronizado
                        </span>
                    </div>
                </div>

                <!-- Elemento decorativo -->
                <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-brand-200 rounded-full blur-2xl opacity-30 -z-10"></div>
            </div>
        </div>
    </div>
</section>

@push('styles')
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        
        .animate-pulse-slow {
            animation: pulse 6s ease-in-out infinite;
        }
        
        .animation-delay-1000 {
            animation-delay: 1s;
        }
        
        .shadow-3xl {
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.15);
        }
        
        /* Mobile adjustments */
        @media (max-width: 768px) {
            .animate-float {
                animation: none;
            }
            .absolute.-top-6.-right-6 {
                top: -0.5rem;
                right: -0.5rem;
            }
        }
    </style>   
@endpush