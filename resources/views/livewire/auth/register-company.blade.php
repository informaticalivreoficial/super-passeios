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
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(22,163,183,0.2); border: 1px solid rgba(22,163,183,0.4);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/></svg>
                </div>
                <span class="text-white font-bold text-lg" style="font-family: 'Syne', sans-serif;">{{ $config->app_name ?? config('app.name') }}</span>
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
                    <p class="text-2xl font-bold text-white" style="font-family: 'Syne', sans-serif;">24h</p>
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
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 ">

        <div class="w-full max-w-md">

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
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Senha <span style="color: #16a3b7;">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input
                            type="password"
                            wire:model="password"
                            placeholder="Mínimo 8 caracteres"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
                    </div>
                    @error('password')
                        <p class="text-xs" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar senha --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Confirmar senha <span style="color: #16a3b7;">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                        <input
                            type="password"
                            wire:model="password_confirmation"
                            placeholder="Repita a senha"
                            class="w-full border rounded-xl text-sm pl-9 pr-3 py-2.5 outline-none transition"
                            style="border-color: #e8e4d8; color: #051e34;"
                            onfocus="this.style.borderColor='#16a3b7'; this.style.boxShadow='0 0 0 3px rgba(22,163,183,0.15)'"
                            onblur="this.style.borderColor='#e8e4d8'; this.style.boxShadow='none'"
                        >
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

                {{-- Termos --}}
                <p class="text-xs text-center" style="color: #b0a98a;">
                    Ao criar uma conta você concorda com nossos
                    <a href="#" style="color: #16a3b7;">Termos de Uso</a>
                    e
                    <a href="#" style="color: #16a3b7;">Política de Privacidade</a>.
                </p>

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