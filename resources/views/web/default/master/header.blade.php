<nav class="sticky top-0 z-50" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(226,232,240,0.8); box-shadow: 0 1px 20px rgba(0,0,0,0.06);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center h-16 lg:h-20 gap-6">

            {{-- Logo --}}
            <a href="{{ route('web.home') }}" class="flex items-center gap-3 group flex-shrink-0">
                <img
                    src="{{ $config->getlogo() }}"
                    alt="{{ $config->app_name }}"
                    class="h-10 w-auto object-contain transition-all duration-300 group-hover:scale-105 group-hover:opacity-80"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                >
            </a>            

            {{-- Links Desktop --}}
            <div class="hidden lg:flex items-center gap-1 mx-8">
                <a href="{{ route('web.site.tours') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-600 transition-all duration-200 hover:bg-blue-50"
                style="color: var(--navy);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Passeios
                </a>

                <a href="{{ route('web.site.companies') }}"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-600 transition-all duration-200 hover:bg-blue-50"
                style="color: var(--navy);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Operadoras
                </a>                
            </div>  
            
            {{-- Busca --}}
            <div class="hidden lg:block flex-1">
                <livewire:web.search-dropdown />
            </div>

            <div class="flex items-center gap-3 ml-auto lg:ml-0">

                {{-- Botão Desktop --}}
                <div class="hidden lg:flex items-center gap-1 mx-8">
                    @if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->hasRole('proprietary'))
                        <a href="{{ route('company.dashboard') }}"
                        class="btn-outline justify-center text-sm py-2.5">
                            Meu Painel
                        </a>
                    @elseif(Auth::guard('customer')->check() && Auth::guard('customer')->user()->hasRole('client'))
                        <a href="{{ route('customer.orders.find') }}"
                        class="btn-outline justify-center text-sm py-2.5">
                            Meus Pedidos
                        </a>
                    @else
                        <a href="{{ route('customer.login') }}"
                        class="btn-outline justify-center text-sm py-2.5">
                            Entrar
                        </a>
                    @endif
                </div>

                {{-- Botão Mobile --}}
                <button
                    onclick="toggleMobileMenu()"
                    class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl transition-all duration-200 hover:bg-gray-100"
                    style="color: var(--navy);"
                    aria-label="Menu"
                >
                    <svg id="icon-menu" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>           
            

        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu"
        class="hidden lg:hidden"
        style="background: white; border-top: 1px solid #f1f5f9;">

        <div class="px-4 py-4 space-y-1">

            <a href="{{ route('web.site.tours') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-blue-50 text-sm font-600"
            style="color: var(--navy);">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(37,99,235,0.1);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--primary);">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                Passeios
            </a>

            <a href="{{ route('web.site.companies') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-blue-50 text-sm font-600"
            style="color: var(--navy);">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(37,99,235,0.1);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color: var(--primary);">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
                Operadoras
            </a>            
        </div>

        <div class="px-4 pb-5 pt-2" style="border-top: 1px solid #f1f5f9;">
            @if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->hasRole('proprietary'))
                <a href="{{ route('company.dashboard') }}"
                class="w-full btn-outline justify-center text-sm py-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Meu Painel
                </a>
            @elseif(Auth::guard('customer')->check() && Auth::guard('customer')->user()->hasRole('client'))
                <a href="{{ route('customer.orders.find') }}"
                class="w-full btn-outline justify-center text-sm py-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Meus Pedidos
                </a>
            @else
                <a href="{{ route('customer.login') }}"
                class="w-full btn-outline justify-center text-sm py-2.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Entrar
                </a>
            @endif        
        </div>

    </div>

    <div class="md:hidden px-4 pb-4">
        <livewire:web.search-dropdown />
    </div>
</nav>

@push('scripts')
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const iconMenu = document.getElementById('icon-menu');
            const iconClose = document.getElementById('icon-close');

            menu.classList.toggle('hidden');
            iconMenu.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        }
    </script>
@endpush