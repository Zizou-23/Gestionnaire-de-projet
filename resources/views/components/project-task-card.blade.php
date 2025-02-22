<!-- resources/views/components/project-task-card.blade.php -->

@props([
    'project',
    'tasks',
])

<div class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">

    <!-- Icône à gauche (vous pouvez la personnaliser) -->
    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-[#FF2D20]/10 sm:size-16">
        <svg class="size-5 sm:size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <g fill="#FF2D20">
                <!-- Le chemin de l'icône -->
                <path d="M16.597 12.635a.247.247 0 0 0-.08-.237 2.234 2.234 0 0 1-.769-1.68c.001-.195.03-.39.084-.578a.25.25 0 0 0-.09-.267 8.8 8.8 0 0 0-4.826-1.66.25.25 0 0 0-.268.181 2.5 2.5 0 0 1-2.4 1.824.045.045 0 0 0-.045.037 12.255 12.255 0 0 0-.093 3.86.251.251 0 0 0 .208.214c2.22.366 4.367 1.08 6.362 2.118a.252.252 0 0 0 .32-.079 10.09 10.09 0 0 0 1.597-3.733Z" />
                <!-- Vous pouvez continuer le code SVG pour votre icône -->
            </g>
        </svg>
    </div>

    <!-- Contenu principal -->
    <div class="pt-3 sm:pt-5 flex-1">
        <h2 class="text-xl font-semibold text-black dark:text-white">
            {{ $project->title }}
        </h2>
        <p class="mt-1 text-sm/relaxed text-gray-600 dark:text-gray-300">
            {{ $project->description }}
        </p>

        <!-- Liste des tâches du projet -->
        <div class="mt-4 space-y-2">
            @foreach($tasks as $task)
                <div class="border rounded p-2 dark:border-gray-700">
                    <strong class="text-black dark:text-white">{{ $task->title }}</strong>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        {{ $task->description }}
                    </p>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:underline text-sm">
                        Modifier
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>


