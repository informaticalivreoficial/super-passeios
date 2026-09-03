<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-history mr-2"></i> Histórico de Envios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.newsletter.index') }}">Newsletter</a></li>
                        <li class="breadcrumb-item active">Histórico</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 -m-4 p-4 lg:p-6">

        {{-- MÉTRICAS --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
            <div class="bg-white rounded-2xl border border-slate-100 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total de Campanhas</p>
                <p class="text-lg font-black text-slate-800">{{ $totalCampaigns }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-green-100 p-4">
                <p class="text-[10px] font-bold text-green-500 uppercase tracking-widest mb-1">Total de E-mails Enviados</p>
                <p class="text-lg font-black text-green-600">{{ number_format($totalSent, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- LISTAGEM --}}
        @if($campaigns->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Assunto</th>
                                <th class="px-4 py-3 text-center">Enviados</th>
                                <th class="px-4 py-3 text-center">Sucesso</th>
                                <th class="px-4 py-3 text-center">Falhas</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Data</th>
                                <th class="px-4 py-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($campaigns as $campaign)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-4 py-3 text-xs text-slate-500">{{ $campaign->id }}</td>
                                    <td class="px-4 py-3 font-bold text-slate-800 max-w-[300px] truncate">
                                        {{ $campaign->subject }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                            {{ $campaign->total_recipients }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600">
                                            {{ $campaign->sent_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $campaign->failed_count > 0 ? 'bg-red-50 text-red-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $campaign->failed_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($campaign->status === 'sent')
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600">Enviado</span>
                                        @elseif($campaign->status === 'sending')
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-600">Enviando...</span>
                                        @else
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600">Falhou</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs text-slate-500">
                                        {{ $campaign->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('admin.newsletter.campaign.show', $campaign->id) }}"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors"
                                            title="Ver detalhes">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">{{ $campaigns->links() }}</div>
        @else
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 py-16 text-center">
                <p class="text-sm font-bold text-slate-500">Nenhuma campanha enviada ainda.</p>
            </div>
        @endif
    </div>
</div>
