<div class="min-h-screen flex" style="background: #fafaf8;">

    {{-- LADO ESQUERDO — decorativo --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12"
        style="background: linear-gradient(135deg, #051e34 0%, #0a3358 60%, #0e4a7a 100%);">

        {{-- Efeito de brilho --}}
        <div class="absolute inset-0 opacity-20"
            style="background-image: radial-gradient(circle at 30% 70%, #16a3b7 0%, transparent 50%), radial-gradient(circle at 80% 20%, #fadd37 0%, transparent 40%);"></div>

        {{-- Onda decorativa --}}
        <div class="absolute bottom-0 right-0 opacity-10">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" style="width: 400px; height: 400px;">
                <circle cx="300" cy="300" r="200" fill="none" stroke="#16a3b7" stroke-width="1"/>
                <circle cx="300" cy="300" r="150" fill="none" stroke="#16a3b7" stroke-width="1"/>
                <circle cx="300" cy="300" r="100" fill="none" stroke="#fadd37" stroke-width="1"/>
            </svg>
        </div>

        {{-- Logo --}}
        <div class="relative z-10">
            <a href="{{ route('web.home') }}" class="flex items-center gap-3">
                @if($config->getlogo())
                    <img src="{{ $config->getlogo() }}" alt="{{ $config->app_name ?? config('app.name') }}" class="h-14 w-auto object-contain">
                @else
                    <span class="text-white font-bold text-lg" style="font-family: 'Syne', sans-serif;">{{ $config->app_name ?? config('app.name') }}</span>
                @endif                
            </a>
        </div>

        {{-- Conteúdo central --}}
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full mb-6 text-xs font-bold uppercase tracking-widest"
                style="background: rgba(250,221,55,0.15); border: 1px solid rgba(250,221,55,0.3); color: #fadd37;">
                Para empresas
            </div>
            <h2 class="text-4xl font-extrabold text-white mb-4 leading-tight" style="font-family: 'Syne', sans-serif;">
                Venda seus passeios<br>
                <span style="color: #fadd37;">para o Brasil inteiro</span>
            </h2>
            <p class="text-base leading-relaxed" style="color: rgba(255,255,255,0.6); max-width: 340px;">
                Cadastre sua operação náutica e comece a receber reservas online com toda a segurança.
            </p>

            <div class="flex items-center gap-6 mt-10">
                <div>
                    <p class="text-2xl font-bold text-white" style="font-family: 'Syne', sans-serif;">100%</p>
                    <p class="text-xs" style="color: rgba(255,255,255,0.5);">Gratuito</p>
                </div>
                <div class="w-px h-8" style="background: rgba(255,255,255,0.15);"></div>
                <div>
                    <p class="text-2xl font-bold text-white" style="font-family: 'Syne', sans-serif;">2h</p>
                    <p class="text-xs" style="color: rgba(255,255,255,0.5);">Para ativar</p>
                </div>
                <div class="w-px h-8" style="background: rgba(255,255,255,0.15);"></div>
                <div>
                    <p class="text-2xl font-bold text-white" style="font-family: 'Syne', sans-serif;">∞</p>
                    <p class="text-xs" style="color: rgba(255,255,255,0.5);">Passeios</p>
                </div>
            </div>
        </div>

        {{-- Rodapé --}}
        <div class="relative z-10">
            <p class="text-xs" style="color: rgba(255,255,255,0.3);">
                © {{ date('Y') }} {{ $config->app_name ?? config('app.name') }}
            </p>
        </div>

    </div>

    {{-- LADO DIREITO — formulário --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-2 ">

        <div class="w-full max-w-md lg:max-w-lg">

            {{-- Header --}}
            <div class="mb-8">
                <a href="{{ route('web.home') }}" class="lg:hidden inline-flex items-center gap-2 mb-6 text-sm font-medium" style="color: #16a3b7;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    Voltar ao início
                </a>
                
                <h1 class="text-3xl font-extrabold mb-2" style="font-family: 'Syne', sans-serif; color: #051e34;">
                    Cadastre sua empresa
                </h1>
                <p class="text-sm" style="color: #87c2c0;">
                    Já tem conta?
                    <a href="{{ route('login') }}" style="color: #16a3b7; font-weight: 600;">Entrar agora</a>
                </p>
            </div>

            {{-- Formulário --}}
            <form wire:submit="save" class="space-y-4">

                {{-- Nome --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Nome completo <span style="color: #16a3b7;">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input
                            type="text"
                            wire:model="name"
                            placeholder="Seu nome completo"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
                    </div>
                    @error('name')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">E-mail <span style="color: #16a3b7;">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="contato@suaempresa.com"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
                    </div>
                    @error('email')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Telefone --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">WhatsApp <span style="color: #16a3b7;">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <input
                            type="text"
                            wire:model="cell_phone"
                            placeholder="(00) 00000-0000"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                            x-data
                            x-init="$nextTick(() => {
                                IMask($el, {
                                    mask: [
                                        { mask: '(00) 0000-0000' },
                                        { mask: '(00) 00000-0000' }
                                    ]
                                })
                            })"
                        >
                    </div>
                    @error('cell_phone')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Senha --}}
                <div class="flex flex-col gap-1.5"
                     x-data="{ show: false }">
                    <label class="text-sm font-bold" style="color: #051e34;">Senha <span style="color: #16a3b7;">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input
                            :type="show ? 'text' : 'password'"
                            wire:model="password"
                            placeholder="Mínimo 8 caracteres"
                            class="w-full border rounded-xl text-sm pl-9 pr-10 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2"
                            style="color: #b0a98a;"
                        >
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar senha --}}
                <div class="flex flex-col gap-1.5"
                     x-data="{ show: false }">
                    <label class="text-sm font-bold" style="color: #051e34;">Confirmar senha <span style="color: #16a3b7;">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input
                            :type="show ? 'text' : 'password'"
                            wire:model="password_confirmation"
                            placeholder="Repita a senha"
                            class="w-full border rounded-xl text-sm pl-9 pr-10 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
                        <button
                            type="button"
                            @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2"
                            style="color: #b0a98a;"
                        >
                            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-extrabold text-sm transition"
                        style="background: #16a3b7; color: white; box-shadow: 0 2px 0 #0e7a8a; font-family: 'Syne', sans-serif;"
                        onmouseover="this.style.background='#13919e'"
                        onmouseout="this.style.background='#16a3b7'"
                    >
                        {{-- Estado normal --}}
                        <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Criar minha conta
                        </span>

                        {{-- Estado loading --}}
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            Criando conta...
                        </span>
                    </button>
                </div>

                {{-- Aceites --}}
                <div class="space-y-3 pt-2">

                    {{-- Termos de Uso --}}
                    <div class="flex items-start gap-3" x-data="{ open: false, content: '', loading: false }">
                        <input
                            type="checkbox"
                            wire:model="aceite_termos"
                            id="aceite_termos"
                            class="mt-0.5 h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500 shrink-0"
                            style="accent-color: #16a3b7;"
                        >
                        <label for="aceite_termos" class="text-xs leading-relaxed" style="color: #5a5a5a;">
                            Li e concordo com os
                            <button
                                type="button"
                                @click="
                                    open = true;
                                    if (!content) {
                                        loading = true;
                                        fetch('{{ route("web.blog.page", ["slug" => "termos-de-uso-para-operadores"]) }}')
                                            .then(r => r.text())
                                            .then(html => {
                                                const parser = new DOMParser();
                                                const doc = parser.parseFromString(html, 'text/html');
                                                const article = doc.querySelector('article') || doc.querySelector('.prose') || doc.querySelector('main');
                                                content = article ? article.innerHTML : '<p>Conteúdo não disponível.</p>';
                                                loading = false;
                                            })
                                            .catch(() => { content = '<p>Erro ao carregar conteúdo.</p>'; loading = false; });
                                    }
                                "
                                class="font-bold inline"
                                style="color: #16a3b7; text-decoration: underline; text-underline-offset: 2px;"
                            >Termos de Uso do Operador</button>
                        </label>

                        {{-- Modal Termos --}}
                        <div
                            x-show="open"
                            x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center p-4"
                            style="background: rgba(5,30,52,0.6); backdrop-filter: blur(4px);"
                            @click.self="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                        >
                            <div
                                class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                            >
                                <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid #e8e4d8;">
                                    <h3 class="text-lg font-bold" style="color: #051e34; font-family: 'Syne', sans-serif;">Termos de Uso do Operador</h3>
                                    <button @click="open = false" class="p-2 rounded-lg hover:bg-gray-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="px-6 py-4 overflow-y-auto prose prose-sm max-w-none" style="color: #333;">
                                    <template x-if="loading">
                                        <div class="flex items-center justify-center py-12">
                                            <svg class="animate-spin w-6 h-6" style="color: #16a3b7;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                                        </div>
                                    </template>
                                    <template x-if="!loading">
                                        <div x-html="content"></div>
                                    </template>
                                </div>
                                <div class="px-6 py-3 flex justify-end" style="border-top: 1px solid #e8e4d8;">
                                    <button
                                        type="button"
                                        @click="open = false"
                                        class="px-5 py-2 rounded-xl text-sm font-bold transition"
                                        style="background: #16a3b7; color: white;"
                                    >Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Política de Privacidade --}}
                    <div class="flex items-start gap-3" x-data="{ open: false, content: '', loading: false }">
                        <input
                            type="checkbox"
                            wire:model="aceite_privacidade"
                            id="aceite_privacidade"
                            class="mt-0.5 h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-500 shrink-0"
                            style="accent-color: #16a3b7;"
                        >
                        <label for="aceite_privacidade" class="text-xs leading-relaxed" style="color: #5a5a5a;">
                            Li e estou ciente da
                            <button
                                type="button"
                                @click="
                                    open = true;
                                    if (!content) {
                                        loading = true;
                                        fetch('{{ route("web.blog.page", ["slug" => "politica-de-privacidade-para-operadores"]) }}')
                                            .then(r => r.text())
                                            .then(html => {
                                                const parser = new DOMParser();
                                                const doc = parser.parseFromString(html, 'text/html');
                                                const article = doc.querySelector('article') || doc.querySelector('.prose') || doc.querySelector('main');
                                                content = article ? article.innerHTML : '<p>Conteúdo não disponível.</p>';
                                                loading = false;
                                            })
                                            .catch(() => { content = '<p>Erro ao carregar conteúdo.</p>'; loading = false; });
                                    }
                                "
                                class="font-bold inline"
                                style="color: #16a3b7; text-decoration: underline; text-underline-offset: 2px;"
                            >Política de Privacidade</button>
                        </label>

                        {{-- Modal Privacidade --}}
                        <div
                            x-show="open"
                            x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center p-4"
                            style="background: rgba(5,30,52,0.6); backdrop-filter: blur(4px);"
                            @click.self="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                        >
                            <div
                                class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                            >
                                <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid #e8e4d8;">
                                    <h3 class="text-lg font-bold" style="color: #051e34; font-family: 'Syne', sans-serif;">Política de Privacidade</h3>
                                    <button @click="open = false" class="p-2 rounded-lg hover:bg-gray-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="px-6 py-4 overflow-y-auto prose prose-sm max-w-none" style="color: #333;">
                                    <template x-if="loading">
                                        <div class="flex items-center justify-center py-12">
                                            <svg class="animate-spin w-6 h-6" style="color: #16a3b7;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                                        </div>
                                    </template>
                                    <template x-if="!loading">
                                        <div x-html="content"></div>
                                    </template>
                                </div>
                                <div class="px-6 py-3 flex justify-end" style="border-top: 1px solid #e8e4d8;">
                                    <button
                                        type="button"
                                        @click="open = false"
                                        class="px-5 py-2 rounded-xl text-sm font-bold transition"
                                        style="background: #16a3b7; color: white;"
                                    >Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('aceite_termos')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                    @error('aceite_privacidade')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror

                </div>

            </form>

        </div>
    </div>

    {{-- OVERLAY DE LOADING --}}
    <div
        wire:loading.flex
        wire:target="save"
        class="fixed inset-0 z-50 items-center justify-center"
        style="background: rgba(5,30,52,0.7); backdrop-filter: blur(4px);"
    >
        <div class="flex flex-col items-center gap-4">
            <div class="relative w-16 h-16">
                <svg class="animate-spin w-16 h-16" style="color: #16a3b7;" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-6 h-6" style="color: #fadd37;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg>
                </div>
            </div>
            <div class="text-center">
                <p class="font-bold text-white text-lg" style="font-family: 'Syne', sans-serif;">Criando sua conta...</p>
                <p class="text-sm mt-1" style="color: rgba(255,255,255,0.6);">Aguarde um momento</p>
            </div>
        </div>
    </div>

</div>