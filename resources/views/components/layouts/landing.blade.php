<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name'))</title>

    @vite([
        'resources/css/app.css',
        'resources/js/front.js'
    ])

    @stack('styles')
</head>

<body class="bg-white text-slate-900 antialiased">

    @yield('content')

    @stack('scripts')

</body>
</html>