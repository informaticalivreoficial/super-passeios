<div class="max-w-4xl mx-auto space-y-6" x-data="{ scrolled: false, showScrollTop: false }"
     @scroll.window="scrolled = window.scrollY > 200; showScrollTop = window.scrollY > 500">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs" style="color: #87c2c0;">
        <a href="{{ route('company.documents.index') }}" class="hover:underline">Contratos e Documentos</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
        <span style="color: #051e34;">{{ $document->title }}</span>
    </div>

    {{-- Header do Documento --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;">
        <div class="px-6 py-5" style="border-bottom: 1px solid #f0ece4;">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-lg font-extrabold" style="color: #051e34;">{{ $document->title }}</h1>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600">v{{ $document->version }}</span>
                        @if($document->is_required)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-50 text-red-600">Obrigatório</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-500">Opcional</span>
                        @endif
                    </div>
                    @if($document->description)
                        <p class="text-sm mt-1" style="color: #87c2c0;">{{ $document->description }}</p>
                    @endif
                </div>

                {{-- Status --}}
                <div class="shrink-0">
                    @if($status === 'accepted')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-green-50 text-green-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Aceito
                        </span>
                    @elseif($status === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-red-50 text-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                            Aceite pendente
                        </span>
                    @elseif($status === 'update_available')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-yellow-50 text-yellow-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Atualização disponível
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-slate-100 text-slate-500">Opcional</span>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap gap-4 mt-3 text-xs" style="color: #b0a98a;">
                @if($document->published_at)
                    <span>Publicado em {{ $document->published_at->format('d/m/Y') }}</span>
                @endif
                @if($document->effective_at)
                    <span>Vigente a partir de {{ $document->effective_at->format('d/m/Y') }}</span>
                @endif
                @if($document->expires_at)
                    <span>Válido até {{ $document->expires_at->format('d/m/Y') }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Conteúdo --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;" id="document-content">
        <div class="px-6 py-5">
                <div class="prose prose-sm prose-slate max-w-none">
                    {!! $renderedContent !!}
            </div>
        </div>
    </div>

    {{-- Aceite --}}
    @if($status !== 'accepted' && $document->isPublished())
        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8e4d8;"
             x-data="{ checked: false, viewed: @js($hasViewed) }"
             @mark-as-viewed.window="viewed = true">
            <div class="px-6 py-5 space-y-4">

                @if(!$hasViewed)
                    <div class="flex items-center gap-3 p-4 rounded-xl" style="background-color: #fffbeb; border: 1px solid #fde68a;" x-show="!viewed" x-transition>
                        <svg class="w-5 h-5 shrink-0" style="color: #d97706;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
                        </svg>
                        <p class="text-sm" style="color: #92400e;">Você precisa visualizar o conteúdo completo antes de aceitar.</p>
                    </div>
                @endif

                <label class="flex items-start gap-3 cursor-pointer group">
                    <input type="checkbox" x-model="checked" wire:model="agreeTerms" class="mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm font-bold transition group-hover:text-blue-600" style="color: #051e34;">
                        Li e concordo com este documento
                    </span>
                </label>

                <div class="flex items-center gap-3 pt-2">
                    <button
                        type="button"
                        wire:click="accept"
                        :disabled="!checked || !viewed"
                        :class="checked && viewed ? 'text-white cursor-pointer' : 'text-slate-400 cursor-not-allowed'"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-extrabold transition"
                        :style="checked && viewed ? 'background-color: #23c55e; color: #ffffff; box-shadow: 0 2px 0 #15803d;' : 'background-color: #f1f5f9;'"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        Aceitar e Continuar
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Botão Voltar --}}
    <div>
        <a href="{{ route('company.documents.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold transition"
           style="color: #87c2c0; border: 1px solid #e8e4d8;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            Voltar
        </a>
    </div>

    {{-- Scroll to top button --}}
    <button
        x-show="showScrollTop"
        x-transition
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 w-10 h-10 rounded-full flex items-center justify-center shadow-lg z-50 transition"
        style="background-color: #23c55e; color: white;">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg>
    </button>

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                const observer = new IntersectionObserver(
                    (entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.markAsViewed();
                                window.dispatchEvent(new CustomEvent('mark-as-viewed'));
                                observer.disconnect();
                            }
                        });
                    },
                    { threshold: 0.1 }
                );

                const target = document.getElementById('document-content');
                if (target) {
                    observer.observe(target);
                }
            });
        </script>
    @endpush
</div>
