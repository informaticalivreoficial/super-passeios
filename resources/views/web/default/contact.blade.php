@extends("web.$config->template.master.master")



@section('content')
<div>
    @if($success)
        {{-- Sucesso --}}
        <div class="text-center py-8">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-2xl animate-fade-up">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-800 mb-3">Mensagem enviada com sucesso!</h3>
            <p class="text-gray-500 mb-2">Obrigado pelo contato. Nossa equipe retornará em até 2 horas.</p>
            <p class="text-sm text-gray-400 mb-8">Enviamos uma confirmação para o seu e-mail.</p>
            <button 
                wire:click="$set('success', false)"
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                Enviar nova mensagem
            </button>    
        </div>
    @else
        {{-- Formulário --}}
        <form wire:submit.prevent="submit" class="space-y-6">
            
            {{-- E-mail --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">E-mail corporativo</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input 
                        wire:model.lazy="email" 
                        type="email" 
                        placeholder="voce@suaempresa.com"
                        class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 outline-none text-gray-800 font-medium bg-gray-50 focus:bg-white"
                    >
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

            {{-- Telefone --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp / Telefone</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <input 
                        wire:model.lazy="phone" 
                        type="tel" 
                        placeholder="(00) 00000-0000"
                        class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 outline-none text-gray-800 font-medium bg-gray-50 focus:bg-white"
                    >
                </div>
                @error('phone') 
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
                <label class="block text-sm font-bold text-gray-700 mb-2">Como podemos ajudar?</label>
                <div class="relative group">
                    <div class="absolute top-4 left-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <textarea 
                        wire:model.lazy="message" 
                        rows="5"
                        placeholder="Descreva sua necessidade, dúvida ou projeto..."
                        class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 outline-none text-gray-800 font-medium bg-gray-50 focus:bg-white resize-none"
                    ></textarea>
                </div>
                <div class="flex justify-between items-center mt-2">
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
                    <span class="text-xs text-gray-400">Mínimo 10 caracteres</span>
                </div>
            </div>

            {{-- Botão Enviar --}}
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 
                    hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700
                    text-white font-extrabold py-4 rounded-2xl shadow-xl hover:shadow-2xl 
                    transform hover:scale-[1.02] transition-all duration-300 
                    flex items-center justify-center gap-3 group"
            >
                <span>Enviar mensagem</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Info de privacidade --}}
            <p class="text-xs text-gray-400 text-center">
                Seus dados estão seguros e não serão compartilhados.
            </p>

        </form>
    @endif
</div>
@endsection