<!-- resources/views/layout/header.blade.php -->
<header class="bg-gray-50 dark:bg-black py-6">
    <div class="container mx-auto flex justify-between items-center">
        <div>
            <a href="{{ url('/') }}">
                <!-- Vous pouvez remplacer cette image par votre logo -->
                <img src="https://laravel.com/assets/img/welcome/background.svg" alt="Logo" class="h-10">
            </a>
        </div>
        <nav class="flex space-x-4">
            <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">Dashboard</a>
            <a href="{{ route('projects.index') }}" class="rounded-md px-3 py-2 transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">Projets</a>
            <a href="{{ route('tasks.index') }}" class="rounded-md px-3 py-2 transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">Tâches</a>
            <a href="{{ route('profile.edit') }}" class="rounded-md px-3 py-2 transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">Profil</a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="rounded-md px-3 py-2 transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
               Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </nav>
    </div>
</header>
