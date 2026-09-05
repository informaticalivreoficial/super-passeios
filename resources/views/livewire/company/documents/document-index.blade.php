<div class="max-w-6xl mx-auto space-y-6">

    {{-- Alerta de Pendências --}}
    @if($hasPendingRequired)
        <div class="rounded-2xl overflow-hidden" style="border: 1px solid #fde68a; background-color: #fffbeb;">
            <div class="flex items-center gap-3 px-6 py-4">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(245,158,11,0.1);">
                    <svg class="w-5 h-5" style="color: #d97706;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold" style="color: #92400e;">
                        Você possui {{ $pendingCount }} {{ Str::plural('documento obrigatório aguardando aceite', $pendingCount) }}.
                    </p>
                    <p class="text-xs mt-0.5" style="color: #a16207;">
                        Aceite os documentos abaixo para manter sua conta em dia.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="rounded-2xl overflow-hidden" style="border: 1px solid #bbf7d0; background-color: #f0fdf4;">
            <div class="flex items-center gap-3 px-6 py-4">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(35,197,94,0.1);">
                    <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold" style="color: #166534;">Todos os documentos obrigatórios estão atualizados.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Lista de Documentos --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">

        <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid #f0ece4;">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background-color: rgba(51,123,188,0.1);">
                <svg class="w-5 h-5" style="color: #337bbc;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold" style="color: #051e34;">Contratos e Documentos</h2>
                <p class="text-xs" style="color: #87c2c0;">Visualize e aceite os documentos e contratos.</p>
            </div>
        </div>

        <div class="divide-y" style="border-color: #f0ece4;">
            @forelse($documentsWithStatus as $item)
                @php
                    $doc = $item['document'];
                    $status = $item['status'];
                @endphp
                <a href="{{ route('company.documents.show', $doc->id) }}"
                   class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition group">

                    {{-- Status Icon --}}
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 @if($status === 'accepted') bg-green-50 @elseif($status === 'pending') bg-red-50 @elseif($status === 'update_available') bg-yellow-50 @else bg-slate-50 @endif">
                        @if($status === 'accepted')
                            <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($status === 'pending')
                            <svg class="w-5 h-5" style="color: #e53e3e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                        @elseif($status === 'update_available')
                            <svg class="w-5 h-5" style="color: #d97706;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        @else
                            <svg class="w-5 h-5" style="color: #94a3b8;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold truncate" style="color: #051e34;">{{ $doc->title }}</p>
                            @if($doc->is_required)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-50 text-red-600 shrink-0">Obrigatório</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500 shrink-0">Opcional</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-xs" style="color: #87c2c0;">v{{ $doc->version }}</span>
                            @if($doc->published_at)
                                <span class="text-xs" style="color: #c5bfb2;">Publicado em {{ $doc->published_at->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="shrink-0">
                        @if($status === 'accepted')
                            <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold bg-green-50 text-green-700">Aceito</span>
                        @elseif($status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold bg-red-50 text-red-700 animate-pulse">Aceite pendente</span>
                        @elseif($status === 'update_available')
                            <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold bg-yellow-50 text-yellow-700">Atualização disponível</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold bg-slate-100 text-slate-500">Opcional</span>
                        @endif
                    </div>

                    {{-- Arrow --}}
                    <svg class="w-4 h-4 shrink-0 transition-transform group-hover:translate-x-0.5" style="color: #c5bfb2;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto mb-3" style="color: #e8e4d8;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-sm font-bold" style="color: #b0a98a;">Nenhum documento disponível no momento.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
