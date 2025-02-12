<!-- resources/views/layout/header.blade.php -->
<header class="bg-blue-600 text-white py-4 px-6 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Gestionnaire de Projets</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="{{ route('dashboard') }}" class="hover:underline">Tableau de bord</a></li>
                <li><a href="{{ route('projects.index') }}" class="hover:underline">Projets</a></li>
                <li><a href="{{ route('tasks.index') }}" class="hover:underline">Tâches</a></li>
                <li>
                    <!-- Exemple de lien de déconnexion. Assure-toi d'avoir une route ou un formulaire pour la déconnexion -->
                    <a href="{{ route('logout') }}" class="hover:underline"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</header>
