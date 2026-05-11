<!DOCTYPE html>
<html lang="pt-br">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">       

        {{-- Content --}}
        <main class="flex-1 p-8">

            {{ $slot }}

        </main>

    </div>

    @livewireScripts

</body>
</html>