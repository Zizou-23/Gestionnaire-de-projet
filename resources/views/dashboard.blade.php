<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-4">Tableau de bord</h1>
        <p class="text-gray-600 dark:text-gray-400">
            Bienvenue, {{ auth()->user()->name }} ! Voici vos projets.
        </p>
    </div>

    <!-- Projets créés par l'utilisateur -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Mes Projets Créés</h2>
        @if($createdProjects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($createdProjects as $project)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-xl font-semibold">{{ $project->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                        <a href="{{ route('projects.show', $project->id) }}" class="text-blue-500 hover:underline mt-2 inline-block">Voir le projet</a>
                    </div>
                @endforeach
            </div>
        @else
            <p>Aucun projet créé par vous.</p>
        @endif
    </div>

    <!-- Projets auxquels l'utilisateur participe -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Projets auxquels je participe</h2>
        @if($participatingProjects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($participatingProjects as $project)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h3 class="text-xl font-semibold">{{ $project->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                        <a href="{{ route('projects.show', $project->id) }}" class="text-blue-500 hover:underline mt-2 inline-block">Voir le projet</a>
                    </div>
                @endforeach
            </div>
        @else
            <p>Vous ne participez à aucun projet pour le moment.</p>
        @endif
    </div>
</x-app-layout>
