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
 
       
 
        h1, h2, h3, h4, .font-display { 
             
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
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--navy), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }
 
        .section-subtitle {
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
        @keyframes slow-zoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
        .animate-slow-zoom {
            animation: slow-zoom 20s infinite alternate;
        }
        [x-cloak] { display: none !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/front.js'])
    
	@stack('styles')
</head>

<body style="background: linear-gradient(180deg, #EEF4FB 0%, #F8FAFC 100%); color: var(--navy);" x-data="cookieConsent">	

    {{-- HEADER --}}
    @include('web.' . $config->template . '.master.header')	

    @yield('content')

    {{-- FOOTER --}}
    @include('web.' . $config->template . '.master.footer')  
    
    <!-- BANNER -->
    <div 
        x-cloak
        x-show="!accepted"
        class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-4 z-40"
    >
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <p>
                Utilizamos cookies para melhorar sua experiência.
            </p>

            <div class="flex gap-3">
                <button @click="acceptAll()" class="bg-green-600 px-4 py-2 rounded">
                    Aceitar todos
                </button>

                <button @click="openModal()" class="bg-gray-600 px-4 py-2 rounded">
                    Preferências
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div 
        x-cloak
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        @click.self="closeModal()"
    >
        <div class="bg-white text-black p-6 rounded w-96 relative">
            
            <button 
                @click="closeModal()" 
                class="absolute top-2 right-2 text-gray-500"
            >
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4">Preferências de Cookies</h2>

            <label class="block mb-2">
                <input type="checkbox" checked disabled>
                Essenciais
            </label>

            <label class="block mb-2">
                <input type="checkbox" x-model="stats">
                Estatísticos
            </label>

            <label class="block mb-4">
                <input type="checkbox" x-model="marketing">
                Marketing
            </label>

            <button 
                @click="save()" 
                class="bg-blue-600 text-white px-4 py-2 rounded w-full"
            >
                Salvar preferências
            </button>
        </div>
    </div> 

    <!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HQ3MRW6582"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'G-HQ3MRW6582');
	</script>	

    @stack('scripts')
</body>
</html>