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
                <span
                    class="font-display font-800 text-xl hidden items-center"
                    style="font-family: 'Syne', sans-serif; font-weight: 800; background: linear-gradient(135deg, var(--navy), var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"
                >
                    {{ $config->app_name }}
                </span>
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

                @if($config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}"
                    target="_blank"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-600 transition-all duration-200 hover:bg-green-50"
                    style="color: #16a34a;">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        WhatsApp
                    </a>
                @endif
            </div>  
            
            {{-- Busca --}}
            <div class="hidden lg:block flex-1">
                <livewire:web.search-dropdown />
            </div>

            
            <a href="{{ route('customer.login') }}"
            class="btn-outline justify-center text-sm py-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Entrar
            </a>
            

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

            @if($config->whatsapp)
                <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}"
                target="_blank"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-green-50 text-sm font-600"
                style="color: #16a34a;">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(22,163,74,0.1);">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </span>
                    WhatsApp
                </a>
            @endif

        </div>

        <div class="px-4 pb-5 pt-2" style="border-top: 1px solid #f1f5f9;">
            <a href="{{ route('customer.login') }}"
            class="w-full btn-outline justify-center text-sm py-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Entrar
            </a>            
        </div>

    </div>

    <div class="md:hidden px-4 pb-4">

        <form
            action="#"
            method="GET"
            class="relative"
        >

            <svg
                class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
            </svg>

            <input
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Buscar passeios..."
                class="w-full h-12 pl-12 pr-4 rounded-2xl border border-slate-200"
            >

        </form>

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