<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\PasswordController;

Route::get('/', function () {
    return view('welcome');
});

// Regrouper toutes les routes nécessitant une authentification et une vérification d'email
Route::middleware(['auth', 'verified'])->group(function () {

    // Route vers le dashboard via DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes pour le profil utilisateur (gérées par Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/partials', [ProfileController::class, 'update'])->name('partials.update');
    Route::delete('/partials', [ProfileController::class, 'destroy'])->name('partials.destroy');
    Route::put('/partials', [PasswordController::class, 'update'])->name('partials.update');

    // Routes pour la gestion des projets
    // Vos méthodes dans ProjectController retourneront les vues avec le suffixe "pro" (ex. : 'projects.indexpro')
    Route::resource('projects', ProjectController::class);

    // Routes pour la gestion des tâches
    Route::resource('tasks', TaskController::class);

    // Route pour ajouter un membre directement au projet
    Route::post('/projects/{project}/add-member', [ProjectController::class, 'addMemberDirectly'])
     ->name('projects.add-member');

     Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');

    
});



// Route pour inviter un utilisateur au projet
Route::post('/projects/{project}/invite', [ProjectController::class, 'inviteUser'])
    ->middleware(['auth', 'verified'])
    ->name('projects.invite');

// Route pour accepter l’invitation (lien dans l’e-mail)
Route::get('/projects/{project}/join', [ProjectController::class, 'joinProject'])
    ->middleware('auth') // On peut exiger que l'utilisateur soit connecté pour rejoindre
    ->name('projects.join');




require __DIR__.'/auth.php';
