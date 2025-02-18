<!-- resources/views/projects/show.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Détails du Projet
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold mb-4">{{ $project->title }}</h1>
        <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
        
        <div class="mt-6">
            <h2 class="text-2xl font-semibold mb-4">Tâches associées</h2>
            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mb-4 inline-block">Ajouter une Tâche</a>
            @if($project->tasks->count() > 0)
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($project->tasks as $task)
                        <li class="py-4 flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-semibold">{{ $task->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-300">{{ Str::limit($task->description, 100) }}</p>
                            </div>
                            <div class="flex space-x-4">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Confirmez-vous la suppression de cette tâche ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600 dark:text-gray-300">Aucune tâche n'a été ajoutée pour ce projet.</p>
            @endif
        </div>
    </div>
</x-app-layout>
