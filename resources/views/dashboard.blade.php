<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-4">Tableau de bord</h1>
        <p class="text-gray-600 dark:text-gray-400">
            Bienvenue, {{ auth()->user()->name }} ! Voici un aperçu de vos projets et tâches.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($projects as $project)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-2">{{ $project->title }}</h2>
                <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                <div class="mt-4">
                    <a href="{{ route('projects.show', $project->id) }}" class="text-blue-500 hover:underline">
                        Voir le projet
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
