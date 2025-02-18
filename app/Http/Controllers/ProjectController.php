<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Affiche la liste des projets de l'utilisateur connecté.
     */
    public function index()
    {
        // On récupère les projets auxquels l'utilisateur connecté participe.
        $projects = Auth::user()->projects;
        return view('projects.indexpro', compact('projects'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau projet.
     */
    public function create()
    {
        return view('projects.createpro');
    }

    /**
     * Enregistre un nouveau projet dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'status'      => 'required|in:en cours,terminé,en attente',
        ]);

        // Ajout de l'utilisateur créateur (champ created_by)
        $validated['created_by'] = Auth::id();

        // Création du projet
        $project = Project::create($validated);

        // On attache l'utilisateur au projet via la table pivot avec le rôle "admin"
        $project->users()->attach(Auth::id(), ['role' => 'admin']);

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès.');
    }

    /**
     * Affiche les détails d'un projet (avec ses tâches associées).
     */
    public function show(string $id)
    {
        $project = Project::with('tasks')->findOrFail($id);
        return view('projects.showpro', compact('project'));
    }

    /**
     * Affiche le formulaire d'édition d'un projet.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.editpro', compact('project'));
    }

    /**
     * Met à jour un projet dans la base de données.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'status'      => 'required|in:en cours,terminé,en attente',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Projet mis à jour avec succès.');
    }

    /**
     * Supprime un projet de la base de données.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès.');
    }
}
