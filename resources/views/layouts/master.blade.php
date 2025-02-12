<!-- resources/views/layout/master.blade.php -->
<!DOCTYPE html>
<html lang="fr" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion de Projets')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Inclusion d'AlpineJS pour gérer l'état de la sidebar -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    @include('layouts.header')
    
    <!-- Wrapper pour la sidebar et le contenu principal -->
    <div class="flex">
        <!-- Inclusion de la sidebar -->
        @include('layouts.sidebar')
        
        <!-- Zone de contenu principal ajustée pour laisser la place à la sidebar -->
        <div class="flex-1 ml-0 lg:ml-64">
            <main class="container mx-auto mt-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    <footer class="text-center p-4 bg-gray-200 mt-10">
        <p>&copy; 2025 Gestionnaire de Projet - Tous droits réservés.</p>
    </footer>
</body>
</html>
