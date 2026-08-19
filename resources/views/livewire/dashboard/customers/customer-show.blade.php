<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user mr-2"></i> Perfil do Cliente</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}">Clientes</a></li>
                        <li class="breadcrumb-item active">Perfil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900">{{ $customer->name }}</h2>
                    <p class="text-sm text-slate-400">{{ $customer->email }}</p>
                </div>
            </div>
            <a href="{{ route('admin.customers.index') }}"
                class="inline-flex items-center gap-2 h-11 px-4 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar para clientes
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-2 mb-6">
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $customer->status ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                {{ $customer->status ? 'Ativo' : 'Inativo' }}
            </span>
            @if($customer->isProprietary())
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600">Proprietário</span>
            @endif
            @if($customer->isClient())
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">Cliente</span>
            @endif
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                Cadastro: {{ $customer->created_at->format('d/m/Y') }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Dados pessoais</p>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">CPF</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->cpf ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Nascimento</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->birthday ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Gênero</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->gender ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Estado civil</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->civil_status ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Contato</p>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Telefone</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->phone ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Celular</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->cell_phone ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">WhatsApp</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->whatsapp ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">E-mail adicional</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->additional_email ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Endereço</p>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Endereço</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->street ?? '—' }}, {{ $customer->number ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Bairro</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->neighborhood ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Cidade / UF</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->city ?? '—' }} - {{ $customer->state ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">CEP</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $customer->zipcode ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Empresa</p>
                <p class="text-sm font-black text-slate-800 truncate">{{ $customer->company?->alias_name ?? '—' }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-indigo-100 p-4">
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Reservas Pagas</p>
                <p class="text-lg font-black text-indigo-600">{{ number_format($customer->bookings->where('payment_status', \App\Enums\PaymentStatusEnum::PAID)->count(), 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-emerald-100 p-4">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1">Receita Gerada</p>
                <p class="text-lg font-black text-emerald-600">R$ {{ number_format($customer->bookings->where('payment_status', \App\Enums\PaymentStatusEnum::PAID)->sum('total'), 2, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total de Reservas</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($customer->bookings->count(), 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-700">Reservas do cliente</h3>
            </div>

            @if($customer->bookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Passeio</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Pagamento</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-right">Criada em</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($customer->bookings->sortByDesc('created_at') as $booking)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-slate-800 max-w-[240px] truncate">{{ $booking->tour?->title ?? '—' }}</p>
                                        <p class="text-xs text-slate-400 font-mono">#{{ strtoupper(substr($booking->uuid, 0, 8)) }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $statusBadge = match($booking->status) {
                                                \App\Enums\BookingStatusEnum::CONFIRMED => 'bg-green-50 text-green-600',
                                                \App\Enums\BookingStatusEnum::CANCELLED => 'bg-red-50 text-red-600',
                                                \App\Enums\BookingStatusEnum::COMPLETED => 'bg-indigo-50 text-indigo-600',
                                                \App\Enums\BookingStatusEnum::NO_SHOW => 'bg-slate-100 text-slate-500',
                                                default => 'bg-amber-50 text-amber-600',
                                            };
                                        @endphp
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusBadge }}">
                                            {{ $booking->status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $paymentBadge = match($booking->payment_status) {
                                                \App\Enums\PaymentStatusEnum::PAID => 'bg-green-50 text-green-600',
                                                \App\Enums\PaymentStatusEnum::REFUSED => 'bg-red-50 text-red-600',
                                                \App\Enums\PaymentStatusEnum::REFUNDED => 'bg-slate-100 text-slate-500',
                                                \App\Enums\PaymentStatusEnum::EXPIRED => 'bg-slate-100 text-slate-500',
                                                default => 'bg-amber-50 text-amber-600',
                                            };
                                        @endphp
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $paymentBadge }}">
                                            {{ $booking->payment_status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-black text-slate-700">R$ {{ number_format($booking->total, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-12 text-center">
                    <p class="text-sm font-bold text-slate-500">Este cliente ainda não possui reservas.</p>
                </div>
            @endif
        </div>

    </div>
</div>