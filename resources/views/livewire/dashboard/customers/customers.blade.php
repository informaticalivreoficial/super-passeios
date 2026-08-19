<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user-friends mr-2"></i> Clientes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Clientes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6" x-data="{ showDetail: @entangle('showDetailModal') }">

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-8 gap-3 mb-6">
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
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Com Reservas</p>
                <p class="text-lg font-black text-indigo-600">{{ number_format($metrics['withBookings'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-red-100 p-4">
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Sem Reservas</p>
                <p class="text-lg font-black text-red-600">{{ number_format($metrics['withoutBookings'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Hoje</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['today'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mês</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['month'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1">Receita</p>
                <p class="text-lg font-black text-emerald-600">R$ {{ number_format($metrics['revenue'], 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="space-y-3 mb-6">
            <div class="relative w-full lg:max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome, e-mail ou CPF..."
                    class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:border-blue-400 transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <select wire:model.live="companyFilter"
                    class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Todas as empresas</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->alias_name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="statusFilter"
                    class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Ativos e inativos</option>
                    <option value="active">Somente ativos</option>
                    <option value="inactive">Somente inativos</option>
                </select>
            </div>
        </div>

        {{-- TABELA --}}
        @if($customers->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">
                                    <button wire:click="sortBy('name')" class="hover:text-slate-600 flex items-center gap-1">
                                        Cliente
                                        @if($sortField === 'name') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
                                <th class="px-4 py-3">Empresa</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Reservas Pagas</th>
                                <th class="px-4 py-3 text-right">
                                    <button wire:click="sortBy('revenue')" class="hover:text-slate-600 flex items-center gap-1 ml-auto">
                                        Receita
                                        @if($sortField === 'revenue') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
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
                            @foreach($customers as $customer)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-slate-800 truncate max-w-[200px]">{{ $customer->name }}</p>
                                        <p class="text-xs text-slate-400 truncate max-w-[200px]">{{ $customer->email }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-xs font-semibold text-slate-600 max-w-[140px] truncate">
                                        {{ $customer->company?->alias_name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $customer->status ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $customer->status ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center font-black text-slate-700">
                                        {{ number_format($customer->bookings_count ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-black text-emerald-600">
                                        R$ {{ number_format($customer->revenue ?? 0, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">
                                        {{ $customer->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="openDetail({{ $customer->id }})"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                            title="Ver detalhes">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $customers->links() }}</div>

        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhum cliente encontrado!</p>
            </div>
        @endif

        {{-- MODAL DE DETALHES --}}
        <div x-show="showDetail" x-cloak
             class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4"
             x-transition.opacity>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
                 @click.outside="showDetail = false">

                @if($selectedCustomer)
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-xl font-black text-slate-900">Detalhes do cliente</h2>
                                <p class="text-sm text-slate-400 mt-0.5">{{ $selectedCustomer->email }}</p>
                            </div>
                            <button type="button" wire:click="closeDetail"
                                class="w-9 h-9 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M18 6L6 18M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 mb-6">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $selectedCustomer->status ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                {{ $selectedCustomer->status ? 'Ativo' : 'Inativo' }}
                            </span>
                            @if($selectedCustomer->isProprietary())
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600">Proprietário</span>
                            @endif
                            @if($selectedCustomer->isClient())
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">Cliente</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 mb-6">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Dados pessoais</p>
                                <p class="text-sm font-bold text-slate-800">{{ $selectedCustomer->name }}</p>
                                <p class="text-xs text-slate-500">CPF: {{ $selectedCustomer->cpf ?? '—' }}</p>
                                <p class="text-xs text-slate-500">Nascimento: {{ $selectedCustomer->birthday ?? '—' }}</p>
                                <p class="text-xs text-slate-500">Gênero: {{ $selectedCustomer->gender ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Contato</p>
                                <p class="text-xs text-slate-600">E-mail: {{ $selectedCustomer->email ?? '—' }}</p>
                                <p class="text-xs text-slate-600">Telefone: {{ $selectedCustomer->phone ?? '—' }}</p>
                                <p class="text-xs text-slate-600">Celular: {{ $selectedCustomer->cell_phone ?? '—' }}</p>
                                <p class="text-xs text-slate-600">WhatsApp: {{ $selectedCustomer->whatsapp ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Endereço</p>
                                <p class="text-xs text-slate-600">{{ $selectedCustomer->street ?? '—' }}, {{ $selectedCustomer->number ?? '—' }}</p>
                                <p class="text-xs text-slate-600">{{ $selectedCustomer->neighborhood ?? '—' }}</p>
                                <p class="text-xs text-slate-600">{{ $selectedCustomer->city ?? '—' }} - {{ $selectedCustomer->state ?? '—' }}</p>
                                <p class="text-xs text-slate-600">CEP: {{ $selectedCustomer->zipcode ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Empresa</p>
                                <p class="text-sm font-bold text-slate-800">{{ $selectedCustomer->company?->alias_name ?? '—' }}</p>
                                <p class="text-xs text-slate-500">Cadastro: {{ $selectedCustomer->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Reservas do cliente</p>
                            @if($selectedCustomer->bookings->count() > 0)
                                <div class="overflow-x-auto rounded-xl border border-slate-100">
                                    <table class="w-full text-xs">
                                        <thead>
                                            <tr class="bg-slate-50 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                <th class="px-3 py-2">Passeio</th>
                                                <th class="px-3 py-2 text-center">Status</th>
                                                <th class="px-3 py-2 text-center">Pagamento</th>
                                                <th class="px-3 py-2 text-right">Total</th>
                                                <th class="px-3 py-2 text-right">Data</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach($selectedCustomer->bookings->sortByDesc('created_at')->take(10) as $booking)
                                                <tr>
                                                    <td class="px-3 py-2 font-semibold text-slate-700 max-w-[180px] truncate">{{ $booking->tour?->title ?? '—' }}</td>
                                                    <td class="px-3 py-2 text-center">
                                                        <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold {{ $booking->status->value === 'CONFIRMED' ? 'bg-green-50 text-green-600' : ($booking->status->value === 'CANCELLED' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">
                                                            {{ $booking->status->label() }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-center">
                                                        <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold {{ $booking->payment_status->value === 'PAID' ? 'bg-green-50 text-green-600' : ($booking->payment_status->value === 'REFUSED' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">
                                                            {{ $booking->payment_status->label() }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-2 text-right font-black text-slate-700">R$ {{ number_format($booking->total, 2, ',', '.') }}</td>
                                                    <td class="px-3 py-2 text-right text-slate-500">{{ $booking->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-xs text-slate-400">Este cliente ainda não possui reservas.</p>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>