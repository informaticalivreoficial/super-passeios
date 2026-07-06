<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield( 'title', env('APP_NAME') )</title>   

    <link rel="icon" href="{{ asset('theme/images/security.ico')}}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body>

    {{ $slot }}   
    <livewire:components.toastr-notification />

    @livewireScripts

    @stack('scripts')
</body>
</html>