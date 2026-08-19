<div>
    @section('title', $title)

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-industry mr-2"></i> Perfil da Empresa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.companies.index') }}">Empresas</a></li>
                        <li class="breadcrumb-item active">Perfil</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        {{-- HEADER --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <img src="{{ $company->getLogoUrl() }}" alt="{{ $company->alias_name }}"
                    class="w-16 h-16 rounded-2xl object-cover border border-slate-200 shrink-0">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-xl font-black text-slate-900">{{ $company->alias_name }}</h2>
                        @if($company->highlight)
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 flex items-center gap-1">
                                <i class="fas fa-shield-alt text-xs"></i> Verificada
                            </span>
                        @endif
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $company->status ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }}">
                            {{ $company->status ? 'Ativa' : 'Inativa' }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-400">{{ $company->social_name ?? '—' }} · Cadastro: {{ $company->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.companies.report', $company) }}"
                    class="inline-flex items-center gap-2 h-11 px-4 rounded-xl bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 3v12m0 0l-4-4m4 4l4-4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"/>
                    </svg>
                    Exportar PDF
                </a>
                <a href="{{ route('admin.companies.edit', $company) }}"
                    class="inline-flex items-center gap-2 h-11 px-4 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
                <a href="{{ route('admin.companies.index') }}"
                    class="inline-flex items-center gap-2 h-11 px-4 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                    Voltar
                </a>
            </div>
        </div>

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Receita (pagas)</p>
                <p class="text-lg font-black text-emerald-600">R$ {{ number_format($metrics['revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-blue-100 p-4">
                <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1">Comissão</p>
                <p class="text-lg font-black text-blue-600">R$ {{ number_format($metrics['commission'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Saldo Disponível</p>
                <p class="text-lg font-black text-green-600">R$ {{ number_format($metrics['available'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-amber-100 p-4">
                <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-1">Saldo Pendente</p>
                <p class="text-lg font-black text-amber-600">R$ {{ number_format($metrics['pending'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Já Sacado</p>
                <p class="text-lg font-black text-slate-800">R$ {{ number_format($metrics['withdrawn'], 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Embarcações</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['vessels'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Passeios</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['tours'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Passeios Ativos</p>
                <p class="text-lg font-black text-green-600">{{ number_format($metrics['activeTours'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-indigo-100 p-4">
                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Reservas</p>
                <p class="text-lg font-black text-indigo-600">{{ number_format($metrics['bookings'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Reservas Pagas</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['paidBookings'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Clientes</p>
                <p class="text-lg font-black text-slate-800">{{ number_format($metrics['customers'], 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- DADOS DA EMPRESA --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Dados cadastrais</p>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">CNPJ</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->document_company ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Cadastur</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->cadastur ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Comissão</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->commission_rate ?? 0 }}%</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Responsável</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->responsable_name ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">E-mail responsável</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->responsable_email ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Contato</p>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">E-mail</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->email ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Telefone</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->phone ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Celular</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->cell_phone ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">WhatsApp</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->whatsapp ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Website</dt>
                        <dd class="font-bold text-slate-700 text-right truncate max-w-[180px]">{{ $company->url ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-5">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Endereço</p>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Endereço</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->street ?? '—' }}, {{ $company->number ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Bairro</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->neighborhood ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Cidade / UF</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->city ?? '—' }} - {{ $company->state ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">CEP</dt>
                        <dd class="font-bold text-slate-700 text-right">{{ $company->zipcode ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Instagram</dt>
                        <dd class="font-bold text-slate-700 text-right truncate max-w-[180px]">{{ $company->instagram ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- GRÁFICOS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4">Faturamento por mês</h3>
                <div style="position: relative; height: 260px;">
                    <canvas id="companyRevenueChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4">Reservas por status</h3>
                <div style="position: relative; height: 260px;">
                    <canvas id="companyBookingsChart"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 p-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4">Passeios por tipo</h3>
                <div style="position: relative; height: 240px;">
                    <canvas id="companyTourTypeChart"></canvas>
                </div>
            </div>
        </div>

        {{-- EMBARCAÇÕES --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mb-6">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-700">Embarcações ({{ $company->vessels->count() }})</h3>
            </div>
            @if($company->vessels->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Nome</th>
                                <th class="px-4 py-3 text-center">Tipo</th>
                                <th class="px-4 py-3 text-center">Capacidade</th>
                                <th class="px-4 py-3 text-center">Passeios</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($company->vessels as $vessel)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-800">{{ $vessel->name }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">{{ $vessel->type ?: '—' }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-center font-black text-slate-700">{{ $vessel->capacity ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center font-black text-slate-700">{{ $vessel->tours->count() }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $vessel->active ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $vessel->active ? 'Ativa' : 'Inativa' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center">
                    <p class="text-sm font-bold text-slate-500">Nenhuma embarcação cadastrada.</p>
                </div>
            @endif
        </div>

        {{-- PASSEIOS --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mb-6">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-700">Passeios ({{ $company->tours->count() }})</h3>
            </div>
            @if($company->tours->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Passeio</th>
                                <th class="px-4 py-3 text-center">Tipo</th>
                                <th class="px-4 py-3 text-center">Embarcação</th>
                                <th class="px-4 py-3 text-right">Preço</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($company->tours as $tour)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-slate-800 max-w-[260px] truncate">{{ $tour->title }}</p>
                                        <p class="text-xs text-slate-400">{{ $tour->views ?? 0 }} views</p>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $tour->tour_type?->badge() ?? 'bg-slate-100 text-slate-600' }}">
                                            {{ $tour->tour_type?->label() ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center text-xs text-slate-500">{{ $tour->vessel?->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-right font-black text-slate-700">R$ {{ number_format($tour->price, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $tour->active ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $tour->active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center">
                    <p class="text-sm font-bold text-slate-500">Nenhum passeio cadastrado.</p>
                </div>
            @endif
        </div>

        {{-- RESERVAS RECENTES --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden mb-6">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-700">Reservas recentes</h3>
            </div>
            @if($recentBookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Código</th>
                                <th class="px-4 py-3">Cliente</th>
                                <th class="px-4 py-3">Passeio</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Pagamento</th>
                                <th class="px-4 py-3 text-right">Total</th>
                                <th class="px-4 py-3 text-right">Criada em</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentBookings as $booking)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs font-bold text-slate-500">#{{ strtoupper(substr($booking->uuid, 0, 8)) }}</td>
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-slate-800 max-w-[160px] truncate">{{ $booking->customer_name }}</p>
                                        <p class="text-xs text-slate-400 max-w-[160px] truncate">{{ $booking->customer_email }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-xs font-semibold text-slate-600 max-w-[180px] truncate">{{ $booking->tour?->title ?? '—' }}</td>
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
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusBadge }}">{{ $booking->status->label() }}</span>
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
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $paymentBadge }}">{{ $booking->payment_status->label() }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-black text-slate-700">R$ {{ number_format($booking->total, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center">
                    <p class="text-sm font-bold text-slate-500">Nenhuma reserva encontrada.</p>
                </div>
            @endif
        </div>

        {{-- CLIENTES --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-700">Clientes ({{ $company->customers->count() }})</h3>
            </div>
            @if($company->customers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">Cliente</th>
                                <th class="px-4 py-3">E-mail</th>
                                <th class="px-4 py-3 text-center">Telefone</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-right">Cadastro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($company->customers as $customer)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-800 max-w-[200px] truncate">{{ $customer->name }}</td>
                                    <td class="px-4 py-3 text-xs text-slate-500 max-w-[200px] truncate">{{ $customer->email }}</td>
                                    <td class="px-4 py-3 text-center text-xs text-slate-500">{{ $customer->cell_phone ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $customer->status ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $customer->status ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right text-xs text-slate-500">{{ $customer->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center">
                    <p class="text-sm font-bold text-slate-500">Nenhum cliente vinculado.</p>
                </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const revenue = @json($revenueChart);
    const statuses = @json($bookingsStatusChart);
    const tourTypes = @json($tourTypeChart);

    new Chart(document.getElementById('companyRevenueChart'), {
        type: 'line',
        data: {
            labels: revenue.labels,
            datasets: [{
                label: 'Faturamento',
                data: revenue.values,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.08)',
                fill: true,
                tension: 0.3,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: (v) => 'R$ ' + v.toLocaleString('pt-BR') } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('companyBookingsChart'), {
        type: 'doughnut',
        data: {
            labels: statuses.labels,
            datasets: [{
                data: statuses.values,
                backgroundColor: ['#f59e0b', '#22c55e', '#ef4444', '#6366f1', '#94a3b8'],
                borderWidth: 3,
                borderColor: '#ffffff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, padding: 16, font: { size: 12 } } } }
        }
    });

    new Chart(document.getElementById('companyTourTypeChart'), {
        type: 'bar',
        data: {
            labels: tourTypes.labels,
            datasets: [{
                label: 'Passeios',
                data: tourTypes.values,
                backgroundColor: 'rgba(16, 185, 129, 0.7)',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush