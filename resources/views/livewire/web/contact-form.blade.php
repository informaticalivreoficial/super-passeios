<div class="contact-form">
    @php
        $inputBase = 'w-full pl-12 pr-4 py-4 rounded-2xl border-2 focus:ring-4 focus:ring-blue-100 transition-all duration-300 outline-none text-gray-800 font-medium bg-gray-50 focus:bg-white';
        $erroInput = 'border-red-400 focus:border-red-500';
        $okInput = 'border-gray-200 focus:border-blue-500';
    @endphp

    @if ($enviado)
        <div class="text-center py-8">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-800 mb-3">Mensagem enviada com sucesso!</h3>
            <p class="text-gray-500 mb-2">Obrigado pelo contato. Nossa equipe retornará em breve.</p>
            <p class="text-sm text-gray-400 mb-8">Responderemos pelo e-mail informado.</p>
            <button
                type="button"
                wire:click="novaMensagem"
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                Enviar nova mensagem
            </button>
        </div>
    @else
        <form wire:submit="submit" autocomplete="off" novalidate class="space-y-6">

            {{-- Honeypot: invisível para pessoas, atrativo para bots --}}
            <div class="hp-wrapper" aria-hidden="true" tabindex="-1" style="display: none !important;">
                <input type="text" id="hp-a" name="hp_campo_a" tabindex="-1" autocomplete="off"
                    data-lpignore="true" data-1p-ignore data-bwignore data-form-type="other" wire:model="hp_campo_a">
                <input type="text" id="hp-b" name="hp_campo_b" tabindex="-1" autocomplete="off"
                    data-lpignore="true" data-1p-ignore data-bwignore data-form-type="other" wire:model="hp_campo_b">
            </div>

            {{-- Erro geral do formulário --}}
            @error('form')
                <div class="flex items-start gap-2 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            {{-- Nome --}}
            <div>
                <label for="contact-name" class="block text-sm font-bold text-gray-700 mb-2">Seu nome</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input
                        id="contact-name"
                        wire:model.blur="name"
                        type="text"
                        placeholder="Como podemos te chamar?"
                        autocomplete="name"
                        aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                        class="{{ $inputBase }} {{ $errors->has('name') ? $erroInput : $okInput }}">
                </div>
                @error('name')
                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- E-mail --}}
            <div>
                <label for="contact-email" class="block text-sm font-bold text-gray-700 mb-2">E-mail</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input
                        id="contact-email"
                        wire:model.blur="email"
                        type="email"
                        placeholder="voce@email.com"
                        autocomplete="email"
                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        class="{{ $inputBase }} {{ $errors->has('email') ? $erroInput : $okInput }}">
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- WhatsApp --}}
            <div>
                <label for="contact-phone" class="block text-sm font-bold text-gray-700 mb-2">
                    WhatsApp / Telefone <span class="font-normal text-gray-400">(opcional)</span>
                </label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <input
                        id="contact-phone"
                        wire:model.blur="whatsapp"
                        type="tel"
                        placeholder="(00) 00000-0000"
                        autocomplete="tel"
                        aria-invalid="{{ $errors->has('whatsapp') ? 'true' : 'false' }}"
                        class="{{ $inputBase }} {{ $errors->has('whatsapp') ? $erroInput : $okInput }}">
                </div>
                @error('whatsapp')
                    <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Mensagem --}}
            <div>
                <label for="contact-message" class="block text-sm font-bold text-gray-700 mb-2">Como podemos ajudar?</label>
                <div class="relative group">
                    <div class="absolute top-4 left-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <textarea
                        id="contact-message"
                        wire:model.blur="message"
                        rows="5"
                        placeholder="Descreva sua dúvida, sugestão ou necessidade..."
                        aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}"
                        class="{{ $inputBase }} {{ $errors->has('message') ? $erroInput : $okInput }} resize-none"
                    ></textarea>
                </div>
                <div class="flex justify-between items-center mt-2 gap-4">
                    @error('message')
                        <p class="text-red-500 text-sm flex items-center gap-1">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @else
                        <span></span>
                    @enderror
                    <span class="text-xs text-gray-400 whitespace-nowrap">Mínimo 10 caracteres</span>
                </div>
            </div>

            {{-- Botão Enviar --}}
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="submit"
                class="w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600
                    hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700
                    text-white font-extrabold py-4 rounded-2xl shadow-xl hover:shadow-2xl
                    transform hover:scale-[1.02] transition-all duration-300
                    flex items-center justify-center gap-3 group disabled:opacity-70 disabled:cursor-wait">
                <span wire:loading.remove wire:target="submit">Enviar mensagem</span>
                <span wire:loading wire:target="submit">Enviando...</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Info de privacidade --}}
            <p class="text-xs text-gray-400 text-center">
                Seus dados estão seguros e não serão compartilhados.
            </p>

        </form>

        <style>
            .contact-form .hp-wrapper {
                display: none !important;
            }
        </style>
    @endif
</div>
