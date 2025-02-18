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
        // Récupérer les projets de l'utilisateur connecté, avec leurs tâches associées
        $projects = Auth::user()->projects()->with('tasks')->get();

        // Retourne la vue "dashboard" en passant la variable $projects
        return view('dashboard', compact('projects'));
    }
}
