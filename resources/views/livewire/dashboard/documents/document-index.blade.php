<div class="bg-slate-50 min-h-screen -m-4 p-4 lg:p-6">
    @section('title', 'Contratos e Documentos')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Contratos e Documentos</h1>
        <nav class="text-sm text-slate-400 font-medium">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600">Início</a>
            <span class="mx-1.5">/</span>
            <span class="text-slate-600">Contratos e Documentos</span>
        </nav>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por título, tipo ou versão..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                />
            </div>
            <div class="w-full md:w-48">
                <select wire:model.live="typeFilter" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                    <option value="">Todos os tipos</option>
                    @foreach($types as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-40">
                <select wire:model.live="statusFilter" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                    <option value="">Todos os status</option>
                    <option value="published">Publicado</option>
                    <option value="draft">Rascunho</option>
                    <option value="inactive">Inativo</option>
                </select>
            </div>
            <a href="{{ route('admin.documents.create') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-blue-600 text-white hover:bg-blue-700 transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                Novo Documento
            </a>
        </div>
    </div>

    {{-- Documents Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs tracking-wider">Documento</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs tracking-wider">Versão</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs tracking-wider">Tipo</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs tracking-wider">Obrigatório</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs tracking-wider">Status</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs tracking-wider">Publicado em</th>
                        <th class="text-right px-4 py-3 font-bold text-slate-500 uppercase text-xs tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-900">{{ $document->title }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $document->slug }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                    v{{ $document->version }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-600 text-xs">{{ $document->type }}</td>
                            <td class="px-4 py-3">
                                @if($document->is_required)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-red-50 text-red-700">Sim</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-500">Não</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($document->isPublished())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-green-50 text-green-700">Publicado</span>
                                @elseif($document->isDraft())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-700">Rascunho</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-500">Inativo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-500 text-xs">
                                {{ $document->published_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.documents.edit', $document->id) }}"
                                       class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition"
                                       title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @if($document->isPublished())
                                        <a href="{{ route('admin.documents.acceptances', $document->id) }}"
                                           class="p-2 rounded-lg text-slate-400 hover:text-purple-600 hover:bg-purple-50 transition"
                                           title="Aceites">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </a>
                                    @endif
                                    @if($document->isPublished())
                                        <button
                                            wire:click="toggleStatus({{ $document->id }})"
                                            class="p-2 rounded-lg text-slate-400 hover:text-yellow-600 hover:bg-yellow-50 transition"
                                            title="Desativar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        </button>
                                    @endif
                                    @if(!$document->isPublished())
                                        <button
                                            wire:click="confirmDeleteDocument({{ $document->id }})"
                                            class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition"
                                            title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="text-sm font-bold text-slate-400">Nenhum documento encontrado</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($documents->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $documents->links() }}
            </div>
        @endif
    </div>
</div>
