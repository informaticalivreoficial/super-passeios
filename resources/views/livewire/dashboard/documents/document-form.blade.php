<div class="bg-slate-50 min-h-screen -m-4 p-4 lg:p-6" x-data="{ currentTab: 'dados' }">
    @section('title', $isEditing ? 'Editar Documento' : 'Novo Documento')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $isEditing ? 'Editar Documento' : 'Novo Documento' }}</h1>
        <nav class="text-sm text-slate-400 font-medium">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600">Início</a>
            <span class="mx-1.5">/</span>
            <a href="{{ route('admin.documents.index') }}" class="hover:text-slate-600">Contratos e Documentos</a>
            <span class="mx-1.5">/</span>
            <span class="text-slate-600">{{ $isEditing ? 'Editar' : 'Novo' }}</span>
        </nav>
    </div>

    {{-- Action Buttons --}}
    @if($isEditing && $document)
        <div class="flex flex-wrap gap-2 mb-6">
            @if(!$document->isPublished())
                <button
                    wire:click="publish"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-green-600 text-white hover:bg-green-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Publicar Documento
                </button>
            @endif
            @if($document->isPublished())
                <button
                    wire:click="createNewVersion"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-blue-600 text-white hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    Criar Nova Versão
                </button>
                <a href="{{ route('admin.documents.acceptances', $document->id) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-purple-600 text-white hover:bg-purple-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Ver Aceites
                </a>
            @endif
        </div>
    @endif

    {{-- Tabs --}}
    <div class="bg-white rounded-2xl border border-slate-100 mb-6">
        <div class="flex border-b border-slate-100">
            <button @click="currentTab = 'dados'"
                    :class="currentTab === 'dados' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-400 hover:text-slate-600'"
                    class="px-6 py-3 text-sm font-bold border-b-2 transition">
                Dados do Documento
            </button>
            <button @click="currentTab = 'conteudo'"
                    :class="currentTab === 'conteudo' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-400 hover:text-slate-600'"
                    class="px-6 py-3 text-sm font-bold border-b-2 transition">
                Conteúdo
            </button>
        </div>
    </div>

    <form wire:submit.prevent="save">
        {{-- Tab: Dados --}}
        <div x-show="currentTab === 'dados'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @if($isEditing)
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Tipo do Documento</label>
                        <input type="text" value="{{ \App\Enums\DocumentTypeEnum::tryFrom($type)?->label() ?? $type }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-slate-50 text-slate-600"
                               readonly>
                        <input type="hidden" wire:model="type">
                    </div>
                @else
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Tipo do Documento <span class="text-red-500">*</span></label>
                        <select wire:model="type"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white @error('type') border-red-500 @enderror">
                            <option value="">Selecione...</option>
                            @foreach($types as $typeOption)
                                <option value="{{ $typeOption->value }}">{{ $typeOption->label() }}</option>
                            @endforeach
                        </select>
                        @error('type') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Versão <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="version"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('version') border-red-500 @enderror"
                           placeholder="Ex: 1.0"
                           @if($isEditing && $document?->isPublished()) readonly @endif>
                    @error('version') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Título <span class="text-red-500">*</span></label>
                <input type="text" wire:model="title"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('title') border-red-500 @enderror"
                       placeholder="Título do documento">
                @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Descrição</label>
                <textarea wire:model="description" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('description') border-red-500 @enderror"
                          placeholder="Breve descrição do documento"></textarea>
                @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="flex items-center gap-3 pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_required" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <span class="text-sm font-bold text-slate-700">Documento obrigatório</span>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Data de vigência</label>
                    <input type="text" wire:model="effective_at" id="effective_at" placeholder="dd/mm/aaaa"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('effective_at') border-red-500 @enderror">
                    @error('effective_at') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Data de encerramento</label>
                    <input type="text" wire:model="expires_at" id="expires_at" placeholder="dd/mm/aaaa"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('expires_at') border-red-500 @enderror">
                    @error('expires_at') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="w-48">
                <label class="block text-sm font-bold text-slate-700 mb-1">Ordem de exibição</label>
                <input type="number" wire:model="sort_order" min="0"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('sort_order') border-red-500 @enderror">
                @error('sort_order') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Tab: Conteúdo --}}
        <div x-show="currentTab === 'conteudo'" class="bg-white rounded-2xl border border-slate-100 p-6">
            <div x-data="{ preview: false }">
                <div class="flex items-center gap-2 mb-3">
                    <button type="button" @click="preview = false"
                            :class="!preview ? 'bg-blue-100 text-blue-700' : 'text-slate-500 hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                        Editar
                    </button>
                    <button type="button" @click="preview = true"
                            :class="preview ? 'bg-blue-100 text-blue-700' : 'text-slate-500 hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition">
                        Pré-visualizar
                    </button>
                </div>

                <div x-show="!preview">
                    <textarea wire:model.live="content" id="md-content" rows="20"
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition font-mono @error('content') border-red-500 @enderror"
                              placeholder="Conteúdo em Markdown..."></textarea>
                    @error('content') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-slate-400 mt-1">Suporta Markdown. Exemplos: <code># Título</code>, <code>**negrito**</code>, <code>*itálico*</code>, <code>- item</code>, <code>[link](url)</code></p>
                </div>

                <div x-show="preview" x-cloak
                     class="prose prose-sm prose-slate max-w-none min-h-[200px] px-4 py-3 rounded-xl border border-slate-200 bg-slate-50">
                    {!! $this->renderedContent !!}
                </div>
            </div>
        </div>

        {{-- Save --}}
        <div class="flex items-center justify-end gap-3 mt-6">
            <a href="{{ route('admin.documents.index') }}"
               class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold bg-blue-600 text-white hover:bg-blue-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                {{ $isEditing && $document?->isPublished() ? 'Salvar Alterações' : 'Salvar' }}
            </button>
        </div>
    </form>

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', initFlatpickrDocs);
            document.addEventListener('livewire:navigated', initFlatpickrDocs);

            function initFlatpickrDocs() {
                ['effective_at', 'expires_at'].forEach(function (id) {
                    const input = document.getElementById(id);
                    if (!input) return;

                    const existing = input._flatpickr;
                    if (existing) existing.destroy();

                    flatpickr(input, {
                        dateFormat: 'd/m/Y',
                        allowInput: true,
                        minDate: id === 'expires_at' ? (document.getElementById('effective_at')?.value || 'today') : 'today',
                        defaultDate: input.value || null,
                        onChange: function (selectedDates, dateStr) {
                            input.value = dateStr;
                            input.dispatchEvent(new Event('input'));
                        }
                    });
                });
            }
        </script>
    @endpush
</div>
