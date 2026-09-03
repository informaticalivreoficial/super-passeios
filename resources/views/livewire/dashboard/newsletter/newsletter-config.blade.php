<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-cog mr-2"></i> {{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.newsletter.index') }}">Newsletter</a></li>
                        <li class="breadcrumb-item active">Configurações</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">

        {{-- CARD: REMETENTE --}}
        <div class="bg-white rounded-2xl overflow-hidden mb-4" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Remetente</h2>
                    <p class="text-xs" style="color: #87c2c0;">Configurações de quem envia o e-mail.</p>
                </div>
            </div>

            <div class="p-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-bold" style="color: #051e34;">Nome do remetente *</label>
                            <input type="text" wire:model="from_name" class="input-pagbank input-pagbank-default"
                                placeholder="Ex: SuperPasseios">
                            @error('from_name') <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-bold" style="color: #051e34;">E-mail do remetente</label>
                            <input type="email" wire:model="from_email" class="input-pagbank input-pagbank-default"
                                placeholder="padrão: config do sistema">
                            @error('from_email') <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-bold" style="color: #051e34;">Responder para</label>
                            <input type="email" wire:model="reply_to" class="input-pagbank input-pagbank-default"
                                placeholder="Ex: sac@superpasseios.com.br">
                            @error('reply_to') <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD: RODAPÉ --}}
        <div class="bg-white rounded-2xl overflow-hidden mb-4" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(35,197,94,0.1);">
                        <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold" style="color: #051e34;">Rodapé do E-mail</h2>
                        <p class="text-xs" style="color: #87c2c0;">Texto e link de descadastro automático.</p>
                    </div>
                </div>
                <label class="flex items-center gap-2 cursor-pointer mb-0">
                    <input type="checkbox" wire:model="show_footer" class="w-4 h-4 rounded border-gray-300 text-cyan-500 focus:ring-cyan-500">
                    <span class="text-sm font-bold" style="color: #051e34;">Exibir rodapé</span>
                </label>
            </div>

            <div class="p-6" style="{{ !$show_footer ? 'opacity:0.5;pointer-events:none;' : '' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-bold" style="color: #051e34;">Texto do rodapé *</label>
                            <input type="text" wire:model="footer_text" class="input-pagbank input-pagbank-default"
                                placeholder="Ex: Você recebeu este e-mail porque está inscrito na nossa newsletter.">
                            @error('footer_text') <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-bold" style="color: #051e34;">Texto do link de descadastro *</label>
                            <input type="text" wire:model="unsubscribe_text" class="input-pagbank input-pagbank-default"
                                placeholder="Ex: Clique aqui para cancelar sua inscrição">
                            @error('unsubscribe_text') <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-bold" style="color: #051e34;">Cor de fundo</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" wire:model="footer_background" class="w-10 h-10 rounded-lg border-0 cursor-pointer" style="padding:0;">
                                <input type="text" wire:model="footer_background" class="input-pagbank input-pagbank-default flex-grow-1" style="font-family: monospace;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-bold" style="color: #051e34;">Cor do texto</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" wire:model="footer_text_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer" style="padding:0;">
                                <input type="text" wire:model="footer_text_color" class="input-pagbank input-pagbank-default flex-grow-1" style="font-family: monospace;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-sm font-bold" style="color: #051e34;">Cor do link</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" wire:model="footer_link_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer" style="padding:0;">
                                <input type="text" wire:model="footer_link_color" class="input-pagbank input-pagbank-default flex-grow-1" style="font-family: monospace;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <label class="flex items-center gap-2 cursor-pointer mb-0">
                            <input type="checkbox" wire:model="show_address" class="w-4 h-4 rounded border-gray-300 text-cyan-500 focus:ring-cyan-500">
                            <span class="text-sm font-bold" style="color: #051e34;">Mostrar endereço da empresa no rodapé</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD: PREVIEW --}}
        <div class="bg-white rounded-2xl overflow-hidden mb-4" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(124,58,237,0.1);">
                    <svg class="w-5 h-5" style="color: #7c3aed;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Prévia do Rodapé</h2>
                    <p class="text-xs" style="color: #87c2c0;">Como vai aparecer no e-mail enviado.</p>
                </div>
            </div>

            <div class="p-6">
                <div class="rounded-xl overflow-hidden" style="border: 1px solid #e5e7eb;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="padding:24px 20px;background:{{ $footer_background }};text-align:center;">
                                <p style="margin:0 0 8px 0;font-size:12px;color:{{ $footer_text_color }};">{{ $footer_text }}</p>
                                <p style="margin:0 0 8px 0;font-size:12px;color:{{ $footer_text_color }};">
                                    <a href="#" style="color:{{ $footer_link_color }};text-decoration:underline;font-weight:600;">{{ $unsubscribe_text }}</a>
                                </p>
                                <p style="margin:0;font-size:10px;color:{{ $footer_text_color }};">&copy; {{ date('Y') }} Super Passeios. Todos os direitos reservados.</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- AÇÕES --}}
        <div class="flex justify-end gap-3 mb-6">
            <a href="{{ route('admin.newsletter.index') }}"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition"
                style="border: 1px solid #e8e4d8; background: white; color: #87c2c0;">
                Cancelar
            </a>
            <button type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-extrabold transition"
                style="background-color: #23c55e; color: #051e34; box-shadow: 0 2px 0 #15803d;">
                <span wire:loading.remove wire:target="save">
                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                    Salvar
                </span>
                <span wire:loading wire:target="save">
                    <svg class="w-4 h-4 inline animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    Salvando...
                </span>
            </button>
        </div>

    </form>
</div>
