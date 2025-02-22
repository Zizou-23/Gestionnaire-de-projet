<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskAssignedNotification;

class TaskController extends Controller
{
    /**
     * Affiche la liste des tâches assignées à l'utilisateur connecté.
     */
    public function index()
    {
        // On récupère les tâches assignées à l'utilisateur connecté.
        $tasks = Auth::user()->tasks;
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle tâche.
     */public function create(Request $request)
{
    // Récupérer l'ID du projet depuis la query string
    $projectId = $request->query('project_id');

    // Si project_id est fourni, récupérer le projet correspondant
    $project = null;
    if ($projectId) {
        $project = Project::with('users')->find($projectId);
    }

    // Retourner la vue en transmettant la variable $project (même si null)
    return view('tasks.create', compact('project'));
}

    /**
     * Enregistre une nouvelle tâche dans la base de données.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date'    => 'nullable|date',
        'status'      => 'required|in:en cours,terminée,suspendue',
        'project_id'  => 'required|exists:projects,id',
        'assigned_to' => 'nullable|exists:users,id',
    ]);

    $task = Task::create($validated);

    // Envoi d’un e-mail si un utilisateur est assigné (voir section 2)
    if (!empty($validated['assigned_to'])) {
        $user = User::find($validated['assigned_to']);
        $user->notify(new TaskAssignedNotification($task));
    }
    

    return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès.');
}


    /**
     * Affiche les détails d'une tâche.
     */
    public function show(string $id)
    {
        $task = Task::with('files')->findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Affiche le formulaire d'édition d'une tâche.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Met à jour une tâche dans la base de données.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date',
            'status'      => 'required|in:en cours,terminée,suspendue',
        ]);

        $task->update($validated);

        // Si de nouveaux fichiers sont joints lors de l'édition, on les gère
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $uploadedFile) {
                $path = $uploadedFile->store("tasks/{$task->id}", 'public');
                $task->files()->create([
                    'file_path'   => $path,
                    'uploaded_by' => Auth::id(),
                ]);
            }
        }

             // Envoi d’un e-mail si un utilisateur est assigné (voir section 2)
        if (!empty($validated['assigned_to'])) {
            $user = User::find($validated['assigned_to']);
            $user->notify(new TaskAssignedNotification($task));
        }
            // Si le statut a changé
        if ($task->wasChanged('status')) {
            broadcast(new TaskStatusUpdated($task));
        }

    return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour.');
    }

    /**
     * Supprime une tâche de la base de données.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
