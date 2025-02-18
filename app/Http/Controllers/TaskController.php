<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     */
    public function create()
    {
        // Si la création de tâche se fait dans le contexte d'un projet, on peut récupérer project_id dans la query string.
        $project_id = request('project_id');
        return view('tasks.create', compact('project_id'));
    }

    /**
     * Enregistre une nouvelle tâche dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date',
            'status'      => 'required|in:en cours,terminée,suspendue',
            'project_id'  => 'required|exists:projects,id',
            // Optionnel : 'assigned_to' si vous souhaitez spécifier un utilisateur assigné
        ]);

        // Si le champ 'assigned_to' n'est pas renseigné, on assigne la tâche à l'utilisateur connecté
        if (!isset($validated['assigned_to'])) {
            $validated['assigned_to'] = Auth::id();
        }

        // Création de la tâche
        $task = Task::create($validated);

        // Gestion des fichiers joints (s'il y en a)
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $uploadedFile) {
                // Stockage du fichier dans le dossier public (ex: storage/app/public/tasks/{id})
                $path = $uploadedFile->store("tasks/{$task->id}", 'public');
                // Création d'une entrée associée dans la table files via la relation définie dans le modèle Task
                $task->files()->create([
                    'file_path'   => $path,
                    'uploaded_by' => Auth::id(),
                ]);
            }
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

        return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour avec succès.');
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
