<!-- resources/views/projects/index.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Liste des Projets
    </x-slot>

    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold">Projets</h1>
        <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Créer un Projet
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($projects as $project)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold">{{ $project->title }}</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">{{ Str::limit($project->description, 150) }}</p>
                <div class="mt-4 flex space-x-4">
                    <a href="{{ route('projects.show', $project->id) }}" class="text-blue-500 hover:underline">Voir</a>
                    <a href="{{ route('projects.edit', $project->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Confirmez-vous la suppression de ce projet ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <p>Aucun projet trouvé.</p>
        @endforelse
    </div>
</x-app-layout>
