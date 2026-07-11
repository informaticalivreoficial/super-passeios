<section id="beneficios" class="relative py-24 lg:py-32 overflow-hidden bg-gradient-to-b from-white via-slate-50/50 to-white">
    
    <!-- Elementos decorativos de fundo -->
    <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-brand-100/20 blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-sky-100/20 blur-3xl"></div>
    
    <!-- Grid pattern sutil -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%239C92AC" fill-opacity="0.03"%3E%3Cpath d="M20 20v-4h-4v4h-4v4h4v4h4v-4h4v-4h-4zm0-20V0h-4v4h-4v4h4v4h4V8h4V4h-4zM4 20v-4H0v4H-4v4H0v4h4v-4h4v-4H4zM4 0V0H0v4H-4v4H0v4h4V8h4V4H4z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6">

        {{-- Título --}}
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-100 to-brand-50 border border-brand-200/50 shadow-sm mb-4">
                <svg class="w-4 h-4 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-brand-700 font-semibold text-sm">
                    Por que escolher nossa plataforma?
                </span>
            </div>

            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tight text-slate-900">
                Tudo que sua empresa precisa para
                <span class="relative inline-block mt-1">
                    <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-brand-600">
                        vender mais passeios
                    </span>
                    <!-- Underline animado -->
                    <svg class="absolute -bottom-2 left-0 w-full h-3 text-brand-300/60" viewBox="0 0 200 8" preserveAspectRatio="none">
                        <path d="M0 4 Q50 8 100 4 Q150 0 200 4" stroke="currentColor" stroke-width="3" fill="none"/>
                    </svg>
                </span>
            </h2>

            <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Uma solução completa para organizar sua operação,
                receber reservas e oferecer uma experiência profissional
                aos seus clientes.
            </p>
        </div>

        {{-- Cards --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mt-16 lg:mt-20">
            
            {{-- Card 1 - Reservas --}}
            <div class="group relative p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 hover:border-brand-200/50">
                <!-- Gradiente de fundo no hover -->
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-50/0 to-brand-50/0 group-hover:from-brand-50/30 group-hover:to-sky-50/30 transition-all duration-500"></div>
                
                <div class="relative">
                    <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm group-hover:shadow-lg">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-brand-400/10 to-brand-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <svg class="w-7 h-7 text-brand-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h3 class="mt-6 text-xl font-black text-slate-900 group-hover:text-brand-600 transition-colors">
                        Reservas organizadas
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Receba reservas online e tenha controle total
                        da sua agenda de passeios.
                    </p>

                    <!-- Link sutil -->
                    <div class="mt-4 flex items-center text-sm font-semibold text-brand-500 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card 2 - Oportunidades --}}
            <div class="group relative p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 hover:border-brand-200/50">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-50/0 to-brand-50/0 group-hover:from-brand-50/30 group-hover:to-sky-50/30 transition-all duration-500"></div>
                
                <div class="relative">
                    <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm group-hover:shadow-lg">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-emerald-400/10 to-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <svg class="w-7 h-7 text-emerald-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>

                    <h3 class="mt-6 text-xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors">
                        Mais oportunidades
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Apresente seus passeios para clientes
                        procurando novas experiências.
                    </p>

                    <div class="mt-4 flex items-center text-sm font-semibold text-emerald-500 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card 3 - Controle financeiro --}}
            <div class="group relative p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 hover:border-brand-200/50">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-50/0 to-brand-50/0 group-hover:from-brand-50/30 group-hover:to-sky-50/30 transition-all duration-500"></div>
                
                <div class="relative">
                    <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-100 to-violet-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm group-hover:shadow-lg">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-violet-400/10 to-violet-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <svg class="w-7 h-7 text-violet-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>

                    <h3 class="mt-6 text-xl font-black text-slate-900 group-hover:text-violet-600 transition-colors">
                        Controle financeiro
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Acompanhe vendas, saldo disponível e
                        solicitações de saque.
                    </p>

                    <div class="mt-4 flex items-center text-sm font-semibold text-violet-500 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card 4 - Gestão de clientes --}}
            <div class="group relative p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 hover:border-brand-200/50">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-50/0 to-brand-50/0 group-hover:from-brand-50/30 group-hover:to-sky-50/30 transition-all duration-500"></div>
                
                <div class="relative">
                    <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm group-hover:shadow-lg">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-blue-400/10 to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <svg class="w-7 h-7 text-blue-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>

                    <h3 class="mt-6 text-xl font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                        Gestão de clientes
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Tenha histórico dos seus clientes e
                        reservas em um único lugar.
                    </p>

                    <div class="mt-4 flex items-center text-sm font-semibold text-blue-500 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card 5 - Acesse de qualquer lugar --}}
            <div class="group relative p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 hover:border-brand-200/50">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-50/0 to-brand-50/0 group-hover:from-brand-50/30 group-hover:to-sky-50/30 transition-all duration-500"></div>
                
                <div class="relative">
                    <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm group-hover:shadow-lg">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-amber-400/10 to-amber-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <svg class="w-7 h-7 text-amber-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h3 class="mt-6 text-xl font-black text-slate-900 group-hover:text-amber-600 transition-colors">
                        Acesse de qualquer lugar
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Gerencie sua empresa pelo computador,
                        tablet ou celular.
                    </p>

                    <div class="mt-4 flex items-center text-sm font-semibold text-amber-500 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card 6 - Segurança --}}
            <div class="group relative p-8 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 hover:border-brand-200/50">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-brand-50/0 to-brand-50/0 group-hover:from-brand-50/30 group-hover:to-sky-50/30 transition-all duration-500"></div>
                
                <div class="relative">
                    <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-100 to-rose-50 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-sm group-hover:shadow-lg">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-rose-400/10 to-rose-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <svg class="w-7 h-7 text-rose-500 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>

                    <h3 class="mt-6 text-xl font-black text-slate-900 group-hover:text-rose-600 transition-colors">
                        Segurança
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Pagamentos e informações protegidas
                        para sua empresa e seus clientes.
                    </p>

                    <div class="mt-4 flex items-center text-sm font-semibold text-rose-500 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                        <span>Saiba mais</span>
                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- CTA adicional --}}
        <div class="text-center mt-16">
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