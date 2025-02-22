<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord de l'utilisateur.
     *
     * Récupère les projets associés à l'utilisateur connecté,
     * ainsi que leurs tâches, et les transmet à la vue "dashboard".
     */
    public function index()
    {

        $user = Auth::user();


         // Récupérer tous les projets auxquels l'utilisateur participe (avec la relation project)
         $allProjects = $user->projects()->with('tasks')->get();

        // Séparer les projets créés par l'utilisateur et ceux où il est simplement membre
        $createdProjects = $allProjects->where('created_by', $user->id);
        $participatingProjects = $allProjects->where('created_by', '!=', $user->id);

         // Retourne la vue "dashboard" en passant la variable $projects
        return view('dashboard', compact('createdProjects', 'participatingProjects'));

    }
}
