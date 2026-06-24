<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#2563EB">
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #2563EB;
            --primary-dark: #1d4ed8;
            --secondary: #4F46E5;
            --accent: #F97316;
            --success: #16A34A;
            --warning: #F59E0B;
            --danger: #DC2626;
            --navy: #0f172a;
            --slate: #64748b;
            --light: #EEF4FB;
            --white: #FFFFFF;
            --border: #E2E8F0;
        }
 
        * { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
 
        h1, h2, h3, h4, .font-display { 
            font-family: 'Syne', sans-serif; 
        }
 
        /* Navbar Styles */
        .nav-link {
            position: relative;
            color: var(--navy);
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s;
            padding: 0.5rem 0;
        }
 
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 2px;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
 
        .nav-link:hover { 
            color: var(--primary); 
        }
        .nav-link:hover::after { 
            width: 100%; 
        }
 
        /* Button Styles */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            border-radius: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.3);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
 
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
 
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #4338CA);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
        }
 
        .btn-primary:hover::before {
            left: 100%;
        }
 
        .btn-primary:active {
            transform: translateY(0);
        }
 
        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #F59E0B, #D97706);
            color: white;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            border-radius: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
            border: none;
            cursor: pointer;
        }
 
        .btn-gold:hover {
            background: linear-gradient(135deg, #D97706, #B45309);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.4);
        }
 
        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: white;
            color: var(--navy);
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.875rem;
            border-radius: 0.875rem;
            transition: all 0.3s;
            border: 2px solid var(--border);
        }
 
        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
 
        /* Card Styles */
        .card-tour {
            background: white;
            border-radius: 1.25rem;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
 
        .card-tour:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
            border-color: var(--primary);
        }
 
        /* Badge Styles */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.025em;
            text-transform: uppercase;
        }
 
        .badge-primary {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(79, 70, 229, 0.1));
            border: 1px solid rgba(37, 99, 235, 0.2);
            color: var(--primary);
        }
 
        .badge-success {
            background: rgba(22, 163, 74, 0.1);
            border: 1px solid rgba(22, 163, 74, 0.2);
            color: var(--success);
        }
 
        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }
 
        .badge-accent {
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(234, 88, 12, 0.1));
            border: 1px solid rgba(249, 115, 22, 0.2);
            color: var(--accent);
        }
 
        /* Section Styles */
        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--navy), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }
 
        .section-subtitle {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.125rem;
            color: var(--slate);
            line-height: 1.6;
        }
 
        /* Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
 
        .glass-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
 
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
 
        .gradient-text-gold {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
 
        /* Wave Divider */
        .wave-divider {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
 
        /* Scroll suave */
        html { 
            scroll-behavior: smooth; 
        }
 
        /* Animações */
        @keyframes fadeUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
 
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
 
        @keyframes slideInRight {
            from { 
                opacity: 0;
                transform: translateX(30px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
 
        @keyframes pulse-glow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(37, 99, 235, 0.3);
            }
            50% { 
                box-shadow: 0 0 40px rgba(37, 99, 235, 0.6);
            }
        }
 
        .animate-fade-up {
            animation: fadeUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
 
        .animate-fade-in {
            animation: fadeIn 0.6s ease forwards;
        }
 
        .animate-slide-in {
            animation: slideInRight 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
 
        .animate-pulse-glow {
            animation: pulse-glow 2s infinite;
        }
 
        /* Stagger children animations */
        .stagger-children > * {
            opacity: 0;
            animation: fadeUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
 
        .stagger-children > *:nth-child(1) { animation-delay: 0.1s; }
        .stagger-children > *:nth-child(2) { animation-delay: 0.2s; }
        .stagger-children > *:nth-child(3) { animation-delay: 0.3s; }
        .stagger-children > *:nth-child(4) { animation-delay: 0.4s; }
        .stagger-children > *:nth-child(5) { animation-delay: 0.5s; }
        .stagger-children > *:nth-child(6) { animation-delay: 0.6s; }
 
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
 
        ::-webkit-scrollbar-track {
            background: var(--light);
        }
 
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 4px;
        }
 
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
 
        /* Selection */
        ::selection {
            background: rgba(37, 99, 235, 0.2);
            color: var(--navy);
        }
    </style>
	@stack('styles')
</head>

<body style="background: linear-gradient(180deg, #EEF4FB 0%, #F8FAFC 100%); color: var(--navy);">	

    {{-- NAVBAR MODERNIZADA --}}
    <nav class="sticky top-0 z-50 glass shadow-lg" style="border-bottom: 1px solid rgba(226, 232, 240, 0.5);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">

                {{-- Logo --}}
                <a href="{{ route('web.home') }}" class="flex items-center gap-3 group flex-shrink-0">
                    <div class="relative">
                        <img
                            src="{{ $config->getlogo() }}"
                            alt="{{ $config->app_name }}"
                            class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block'"
                        >
                        <span
                            class="font-display font-800 text-xl hidden"
                            style="font-family: 'Syne', sans-serif; font-weight: 800; background: linear-gradient(135deg, var(--navy), var(--primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"
                        >
                            {{ $config->app_name }}
                        </span>
                    </div>
                </a>

                {{-- Links Desktop --}}
                <div class="hidden lg:flex items-center gap-1">
                    <a href="{{ route('web.site.tours') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-blue-50 transition-all">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M3 17l4-8 4 4 4-6 4 10"/>
                            </svg>
                            Passeios
                        </span>
                    </a>
                    <a href="{{ route('web.home') }}#empresas" class="nav-link px-3 py-2 rounded-lg hover:bg-blue-50 transition-all">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Empresas
                        </span>
                    </a>
                    @if($config->whatsapp)
                        <a
                            href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}"
                            target="_blank"
                            class="nav-link px-3 py-2 rounded-lg hover:bg-blue-50 transition-all"
                        >
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/>
                                </svg>
                                Contato
                            </span>
                        </a>
                    @endif
                </div>

                {{-- Botões CTA APENAS Desktop --}}
                <div class="hidden lg:flex items-center gap-3">
                    <a href="{{ route('login') }}" class="btn-outline text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Entrar
                    </a>
                    <a href="{{route('register.company')}}" class="btn-gold text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4"/>
                        </svg>
                        Cadastre sua empresa
                    </a>
                </div>

                {{-- APENAS Botão Menu Mobile --}}
                <button class="lg:hidden btn-outline p-2" onclick="toggleMobileMenu()" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden lg:hidden glass border-t border-gray-200">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('web.site.tours') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-all font-semibold text-gray-700">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 17l4-8 4 4 4-6 4 10"/>
                    </svg>
                    Passeios
                </a>
                <a href="{{ route('web.home') }}#empresas" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-all font-semibold text-gray-700">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Empresas
                </a>
                @if($config->whatsapp)
                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank" 
                        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-50 transition-all font-semibold text-gray-700">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/>
                        </svg>
                        WhatsApp
                    </a>
                @endif
                
                {{-- Botões CTA APENAS Mobile --}}
                <div class="pt-4 space-y-2 border-t border-gray-200 mt-4">
                    <a href="{{ route('login') }}" class="btn-outline w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Entrar
                    </a>
                    <a href="{{route('register.company')}}" class="btn-gold w-full justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4"/>
                        </svg>
                        Cadastre sua empresa
                    </a>
                </div>
            </div>
        </div>
    </nav>	

    @yield('content')

    {{-- FOOTER MODERNIZADO --}}
    <footer class="relative overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);">
        
        {{-- Decorative Elements --}}
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
 
                {{-- Brand --}}
                <div class="lg:col-span-2">
                    <img
                        src="{{ $config->getlogo() }}"
                        alt="{{ $config->app_name }}"
                        class="h-10 w-auto object-contain mb-6 brightness-200"
                        onerror="this.style.display='none'"
                    >
                    <p class="text-sm leading-relaxed mb-8" style="color: rgba(255,255,255,0.6); max-width: 360px;">
                        {{ Str::limit($config->information, 180) }}
                    </p>
                    <div class="flex items-center gap-3">
                        @if($config->instagram)
                            <a href="{{ $config->instagram }}" target="_blank" 
                                class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:bg-gradient-to-br hover:from-pink-500 hover:to-purple-500"
                                style="background: rgba(255,255,255,0.1);">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                        @if($config->facebook)
                            <a href="{{ $config->facebook }}" target="_blank" 
                                class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:bg-blue-600"
                                style="background: rgba(255,255,255,0.1);">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        @endif
                        @if($config->whatsapp)
                            <a href="https://wa.me/55{{ preg_replace('/\D/', '', $config->whatsapp) }}" target="_blank" 
                                class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:bg-green-500"
                                style="background: rgba(255,255,255,0.1);">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
 
                {{-- Links --}}
                <div>
                    <h4 class="font-display font-700 text-sm uppercase tracking-widest mb-6" 
                        style="font-family: 'Syne', sans-serif; background: linear-gradient(135deg, #F59E0B, #D97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Portal
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('web.home') }}" class="text-sm transition-all duration-300 hover:text-white flex items-center gap-2 group" 
                                style="color: rgba(255,255,255,0.6);">
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7"/>
                                </svg>
                                Passeios
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('web.home') }}#empresas" class="text-sm transition-all duration-300 hover:text-white flex items-center gap-2 group" 
                                style="color: rgba(255,255,255,0.6);">
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7"/>
                                </svg>
                                Empresas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}" class="text-sm transition-all duration-300 hover:text-white flex items-center gap-2 group" 
                                style="color: rgba(255,255,255,0.6);">
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7"/>
                                </svg>
                                Área da empresa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('web.contact') }}" class="text-sm transition-all duration-300 hover:text-white flex items-center gap-2 group" 
                                style="color: rgba(255,255,255,0.6);">
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M9 5l7 7-7 7"/>
                                </svg>
                                Atendimento ao cliente
                            </a>
                        </li>
                    </ul>
                </div>
 
                {{-- Contato --}}
                <div>
                    <h4 class="font-display font-700 text-sm uppercase tracking-widest mb-6" 
                        style="font-family: 'Syne', sans-serif; background: linear-gradient(135deg, #F59E0B, #D97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Contato
                    </h4>
                    <ul class="space-y-3">
                        @if($config->email)
                            <li class="flex items-center gap-3 text-sm" style="color: rgba(255,255,255,0.6);">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $config->email }}
                            </li>
                        @endif
                        @if($config->whatsapp)
                            <li class="flex items-center gap-3 text-sm" style="color: rgba(255,255,255,0.6);">
                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/>
                                </svg>
                                {{ $config->whatsapp }}
                            </li>
                        @endif
                        @if($config->city)
                            <li class="flex items-center gap-3 text-sm" style="color: rgba(255,255,255,0.6);">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $config->city }}, {{ $config->state }}
                            </li>
                        @endif
                    </ul>
                </div>
 
            </div>
 
            <div class="mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4" 
                style="border-top: 1px solid rgba(255,255,255,0.08);">
                <p class="text-sm" style="color: rgba(255,255,255,0.4);">
                    © {{ date('Y') }} {{ $config->app_name }}. Todos os direitos reservados.
                </p>
                <div class="flex items-center gap-6">
                    @if($config->privacy_policy)
                        <a href="#" class="text-sm transition-all duration-300 hover:text-white" 
                            style="color: rgba(255,255,255,0.4);">
                            Política de Privacidade
                        </a>
                    @endif
                    @if($config->terms_condicions)
                        <a href="#" class="text-sm transition-all duration-300 hover:text-white" 
                            style="color: rgba(255,255,255,0.4);">
                            Termos de Uso
                        </a>
                    @endif
                </div>
            </div>
 
        </div>
    </footer>

    {{-- Mobile Menu Script --}}
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>

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