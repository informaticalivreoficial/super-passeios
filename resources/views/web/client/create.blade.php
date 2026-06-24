<!DOCTYPE html>
<html lang="pt-br">
<head>
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