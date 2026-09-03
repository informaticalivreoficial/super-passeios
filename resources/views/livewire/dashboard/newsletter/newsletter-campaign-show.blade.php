<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-envelope-open-text mr-2"></i> {{ $campaign->subject }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.newsletter.index') }}">Newsletter</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.newsletter.history') }}">Histórico</a></li>
                        <li class="breadcrumb-item active">Campanha #{{ $campaign->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        {{-- INFO DA CAMPANHA --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-1">Assunto</p>
                    <p class="text-sm font-bold text-slate-800">{{ $campaign->subject }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-1">Enviado em</p>
                    <p class="text-sm text-slate-600">{{ $campaign->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-1">Status</p>
                    @if($campaign->status === 'sent')
                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600">Enviado</span>
                    @elseif($campaign->status === 'sending')
                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-600">Enviando...</span>
                    @else
                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600">Falhou</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ESTATÍSTICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</p>
                <p class="text-lg font-black text-slate-800">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Enviados</p>
                <p class="text-lg font-black text-green-600">{{ $stats['sent'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-red-100 p-4">
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Falhas</p>
                <p class="text-lg font-black text-red-600">{{ $stats['failed'] }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-yellow-100 p-4">
                <p class="text-[10px] font-bold text-yellow-500 uppercase tracking-widest mb-1">Pendentes</p>
                <p class="text-lg font-black text-yellow-600">{{ $stats['pending'] }}</p>
            </div>
        </div>

        {{-- CONTEÚDO DO E-MAIL --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
            <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-3">Conteúdo do E-mail</p>
            <div class="border border-slate-200 rounded-xl p-4 prose prose-sm max-w-none">
                {!! $campaign->body !!}
            </div>
        </div>

        {{-- LISTA DE DESTINATÁRIOS --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-100">
                <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">Destinatários</p>
            </div>

            @if($sends->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">E-mail</th>
                                <th class="px-4 py-3">Nome</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3">Enviado em</th>
                                <th class="px-4 py-3">Erro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($sends as $send)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 text-xs text-slate-600">
                                        {{ $send->newsletter?->email ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-600">
                                        {{ $send->newsletter?->name ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($send->status === 'sent')
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600">Enviado</span>
                                        @elseif($send->status === 'failed')
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600">Falhou</span>
                                        @else
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-600">Pendente</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-500">
                                        {{ $send->sent_at ? $send->sent_at->format('d/m/Y H:i') : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs text-red-500 max-w-[200px] truncate">
                                        {{ $send->error ?: '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <p class="text-sm text-slate-500">Nenhum envio registrado.</p>
                </div>
            @endif
        </div>
    </div>
</div>
