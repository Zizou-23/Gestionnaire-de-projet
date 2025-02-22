<!-- resources/views/projects/show.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Détails du Projet
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8 space-y-8">
        <!-- En-tête du projet -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h1 class="text-3xl font-bold mb-2 text-gray-800 dark:text-white">
                {{ $project->title }}
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
                {{ $project->description }}
            </p>
        </div>

        <!-- Gestion des membres : ajout direct + liste -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-6">
            <!-- Ajouter un membre (sans email) -->
            <div>
                <h2 class="text-2xl font-semibold mb-2 text-gray-800 dark:text-white">
                    Ajouter un membre
                </h2>
                <form action="{{ route('projects.add-member', $project->id) }}"
                      method="POST"
                      class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    @csrf
                    <input
                        type="text"
                        name="contact"
                        placeholder="Nom ou e-mail"
                        class="w-full sm:w-auto p-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring focus:ring-blue-200"
                        required
                    >
                    <select
                        name="role"
                        class="p-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring focus:ring-blue-200"
                    >
                        <option value="membre">Membre</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button
                        type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition">
                        Ajouter Utilisateur
                    </button>
                </form>
            </div>

            <!-- Inviter un membre par email -->
            <div>
                <h2 class="text-2xl font-semibold mb-2 text-gray-800 dark:text-white">
                    Inviter un membre par e-mail
                </h2>
                <form action="{{ route('projects.invite', $project->id) }}"
                      method="POST"
                      class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    @csrf
                    <input
                        type="text"
                        name="contact"
                        placeholder="Adresse e-mail ou nom d'utilisateur"
                        class="w-full sm:w-auto p-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring focus:ring-blue-200"
                        required
                    >
                    <select
                        name="role"
                        class="p-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring focus:ring-blue-200"
                    >
                        <option value="membre">Membre</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button
                        type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition">
                        Envoyer l’invitation
                    </button>
                </form>
            </div>

            <!-- Liste des membres -->
            <div>
                <h2 class="text-2xl font-semibold mb-2 text-gray-800 dark:text-white">
                    Membres du Projet
                </h2>
                @if($project->users->count() > 0)
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($project->users as $member)
                            <li class="text-gray-700 dark:text-gray-300">
                                <span class="font-medium text-gray-800 dark:text-white">{{ $member->name }}</span>
                                <span class="text-sm text-gray-500">({{ $member->pivot->role }})</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600 dark:text-gray-300">
                        Aucun membre n'a encore rejoint ce projet.
                    </p>
                @endif
            </div>
        </div>

        <!-- Section des tâches -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">
                    Tâches associées
                </h2>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition">
                   Ajouter une Tâche
                </a>
            </div>

            @if($project->tasks->count() > 0)
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($project->tasks as $task)
                        <li class="py-4 flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">
                                    {{ $task->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    {{ Str::limit($task->description, 100) }}
                                </p>
                            </div>
                            <div class="flex space-x-4">
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                   class="text-blue-500 hover:underline transition">
                                   Modifier
                                </a>
                                <form
                                    action="{{ route('tasks.destroy', $task->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Confirmez-vous la suppression de cette tâche ?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-500 hover:underline transition">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600 dark:text-gray-300">
                    Aucune tâche n'a été ajoutée pour ce projet.
                </p>
            @endif
        </div>
    </div>
</x-app-layout>
