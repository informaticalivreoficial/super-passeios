<section id="faq" class="relative py-24 lg:py-32 overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-50/50">
    
    <!-- Elementos decorativos -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-200/50 to-transparent"></div>
    <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-brand-100/20 blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-sky-100/20 blur-3xl"></div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6">

        {{-- Título --}}
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-brand-100 to-brand-50 border border-brand-200/50 shadow-sm mb-4">
                <svg class="w-4 h-4 text-brand-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3 3 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
                <span class="text-brand-700 font-semibold text-sm">
                    Perguntas Frequentes
                </span>
            </div>

            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tight text-slate-900">
                Dúvidas comuns
                <span class="relative inline-block mt-1">
                    <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-brand-600">
                        sobre a plataforma
                    </span>
                    <svg class="absolute -bottom-2 left-0 w-full h-3 text-brand-300/60" viewBox="0 0 200 8" preserveAspectRatio="none">
                        <path d="M0 4 Q50 8 100 4 Q150 0 200 4" stroke="currentColor" stroke-width="3" fill="none"/>
                    </svg>
                </span>
            </h2>

            <p class="mt-6 text-lg sm:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Tire suas dúvidas e saiba como nossa plataforma pode ajudar sua empresa a vender mais.
            </p>
        </div>

        {{-- FAQ Accordion --}}
        <div class="mt-16 lg:mt-20 space-y-4" 
        x-data="{ 
            active: null,
            toggle(index) {
                this.active = this.active === index ? null : index;
            }
        }">
            
            {{-- FAQ 1 --}}
            <div class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <button @click="toggle(1)" class="w-full px-6 lg:px-8 py-5 flex items-center justify-between gap-4 text-left focus:outline-none">
                    <span class="text-base lg:text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">
                        Como funciona o cadastro da minha empresa?
                    </span>
                    <span class="flex-shrink-0 w-8 h-8 rounded-full bg-brand-50 group-hover:bg-brand-100 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-500 transition-transform duration-300" 
                             :class="active === 1 ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                
                <div x-show="active === 1" 
                     x-transition:enter="transition-all duration-300 ease-out"
                     x-transition:enter-start="max-h-0 opacity-0"
                     x-transition:enter-end="max-h-[500px] opacity-100"
                     x-transition:leave="transition-all duration-200 ease-in"
                     x-transition:leave-start="max-h-[500px] opacity-100"
                     x-transition:leave-end="max-h-0 opacity-0"
                     class="px-6 lg:px-8 pb-6">
                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-slate-600 leading-relaxed">
                            O cadastro é simples e rápido. Você informa os dados da sua empresa, cria seu perfil profissional e já pode começar a cadastrar seus passeios. Todo o processo leva menos de 5 minutos e você pode começar a receber reservas imediatamente.
                        </p>
                        <div class="mt-4 flex items-center gap-2 text-sm text-brand-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Cadastro gratuito e sem fidelidade</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <button @click="toggle(2)" class="w-full px-6 lg:px-8 py-5 flex items-center justify-between gap-4 text-left focus:outline-none">
                    <span class="text-base lg:text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">
                        Quais são os custos da plataforma?
                    </span>
                    <span class="flex-shrink-0 w-8 h-8 rounded-full bg-brand-50 group-hover:bg-brand-100 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-500 transition-transform duration-300" 
                             :class="active === 2 ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                
                <div x-show="active === 2" 
                     x-transition:enter="transition-all duration-300 ease-out"
                     x-transition:enter-start="max-h-0 opacity-0"
                     x-transition:enter-end="max-h-[500px] opacity-100"
                     x-transition:leave="transition-all duration-200 ease-in"
                     x-transition:leave-start="max-h-[500px] opacity-100"
                     x-transition:leave-end="max-h-0 opacity-0"
                     class="px-6 lg:px-8 pb-6">
                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-slate-600 leading-relaxed">
                            A plataforma é gratuita para cadastro e publicação de passeios. Cobramos apenas uma pequena comissão sobre as reservas realizadas através da plataforma. Não há mensalidades, taxas de adesão ou custos escondidos.
                        </p>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="bg-green-50 rounded-xl p-3 text-center border border-green-200/50">
                                <p class="text-xs text-slate-500">Cadastro</p>
                                <p class="font-bold text-green-600">Gratuito</p>
                            </div>
                            <div class="bg-green-50 rounded-xl p-3 text-center border border-green-200/50">
                                <p class="text-xs text-slate-500">Comissão</p>
                                <p class="font-bold text-green-600">Apenas sobre vendas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <button @click="toggle(3)" class="w-full px-6 lg:px-8 py-5 flex items-center justify-between gap-4 text-left focus:outline-none">
                    <span class="text-base lg:text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">
                        Como recebo os pagamentos das reservas?
                    </span>
                    <span class="flex-shrink-0 w-8 h-8 rounded-full bg-brand-50 group-hover:bg-brand-100 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-500 transition-transform duration-300" 
                             :class="active === 3 ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                
                <div x-show="active === 3" 
                     x-transition:enter="transition-all duration-300 ease-out"
                     x-transition:enter-start="max-h-0 opacity-0"
                     x-transition:enter-end="max-h-[500px] opacity-100"
                     x-transition:leave="transition-all duration-200 ease-in"
                     x-transition:leave-start="max-h-[500px] opacity-100"
                     x-transition:leave-end="max-h-0 opacity-0"
                     class="px-6 lg:px-8 pb-6">
                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-slate-600 leading-relaxed">
                            Os pagamentos são processados de forma segura através de nossa plataforma. O valor das reservas fica disponível em sua carteira digital e você pode solicitar o saque a qualquer momento. O dinheiro é transferido para sua conta bancária em até 2 dias úteis.
                        </p>
                        <div class="mt-4 flex flex-wrap items-center gap-4 text-sm">
                            <span class="flex items-center gap-1.5 text-slate-600">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Saque a qualquer momento
                            </span>
                            <span class="flex items-center gap-1.5 text-slate-600">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Transferência em 2 dias úteis
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <button @click="toggle(4)" class="w-full px-6 lg:px-8 py-5 flex items-center justify-between gap-4 text-left focus:outline-none">
                    <span class="text-base lg:text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">
                        Preciso ter site para usar a plataforma?
                    </span>
                    <span class="flex-shrink-0 w-8 h-8 rounded-full bg-brand-50 group-hover:bg-brand-100 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-500 transition-transform duration-300" 
                             :class="active === 4 ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                
                <div x-show="active === 4" 
                     x-transition:enter="transition-all duration-300 ease-out"
                     x-transition:enter-start="max-h-0 opacity-0"
                     x-transition:enter-end="max-h-[500px] opacity-100"
                     x-transition:leave="transition-all duration-200 ease-in"
                     x-transition:leave-start="max-h-[500px] opacity-100"
                     x-transition:leave-end="max-h-0 opacity-0"
                     class="px-6 lg:px-8 pb-6">
                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-slate-600 leading-relaxed">
                            Não! A plataforma já inclui uma página profissional para sua empresa, onde você pode divulgar todos os seus passeios. Seus clientes podem acessar, ver os passeios disponíveis e fazer reservas diretamente pela sua página.
                        </p>
                        <div class="mt-4 flex items-center gap-2 text-sm text-brand-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Página profissional incluída</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 5 --}}
            <div class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <button @click="toggle(5)" class="w-full px-6 lg:px-8 py-5 flex items-center justify-between gap-4 text-left focus:outline-none">
                    <span class="text-base lg:text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">
                        A plataforma é segura?
                    </span>
                    <span class="flex-shrink-0 w-8 h-8 rounded-full bg-brand-50 group-hover:bg-brand-100 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-500 transition-transform duration-300" 
                             :class="active === 5 ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                
                <div x-show="active === 5" 
                     x-transition:enter="transition-all duration-300 ease-out"
                     x-transition:enter-start="max-h-0 opacity-0"
                     x-transition:enter-end="max-h-[500px] opacity-100"
                     x-transition:leave="transition-all duration-200 ease-in"
                     x-transition:leave-start="max-h-[500px] opacity-100"
                     x-transition:leave-end="max-h-0 opacity-0"
                     class="px-6 lg:px-8 pb-6">
                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-slate-600 leading-relaxed">
                            Sim! Utilizamos as mais avançadas tecnologias de segurança para proteger os dados da sua empresa e de seus clientes. Todos os pagamentos são processados com criptografia de ponta a ponta e seguimos rigorosos padrões de segurança.
                        </p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 text-xs font-medium text-slate-600 border border-slate-200/50">
                                <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Criptografia SSL
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 text-xs font-medium text-slate-600 border border-slate-200/50">
                                <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pagamentos seguros
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 text-xs font-medium text-slate-600 border border-slate-200/50">
                                <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Proteção de dados
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FAQ 6 --}}
            <div class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                <button @click="toggle(6)" class="w-full px-6 lg:px-8 py-5 flex items-center justify-between gap-4 text-left focus:outline-none">
                    <span class="text-base lg:text-lg font-bold text-slate-900 group-hover:text-brand-600 transition-colors">
                        Como faço para divulgar meus passeios?
                    </span>
                    <span class="flex-shrink-0 w-8 h-8 rounded-full bg-brand-50 group-hover:bg-brand-100 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 text-brand-500 transition-transform duration-300" 
                             :class="active === 6 ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </button>
                
                <div x-show="active === 6" 
                     x-transition:enter="transition-all duration-300 ease-out"
                     x-transition:enter-start="max-h-0 opacity-0"
                     x-transition:enter-end="max-h-[500px] opacity-100"
                     x-transition:leave="transition-all duration-200 ease-in"
                     x-transition:leave-start="max-h-[500px] opacity-100"
                     x-transition:leave-end="max-h-0 opacity-0"
                     class="px-6 lg:px-8 pb-6">
                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-slate-600 leading-relaxed">
                            Ao cadastrar seus passeios na plataforma, eles ficam disponíveis para milhares de clientes em busca de novas experiências. Além disso, você pode compartilhar o link da sua página profissional nas redes sociais, WhatsApp e outros canais.
                        </p>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 text-xs font-medium text-slate-600 border border-slate-200/50">
                                <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Visibilidade na plataforma
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 text-xs font-medium text-slate-600 border border-slate-200/50">
                                <svg class="w-3.5 h-3.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                Compartilhamento social
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Ainda com dúvidas? --}}
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-br from-brand-50 to-sky-50 rounded-3xl p-8 lg:p-12 border border-brand-200/30">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-brand-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900">
                        Ainda tem dúvidas?
                    </h3>
                    <p class="mt-2 text-slate-600 max-w-lg">
                        Nossa equipe está pronta para ajudar você a começar sua jornada na plataforma.
                    </p>
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-4">
                        @if ($config->email)
                            <a href="mailto:{{ $config->email }}" 
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-white hover:bg-brand-50 text-slate-700 font-semibold border border-slate-200 hover:border-brand-300 transition-all duration-300 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $config->email }}
                            </a>
                        @endif                        
                        @if ($config->whatsapp)
                            <a href="#" 
                            onclick="shareWhatsApp(event)"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-green-500 hover:bg-green-600 text-white font-semibold shadow-lg shadow-green-500/30 hover:shadow-green-500/50 transition-all duration-300 hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-7.36 3.81c-3.87 0-7-3.13-7-7 0-3.87 3.13-7 7-7 3.87 0 7 3.13 7 7 0 3.87-3.13 7-7 7z"/>
                                </svg>
                                Falar no WhatsApp
                            </a>
                        @endif                        
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Final --}}
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