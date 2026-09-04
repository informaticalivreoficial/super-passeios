<div class="max-w-6xl mx-auto space-y-6">

    {{-- CARD: EXCLUSÃO DE CONTA --}}
    @if($company && $company->exists)
        <div class="rounded-2xl overflow-hidden" style="border: 1px solid #fecaca; background-color: #fff7f7;">

            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #fecaca;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(229,62,62,0.1);">
                    <svg class="w-5 h-5" style="color: #e53e3e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #e53e3e;">Exclusão de Conta</h2>
                    <p class="text-xs" style="color: #b0a98a;">Exclusão permanente da conta e de todos os dados.</p>
                </div>
            </div>

            <div class="p-6">

                @if($company->isDeletionPending())
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 shrink-0" style="color: #e53e3e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                            <div>
                                <p class="text-sm font-bold" style="color: #e53e3e;">Exclusão agendada</p>
                                <p class="text-sm mt-0.5" style="color: #7a6800;">
                                    Sua conta será excluída permanentemente em
                                    <strong>{{ $company->deletion_scheduled_for->format('d/m/Y \à\s H:i') }}</strong>.
                                </p>
                                <p class="text-xs mt-1" style="color: #b0a98a;">
                                    Você pode cancelar a exclusão dentro desse período.
                                </p>
                            </div>
                        </div>

                        <button
                            type="button"
                            wire:click="cancelDeletion"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-extrabold transition shrink-0"
                            style="background-color: #23c55e; color: #ffffff; box-shadow: 0 2px 0 #15803d;"
                            onmouseover="this.style.backgroundColor='#1aad52'"
                            onmouseout="this.style.backgroundColor='#23c55e'"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M3 12a9 9 0 109-9 9.75 9.75 0 00-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                            Cancelar exclusão
                        </button>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold" style="color: #051e34;">Excluir minha conta</p>
                            <p class="text-xs mt-1" style="color: #b0a98a;">
                                Ao solicitar, sua conta será excluída permanentemente em <strong>7 dias</strong>.
                                Dentro desse período você pode cancelar a exclusão.
                            </p>
                        </div>

                        <button
                            type="button"
                            wire:click="requestDeletion"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-extrabold transition shrink-0"
                            style="background-color: #e53e3e; color: #ffffff; box-shadow: 0 2px 0 #b83232;"
                            onmouseover="this.style.backgroundColor='#c53030'"
                            onmouseout="this.style.backgroundColor='#e53e3e'"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Solicitar exclusão da conta
                        </button>
                    </div>
                @endif

            </div>

        </div>
    @endif

    {{-- CARD: CONTRATOS --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

        <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(51,123,188,0.1);">
                <svg class="w-5 h-5" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold" style="color: #051e34;">Contratos</h2>
                <p class="text-xs" style="color: #87c2c0;">Gerencie seus contratos e termos de uso.</p>
            </div>
        </div>

        <div class="p-6">
            <p class="text-sm" style="color: #b0a98a;">Em breve.</p>
        </div>

    </div>

</div>
