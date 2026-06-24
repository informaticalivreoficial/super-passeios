{{-- resources/views/livewire/booking-form-improved.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4">
    <div class="max-w-2xl mx-auto">
        
        {{-- Header com gradiente --}}
        <div class="text-center mb-8">
            <img class="h-20 w-auto mx-auto" src="{{ $config->getlogo() }}" alt="{{ $config->app_name }}">
            <p class="text-gray-500 mt-2">Complete sua reserva em 3 passos!</p>
        </div>

        {{-- Progress Bar Animada --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                @foreach(['Resumo', 'Seus dados', 'Pagamento'] as $index => $stepName)
                    <div class="flex items-center {{ $index < 2 ? 'flex-1' : '' }}">
                        {{-- Círculo do step --}}
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 
                                {{ $step > $index + 1 ? 'bg-green-500' : ($step === $index + 1 ? 'bg-blue-600' : 'bg-gray-200') }}">
                                @if($step > $index + 1)
                                    {{-- Check icon --}}
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    <span class="text-sm font-semibold {{ $step === $index + 1 ? 'text-white' : 'text-gray-500' }}">
                                        {{ $index + 1 }}
                                    </span>
                                @endif
                            </div>
                            <span class="absolute -bottom-6 left-1/2 transform -translate-x-1/2 text-xs font-medium
                                {{ $step >= $index + 1 ? 'text-blue-600' : 'text-gray-400' }} whitespace-nowrap">
                                {{ $stepName }}
                            </span>
                        </div>
                        
                        {{-- Linha de conexão --}}
                        @if($index < 2)
                            <div class="flex-1 h-1 mx-2 rounded transition-all duration-300
                                {{ $step > $index + 1 ? 'bg-green-500' : ($step === $index + 1 ? 'bg-blue-200' : 'bg-gray-200') }}">
                                @if($step > $index + 1)
                                    <div class="h-full bg-green-500 rounded animate-pulse"></div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Card do Tour com Gradiente --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 transform transition-all duration-300 hover:shadow-2xl">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center">
                        <img class="w-16 h-16 object-cover rounded-lg" 
                            src="{{ $tourDate->tour->cover() }}" 
                            alt="{{ $tourDate->tour->title }}">
                    </div>
                    <div class="text-white">
                        <h2 class="font-bold text-lg">{{ $tourDate->tour->title }}</h2>
                        <div class="flex gap-4 text-sm text-blue-100">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $tourDate->date->format('d/m/Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $tourDate->start_time }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-auto text-right">
                        <div class="text-2xl font-bold text-white">R$ {{ number_format($total, 2, ',', '.') }}</div>
                        <div class="text-xs text-blue-100">total</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 1: Resumo/Quantidades --}}
        @if($step === 1)
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Quantas pessoas?
                </h3>

                {{-- Adultos --}}
                <div class="bg-gradient-to-r from-blue-50 to-white p-4 rounded-xl mb-4 border border-blue-100 hover:shadow-md transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Adultos
                            </div>
                            <div class="text-sm text-gray-500 mt-1">R$ {{ number_format($tourDate->price, 2, ',', '.') }} por pessoa</div>
                        </div>
                        <div class="flex items-center gap-4">
                            <button wire:click="$set('adults', {{ max(1, $adults - 1) }})" 
                                class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 
                                    flex items-center justify-center text-gray-600 hover:text-blue-600 transition-all duration-200">
                                −
                            </button>
                            <span class="text-xl font-bold text-gray-800 min-w-[2rem] text-center">{{ $adults }}</span>
                            <button wire:click="$set('adults', {{ $adults + 1 }})"
                                class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 
                                    text-white flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                +
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Crianças (se houver meia entrada) --}}
                @if($tourDate->half_price)
                    <div class="bg-gradient-to-r from-orange-50 to-white p-4 rounded-xl mb-6 border border-orange-200 hover:shadow-md transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                                    </svg>
                                    Crianças
                                    <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-medium">meia entrada</span>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">R$ {{ number_format($tourDate->half_price, 2, ',', '.') }} por criança</div>
                            </div>
                            <div class="flex items-center gap-4">
                                <button wire:click="$set('children', {{ max(0, $children - 1) }})"
                                    class="w-10 h-10 rounded-lg border-2 border-gray-200 hover:border-orange-400 hover:bg-orange-50 
                                        flex items-center justify-center text-gray-600 hover:text-orange-600 transition-all duration-200">
                                    −
                                </button>
                                <span class="text-xl font-bold text-gray-800 min-w-[2rem] text-center">{{ $children }}</span>
                                <button wire:click="$set('children', {{ $children + 1 }})"
                                    class="w-10 h-10 rounded-lg bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 
                                        text-white flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Vagas disponíveis --}}
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl mb-6 border border-green-200">
                    <div class="flex items-center gap-2 text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">{{ $tourDate->available_slots }} vagas disponíveis nesta data</span>
                    </div>
                </div>

                @error('adults') 
                    <div class="text-red-500 text-sm mb-4">{{ $message }}</div>
                @enderror

                <div class="flex gap-3 mt-8">
                    <button onclick="window.history.back()"
                        class="flex-1 border-2 border-gray-200 hover:border-blue-400 text-gray-600 hover:text-blue-600 
                            font-semibold py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Voltar
                    </button>
                    <button wire:click="nextStep"
                        class="flex-[2] bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                            text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl 
                            transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                        Continuar
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>                
            </div>
        @endif

        {{-- STEP 2: Dados do Cliente --}}
        @if($step === 2)
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                    </svg>
                    Seus dados
                </h3>

                {{-- Inputs com ícones contextuais --}}
                <div class="space-y-5">
                    {{-- Nome --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Nome completo
                        </label>
                        <div class="relative">
                            <input wire:model="name" type="text" 
                                class="w-full pl-4 pr-4 py-3 rounded-xl border-2 border-gray-200 
                                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200 
                                    transition-all duration-300 outline-none"
                                placeholder="Como está no documento">
                        </div>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            E-mail
                        </label>
                        <div class="relative">
                            <input wire:model="email" type="email" 
                                class="w-full pl-4 pr-4 py-3 rounded-xl border-2 border-gray-200 
                                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200 
                                    transition-all duration-300 outline-none"
                                placeholder="seu@email.com">
                        </div>
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Telefone --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Telefone / WhatsApp
                        </label>
                        <div class="relative">
                            <input wire:model="phone" type="tel" 
                                class="w-full pl-4 pr-4 py-3 rounded-xl border-2 border-gray-200 
                                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200 
                                    transition-all duration-300 outline-none"
                                placeholder="(00) 00000-0000">
                        </div>
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- CPF --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                            </svg>
                            CPF
                        </label>
                        <div class="relative">
                            <input wire:model="cpf" type="text" 
                                class="w-full pl-4 pr-4 py-3 rounded-xl border-2 border-gray-200 
                                    focus:border-blue-500 focus:ring-2 focus:ring-blue-200 
                                    transition-all duration-300 outline-none"
                                placeholder="000.000.000-00">
                        </div>
                        @error('cpf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button wire:click="prevStep"
                        class="flex-1 border-2 border-gray-200 hover:border-blue-400 text-gray-600 hover:text-blue-600 
                            font-semibold py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Voltar
                    </button>
                    <button wire:click="nextStep"
                        class="flex-[2] bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                            text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl 
                            transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                        Continuar para pagamento
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- STEP 3: Pagamento --}}
        @if($step === 3)
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Forma de pagamento
                </h3>

                {{-- Métodos de pagamento --}}
                <div class="grid grid-cols-2 gap-4 mb-6">
                    {{-- PIX --}}
                    <button wire:click="$set('paymentMethod', 'pix')"
                        class="p-4 rounded-xl border-2 transition-all duration-300 
                            {{ $paymentMethod === 'pix' ? 'border-green-500 bg-green-50 shadow-lg' : 'border-gray-200 hover:border-green-300' }}">
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" viewBox="0 0 512 512" fill="currentColor">
                                    <path d="M242.4 292.5C247.8 287.1 257.1 287.1 262.5 292.5L339.5 369.5C357.6 387.6 387.4 387.6 405.5 369.5L412.5 362.5L331.5 281.5C313.4 263.4 313.4 233.6 331.5 215.5L412.5 134.5L405.5 127.5C387.4 109.4 357.6 109.4 339.5 127.5L262.5 204.5C257.1 209.9 247.8 209.9 242.4 204.5L165.5 127.5C147.4 109.4 117.6 109.4 99.5 127.5L92.5 134.5L173.5 215.5C191.6 233.6 191.6 263.4 173.5 281.5L92.5 362.5L99.5 369.5C117.6 387.6 147.4 387.6 165.5 369.5L242.4 292.5z"/>
                                </svg>
                            </div>
                            <div class="font-semibold text-gray-800">PIX</div>
                            <div class="text-xs text-gray-500">Aprovação imediata</div>
                        </div>
                    </button>

                    {{-- Cartão --}}
                    <button wire:click="$set('paymentMethod', 'card')"
                        class="p-4 rounded-xl border-2 transition-all duration-300 
                            {{ $paymentMethod === 'card' ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200 hover:border-blue-300' }}">
                        <div class="text-center">
                            <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="1" y="4" width="22" height="16" rx="2"/>
                                    <path d="M1 10h22"/>
                                </svg>
                            </div>
                            <div class="font-semibold text-gray-800">Cartão</div>
                            <div class="text-xs text-gray-500">Crédito ou débito</div>
                        </div>
                    </button>
                </div>

                {{-- Total --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total a pagar</span>
                        <span class="text-2xl font-bold text-blue-600">R$ {{ number_format($total, 2, ',', '.') }}</span>
                    </div>
                </div>

                @if($errorMsg)
                    <div class="bg-red-50 border border-red-200 p-4 rounded-xl mb-6 text-red-600">
                        {{ $errorMsg }}
                    </div>
                @endif

                <div class="flex gap-3">
                    <button wire:click="prevStep"
                        class="flex-1 border-2 border-gray-200 hover:border-blue-400 text-gray-600 hover:text-blue-600 
                            font-semibold py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Voltar
                    </button>
                    <button wire:click="pay" wire:loading.attr="disabled"
                        class="flex-[2] bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 
                            text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl 
                            transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2
                            disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="pay">
                            {{ $paymentMethod === 'pix' ? 'Gerar QR Code PIX' : 'Pagar agora' }}
                        </span>
                        <span wire:loading wire:target="pay">Processando...</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- STEP 4: Confirmação PIX --}}
        @if($step === 4 && $pixData)
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center transform transition-all duration-300">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Quase lá!</h3>
                <p class="text-gray-500 mb-6">Escaneie o QR Code ou copie o código PIX abaixo</p>

                @if($pixData['qr_code_base64'])
                    <img src="data:image/png;base64,{{ $pixData['qr_code_base64'] }}" 
                        class="w-48 h-48 mx-auto mb-6 rounded-xl shadow-lg" alt="QR Code PIX">
                @endif

                <div class="bg-gray-50 p-4 rounded-xl mb-4">
                    <div class="flex gap-2">
                        <code class="flex-1 text-xs text-gray-600 break-all text-left">{{ $pixData['qr_code'] }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $pixData['qr_code'] }}')"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold 
                                transition-all duration-300 whitespace-nowrap">
                            Copiar
                        </button>
                    </div>
                </div>

                <p class="text-sm text-gray-500">
                    ⏱ O código expira em <strong>30 minutos</strong>.<br>
                    Após o pagamento, você receberá a confirmação por e-mail.
                </p>
            </div>
        @endif

    </div>
</div>

@push('scripts')
@if($step === 3 && $paymentMethod === 'card')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    const mp = new MercadoPago('{{ config("services.mercadopago.public_key") }}', { locale: 'pt-BR' });
    const cardForm = mp.cardForm({
        amount: "{{ $total }}",
        iframe: true,
        form: {
            id: "mp-card-form",
            cardNumber:     { id: "cardNumber",     placeholder: "Número do cartão" },
            expirationDate: { id: "expirationDate", placeholder: "MM/AA" },
            securityCode:   { id: "securityCode",   placeholder: "CVV" },
            cardholderName: { id: "cardholderName", placeholder: "Nome no cartão" },
            issuer:         { id: "issuer",         placeholder: "Banco emissor" },
            installments:   { id: "installments",   placeholder: "Parcelas" },
        },
        callbacks: {
            onFormMounted: error => { if (error) console.warn('Form error:', error); },
            onSubmit: async (event) => {
                event.preventDefault();
                const { paymentMethodId, token, installments } = cardForm.getCardFormData();
                @this.set('cardToken', token);
                @this.set('paymentMethodId', paymentMethodId);
                @this.set('installments', installments);
                @this.call('pay');
            },
        },
    });
</script>
@endif
@endpush