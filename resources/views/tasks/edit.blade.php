<!-- resources/views/tasks/edit.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Modifier la Tâche
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold mb-6">Modifier la tâche</h1>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700 dark:text-gray-300 font-semibold">Titre de la Tâche</label>
                <input type="text" name="title" id="title" value="{{ $task->title }}" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 dark:text-gray-300 font-semibold">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required>{{ $task->description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="due_date" class="block text-gray-700 dark:text-gray-300 font-semibold">Date d'Échéance</label>
                <input type="date" name="due_date" id="due_date" value="{{ $task->due_date }}" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-gray-700 dark:text-gray-300 font-semibold">Statut</label>
                <select name="status" id="status" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    <option value="en cours" @if($task->status == 'en cours') selected @endif>En cours</option>
                    <option value="terminée" @if($task->status == 'terminée') selected @endif>Terminée</option>
                    <option value="suspendue" @if($task->status == 'suspendue') selected @endif>Suspendue</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="attachment" class="block text-gray-700 dark:text-gray-300 font-semibold">Modifier les Fichiers joints (optionnel)</label>
                <input type="file" name="attachment[]" id="attachment" multiple class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Mettre à jour la Tâche
            </button>
        </form>
    </div>
</x-app-layout>
