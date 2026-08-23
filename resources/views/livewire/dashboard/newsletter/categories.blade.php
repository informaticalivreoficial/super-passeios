<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-tags mr-2"></i> Categorias da Newsletter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.newsletter.index') }}">Newsletter</a></li>
                        <li class="breadcrumb-item active">Categorias</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 mb-6">
            <div class="relative w-full lg:max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar categoria..."
                    class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:border-blue-400 transition">
            </div>

            <button @click="$dispatch('open-newsletter-category-modal', { editId: null })"
                class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Cadastrar Categoria
            </button>
        </div>

        @if($categories->count() > 0)
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
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">E-mails</th>
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
                            @foreach($categories as $category)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-800">{{ $category->name }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="toggleStatus({{ $category->id }})"
                                            class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $category->active ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}"
                                            title="Alternar status">
                                            {{ $category->active ? 'Ativa' : 'Inativa' }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 text-center font-black text-slate-700">
                                        {{ number_format($category->newsletters_count ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">
                                        {{ $category->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="$dispatch('open-newsletter-category-modal', { editId: {{ $category->id }} })"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                                title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                            </button>
                                            <button wire:click="setDeleteId({{ $category->id }})"
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

            <div class="mt-6">{{ $categories->links() }}</div>
        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhuma categoria encontrada!</p>
            </div>
        @endif

        <div
            x-data="{ open: false }"
            x-on:open-newsletter-category-modal.window="
                open = true;
                Livewire.dispatch('loadNewsletterCategory', { payload: $event.detail })
            "
            x-on:newsletter-category-saved.window="open = false"
            x-show="open"
            style="display: none"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-[1050]"
        >
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
                <livewire:dashboard.newsletter.newsletter-category-form />
                <div class="mt-4 text-right">
                    <button
                        @click="open = false; Livewire.dispatch('resetNewsletterCategoryForm')"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">
                        Fechar
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
