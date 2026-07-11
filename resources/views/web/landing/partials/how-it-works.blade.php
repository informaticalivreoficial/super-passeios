<section id="funciona" class="relative py-24 lg:py-32 overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50/50">
    
    <!-- Elementos decorativos -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-200/50 to-transparent"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-brand-100/20 blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-sky-100/20 blur-3xl"></div>
    
    <!-- Círculos decorativos flutuantes -->
    <div class="absolute top-1/4 left-[5%] w-3 h-3 rounded-full bg-brand-300/30 animate-float-slow"></div>
    <div class="absolute bottom-1/3 right-[5%] w-4 h-4 rounded-full bg-sky-300/30 animate-float-slow animation-delay-1000"></div>
    <div class="absolute top-1/3 right-[10%] w-2 h-2 rounded-full bg-violet-300/30 animate-float-slow animation-delay-2000"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6">

        {{-- Título --}}
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-100 to-brand-50 border border-brand-200/50 shadow-sm mb-4">
                <svg class="w-4 h-4 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-brand-700 font-semibold text-sm">
                    Simples e rápido
                </span>
            </div>

            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tight text-slate-900">
                Comece a vender seus passeios
                <span class="relative inline-block mt-1">
                    <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-brand-600">
                        em poucos passos
                    </span>
                    <svg class="absolute -bottom-2 left-0 w-full h-3 text-brand-300/60" viewBox="0 0 200 8" preserveAspectRatio="none">
                        <path d="M0 4 Q50 8 100 4 Q150 0 200 4" stroke="currentColor" stroke-width="3" fill="none"/>
                    </svg>
                </span>
            </h2>

            <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Cadastre sua empresa, publique seus passeios e deixe a plataforma cuidar do restante.
            </p>
        </div>

        {{-- Passos --}}
        <div class="grid md:grid-cols-3 gap-8 lg:gap-12 mt-16 lg:mt-20 relative">
            
            {{-- Linha conectora desktop --}}
            <div class="hidden md:block absolute top-20 left-[16%] right-[16%] h-0.5">
                <div class="relative w-full h-full">
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-300 via-brand-400 to-brand-300 rounded-full"></div>
                    <!-- Pontos animados na linha -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-brand-500 animate-pulse-slow"></div>
                    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-brand-500 animate-pulse-slow animation-delay-1000"></div>
                    <div class="absolute left-1/2 top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-brand-400 animate-pulse-slow animation-delay-2000"></div>
                </div>
            </div>

            {{-- Passo 1 --}}
            <div class="relative group">
                <div class="relative bg-white rounded-3xl p-8 lg:p-10 text-center border border-slate-200/80 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:border-brand-200/50">
                    <!-- Número com design melhorado -->
                    <div class="relative mx-auto w-20 h-20">
                        <!-- Anel decorativo -->
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-brand-100 to-brand-200/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 scale-110"></div>
                        <div class="relative w-full h-full rounded-2xl bg-gradient-to-br from-brand-500 to-brand-600 text-white flex items-center justify-center text-2xl font-black shadow-lg shadow-brand-500/30 group-hover:shadow-brand-500/50 group-hover:scale-110 transition-all duration-300">
                            1
                            <!-- Efeito de brilho -->
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-white/10 to-transparent"></div>
                        </div>
                        <!-- Ícone decorativo -->
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="mt-6 text-xl lg:text-2xl font-black text-slate-900 group-hover:text-brand-600 transition-colors">
                        Cadastre sua empresa
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Informe os dados da sua empresa e crie seu perfil profissional na plataforma.
                    </p>

                    <!-- Indicador de passo -->
                    <div class="mt-6 flex items-center justify-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                        <span class="text-xs font-medium text-slate-400">Passo 1 de 3</span>
                    </div>
                </div>
            </div>

            {{-- Passo 2 --}}
            <div class="relative group md:mt-8">
                <div class="relative bg-white rounded-3xl p-8 lg:p-10 text-center border border-slate-200/80 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:border-brand-200/50">
                    <div class="relative mx-auto w-20 h-20">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-violet-100 to-violet-200/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 scale-110"></div>
                        <div class="relative w-full h-full rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 text-white flex items-center justify-center text-2xl font-black shadow-lg shadow-violet-500/30 group-hover:shadow-violet-500/50 group-hover:scale-110 transition-all duration-300">
                            2
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-white/10 to-transparent"></div>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="mt-6 text-xl lg:text-2xl font-black text-slate-900 group-hover:text-violet-600 transition-colors">
                        Publique seus passeios
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Cadastre roteiros, valores, horários, fotos e disponibilidade.
                    </p>

                    <div class="mt-6 flex items-center justify-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                        <span class="text-xs font-medium text-slate-400">Passo 2 de 3</span>
                    </div>
                </div>
            </div>

            {{-- Passo 3 --}}
            <div class="relative group">
                <div class="relative bg-white rounded-3xl p-8 lg:p-10 text-center border border-slate-200/80 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:border-brand-200/50">
                    <div class="relative mx-auto w-20 h-20">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-200/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 scale-110"></div>
                        <div class="relative w-full h-full rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center text-2xl font-black shadow-lg shadow-emerald-500/30 group-hover:shadow-emerald-500/50 group-hover:scale-110 transition-all duration-300">
                            3
                            <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-white/10 to-transparent"></div>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                            </svg>
                        </div>
                    </div>

                    <h3 class="mt-6 text-xl lg:text-2xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors">
                        Receba reservas
                    </h3>

                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Seus clientes encontram seus passeios, reservam online e você acompanha tudo pelo painel.
                    </p>

                    <div class="mt-6 flex items-center justify-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-xs font-medium text-slate-400">Passo 3 de 3</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- CTA com design melhorado --}}
        <div class="mt-16 lg:mt-20 text-center">
            <div class="inline-flex flex-col sm:flex-row items-center gap-4 bg-gradient-to-br from-slate-50 to-white rounded-2xl p-6 lg:p-8 border border-slate-200/80 shadow-sm">
                <div class="flex items-center gap-3 text-left">
                    <div class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-600">Pronto para começar?</p>
                        <p class="text-xs text-slate-400">Cadastro gratuito</p>
                    </div>
                </div>
                
                <a href="{{ route('register.company') }}"
                   class="group inline-flex items-center gap-2 px-8 py-3.5 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 hover:from-brand-600 hover:to-brand-700 text-white font-bold shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 transition-all duration-300 hover:-translate-y-0.5">
                    <span>Criar minha empresa</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Indicador de confiança --}}
        <div class="mt-12 flex flex-wrap items-center justify-center gap-8 text-sm text-slate-500">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Cadastro gratuito</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Sem fidelidade</span>
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Suporte 24/7</span>
            </div>
        </div>

    </div>
</section>

@push('styles')
<style>
    @keyframes float-slow {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-20px) scale(1.1); }
    }
    
    .animate-float-slow {
        animation: float-slow 6s ease-in-out infinite;
    }
    
    .animation-delay-1000 {
        animation-delay: 1s;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animate-pulse-slow {
        animation: pulse 3s ease-in-out infinite;
    }
</style>    
@endpush