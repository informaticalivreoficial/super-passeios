@extends("web.$config->template.master.master")

@section('content')
{{-- HERO --}}
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, var(--navy) 0%, #0a3358 100%); min-height: 320px;">

    {{-- Fundo animado --}}
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 50%, var(--teal) 0%, transparent 50%);"></div>

    
    {{-- Ícones náuticos decorativos --}}
    <div class="absolute top-12 right-12 opacity-5 hidden lg:block">
        <svg class="w-32 h-32" fill="white" viewBox="0 0 24 24">
            <path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.38 0 2.74-.35 4-.99 2.52 1.29 5.48 1.29 8 0 1.26.64 2.62.99 4 .99h2v-2h-2zM3.95 19H4c1.6 0 3.02-.88 4-2 .98 1.12 2.4 2 4 2s3.02-.88 4-2c.98 1.12 2.4 2 4 2h.05l1.89-6.68c.08-.26.06-.54-.06-.78s-.34-.42-.6-.5L20 10.62V6c0-1.1-.9-2-2-2h-3V1H9v3H6c-1.1 0-2 .9-2 2v4.62l-1.29.42c-.26.08-.48.26-.6.5s-.15.52-.06.78L3.95 19zM6 6h12v3.97L12 8 6 9.97V6z"/>
        </svg>
    </div>

    {{-- Onda --}}
    <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="line-height: 0;">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display: block; width: 100%; height: 80px;">
            <path d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,20 1440,40 L1440,80 L0,80 Z" fill="#fafaf8" opacity="0.5"/>
            <path d="M0,50 C480,90 960,10 1440,50 L1440,80 L0,80 Z" fill="#fafaf8"/>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-28">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs mb-10" style="color: rgba(255,255,255,0.5);">
            <a href="{{ route('web.home') }}" class="hover:text-white transition flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-2 0h2"/>
                </svg>
                Início
            </a>
            <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span style="color: rgba(255,255,255,0.8);">Empresas</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">

            {{-- Texto --}}
            <div class="max-w-2xl">                

                <h1 class="text-4xl lg:text-5xl font-800 text-white mb-4 leading-tight" style="font-family: 'Syne', sans-serif;">
                    Empresas de <br>
                    <span style="color: var(--teal);">Passeios Náuticos</span>
                </h1>

                <p class="text-base leading-relaxed" style="color: rgba(255,255,255,0.65); max-width: 480px;">
                    Encontre as melhores operadoras de passeios do litoral norte. Compare, escolha e reserve com segurança.
                </p>

            </div>

            {{-- Stats --}}
            <div class="flex items-center gap-6 shrink-0">

                <div class="text-center">
                    <p class="text-3xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                        {{ $companies->total() }}
                    </p>
                    <p class="text-xs mt-1" style="color: rgba(255,255,255,0.5);">Empresas</p>
                </div>

                <div class="w-px h-10 opacity-20" style="background: white;"></div>

                <div class="text-center">
                    <p class="text-3xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                        {{ $companies->sum('active_tours_count') }}
                    </p>
                    <p class="text-xs mt-1" style="color: rgba(255,255,255,0.5);">Passeios ativos</p>
                </div>

                <div class="w-px h-10 opacity-20" style="background: white;"></div>

                <div class="text-center">
                    <p class="text-3xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                        {{ $companies->sum('bookings_count') }}
                    </p>
                    <p class="text-xs mt-1" style="color: rgba(255,255,255,0.5);">Reservas</p>
                </div>

            </div>

        </div>

    </div>
</section>

{{-- LISTAGEM --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" 
     x-data="loadMoreCompanies()" 
     x-init="init()">

    {{-- Filtros rápidos --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-2 text-sm" style="color: #87c2c0;">
            <span class="font-medium">{{ $companies->total() }}</span>
            <span>empresas encontradas</span>
        </div>
        
        <div class="flex items-center gap-2">
            <button @click="toggleView()" 
                    class="p-2 rounded-lg transition" 
                    style="border: 1px solid #e8e4d8;"
                    :style="viewMode === 'grid' ? 'background: var(--teal); color: white; border-color: var(--teal);' : 'background: white; color: #87c2c0;'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm0 10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10-10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zm0 10a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            </button>
            
            <button @click="toggleView()" 
                    class="p-2 rounded-lg transition" 
                    style="border: 1px solid #e8e4d8;"
                    :style="viewMode === 'list' ? 'background: var(--teal); color: white; border-color: var(--teal);' : 'background: white; color: #87c2c0;'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    @if($companies->count() > 0)

        {{-- Grid de empresas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" 
             :class="viewMode === 'list' ? 'lg:grid-cols-1' : 'lg:grid-cols-3'"
             x-ref="companiesGrid">

            @foreach($companies as $company)

                {{-- Card empresa --}}
                <div class="group bg-white rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1" 
                     style="border: 1px solid #e8e4d8;"
                     :class="viewMode === 'list' ? 'flex flex-col sm:flex-row' : ''">
                    
                    <a href="{{ route('web.site.company', $company->slug) }}" 
                       class="block w-full"
                       :class="viewMode === 'list' ? 'sm:w-64 shrink-0' : ''">
                       
                        {{-- Imagem de capa --}}
                        <div class="relative h-48 overflow-hidden bg-gray-100 group-hover:scale-105 transition-transform duration-500"
                             :class="viewMode === 'list' ? 'h-full min-h-[180px]' : ''">
                            
                            @php
                                $cover = $company->images->firstWhere('cover', true) ?? $company->images->first();
                            @endphp

                            @if($cover)
                                <img src="{{ Storage::url($cover->path) }}" 
                                     alt="{{ $company->alias_name }}"
                                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--navy) 0%, #0a3358 100%);">
                                    <svg class="w-16 h-16 opacity-20" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M3 17l4-8 4 4 4-6 4 10"/>
                                    </svg>
                                </div>
                            @endif

                            {{-- Badge passeios --}}
                            @if($company->active_tours_count > 0)
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full backdrop-blur-sm" 
                                          style="background: rgba(135,194,192,0.95); color: white;">
                                        {{ $company->active_tours_count }} {{ Str::plural('passeio', $company->active_tours_count) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Badge destaque --}}
                            @if($company->is_featured ?? false)
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full backdrop-blur-sm" 
                                          style="background: rgba(255,193,7,0.95); color: #1a1a1a;">
                                        ⭐ Destaque
                                    </span>
                                </div>
                            @endif
                        </div>
                    </a>

                    {{-- Info --}}
                    <div class="p-5 flex flex-col" 
                         :class="viewMode === 'list' ? 'flex-1' : ''">
                        
                        <div class="flex items-center gap-3 mb-3">
                            {{-- Logo --}}
                            <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border" style="border-color: #e8e4d8;">
                                <img src="{{ $company->getLogoUrl() }}" 
                                     alt="{{ $company->alias_name }}"
                                     class="w-full h-full object-cover">
                            </div>

                            <div class="overflow-hidden flex-1">
                                <a href="{{ route('web.site.company', $company->slug) }}" 
                                   class="hover:opacity-70 transition">
                                    <h2 class="font-display font-700 text-base truncate" style="font-family: 'Syne', sans-serif; color: var(--navy);">
                                        {{ $company->alias_name }}
                                    </h2>
                                </a>
                                @if($company->city)
                                    <div class="flex items-center gap-1 text-xs truncate" style="color: #87c2c0;">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $company->city }}, {{ $company->state }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($company->information)
                            <p class="text-sm leading-relaxed line-clamp-2 mb-4 flex-1" style="color: #87c2c0;">
                                {{ Str::limit($company->information, 120) }}
                            </p>
                        @endif

                        {{-- Stats e ação --}}
                        <div class="flex flex-wrap items-center gap-4 pt-4" style="border-top: 1px solid #f0ece4;">
                            <div class="flex items-center gap-4">
                                <span class="flex items-center gap-1.5 text-xs" style="color: #87c2c0;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ number_format($company->views, 0, ',', '.') }}
                                </span>

                                @if($company->bookings_count > 0)
                                    <span class="flex items-center gap-1.5 text-xs" style="color: #87c2c0;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        {{ number_format($company->bookings_count, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('web.site.company', $company->slug) }}" 
                               class="ml-auto flex items-center gap-1 text-xs font-semibold transition group-hover:gap-2" 
                               style="color: var(--teal);">
                                Ver empresa
                                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- Load More Button --}}
        <div class="mt-12 text-center" x-show="hasMore" x-transition>
            <button @click="loadMore()" 
                    :disabled="loading"
                    class="group relative px-8 py-3 rounded-full font-semibold text-sm transition-all duration-300 overflow-hidden"
                    style="background: var(--navy); color: white;"
                    :style="loading ? 'opacity: 0.7; cursor: not-allowed;' : ''">
                
                {{-- Efeito de onda --}}
                <span class="absolute inset-0 w-full h-full rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300"
                      style="background: radial-gradient(circle at center, white 0%, transparent 70%);"></span>
                
                <span class="relative flex items-center gap-2">
                    <span x-show="!loading">Carregar mais empresas</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Carregando...
                    </span>
                    <svg x-show="!loading" class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </span>
            </button>
            
            {{-- Contador --}}
            <p class="mt-3 text-xs" style="color: #c5bfb2;">
                Mostrando <span x-text="visibleCount"></span> de <span x-text="totalCount"></span> empresas
            </p>
        </div>

    @else

        {{-- Empty State --}}
        <div class="py-24 text-center rounded-2xl" style="border: 2px dashed #e8e4d8;">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: rgba(135,194,192,0.1);">
                <svg class="w-10 h-10" style="color: #c5bfb2;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M3 17l4-8 4 4 4-6 4 10"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2" style="color: var(--navy);">Nenhuma empresa encontrada</h3>
            <p class="text-sm" style="color: #87c2c0;">Tente ajustar seus filtros ou volte mais tarde.</p>
        </div>

    @endif

</div>

@endsection

{{-- Script para Load More com Alpine.js --}}
@push('scripts')
<script>
    function loadMoreCompanies() {
        return {
            // Estado
            viewMode: 'grid',
            page: 1,
            loading: false,
            hasMore: true,
            totalCount: {{ $companies->total() }},
            visibleCount: {{ $companies->count() }},
            
            init() {
                // Carregar preferência do usuário
                const savedMode = localStorage.getItem('companyViewMode');
                if (savedMode) {
                    this.viewMode = savedMode;
                }
            },
            
            toggleView() {
                this.viewMode = this.viewMode === 'grid' ? 'list' : 'grid';
                localStorage.setItem('companyViewMode', this.viewMode);
            },
            
            async loadMore() {
                if (this.loading || !this.hasMore) return;
                
                this.loading = true;
                this.page++;
                
                try {
                    // Usar a rota correta para load-more
                    const response = await fetch(`/empresas/load-more?page=${this.page}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`Erro ${response.status}: ${response.statusText}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.companies && data.companies.length > 0) {
                        // Adicionar novos cards ao grid
                        const grid = this.$refs.companiesGrid;
                        
                        // Criar um container temporário
                        const tempContainer = document.createElement('div');
                        tempContainer.innerHTML = data.html;
                        
                        // Pegar os cards individuais
                        const cards = tempContainer.children;
                        
                        // Adicionar cada card com animação
                        Array.from(cards).forEach((child, index) => {
                            // Clonar para evitar referências
                            const newCard = child.cloneNode(true);
                            
                            // Configurar estado inicial para animação
                            newCard.style.opacity = '0';
                            newCard.style.transform = 'translateY(30px)';
                            newCard.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                            
                            // Adicionar ao grid
                            grid.appendChild(newCard);
                            
                            // Animar com delay progressivo
                            setTimeout(() => {
                                newCard.style.opacity = '1';
                                newCard.style.transform = 'translateY(0)';
                            }, 100 + (index * 80));
                        });
                        
                        this.visibleCount += data.companies.length;
                        this.hasMore = data.has_more;
                        
                        // Atualizar contador
                        this.updateCounter();
                        
                    } else {
                        this.hasMore = false;
                    }
                    
                } catch (error) {
                    console.error('Erro ao carregar mais empresas:', error);
                    this.page--;
                    
                    // Mostrar feedback para o usuário
                    this.showError('Não foi possível carregar mais empresas. Tente novamente.');
                    
                } finally {
                    this.loading = false;
                }
            },
            
            updateCounter() {
                // Atualizar o texto do contador se existir
                const counterEl = document.querySelector('[x-text="visibleCount"]');
                if (counterEl) {
                    counterEl.textContent = this.visibleCount;
                }
            },
            
            showError(message) {
                // Criar toast de erro
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50';
                toast.style.cssText = `
                    background: #dc2626;
                    color: white;
                    font-size: 0.875rem;
                    font-weight: 500;
                    animation: slideUp 0.3s ease-out;
                    max-width: 400px;
                `;
                toast.textContent = message;
                document.body.appendChild(toast);
                
                // Remover após 3 segundos
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        }
    }
</script>

{{-- Estilos para animações --}}
<style>
    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Estilo para o scroll suave ao carregar mais */
    .load-more-trigger {
        scroll-margin-top: 100px;
    }
</style>
@endpush
