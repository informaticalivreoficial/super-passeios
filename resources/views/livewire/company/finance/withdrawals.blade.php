<div class="max-w-6xl mx-auto space-y-6">    

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- COLUNA ESQUERDA --}}
        <div class="lg:col-span-5 space-y-5">

            {{-- SALDO --}}
            <div class="rounded-3xl p-6 text-white" style="background: linear-gradient(135deg, #051e34 0%, #0a3358 100%);">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-widest" style="color: #87c2c0;">Saldo Disponível</span>
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background: rgba(255,255,255,0.08);">
                        <svg class="w-5 h-5" style="color: #fadd37;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="text-base font-semibold" style="color: #87c2c0;">R$</span>
                    <span class="text-4xl font-extrabold text-white">{{ number_format($balance, 2, ',', '.') }}</span>
                </div>
                <p class="text-xs mt-2" style="color: #87c2c0;">Valor disponível para saque imediato</p>
            </div>

            {{-- FORMULÁRIO --}}
            <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">

                <h3 class="font-extrabold text-base mb-5 flex items-center gap-2" style="color: #051e34;">
                    Nova Solicitação
                    <div wire:loading wire:target="requestWithdrawal">
                        <svg class="animate-spin h-4 w-4" style="color: #16a3b7;" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                        </svg>
                    </div>
                </h3>

                <form wire:submit.prevent="requestWithdrawal" class="space-y-5">

                    {{-- CONTA DE DESTINO --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest mb-3" style="color: #87c2c0;">
                            Conta de Destino
                        </label>
                        <div class="space-y-2">
                            @forelse($bankAccounts as $account)
                                <label class="flex items-center gap-3 p-3 rounded-2xl cursor-pointer transition"
                                    wire:click="$set('selectedAccountId', {{ $account->id }})"
                                    style="border: 2px solid {{ $selectedAccountId == $account->id ? '#23c55e' : '#e8e4d8' }}; background: {{ $selectedAccountId == $account->id ? 'rgba(35,197,94,0.04)' : 'white' }};">

                                    {{-- remove o input radio hidden --}}

                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                                        style="background: {{ $account->type === 'pix' ? 'rgba(35,197,94,0.1)' : 'rgba(22,163,183,0.1)' }};">
                                        @if($account->type === 'pix')
                                            <svg class="w-4 h-4" style="color: #23c55e;" viewBox="0 0 512 512" fill="currentColor">
                                                <path d="M242.4 292.5C247.8 287.1 257.1 287.1 262.5 292.5L339.5 369.5C357.6 387.6 387.4 387.6 405.5 369.5L412.5 362.5L331.5 281.5C313.4 263.4 313.4 233.6 331.5 215.5L412.5 134.5L405.5 127.5C387.4 109.4 357.6 109.4 339.5 127.5L262.5 204.5C257.1 209.9 247.8 209.9 242.4 204.5L165.5 127.5C147.4 109.4 117.6 109.4 99.5 127.5L92.5 134.5L173.5 215.5C191.6 233.6 191.6 263.4 173.5 281.5L92.5 362.5L99.5 369.5C117.6 387.6 147.4 387.6 165.5 369.5L242.4 292.5z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M3 21h18M3 10h18M3 6l9-3 9 3M4 10v11M8 10v11M12 10v11M16 10v11M20 10v11"/>
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold truncate" style="color: #051e34;">{{ $account->label }}</p>
                                        <p class="text-xs truncate" style="color: #87c2c0;">{{ $account->holder_name }}</p>
                                    </div>

                                    @if($account->is_default)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0"
                                            style="background: rgba(35,197,94,0.1); color: #15803d;">
                                            Principal
                                        </span>
                                    @endif

                                    @if($selectedAccountId == $account->id)
                                        <svg class="w-5 h-5 shrink-0" style="color: #23c55e;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif

                                </label>
                            @empty
                                <div class="p-4 rounded-2xl text-center" style="border: 2px dashed #e8e4d8;">
                                    <p class="text-xs mb-2" style="color: #87c2c0;">Nenhuma conta cadastrada.</p>
                                    <a href="{{ route('company.finance.banks') }}"
                                       class="text-xs font-bold" style="color: #16a3b7;">
                                        Cadastrar conta
                                    </a>
                                </div>
                            @endforelse
                        </div>
                        @error('selectedAccountId')
                            <p class="text-xs mt-1.5 font-semibold" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- VALOR --}}
                    <div x-data="{
                        displayValue: '',
                        formatMoney(value) {
                            if (!value) return '';
                            value = value.replace(/\D/g, '');
                            value = (parseInt(value) / 100).toFixed(2).replace('.', ',');
                            return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        },
                        updateAmount(val) {
                            this.displayValue = this.formatMoney(val);
                            let numericValue = val.replace(/\D/g, '');
                            $wire.set('amount', (parseInt(numericValue || 0) / 100).toFixed(2));
                        }
                    }">
                        <label class="block text-xs font-bold uppercase tracking-widest mb-2" style="color: #87c2c0;">
                            Valor do saque
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-bold" style="color: #87c2c0;">R$</span>
                            <input
                                type="text"
                                x-model="displayValue"
                                x-on:input="updateAmount($event.target.value)"
                                placeholder="0,00"
                                class="w-full h-12 pl-12 pr-4 rounded-2xl text-sm font-bold outline-none transition"
                                style="border: 1.5px solid #e8e4d8; color: #051e34;"
                                onfocus="this.style.borderColor='#16a3b7'"
                                onblur="this.style.borderColor='#e8e4d8'"
                            >
                        </div>
                        @error('amount')
                            <p class="text-xs mt-1.5 font-semibold" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>                    

                    <button type="submit"
                        wire:loading.attr="disabled"
                        class="w-full h-12 rounded-2xl text-sm font-bold transition"
                        style="background: #051e34; color: white;">
                        <span wire:loading.remove wire:target="requestWithdrawal">Confirmar Solicitação</span>
                        <span wire:loading wire:target="requestWithdrawal">Processando...</span>
                    </button>

                </form>

                @if($successMsg)
                    <div class="mt-4 p-4 rounded-2xl flex items-center gap-2 text-sm font-semibold"
                         style="background: rgba(35,197,94,0.08); color: #15803d;">
                        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $successMsg }}
                    </div>
                @endif

            </div>
        </div>

        {{-- COLUNA DIREITA --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl overflow-hidden" style="border: 1px solid #e8e4d8;">

                <div class="px-6 py-4 flex items-center justify-between" style="border-bottom: 1px solid #f5f2ec;">
                    <h3 class="font-extrabold text-base" style="color: #051e34;">Histórico de Saques</h3>
                    <span class="text-xs font-bold uppercase tracking-widest" style="color: #c5bfb2;">Últimos registros</span>
                </div>

                @if($withdrawals->isEmpty())
                    <div class="p-16 text-center">
                        <div class="w-16 h-16 mx-auto rounded-3xl flex items-center justify-center mb-4"
                             style="background: rgba(22,163,183,0.08);">
                            <svg class="w-8 h-8" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12l7 7 7-7"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold" style="color: #87c2c0;">Nenhum saque solicitado ainda.</p>
                    </div>
                @else
                    <div class="divide-y" style="border-color: #f5f2ec;">
                        @foreach($withdrawals as $withdrawal)
                            @php
                                $statusLabel = match($withdrawal->status) {
                                    'requested' => 'Aguardando',
                                    'approved'  => 'Aprovado',
                                    'paid'      => 'Pago',
                                    'rejected'  => 'Recusado',
                                    default     => $withdrawal->status,
                                };
                                $statusStyle = match($withdrawal->status) {
                                    'requested' => ['bg' => 'rgba(245,158,11,0.1)',  'color' => '#d97706'],
                                    'approved'  => ['bg' => 'rgba(22,163,183,0.1)',  'color' => '#16a3b7'],
                                    'paid'      => ['bg' => 'rgba(35,197,94,0.1)',   'color' => '#15803d'],
                                    'rejected'  => ['bg' => 'rgba(239,68,68,0.1)',   'color' => '#dc2626'],
                                    default     => ['bg' => 'rgba(0,0,0,0.05)',      'color' => '#64748b'],
                                };
                            @endphp
                            <div class="px-6 py-4 flex items-center gap-4">

                                <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0"
                                     style="background: rgba(5,30,52,0.06);">
                                    <svg class="w-5 h-5" style="color: #051e34;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 5v14M5 12l7 7 7-7"/>
                                    </svg>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold" style="color: #051e34;">
                                        R$ {{ number_format($withdrawal->amount, 2, ',', '.') }}
                                    </p>
                                    <p class="text-xs" style="color: #c5bfb2;">
                                        {{ $withdrawal->created_at->format('d/m/Y \à\s H:i') }}
                                    </p>
                                    @if($withdrawal->notes)
                                        <p class="text-xs truncate mt-0.5" style="color: #87c2c0;">
                                            {{ $withdrawal->notes }}
                                        </p>
                                    @endif
                                </div>

                                <span class="px-3 py-1 rounded-full text-xs font-bold shrink-0"
                                      style="background: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['color'] }};">
                                    {{ $statusLabel }}
                                </span>

                            </div>
                        @endforeach
                    </div>

                    @if($withdrawals->hasPages())
                        <div class="px-6 py-4" style="border-top: 1px solid #f5f2ec;">
                            {{ $withdrawals->links() }}
                        </div>
                    @endif
                @endif

            </div>
        </div>

    </div>

</div>