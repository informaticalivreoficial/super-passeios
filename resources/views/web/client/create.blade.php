<!DOCTYPE html>
<html lang="pt-br">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>

    {{ $slot }}   
    <livewire:components.toastr-notification />

    @livewireScripts
</body>
</html>