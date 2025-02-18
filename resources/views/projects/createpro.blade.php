<!-- resources/views/projects/create.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Créer un Projet
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold mb-6">Créer un nouveau projet</h1>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 dark:text-gray-300 font-semibold">Titre du Projet</label>
                <input type="text" name="title" id="title" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 dark:text-gray-300 font-semibold">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required></textarea>
            </div>
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-gray-700 dark:text-gray-300 font-semibold">Date de Début</label>
                    <input type="date" name="start_date" id="start_date" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                </div>
                <div>
                    <label for="end_date" class="block text-gray-700 dark:text-gray-300 font-semibold">Date de Fin</label>
                    <input type="date" name="end_date" id="end_date" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-gray-700 dark:text-gray-300 font-semibold">Statut</label>
                <select name="status" id="status" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
                    <option value="en cours">En cours</option>
                    <option value="terminé">Terminé</option>
                    <option value="en attente">En attente</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Créer le Projet
            </button>
        </form>
    </div>
</x-app-layout>
