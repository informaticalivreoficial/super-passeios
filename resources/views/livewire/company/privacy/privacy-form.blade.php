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

    {{-- CARD: DADOS ARMAZENADOS --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

        <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(51,123,188,0.1);">
                <svg class="w-5 h-5" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold" style="color: #051e34;">Dados Armazenados</h2>
                <p class="text-xs" style="color: #87c2c0;">Informações que mantemos sobre sua conta.</p>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-start gap-3 p-3 rounded-xl" style="background-color: #f8fafc;">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <div>
                        <p class="text-xs font-bold" style="color: #051e34;">Dados pessoais</p>
                        <p class="text-xs" style="color: #b0a98a;">Nome, e-mail, telefone, CPF/CNPJ</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 rounded-xl" style="background-color: #f8fafc;">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <div>
                        <p class="text-xs font-bold" style="color: #051e34;">Dados bancários</p>
                        <p class="text-xs" style="color: #b0a98a;">Conta e agência para repasse</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 rounded-xl" style="background-color: #f8fafc;">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <div>
                        <p class="text-xs font-bold" style="color: #051e34;">Contratos</p>
                        <p class="text-xs" style="color: #b0a98a;">Termos aceitos e versões</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 rounded-xl" style="background-color: #f8fafc;">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <div>
                        <p class="text-xs font-bold" style="color: #051e34;">Passeios e reservas</p>
                        <p class="text-xs" style="color: #b0a98a;">Embarcações, tours e bookings</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- CARD: O QUE ACONTECE AO EXCLUIR --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

        <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(245,158,11,0.1);">
                <svg class="w-5 h-5" style="color: #f59e0b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-bold" style="color: #051e34;">Ao solicitar a exclusão</h2>
                <p class="text-xs" style="color: #87c2c0;">O que acontece com seus dados.</p>
            </div>
        </div>

        <div class="p-6 space-y-3">
            <div class="flex items-start gap-3">
                <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background-color: rgba(229,62,62,0.1);">
                    <svg class="w-3 h-3" style="color: #e53e3e;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold" style="color: #051e34;">Seus passeios serão removidos</p>
                    <p class="text-xs" style="color: #b0a98a;">Tours, embarcações e datas serão excluídos permanentemente.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background-color: rgba(229,62,62,0.1);">
                    <svg class="w-3 h-3" style="color: #e53e3e;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold" style="color: #051e34;">Reservas ativas serão afetadas</p>
                    <p class="text-xs" style="color: #b0a98a;">Clientes não conseguirão mais acessar reservas futuras vinculadas.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background-color: rgba(229,62,62,0.1);">
                    <svg class="w-3 h-3" style="color: #e53e3e;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold" style="color: #051e34;">Saldo pendente será cancelado</p>
                    <p class="text-xs" style="color: #b0a98a;">Valores não sacados serão perdidos. solicite o saque antes.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background-color: rgba(229,62,62,0.1);">
                    <svg class="w-3 h-3" style="color: #e53e3e;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div>
                    <p class="text-xs font-bold" style="color: #051e34;">Dados financeiros serão apagados</p>
                    <p class="text-xs" style="color: #b0a98a;">Transações, saques e dados bancários serão removidos.</p>
                </div>
            </div>
        </div>

    </div>

</div>
