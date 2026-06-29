<div class="min-h-screen bg-slate-50/50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Gestão de Saques</h1>
            <p class="text-slate-500 text-sm">Gerencie seu saldo e solicite transferências para sua conta.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Coluna da Esquerda: Solicitação --}}
            <div class="lg:col-span-5 space-y-6">
                
                {{-- Card de Saldo --}}
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-6 text-white shadow-xl shadow-blue-200">
                    <div class="flex justify-between items-start mb-4">
                        <span class="text-blue-100 text-xs font-bold uppercase tracking-wider">Saldo Disponível</span>
                        <div class="p-2 bg-white/10 rounded-lg backdrop-blur-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xl font-medium text-blue-200">R$</span>
                        <h2 class="text-4xl font-bold">{{ number_format($balance, 2, ',', '.') }}</h2>
                    </div>
                </div>

                {{-- Formulário de Saque --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        Nova Solicitação
                        <div wire:loading wire:target="requestWithdrawal">
                            <svg class="animate-spin h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>
                    </h3>
                    
                    <form wire:submit.prevent="requestWithdrawal" class="space-y-6">
                        {{-- Seleção de Conta --}}
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Conta de Destino</label>
                            <div class="space-y-3">
                                @forelse($bankAccounts as $account)
                                    <label class="relative flex items-center p-3 cursor-pointer rounded-2xl border-2 transition-all {{ $selectedAccountId == $account->id ? 'border-blue-600 bg-blue-50/50' : 'border-slate-100 hover:border-slate-200' }}">
                                        <input type="radio" wire:model="selectedAccountId" value="{{ $account->id }}" class="sr-only">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-bold text-slate-700">{{ $account->label }}</span>
                                                @if($account->is_default)
                                                    <span class="text-[8px] bg-blue-600 text-white px-1.5 py-0.5 rounded-full uppercase">Padrão</span>
                                                @endif
                                            </div>
                                            <p class="text-[10px] text-slate-500 uppercase">{{ $account->holder_name }}</p>
                                        </div>
                                        @if($selectedAccountId == $account->id)
                                            <div class="text-blue-600">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            </div>
                                        @endif
                                    </label>
                                @empty
                                    <div class="p-4 border-2 border-dashed border-slate-200 rounded-2xl text-center">
                                        <p class="text-xs text-slate-500 mb-2">Nenhuma conta cadastrada.</p>
                                        <a href="#" class="text-blue-600 font-bold text-[10px] uppercase hover:underline">Cadastrar Agora</a>
                                    </div>
                                @endforelse
                            </div>
                            @error('selectedAccountId') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Valor --}}
                        <div x-data="{ 
                            displayValue: '',
                            formatMoney(value) {
                                if (!value) return '';
                                // Remove tudo que não é número
                                value = value.replace(/\D/g, '');
                                // Formata como moeda (ex: 1000 -> 10,00)
                                value = (parseInt(value) / 100).toFixed(2).replace('.', ',');
                                // Adiciona separador de milhar
                                return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            },
                            updateAmount(val) {
                                this.displayValue = this.formatMoney(val);
                                // Envia o valor decimal puro para o Livewire (ex: 10.50)
                                let numericValue = val.replace(/\D/g, '');
                                $wire.set('amount', (parseInt(numericValue) / 100).toFixed(2));
                            }
                        }">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Quanto deseja sacar?</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">R$</span>
                                <input 
                                    type="text" 
                                    x-model="displayValue"
                                    x-on:input="updateAmount($event.target.value)"
                                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-blue-500/20 text-lg font-bold text-slate-700 outline-none transition-all"
                                    placeholder="0,00"
                                >
                            </div>
                            @error('amount') <span class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" 
                            wire:loading.attr="disabled"
                            class="w-full bg-slate-900 hover:bg-black text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                            <span>Confirmar Solicitação</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>

                    @if($successMsg)
                        <div class="mt-4 p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-sm font-medium flex items-center gap-2 animate-bounce">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ $successMsg }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Coluna da Direita: Histórico --}}
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Histórico de Movimentações</h3>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Últimos 30 dias</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Data</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Valor</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($withdrawals as $withdrawal)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-slate-700">{{ $withdrawal->created_at->format('d/m/Y') }}</p>
                                            <p class="text-[10px] text-slate-400 uppercase">{{ $withdrawal->created_at->format('H:i') }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-black text-slate-800">R$ {{ number_format($withdrawal->amount, 2, ',', '.') }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($withdrawal->isPending())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase">Aguardando</span>
                                            @elseif($withdrawal->isPaid())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Pago</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 uppercase">{{ $withdrawal->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="p-3 bg-slate-50 rounded-2xl mb-3">
                                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                                </div>
                                                <p class="text-sm text-slate-400 font-medium">Nenhum saque solicitado ainda.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($withdrawals->hasPages())
                        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-50">
                            {{ $withdrawals->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
