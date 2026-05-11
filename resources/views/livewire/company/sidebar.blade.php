<div>
    <aside
        class="sidebar-bg sidebar-border fixed lg:static inset-y-0 left-0 z-50 w-64 flex flex-col transform transition-transform duration-300 lg:min-h-screen"
        :class="sidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    >

        {{-- LOGO --}}
        <div class="h-16 px-5 flex items-center justify-between" style="border-bottom: 1px solid rgba(255,255,255,0.07);">

            <div class="flex items-center gap-2.5">

                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background-color: #fadd37;">
                    <svg class="w-4 h-4" style="color: #051e34;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M12 2a4 4 0 100 8 4 4 0 000-8zM12 10v12M4.93 14.93A10 10 0 0012 22a10 10 0 007.07-7.07M4 18h16"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-extrabold leading-none" style="color: #efebe0;">Náutico</p>
                    <p class="text-[11px] leading-none mt-0.5" style="color: #87c2c0;">Painel da Empresa</p>
                </div>

            </div>

            <button
                class="lg:hidden w-7 h-7 flex items-center justify-center rounded-lg"
                style="color: #87c2c0;"
                @click="sidebar = false"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>

        </div>

        {{-- USER --}}
        <div class="px-4 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07);">

            <div class="user-card flex items-center gap-3 px-3 py-2.5 rounded-xl">

                <div class="avatar-bg w-9 h-9 rounded-xl flex items-center justify-center font-extrabold text-sm shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="overflow-hidden">
                    <p class="font-bold text-sm truncate leading-tight" style="color: #efebe0;">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs truncate leading-tight" style="color: #87c2c0;">
                        {{ auth()->user()->email }}
                    </p>
                </div>

            </div>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            <p class="section-label text-[10px] font-bold uppercase tracking-widest px-3 pb-2">Menu</p>

            <a
                href="{{ route('company.dashboard') }}"
                @class([
                    'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition',
                    'nav-active' => request()->routeIs('company.dashboard'),
                    'nav-inactive' => !request()->routeIs('company.dashboard'),
                ])
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            @if(auth()->check() && auth()->user()->company_id)

                <a
                    href="{{ route('company.company.edit', auth()->user()->company_id) }}"
                    @class([
                        'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition',
                        'nav-active' => request()->routeIs('company.company.edit'),
                        'nav-inactive' => !request()->routeIs('company.company.edit'),
                    ])
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Minha Empresa
                </a>

            @else

                <a
                    href="{{ route('company.company.create') }}"
                    class="create-dashed flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    Criar Empresa
                </a>

            @endif

            <a
                href="{{ route('company.vessels.index') }}"
                @class([
                    'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition',
                    'nav-active' => request()->routeIs('company.vessels.*'),
                    'nav-inactive' => !request()->routeIs('company.vessels.*'),
                ])
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 20a2 2 0 002 2h16a2 2 0 002-2M3 12l9-9 9 9M5 12v6h14v-6"/></svg>
                Embarcações
            </a>

            <a
                href="{{ route('company.tours.index') }}"
                @class([
                    'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition',
                    'nav-active' => request()->routeIs('company.tours.*'),
                    'nav-inactive' => !request()->routeIs('company.tours.*'),
                ])
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 17l4-8 4 4 4-6 4 10"/><path d="M3 21h18"/></svg>
                Passeios
            </a>

            <a
                href="{{ route('company.bookings.index') }}"
                @class([
                    'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition',
                    'nav-active' => request()->routeIs('company.bookings.*'),
                    'nav-inactive' => !request()->routeIs('company.bookings.*'),
                ])
            >
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Reservas
            </a>

        </nav>

        {{-- LOGOUT --}}
        <div class="p-3" style="border-top: 1px solid rgba(255,255,255,0.07);">

            <button
                type="button"
                wire:click="logout"
                class="btn-logout w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sair
            </button>

        </div>

    </aside>
</div>
