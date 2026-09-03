<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-paper-plane mr-2"></i> Enviar Newsletter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.newsletter.index') }}">Newsletter</a></li>
                        <li class="breadcrumb-item active">Enviar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="send">

        {{-- CARD: CONTEÚDO --}}
        <div class="bg-white rounded-2xl overflow-hidden mb-4" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Conteúdo do E-mail</h2>
                    <p class="text-xs" style="color: #87c2c0;">Assunto e corpo da mensagem.</p>
                </div>
            </div>

            <div class="p-6 space-y-5">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Assunto *</label>
                    <input
                        type="text"
                        wire:model="subject"
                        placeholder="Ex: Novidades de setembro - SuperPasseios"
                        class="input-pagbank input-pagbank-default"
                    >
                    @error('subject')
                        <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold" style="color: #051e34;">Conteúdo *</label>
                    <div class="border rounded-xl overflow-hidden" style="border-color: #e8e4d8;">
                        <x-editor-quill
                            :value="$this->body"
                            model="body"
                        />
                    </div>
                    @error('body')
                        <p class="text-xs mt-1" style="color: #e53e3e;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- CARD: DESTINATÁRIOS --}}
        <div class="bg-white rounded-2xl overflow-hidden mb-4" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(35,197,94,0.1);">
                    <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold" style="color: #051e34;">Destinatários</h2>
                    <p class="text-xs" style="color: #87c2c0;">Escolha quem vai receber este e-mail.</p>
                </div>
            </div>

            <div class="p-6 space-y-4">

                {{-- MODOS --}}
                <div class="flex gap-3">
                    <label class="flex items-center gap-3 rounded-xl border px-5 py-3 cursor-pointer transition flex-1"
                        style="border-color: {{ $recipientMode === 'all' ? '#16a3b7' : '#e8e4d8' }}; background: {{ $recipientMode === 'all' ? 'rgba(22,163,183,0.05)' : 'white' }};">
                        <input type="radio" wire:model.live="recipientMode" value="all" class="hidden">
                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0"
                            style="border-color: {{ $recipientMode === 'all' ? '#16a3b7' : '#d1d5db' }};">
                            @if($recipientMode === 'all')
                                <div class="w-2.5 h-2.5 rounded-full" style="background: #16a3b7;"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold mb-0" style="color: #051e34;">Todos os ativos</p>
                            <p class="text-xs mb-0" style="color: #87c2c0;">Envia para todos confirmados</p>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 rounded-xl border px-5 py-3 cursor-pointer transition flex-1"
                        style="border-color: {{ $recipientMode === 'selected' ? '#16a3b7' : '#e8e4d8' }}; background: {{ $recipientMode === 'selected' ? 'rgba(22,163,183,0.05)' : 'white' }};">
                        <input type="radio" wire:model.live="recipientMode" value="selected" class="hidden">
                        <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0"
                            style="border-color: {{ $recipientMode === 'selected' ? '#16a3b7' : '#d1d5db' }};">
                            @if($recipientMode === 'selected')
                                <div class="w-2.5 h-2.5 rounded-full" style="background: #16a3b7;"></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-bold mb-0" style="color: #051e34;">Selecionar assinantes</p>
                            <p class="text-xs mb-0" style="color: #87c2c0;">Escolhe individualmente</p>
                        </div>
                    </label>
                </div>

                {{-- FILTRO: MODO TODOS --}}
                @if($recipientMode === 'all')
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-bold" style="color: #051e34;">Filtrar por categoria</label>
                        <select wire:model.live="categoryId" class="input-pagbank input-pagbank-default">
                            <option value="">Todas as categorias</option>
                            @foreach($this->categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- FILTRO + LISTA: MODO SELECIONAR --}}
                @if($recipientMode === 'selected')
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-bold" style="color: #051e34;">Buscar assinantes</label>
                        <div class="flex gap-3">
                            <div class="relative flex-grow-1">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color: #87c2c0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="M21 21l-4.35-4.35"/>
                                </svg>
                                <input type="text" wire:model.live.debounce.300ms="search"
                                    placeholder="Buscar por nome ou e-mail..."
                                    class="input-pagbank input-pagbank-default pl-10">
                            </div>
                            <div class="flex-shrink-0" style="width: 200px;">
                                <select wire:model.live="categoryId" class="input-pagbank input-pagbank-default">
                                    <option value="">Todas</option>
                                    @foreach($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Select all --}}
                    <div class="flex items-center justify-between rounded-xl px-4 py-3" style="background: #f8fafc; border: 1px solid #e8e4d8;">
                        <label class="flex items-center gap-3 cursor-pointer mb-0">
                            <input type="checkbox" wire:model.live="selectAll"
                                class="w-4 h-4 rounded border-gray-300 text-cyan-500 focus:ring-cyan-500">
                            <span class="text-sm font-bold" style="color: #051e34;">
                                Selecionar todos
                            </span>
                        </label>
                        <span class="text-xs font-bold" style="color: #87c2c0;">
                            {{ count($selected) }} selecionado(s) / {{ $this->subscribers->count() }} encontrado(s)
                        </span>
                    </div>

                    {{-- LISTA --}}
                    <div class="rounded-xl overflow-hidden" style="border: 1px solid #e8e4d8; max-height: 380px; overflow-y: auto;">
                        @forelse($this->subscribers as $subscriber)
                            <label class="flex items-center gap-3 px-4 py-3 cursor-pointer mb-0"
                                style="border-bottom: 1px solid #f0ece4; background: {{ in_array($subscriber->id, $selected) ? 'rgba(22,163,183,0.05)' : 'white' }};"
                                onmouseover="this.style.backgroundColor='rgba(22,163,183,0.08)'"
                                onmouseout="this.style.backgroundColor='{{ in_array($subscriber->id, $selected) ? 'rgba(22,163,183,0.05)' : 'white' }}'">
                                <input type="checkbox" wire:model.live="selected"
                                    value="{{ $subscriber->id }}"
                                    class="w-4 h-4 rounded border-gray-300 text-cyan-500 focus:ring-cyan-500">
                                <div class="flex-grow-1 min-width-0">
                                    <p class="text-sm font-bold mb-0" style="color: #051e34;">
                                        {{ $subscriber->name ?: 'Sem nome' }}
                                    </p>
                                    <p class="text-xs mb-0" style="color: #87c2c0;">{{ $subscriber->email }}</p>
                                </div>
                                @if($subscriber->category)
                                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg shrink-0"
                                        style="background: #f1f5f9; color: #64748b;">
                                        {{ $subscriber->category->name }}
                                    </span>
                                @endif
                            </label>
                        @empty
                            <div class="p-8 text-center">
                                <svg class="w-10 h-10 mx-auto mb-2" style="color: #d1d5db;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128H5.228A2 2 0 015 17.122V5a2 2 0 012-2h6"/>
                                </svg>
                                <p class="text-sm font-bold" style="color: #94a3b8;">Nenhum assinante encontrado.</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>

        {{-- CARD: RESUMO + AÇÕES --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background: {{ $recipientCount > 0 ? 'rgba(35,197,94,0.1)' : 'rgba(239,68,68,0.1)' }};">
                            <svg class="w-5 h-5" style="color: {{ $recipientCount > 0 ? '#23c55e' : '#ef4444' }};" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest font-bold mb-0" style="color: #87c2c0;">Destinatários</p>
                            <p class="text-lg font-black mb-0" style="color: #051e34;">{{ $recipientCount }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.newsletter.index') }}"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold transition"
                            style="border: 1px solid #e8e4d8; background: white; color: #87c2c0;"
                            onmouseover="this.style.color='#051e34'"
                            onmouseout="this.style.color='#87c2c0'">
                            Cancelar
                        </a>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-extrabold transition"
                            style="background-color: {{ $recipientCount > 0 ? '#23c55e' : '#d1d5db' }}; color: #051e34; box-shadow: 0 2px 0 {{ $recipientCount > 0 ? '#15803d' : '#9ca3af' }};"
                            @if($recipientCount === 0) disabled @endif
                        >
                            <span wire:loading.remove wire:target="send">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                </svg>
                                Enviar
                            </span>
                            <span wire:loading wire:target="send">
                                <svg class="w-4 h-4 inline animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                Enviando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
