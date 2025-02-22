<!-- resources/views/layout/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Gestionnaire de Projet' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">

<div class="relative min-h-screen">
    <!-- Image de fond -->
    <img
        class="absolute top-0 left-0 w-full h-full object-cover pointer-events-none"
        src="https://laravel.com/assets/img/welcome/background.svg"
        alt="Background"
    />
    
    <!-- Overlay semi-transparent -->
    <div class="absolute top-0 left-0 w-full h-full bg-black opacity-40 pointer-events-none"></div>

    <!-- Contenu de la page -->
    <div class="relative z-20">
        
        <!-- Inclusion du header -->
        @include('layouts.header')

        <main class="container mx-auto px-6 py-8">
            {{ $slot }}
        </main>

        <!-- Inclusion du footer -->
        @include('layouts.footer')

    </div>
</div>

</body>
</html>
