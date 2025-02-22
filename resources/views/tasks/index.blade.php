<!-- resources/views/tasks/index.blade.php -->
<x-app-layout>
    <x-slot name="title">
        Liste des Tâches par Projet
    </x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-6">Liste des Tâches par Projet</h1>
        @if(isset($tasks) && $tasks->count() > 0)
            @php
                // Groupement des tâches par projet
                $tasksByProject = $tasks->groupBy('project_id');
            @endphp

            <div class="space-y-8">
                @foreach($tasksByProject as $projectId => $tasksOfProject)
                    @php
                        // On récupère le projet associé à ce groupe de tâches
                        $project = $tasksOfProject->first()->project;
                    @endphp

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <!-- En-tête du projet -->
                        <div class="mb-4 border-b pb-2">
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $project->title }}</h2>
                            <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                        </div>

                        <!-- Liste des tâches du projet -->
                        <div class="space-y-4">
                            @foreach($tasksOfProject as $task)
                                <div class="border border-gray-200 dark:border-gray-700 rounded p-4">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $task->title }}</h3>
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:underline transition">Modifier</a>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 mt-1">{{ Str::limit($task->description, 100) }}</p>
                                    
                                    <!-- Fichiers attachés à la tâche -->
                                    @if($task->files && $task->files->count() > 0)
                                        <div class="mt-2">
                                            <h4 class="text-sm font-semibold text-gray-800 dark:text-white">Fichiers attachés :</h4>
                                            <ul class="list-disc pl-4 space-y-1">
                                                @foreach($task->files as $file)
                                                    <li class="text-sm text-gray-600 dark:text-gray-300">
                                                        {{ $file->file_path }}
                                                        <span class="italic">(uploadé par {{ $file->uploadedBy->name }} le {{ $file->created_at->format('d/m/Y H:i') }})</span>
                                                        <a href="{{ route('files.download', $file->id) }}" class="text-blue-500 hover:underline ml-2">Télécharger</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-300">Aucune tâche n'a été trouvée.</p>
        @endif
    </div>
</x-app-layout>
