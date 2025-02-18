<!-- resources/views/tasks/index.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Liste des Tâches
    </x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-4">Liste des Tâches</h1>
        @if(isset($tasks) && $tasks->count() > 0)
            <ul class="list-disc pl-5">
                @foreach($tasks as $task)
                    <li class="mb-2">
                        <strong>{{ $task->title }}</strong>
                        <p>{{ $task->description }}</p>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:underline">Modifier</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucune tâche n'a été trouvée.</p>
        @endif
    </div>
</x-app-layout>
