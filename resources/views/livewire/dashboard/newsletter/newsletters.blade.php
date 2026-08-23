<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-envelope-open-text mr-2"></i> Newsletter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Newsletter</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['total'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Ativos</p>
                <p class="text-lg font-black text-green-600">{{ number_format($metrics['active'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Inativos</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['inactive'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-indigo-100 p-4">
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Confirmados</p>
                <p class="text-lg font-black text-indigo-600">{{ number_format($metrics['confirmed'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-red-100 p-4">
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Não Confirmados</p>
                <p class="text-lg font-black text-red-600">{{ number_format($metrics['unconfirmed'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Hoje</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['today'], 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- AÇÕES / FILTROS --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 mb-6">
            <div class="relative w-full lg:max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome ou e-mail..."
                    class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:border-blue-400 transition">
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <select wire:model.live="statusFilter"
                    class="w-full sm:w-auto h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Ativos e inativos</option>
                    <option value="active">Somente ativos</option>
                    <option value="inactive">Somente inativos</option>
                </select>

                <select wire:model.live="confirmedFilter"
                    class="w-full sm:w-auto h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Confirmados e não confirmados</option>
                    <option value="confirmed">Somente confirmados</option>
                    <option value="unconfirmed">Somente não confirmados</option>
                </select>

                <select wire:model.live="categoryFilter"
                    class="w-full sm:w-auto h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Todas as categorias</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <button wire:click="exportCsv"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-slate-700 text-white text-sm font-bold hover:bg-slate-800 transition-colors"
                    title="Exportar CSV">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    CSV
                </button>

                <button wire:click="exportXls"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 transition-colors"
                    title="Exportar XLS">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    XLS
                </button>

                <button @click="$dispatch('open-newsletter-import-modal')"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-amber-500 text-white text-sm font-bold hover:bg-amber-600 transition-colors"
                    title="Importar CSV">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Importar CSV
                </button>

                <button @click="$dispatch('open-newsletter-modal', { editId: null })"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Cadastrar
                </button>
            </div>
        </div>

        {{-- TABELA --}}
        @if($newsletters->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">
                                    <button wire:click="sortBy('name')" class="hover:text-slate-600 flex items-center gap-1">
                                        Nome
                                        @if($sortField === 'name') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
                                <th class="px-4 py-3">
                                    <button wire:click="sortBy('email')" class="hover:text-slate-600 flex items-center gap-1">
                                        E-mail
                                        @if($sortField === 'email') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
                                <th class="px-4 py-3">Categoria</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Confirmado</th>
                                <th class="px-4 py-3 text-right">
                                    <button wire:click="sortBy('created_at')" class="hover:text-slate-600 flex items-center gap-1 ml-auto">
                                        Cadastro
                                        @if($sortField === 'created_at') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
                                <th class="px-4 py-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($newsletters as $newsletter)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-800 max-w-[200px] truncate">
                                        {{ $newsletter->name ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-600 max-w-[240px] truncate">
                                        {{ $newsletter->email }}
                                    </td>
                                    <td class="px-4 py-3 text-xs font-semibold text-slate-600 max-w-[160px] truncate">
                                        @if($newsletter->category)
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                                {{ $newsletter->category->name }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="toggleStatus({{ $newsletter->id }})"
                                            class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $newsletter->active ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}"
                                            title="Alternar status">
                                            {{ $newsletter->active ? 'Ativo' : 'Inativo' }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $newsletter->confirmed_at ? 'bg-indigo-50 text-indigo-600' : 'bg-red-50 text-red-600' }}">
                                            {{ $newsletter->confirmed_at ? 'Sim' : 'Não' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">
                                        {{ $newsletter->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="$dispatch('open-newsletter-modal', { editId: {{ $newsletter->id }} })"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                                title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                            </button>
                                            <button wire:click="setDeleteId({{ $newsletter->id }})"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                                title="Excluir">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m2 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $newsletters->links() }}</div>

        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhum e-mail encontrado!</p>
            </div>
        @endif

        <div
            x-data="{ open: false }"
            x-on:open-newsletter-modal.window="
                open = true;
                Livewire.dispatch('loadNewsletter', { payload: $event.detail })
            "
            x-on:newsletter-saved.window="open = false"
            x-show="open"
            style="display: none"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-[1050]"
        >
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
                <livewire:dashboard.newsletter.newsletter-form />
                <div class="mt-4 text-right">
                    <button
                        @click="open = false; Livewire.dispatch('resetNewsletterForm')"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                        Fechar
                    </button>
                </div>
            </div>
        </div>

        <div
            x-data="{ open: false }"
            x-on:open-newsletter-import-modal.window="open = true"
            x-on:newsletter-imported.window="open = false"
            x-show="open"
            style="display: none"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-[1050]"
        >
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
                <livewire:dashboard.newsletter.newsletter-import />
                <div class="mt-4 text-right">
                    <button
                        @click="open = false; Livewire.dispatch('resetNewsletterImport')"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                        Fechar
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
