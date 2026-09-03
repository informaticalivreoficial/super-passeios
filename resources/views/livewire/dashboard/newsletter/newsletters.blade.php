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
        <div class="space-y-3 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3">
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
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:flex-wrap sm:justify-end gap-3">
                <button wire:click="exportCsv"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-slate-700 text-white text-sm font-bold hover:bg-slate-800 transition-colors"
                    title="Exportar CSV">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    CSV
                </button>

                <button wire:click="exportXls"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-green-600 text-white text-sm font-bold hover:bg-green-700 transition-colors"
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

                <a href="{{ route('admin.newsletter.history') }}"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-gray-600 text-white text-sm font-bold hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Histórico
                </a>

                <a href="{{ route('admin.newsletter.send') }}"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-purple-600 text-white text-sm font-bold hover:bg-purple-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                    Enviar Newsletter
                </a>

                <a href="{{ route('admin.newsletter.config') }}"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-gray-600 text-white text-sm font-bold hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    Configurações
                </a>

                <a href="{{ route('admin.newsletter.create') }}"
                    class="inline-flex items-center justify-center gap-2 h-11 px-4 rounded-xl bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Cadastrar
                </a>
            </div>
        </div>

        {{-- CARDS --}}
        <div class="row d-flex align-items-stretch">
            @if($newsletters->count() > 0)
                @foreach($newsletters as $newsletter)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                        <div class="card bg-light w-100" style="{{ !$newsletter->active ? 'background: #fffed8 !important;' : '' }}">
                            <div class="card-header text-muted border-bottom-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-xs text-muted">
                                        <i class="fas fa-calendar-alt mr-1"></i> {{ $newsletter->created_at->format('d/m/Y') }}
                                    </span>
                                    @if($newsletter->category)
                                        <span class="badge badge-secondary">{{ $newsletter->category->name }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <h5 class="lead mb-1">
                                    <b>{{ $newsletter->name ?: 'Sem nome' }}</b>
                                </h5>
                                <p class="text-muted text-sm mb-1">
                                    <i class="fas fa-envelope mr-1"></i> {{ $newsletter->email }}
                                </p>
                                @if($newsletter->city)
                                    <p class="text-muted text-sm mb-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $newsletter->city }}
                                    </p>
                                @endif
                                @if($newsletter->instagram)
                                    <p class="text-muted text-sm mb-1">
                                        <i class="fab fa-instagram mr-1"></i> {{ $newsletter->instagram }}
                                    </p>
                                @endif
                                @if($newsletter->site)
                                    <p class="text-muted text-sm mb-1">
                                        <i class="fas fa-globe mr-1"></i>
                                        <a href="{{ $newsletter->site }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 180px;">
                                            {{ $newsletter->site }}
                                        </a>
                                    </p>
                                @endif
                                <div class="mt-2">
                                    <span class="badge {{ $newsletter->confirmed_at ? 'badge-success' : 'badge-danger' }}">
                                        {{ $newsletter->confirmed_at ? 'Confirmado' : 'Não Confirmado' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex align-items-center gap-2">
                                    <x-forms.switch-toggle
                                        wire:key="newsletter-switch-{{ $newsletter->id }}"
                                        wire:click="toggleStatus({{ $newsletter->id }})"
                                        :checked="$newsletter->active"
                                        size="sm"
                                        color="green"
                                    />
                                    @if($newsletter->whatsapp)
                                        <a target="_blank"
                                            href="{{ \App\Helpers\WhatsApp::getNumZap($newsletter->whatsapp) }}"
                                            class="btn btn-xs bg-teal"
                                            title="WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.newsletter.edit', $newsletter->id) }}"
                                        class="btn btn-xs btn-default"
                                        title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-xs bg-danger text-white"
                                        title="Excluir"
                                        wire:click="setDeleteId({{ $newsletter->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                        <p class="text-sm font-bold text-slate-500">Nenhum e-mail encontrado!</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-6">{{ $newsletters->links() }}</div>

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
