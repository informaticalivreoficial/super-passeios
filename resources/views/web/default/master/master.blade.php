<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#ec0000">
	<meta name="msvalidate.01" content="AB238289F13C246C5E386B6770D9F10E" />
    <meta name="copyright" content="{{$config->init_date}} - {{$config->app_name}}">
    <meta name="language" content="pt-br" /> 
    <meta name="author" content="{{config('app.desenvolvedor')}}"/>
    <meta name="designer" content="Renato Montanari">
    <meta name="publisher" content="Renato Montanari">
    <meta name="url" content="{{$config->domain}}" />
    <meta name="keywords" content="{{$config->metatags}}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="Dec 26">

    {!! $head ?? '' !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">
	
	<!-- Favicon and touch icons  -->
	<link href="{{$config->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="144x144">
	<link href="{{$config->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="114x114">
	<link href="{{$config->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="72x72">
	<link href="{{$config->getfaveicon()}}" rel="apple-touch-icon-precomposed">
	<link href="{{$config->getfaveicon()}}" rel="shortcut icon">	

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
	
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy:    #051e34;
            --teal:    #16a3b7;
            --teal-light: #e8f7fa;
            --green:   #23c55e;
            --gold:    #fadd37;
            --sand:    #f5f3ee;
            --muted:   #87c2c0;
        }
 
        * { font-family: 'DM Sans', sans-serif; }
 
        h1, h2, h3, h4, .font-display { font-family: 'Syne', sans-serif; }
 
        .nav-link {
            position: relative;
            color: var(--navy);
            font-weight: 500;
            font-size: 0.875rem;
            transition: color 0.2s;
        }
 
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--teal);
            transition: width 0.3s;
        }
 
        .nav-link:hover { color: var(--teal); }
        .nav-link:hover::after { width: 100%; }
 
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            background: var(--teal);
            color: white;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            border-radius: 0.75rem;
            transition: all 0.2s;
            box-shadow: 0 2px 0 #0e7a8a;
        }
 
        .btn-primary:hover {
            background: #13919e;
            transform: translateY(-1px);
        }
 
        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            background: var(--gold);
            color: var(--navy);
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            border-radius: 0.75rem;
            transition: all 0.2s;
            box-shadow: 0 2px 0 #c4a800;
        }
 
        .btn-gold:hover {
            background: #f0d000;
            transform: translateY(-1px);
        }
 
        .card-tour {
            background: white;
            border-radius: 1.25rem;
            overflow: hidden;
            border: 1px solid #e8e4d8;
            transition: all 0.3s;
        }
 
        .card-tour:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(5,30,52,0.12);
            border-color: var(--teal);
        }
 
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
 
        .badge-teal {
            background: rgba(22,163,183,0.1);
            border: 1px solid rgba(22,163,183,0.3);
            color: var(--teal);
        }
 
        .badge-gold {
            background: rgba(250,221,55,0.15);
            border: 1px solid rgba(250,221,55,0.4);
            color: #c4a800;
        }
 
        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--navy);
            line-height: 1.2;
        }
 
        .wave-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
 
        /* Scroll suave */
        html { scroll-behavior: smooth; }
 
        /* Animações */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
 
        .animate-fade-up {
            animation: fadeUp 0.6s ease forwards;
        }
    </style>
	@stack('styles')
</head>

<body style="background-color: #fafaf8; color: var(--navy);">	

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm" style="border-bottom: 1px solid #e8e4d8;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
 
                {{-- Logo --}}
                <a href="{{ route('web.home') }}" class="flex items-center gap-3">
                    <img
                        src="{{ $config->getlogo() }}"
                        alt="{{ $config->app_name }}"
                        class="h-9 w-auto object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block'"
                    >
                    <span
                        class="font-display font-800 text-xl hidden"
                        style="font-family: 'Syne', sans-serif; font-weight: 800; color: var(--navy);"
                    >
                        {{ $config->app_name }}
                    </span>
                </a>
 
                {{-- Links --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('web.site.tours') }}" class="nav-link">Passeios</a>
                    <a href="{{ route('web.home') }}#empresas" class="nav-link">Empresas</a>
                    @if($config->whatsapp)
                        <a
                            href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}"
                            target="_blank"
                            class="nav-link"
                        >
                            Contato
                        </a>
                    @endif
                </div>
 
                {{-- CTA --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="nav-link hidden md:block">Entrar</a>
                    <a href="{{route('register.company')}}" class="btn-gold text-sm">
                        Cadastre sua empresa
                    </a>
                </div>
 
            </div>
        </div>
    </nav>	

    @yield('content')

     {{-- FOOTER --}}
    <footer style="background-color: var(--navy); color: white;" class="mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
 
                {{-- Brand --}}
                <div class="md:col-span-2">
                    <img
                        src="{{ $config->getlogofooter() }}"
                        alt="{{ $config->app_name }}"
                        class="h-10 w-auto object-contain mb-4"
                        onerror="this.style.display='none'"
                    >
                    <p class="text-sm leading-relaxed mb-6" style="color: rgba(255,255,255,0.6); max-width: 320px;">
                        {{ Str::limit($config->information, 180) }}
                    </p>
                    <div class="flex items-center gap-3">
                        @if($config->instagram)
                            <a href="{{ $config->instagram }}" target="_blank" class="w-9 h-9 rounded-xl flex items-center justify-center transition hover:opacity-80" style="background: rgba(255,255,255,0.1);">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                        @if($config->facebook)
                            <a href="{{ $config->facebook }}" target="_blank" class="w-9 h-9 rounded-xl flex items-center justify-center transition hover:opacity-80" style="background: rgba(255,255,255,0.1);">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if($config->whatsapp)
                            <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank" class="w-9 h-9 rounded-xl flex items-center justify-center transition hover:opacity-80" style="background: rgba(255,255,255,0.1);">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
 
                {{-- Links --}}
                <div>
                    <h4 class="font-display font-700 text-sm uppercase tracking-widest mb-4" style="font-family: 'Syne', sans-serif; color: var(--gold);">Portal</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('web.home') }}" class="text-sm transition hover:text-white" style="color: rgba(255,255,255,0.6);">Passeios</a></li>
                        <li><a href="{{ route('web.home') }}#empresas" class="text-sm transition hover:text-white" style="color: rgba(255,255,255,0.6);">Empresas</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm transition hover:text-white" style="color: rgba(255,255,255,0.6);">Área da empresa</a></li>
                    </ul>
                </div>
 
                {{-- Contato --}}
                <div>
                    <h4 class="font-display font-700 text-sm uppercase tracking-widest mb-4" style="font-family: 'Syne', sans-serif; color: var(--gold);">Contato</h4>
                    <ul class="space-y-2">
                        @if($config->email)
                            <li class="text-sm" style="color: rgba(255,255,255,0.6);">{{ $config->email }}</li>
                        @endif
                        @if($config->whatsapp)
                            <li class="text-sm" style="color: rgba(255,255,255,0.6);">{{ $config->whatsapp }}</li>
                        @endif
                        @if($config->city)
                            <li class="text-sm" style="color: rgba(255,255,255,0.6);">{{ $config->city }}, {{ $config->state }}</li>
                        @endif
                    </ul>
                </div>
 
            </div>
 
            <div class="mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <p class="text-xs" style="color: rgba(255,255,255,0.4);">
                    © {{ date('Y') }} {{ $config->app_name }}. Todos os direitos reservados.
                </p>
                <div class="flex items-center gap-4">
                    @if($config->privacy_policy)
                        <a href="#" class="text-xs transition hover:text-white" style="color: rgba(255,255,255,0.4);">Política de Privacidade</a>
                    @endif
                    @if($config->terms_condicions)
                        <a href="#" class="text-xs transition hover:text-white" style="color: rgba(255,255,255,0.4);">Termos de Uso</a>
                    @endif
                </div>
            </div>
 
        </div>
    </footer>

    <!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HQ3MRW6582"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-HQ3MRW6582');
	</script>

	@livewireScripts

    @stack('scripts')
</body>
</html>