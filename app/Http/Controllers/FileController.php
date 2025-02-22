<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Affiche la liste de tous les fichiers (optionnel, souvent utilisé dans le contexte d'une tâche).
     */
    public function index()
    {
        $files = File::all(); // Vous pouvez filtrer par utilisateur ou par tâche si besoin
        return view('files.index', compact('files'));
    }

    /**
     * Affiche le formulaire de création d'un fichier (peu utilisé, car l'upload se fait via le TaskController).
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Stocke un fichier téléchargé dans le stockage et crée son enregistrement dans la base de données.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'task_id'   => 'required|exists:tasks,id',
        'attachment' => 'required|file',
    ]);

    $filePath = $request->file('attachment')->store("tasks/{$validated['task_id']}", 'public');

    File::create([
        'task_id'     => $validated['task_id'],
        'file_path'   => $filePath,
        'uploaded_by' => auth()->id(),
    ]);

    return back()->with('success', 'Fichier uploadé avec succès.');
}


    /**
     * Affiche les détails d'un fichier ou lance son téléchargement.
     */
    public function show(string $id)
    {
        $file = File::findOrFail($id);
        // Téléchargement du fichier depuis le disque public
        return Storage::disk('public')->download($file->file_path);
    }

    public function download(File $file)
{
    // Vérifier si l’utilisateur a le droit de télécharger (optionnel)
    // if (!Gate::allows('download-file', $file)) { ... }

    return Storage::disk('public')->download($file->file_path);
}


    /**
     * Affiche le formulaire d'édition d'un fichier (rarement nécessaire).
     */
    public function edit(string $id)
    {
        $file = File::findOrFail($id);
        return view('files.edit', compact('file'));
    }

    /**
     * Met à jour le fichier (par exemple, pour remplacer un fichier existant).
     */
    public function update(Request $request, string $id)
    {
        $file = File::findOrFail($id);

        $validated = $request->validate([
            'attachment' => 'required|file',
        ]);

        // Suppression de l'ancien fichier
        Storage::disk('public')->delete($file->file_path);

        // Stockage du nouveau fichier
        $newPath = $request->file('attachment')->store("tasks/{$file->task_id}", 'public');
        $file->update(['file_path' => $newPath]);

        return redirect()->back()->with('success', 'Fichier mis à jour avec succès.');
    }

    /**
     * Supprime un fichier et son enregistrement dans la base de données.
     */
    public function destroy(string $id)
    {
        $file = File::findOrFail($id);
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->back()->with('success', 'Fichier supprimé avec succès.');
    }
}
