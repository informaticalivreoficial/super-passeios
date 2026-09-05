<div class="bg-slate-50 min-h-screen -m-4 p-4 lg:p-6">
    @section('title', 'Aceites - ' . $document->title)

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Aceites</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $document->title }} — v{{ $document->version }}</p>
        </div>
        <nav class="text-sm text-slate-400 font-medium">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600">Início</a>
            <span class="mx-1.5">/</span>
            <a href="{{ route('admin.documents.index') }}" class="hover:text-slate-600">Contratos e Documentos</a>
            <span class="mx-1.5">/</span>
            <span class="text-slate-600">Aceites</span>
        </nav>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-100 p-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total de Operadores</p>
            <p class="text-2xl font-black text-slate-900 mt-1">{{ $statusMap['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-4">
            <p class="text-xs font-bold text-green-500 uppercase tracking-widest">Aceitaram</p>
            <p class="text-2xl font-black text-green-600 mt-1">{{ $statusMap['accepted_count'] }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-4">
            <p class="text-xs font-bold text-red-500 uppercase tracking-widest">Pendentes</p>
            <p class="text-2xl font-black text-red-600 mt-1">{{ $statusMap['pending_count'] }}</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Buscar por nome ou e-mail do operador..."
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
        />
    </div>

    {{-- Aceitos --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-700">Operadores que aceitaram</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs">Operador</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs">Empresa</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs">Data/Hora</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs">IP</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs">Hash</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($acceptances as $acceptance)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-900">{{ $acceptance->customer->name ?? '—' }}</div>
                                <div class="text-xs text-slate-400">{{ $acceptance->customer->email ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600 text-xs">
                                {{ $acceptance->customer->company->alias_name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-slate-500 text-xs">
                                {{ $acceptance->accepted_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-4 py-3 text-slate-500 text-xs font-mono">
                                {{ $acceptance->ip_address ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-slate-400 text-xs font-mono">
                                {{ substr($acceptance->content_hash, 0, 16) }}...
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-400">
                                Nenhum operador aceitou este documento ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($acceptances->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $acceptances->links() }}
            </div>
        @endif
    </div>

    {{-- Pendentes --}}
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="px-4 py-3 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-700">Operadores pendentes</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs">Operador</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs">Empresa</th>
                        <th class="text-left px-4 py-3 font-bold text-slate-500 uppercase text-xs">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statusMap['pending'] as $operator)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <div class="font-bold text-slate-900">{{ $operator->name }}</div>
                                <div class="text-xs text-slate-400">{{ $operator->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600 text-xs">
                                {{ $operator->company->alias_name ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-red-50 text-red-700">
                                    Pendente
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-sm text-slate-400">
                                Todos os operadores aceitaram este documento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.documents.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            Voltar
        </a>
    </div>
</div>
