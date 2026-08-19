<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-calendar-check mr-2"></i> Reservas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item active">Reservas</li>
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
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Hoje</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['today'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mês</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['month'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-amber-100 p-4">
                <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-1">Pendentes</p>
                <p class="text-lg font-black text-amber-600">{{ number_format($metrics['pending'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Pagas</p>
                <p class="text-lg font-black text-green-600">{{ number_format($metrics['paid'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-red-100 p-4">
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Canceladas</p>
                <p class="text-lg font-black text-red-600">{{ number_format($metrics['cancelled'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Receita</p>
                <p class="text-lg font-black text-green-600">R$ {{ number_format($metrics['revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Comissão</p>
                <p class="text-lg font-black text-blue-600">R$ {{ number_format($metrics['commission'], 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- FILTROS --}}
        <div class="space-y-3 mb-6">
            <div class="relative w-full lg:max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Buscar por nome, e-mail ou código..."
                    class="w-full h-11 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:border-blue-400 transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <select wire:model.live="statusFilter"
                    class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Todos os status</option>
                    @foreach(\App\Enums\BookingStatusEnum::cases() as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>

                <select wire:model.live="paymentFilter"
                    class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Todos os pagamentos</option>
                    @foreach(\App\Enums\PaymentStatusEnum::cases() as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>

                <select wire:model.live="methodFilter"
                    class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Todos os métodos</option>
                    <option value="pix">PIX</option>
                    <option value="card">Cartão</option>
                </select>

                <select wire:model.live="companyFilter"
                    class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 outline-none focus:border-blue-400 transition">
                    <option value="">Todas as empresas</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->alias_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- TABELA --}}
        @if($bookings->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">
                                    <button wire:click="sortBy('uuid')" class="hover:text-slate-600 flex items-center gap-1">
                                        Código
                                        @if($sortField === 'uuid') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
                                <th class="px-4 py-3">
                                    <button wire:click="sortBy('customer_name')" class="hover:text-slate-600 flex items-center gap-1">
                                        Cliente
                                        @if($sortField === 'customer_name') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
                                <th class="px-4 py-3">Empresa</th>
                                <th class="px-4 py-3">Passeio / Data</th>
                                <th class="px-4 py-3 text-center">Pessoas</th>
                                <th class="px-4 py-3 text-right">
                                    <button wire:click="sortBy('total')" class="hover:text-slate-600 flex items-center gap-1 ml-auto">
                                        Total
                                        @if($sortField === 'total') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Pagamento</th>
                                <th class="px-4 py-3 text-center">Método</th>
                                <th class="px-4 py-3 text-right">
                                    <button wire:click="sortBy('created_at')" class="hover:text-slate-600 flex items-center gap-1 ml-auto">
                                        Criado em
                                        @if($sortField === 'created_at') <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span> @endif
                                    </button>
                                </th>
                                <th class="px-4 py-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($bookings as $booking)
                                @php
                                    $statusColors = [
                                        'PENDING'   => 'bg-amber-50 text-amber-600',
                                        'CONFIRMED' => 'bg-green-50 text-green-600',
                                        'CANCELLED' => 'bg-red-50 text-red-600',
                                        'COMPLETED' => 'bg-indigo-50 text-indigo-600',
                                        'NO_SHOW'   => 'bg-slate-100 text-slate-500',
                                    ];
                                    $paymentColors = [
                                        'PENDING'   => 'bg-amber-50 text-amber-600',
                                        'PAID'      => 'bg-green-50 text-green-600',
                                        'REFUSED'   => 'bg-red-50 text-red-600',
                                        'REFUNDED'  => 'bg-indigo-50 text-indigo-600',
                                        'EXPIRED'   => 'bg-slate-100 text-slate-500',
                                    ];
                                    $s  = $booking->status->value ?? 'PENDING';
                                    $ps = $booking->payment_status->value ?? 'PENDING';
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-500">
                                        #{{ strtoupper(substr($booking->uuid, 0, 8)) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-slate-800 truncate max-w-[180px]">{{ $booking->customer_name }}</p>
                                        <p class="text-xs text-slate-400 truncate max-w-[180px]">{{ $booking->customer_email }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-xs font-semibold text-slate-600 max-w-[140px] truncate">
                                        {{ $booking->company?->alias_name ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="text-xs font-semibold text-slate-700 truncate max-w-[160px]">{{ $booking->tour?->title ?? '—' }}</p>
                                        @if($booking->tourDate)
                                            <p class="text-xs text-slate-400">{{ $booking->tourDate->date->format('d/m/Y') }} · {{ substr($booking->tourDate->start_time, 0, 5) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs font-bold text-slate-600">
                                        {{ $booking->total_people }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <p class="font-black text-slate-800">R$ {{ number_format($booking->total, 2, ',', '.') }}</p>
                                        <p class="text-[10px] text-slate-400">Comissão: R$ {{ number_format($booking->commission_amount, 2, ',', '.') }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusColors[$s] }}">
                                            {{ $booking->status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $paymentColors[$ps] }}">
                                            {{ $booking->payment_status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 uppercase">
                                            {{ $booking->payment_method === 'pix' ? 'PIX' : 'Cartão' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">
                                        {{ $booking->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button wire:click="openDetail({{ $booking->id }})"
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

            <div class="mt-6">{{ $bookings->links() }}</div>

        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhuma reserva encontrada!</p>
            </div>
        @endif

        {{-- MODAL DE DETALHES --}}
        <div x-show="showDetail" x-cloak
             class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9999] p-4"
             x-transition.opacity>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
                 @click.outside="showDetail = false">

                @if($selectedBooking)
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4 mb-6">
                            <div>
                                <h2 class="text-xl font-black text-slate-900">Detalhes da reserva</h2>
                                <p class="text-sm font-mono text-slate-400 mt-0.5">#{{ $selectedBooking->uuid }}</p>
                            </div>
                            <button type="button" wire:click="closeDetail"
                                class="w-9 h-9 rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M18 6L6 18M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        @php
                            $detailStatusColors = [
                                'PENDING'   => 'bg-amber-50 text-amber-600',
                                'CONFIRMED' => 'bg-green-50 text-green-600',
                                'CANCELLED' => 'bg-red-50 text-red-600',
                                'COMPLETED' => 'bg-indigo-50 text-indigo-600',
                                'NO_SHOW'   => 'bg-slate-100 text-slate-500',
                            ];
                            $detailPaymentColors = [
                                'PENDING'   => 'bg-amber-50 text-amber-600',
                                'PAID'      => 'bg-green-50 text-green-600',
                                'REFUSED'   => 'bg-red-50 text-red-600',
                                'REFUNDED'  => 'bg-indigo-50 text-indigo-600',
                                'EXPIRED'   => 'bg-slate-100 text-slate-500',
                            ];
                            $ds  = $selectedBooking->status->value ?? 'PENDING';
                            $dps = $selectedBooking->payment_status->value ?? 'PENDING';
                        @endphp

                        <div class="flex flex-wrap items-center gap-2 mb-6">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $detailStatusColors[$ds] }}">
                                {{ $selectedBooking->status->label() }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $detailPaymentColors[$dps] }}">
                                Pagamento: {{ $selectedBooking->payment_status->label() }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 uppercase">
                                {{ $selectedBooking->payment_method === 'pix' ? 'PIX' : 'Cartão' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Cliente</p>
                                <p class="text-sm font-bold text-slate-800">{{ $selectedBooking->customer_name }}</p>
                                <p class="text-xs text-slate-500">{{ $selectedBooking->customer_email }}</p>
                                <p class="text-xs text-slate-500">{{ $selectedBooking->customer_phone }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Empresa</p>
                                <p class="text-sm font-bold text-slate-800">{{ $selectedBooking->company?->alias_name ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Passeio</p>
                                <p class="text-sm font-bold text-slate-800">{{ $selectedBooking->tour?->title ?? '—' }}</p>
                                @if($selectedBooking->tourDate)
                                    <p class="text-xs text-slate-500">{{ $selectedBooking->tourDate->date->format('d/m/Y') }} · {{ substr($selectedBooking->tourDate->start_time, 0, 5) }}</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pessoas</p>
                                <p class="text-sm font-bold text-slate-800">{{ $selectedBooking->total_people }} no total</p>
                                <p class="text-xs text-slate-500">
                                    {{ $selectedBooking->adults }} adulto(s)
                                    @if($selectedBooking->children > 0) · {{ $selectedBooking->children }} criança(s) (meia) @endif
                                    @if($selectedBooking->children_free > 0) · {{ $selectedBooking->children_free }} criança(s) (grátis) @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Valores</p>
                                <p class="text-xs text-slate-600">Subtotal: <strong>R$ {{ number_format($selectedBooking->subtotal, 2, ',', '.') }}</strong></p>
                                <p class="text-xs text-slate-600">Comissão: <strong>R$ {{ number_format($selectedBooking->commission_amount, 2, ',', '.') }}</strong></p>
                                <p class="text-xs text-slate-600">Repasse à empresa: <strong>R$ {{ number_format($selectedBooking->company_amount, 2, ',', '.') }}</strong></p>
                                <p class="text-sm font-black text-green-600 mt-1">Total: R$ {{ number_format($selectedBooking->total, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Datas</p>
                                <p class="text-xs text-slate-600">Criada: {{ $selectedBooking->created_at->format('d/m/Y H:i') }}</p>
                                @if($selectedBooking->paid_at)
                                    <p class="text-xs text-slate-600">Paga: {{ $selectedBooking->paid_at->format('d/m/Y H:i') }}</p>
                                @endif
                                @if($selectedBooking->expires_at)
                                    <p class="text-xs text-slate-600">Expira: {{ $selectedBooking->expires_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>