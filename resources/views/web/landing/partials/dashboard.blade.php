<section class="relative py-24 lg:py-32 bg-gradient-to-b from-white via-slate-50/30 to-white overflow-hidden">
    
    <!-- Elementos decorativos -->
    <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-brand-100/20 blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-sky-100/20 blur-3xl"></div>
    
    <!-- Grid pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.04"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6">

        {{-- Título --}}
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-100 to-brand-50 border border-brand-200/50 shadow-sm mb-4">
                <svg class="w-4 h-4 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8l4-2 4 2V6z" clip-rule="evenodd"/>
                </svg>
                <span class="text-brand-700 font-semibold text-sm">
                    Seu painel de controle
                </span>
            </div>

            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tight text-slate-900">
                Tenha sua operação
                <span class="relative inline-block mt-1">
                    <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-brand-600">
                        na palma da mão
                    </span>
                    <svg class="absolute -bottom-2 left-0 w-full h-3 text-brand-300/60" viewBox="0 0 200 8" preserveAspectRatio="none">
                        <path d="M0 4 Q50 8 100 4 Q150 0 200 4" stroke="currentColor" stroke-width="3" fill="none"/>
                    </svg>
                </span>
            </h2>

            <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Acompanhe reservas, vendas, clientes e resultados em um painel simples e intuitivo.
            </p>
        </div>

        {{-- Dashboard mockup --}}
        <div class="mt-16 lg:mt-20 relative">
            
            {{-- Glow melhorado --}}
            <div class="absolute -inset-x-20 -bottom-10 h-60 bg-gradient-to-r from-brand-200/30 via-brand-300/20 to-sky-200/30 blur-3xl"></div>
            
            {{-- Badge flutuante --}}
            <div class="absolute -top-4 -right-4 lg:-top-6 lg:-right-6 z-20 animate-float">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg shadow-green-500/30 flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                    </span>
                    Ao vivo
                </div>
            </div>

            <div class="relative bg-slate-900 rounded-3xl p-4 lg:p-6 shadow-2xl shadow-slate-900/20 hover:shadow-slate-900/30 transition-shadow duration-500">
                
                {{-- Barra superior estilo macOS --}}
                <div class="flex items-center justify-between px-4 py-3 border-b border-slate-700/50">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-400 hover:bg-red-500 transition-colors cursor-pointer"></span>
                        <span class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500 transition-colors cursor-pointer"></span>
                        <span class="w-3 h-3 rounded-full bg-green-400 hover:bg-green-500 transition-colors cursor-pointer"></span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="text-xs text-slate-400 font-medium">
                            Painel da empresa
                        </div>
                        <div class="w-6 h-6 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white text-[10px] font-bold">
                            E
                        </div>
                    </div>
                </div>

                {{-- Conteúdo --}}
                <div class="bg-gradient-to-br from-slate-50 to-white rounded-2xl p-6 lg:p-8 mt-4 grid lg:grid-cols-4 gap-6">
                    
                    {{-- Sidebar --}}
                    <aside class="hidden lg:block bg-white/80 backdrop-blur-sm rounded-2xl p-5 border border-slate-200/50 shadow-sm">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                            </div>
                            <span class="font-black text-sm">Menu</span>
                        </div>

                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gradient-to-r from-brand-50 to-brand-100/30 text-brand-700 font-bold border border-brand-200/50 cursor-pointer hover:scale-105 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Dashboard
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all cursor-pointer group">
                                <svg class="w-4 h-4 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Passeios
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all cursor-pointer group">
                                <svg class="w-4 h-4 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Reservas
                                <span class="ml-auto bg-brand-100 text-brand-700 text-[10px] font-bold px-2 py-0.5 rounded-full">12</span>
                            </div>
                            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all cursor-pointer group">
                                <svg class="w-4 h-4 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Clientes
                            </div>
                            <div className="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition-all cursor-pointer group">
                                <svg class="w-4 h-4 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Financeiro
                            </div>
                        </div>
                    </aside>

                    {{-- Conteúdo principal --}}
                    <div class="lg:col-span-3 space-y-6">
                        
                        {{-- Cards de métricas --}}
                        <div class="grid md:grid-cols-3 gap-4">
                            
                            <div class="group bg-white rounded-2xl p-5 border border-slate-200/50 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">
                                        Saldo disponível
                                    </p>
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="mt-2 text-2xl font-black text-brand-500 group-hover:text-brand-600 transition-colors">
                                    R$ 12.850
                                </h3>
                                <div class="mt-2 flex items-center gap-1.5">
                                    <span class="text-xs text-green-600 font-medium">↑ 12%</span>
                                    <span class="text-xs text-slate-400">este mês</span>
                                </div>
                            </div>

                            <div class="group bg-white rounded-2xl p-5 border border-slate-200/50 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">
                                        Reservas
                                    </p>
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="mt-2 text-2xl font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                                    248
                                </h3>
                                <div class="mt-2 flex items-center gap-1.5">
                                    <span class="text-xs text-green-600 font-medium">↑ 8%</span>
                                    <span class="text-xs text-slate-400">este mês</span>
                                </div>
                            </div>

                            <div class="group bg-white rounded-2xl p-5 border border-slate-200/50 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <p class="text-xs text-slate-400 font-medium tracking-wide uppercase">
                                        Clientes
                                    </p>
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-violet-100 to-violet-50 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="mt-2 text-2xl font-black text-slate-900 group-hover:text-violet-600 transition-colors">
                                    156
                                </h3>
                                <div class="mt-2 flex items-center gap-1.5">
                                    <span class="text-xs text-green-600 font-medium">↑ 15%</span>
                                    <span class="text-xs text-slate-400">este mês</span>
                                </div>
                            </div>

                        </div>

                        {{-- Tabela de reservas --}}
                        <div class="bg-white rounded-2xl p-6 border border-slate-200/50 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex justify-between items-center mb-5">
                                <div class="flex items-center gap-3">
                                    <h3 class="font-black text-slate-900">
                                        Próximas reservas
                                    </h3>
                                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-brand-100 text-brand-700">Hoje</span>
                                </div>
                                <span class="text-xs font-bold text-brand-500 hover:text-brand-600 transition-colors cursor-pointer flex items-center gap-1 group">
                                    Ver todas
                                    <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>

                            <div class="space-y-3">
                                
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-slate-50 to-white hover:from-brand-50/30 hover:to-white transition-all duration-300 border border-transparent hover:border-brand-200/50 cursor-pointer group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm group-hover:text-brand-600 transition-colors">
                                                Passeio Ilha Anchieta
                                            </p>
                                            <p class="text-xs text-slate-400 flex items-center gap-2">
                                                <span>12 passageiros</span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                <span>14:30</span>
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold border border-green-200/50 flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Confirmado
                                    </span>
                                </div>

                                <div class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-slate-50 to-white hover:from-brand-50/30 hover:to-white transition-all duration-300 border border-transparent hover:border-brand-200/50 cursor-pointer group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm group-hover:text-blue-600 transition-colors">
                                                Volta da Ilha
                                            </p>
                                            <p class="text-xs text-slate-400 flex items-center gap-2">
                                                <span>8 passageiros</span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                <span>16:00</span>
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-xs font-bold border border-yellow-200/50 flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                        Pendente
                                    </span>
                                </div>

                                <div class="flex items-center justify-between p-3 rounded-xl bg-gradient-to-r from-slate-50 to-white hover:from-brand-50/30 hover:to-white transition-all duration-300 border border-transparent hover:border-brand-200/50 cursor-pointer group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-purple-50 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm group-hover:text-purple-600 transition-colors">
                                                Passeio ao Pôr do Sol
                                            </p>
                                            <p class="text-xs text-slate-400 flex items-center gap-2">
                                                <span>6 passageiros</span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                <span>18:30</span>
                                            </p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold border border-green-200/50 flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Confirmado
                                    </span>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- CTA --}}
        <div class="text-center mt-12">
            <a href="{{ route('register.company') }}" 
               class="group inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-bold shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 transition-all duration-300 hover:-translate-y-0.5">
                <span>Começar agora</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>

    </div>
</section>