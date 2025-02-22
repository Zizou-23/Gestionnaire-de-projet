<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;                   // Si vous utilisez User dans ProjectController
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;    // Si vous utilisez URL::signedRoute
use Illuminate\Support\Facades\Mail;   // Si vous envoyez des e-mails
use App\Mail\ProjectInvitationMail;    // Si vous envoyez un mail ProjectInvitationMail



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

    public function addMemberDirectly(Request $request, $projectId)
{
    // Validation des données reçues
    $validated = $request->validate([
        'contact' => 'required|string',
        'role'    => 'required|in:admin,membre',
    ]);

    // Rechercher l'utilisateur par email ou par nom
    $user = User::where('email', $validated['contact'])
            ->orWhere('name', $validated['contact'])
            ->first();

    if (!$user) {
        return redirect()->back()->withErrors(['contact' => 'Utilisateur introuvable.']);
    }

    // Récupérer le projet
    $project = Project::findOrFail($projectId);

    // Attacher l'utilisateur au projet avec le rôle spécifié sans détacher les autres membres déjà présents
    $project->users()->syncWithoutDetaching([
        $user->id => ['role' => $validated['role']]
    ]);

    return redirect()->back()->with('success', 'Utilisateur ajouté au projet avec succès.');
}



    /**
     * Invite un utilisateur à rejoindre le projet.
     */
    public function inviteUser(Request $request, $projectId)
    {
        // Valider les données : on attend 'contact' (email ou nom) et 'role'
        $validated = $request->validate([
            'contact' => 'required|string',
            'role'    => 'required|in:admin,membre',
        ]);

        // Chercher l'utilisateur par e-mail (vous pouvez aussi permettre la recherche par nom si souhaité)
        $user = User::where('email', $validated['contact'])->first();

        // Si l'utilisateur n'existe pas, vous pouvez envisager de créer un enregistrement temporaire ou
        // envoyer un e-mail invitant à s'inscrire. Ici, nous allons supposer que l'utilisateur doit déjà exister.
        if (!$user) {
            return redirect()->back()->withErrors(['contact' => 'Utilisateur introuvable.']);
        }

        $project = Project::findOrFail($projectId);

        // Générer un lien signé pour rejoindre le projet
        $joinUrl = URL::signedRoute('projects.join', [
            'project' => $project->id,
            'user'    => $user->id,
            'role'    => $validated['role'],
        ], now()->addDays(7)); // Le lien est valide 7 jours par exemple

        // Envoyer l'invitation par e-mail
        Mail::to($user->email)->send(new ProjectInvitationMail($project, $joinUrl));

        return back()->with('success', 'Invitation envoyée.');
    }
    
    /**
     * Permet à un utilisateur d’accepter une invitation pour rejoindre le projet.
     */
    public function joinProject(Request $request, $projectId)
    {
        // Vérifier la validité du lien signé
        if (! $request->hasValidSignature()) {
            abort(403, 'Lien invalide ou expiré.');
        }
        
        // Récupérer le projet et l'utilisateur via les paramètres
        $project = Project::findOrFail($projectId);
        $userId = $request->query('user');
        $role   = $request->query('role', 'membre'); // par défaut membre

        // Vérifier que l'utilisateur authentifié correspond bien à celui de l'invitation
        if (auth()->id() != $userId) {
            abort(403, 'Vous n’êtes pas autorisé à rejoindre ce projet.');
        }
        
        // Attacher l'utilisateur au projet via la table pivot avec le rôle spécifié
        $project->users()->syncWithoutDetaching([
            auth()->id() => ['role' => $role]
        ]);

        return redirect()->route('projects.show', $project->id)
                         ->with('success', 'Vous avez rejoint le projet avec succès.');
    }

    



}
