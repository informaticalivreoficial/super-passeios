<div class="min-h-screen flex" style="background: #f5f3ee;">

    {{-- LADO ESQUERDO --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12"
         style="background: linear-gradient(135deg, #051e34 0%, #0a3358 60%, #0e4a7a 100%);">

        <div class="absolute inset-0 opacity-20"
             style="background-image: radial-gradient(circle at 30% 70%, #16a3b7 0%, transparent 50%), radial-gradient(circle at 80% 20%, #fadd37 0%, transparent 40%);"></div>

        <div class="absolute bottom-0 right-0 opacity-10">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" style="width: 400px; height: 400px;">
                <circle cx="300" cy="300" r="200" fill="none" stroke="#16a3b7" stroke-width="1"/>
                <circle cx="300" cy="300" r="150" fill="none" stroke="#16a3b7" stroke-width="1"/>
                <circle cx="300" cy="300" r="100" fill="none" stroke="#fadd37" stroke-width="1"/>
            </svg>
        </div>

        <div class="relative z-10">
            <img src="{{ $config->getlogoadmin() }}" alt="{{ $config->app_name }}" class="h-10 w-auto object-contain" onerror="this.style.display='none'">
        </div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full mb-6 text-xs font-bold uppercase tracking-widest"
                 style="background: rgba(250,221,55,0.15); border: 1px solid rgba(250,221,55,0.3); color: #fadd37;">
                Recuperar acesso
            </div>
            <h2 class="text-4xl font-extrabold text-white mb-4 leading-tight" style="font-family: 'Syne', sans-serif;">
                Esqueceu<br>
                <span style="color: #fadd37;">sua senha?</span>
            </h2>
            <p class="text-base leading-relaxed" style="color: rgba(255,255,255,0.6); max-width: 320px;">
                Sem problema. Informe seu e-mail e enviaremos um link para você criar uma nova senha.
            </p>
        </div>

        <div class="relative z-10">
            <p class="text-xs" style="color: rgba(255,255,255,0.3);">© {{ date('Y') }} {{ $config->app_name }}</p>
        </div>

    </div>

    {{-- LADO DIREITO --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">

            <div class="mb-8">
                <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full mb-4"
                     style="background: rgba(22,163,183,0.1); border: 1px solid rgba(22,163,183,0.3); color: #16a3b7;">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                    Redefinir senha
                </div>
                <h1 class="text-3xl font-extrabold mb-2" style="font-family: 'Syne', sans-serif; color: #051e34;">
                    Recuperar senha
                </h1>
                <p class="text-sm" style="color: #87c2c0;">
                    Lembrou a senha?
                    <a href="{{ route('login') }}" style="color: #16a3b7; font-weight: 600;">Voltar ao login</a>
                </p>
            </div>

            {{-- Sucesso --}}
            @if (session('status'))
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl mb-6" style="background: rgba(35,197,94,0.08); border: 1px solid rgba(35,197,94,0.2);">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <p class="text-sm" style="color: #15803d;">{{ session('status') }}</p>
                </div>
            @endif

            <form wire:submit="sendResetLink" class="space-y-4">

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">E-mail cadastrado</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: #b0a98a;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                        <input
                            type="email"
                            wire:model="email"
                            placeholder="seu@email.com"
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

                <div class="pt-2">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="sendResetLink"
                        class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-extrabold text-sm transition"
                        style="background: #16a3b7; color: white; box-shadow: 0 2px 0 #0e7a8a; font-family: 'Syne', sans-serif;"
                        onmouseover="this.style.background='#13919e'"
                        onmouseout="this.style.background='#16a3b7'"
                    >
                        <span wire:loading.remove wire:target="sendResetLink" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
                            Enviar link de recuperação
                        </span>
                        <span wire:loading wire:target="sendResetLink" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                            Enviando...
                        </span>
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>