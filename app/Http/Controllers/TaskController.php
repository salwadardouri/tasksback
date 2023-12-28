<?php

namespace App\Http\Controllers;

use App\Models\tasks;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // Récupérer la liste des tâches
        $tasks = tasks::all();

        // Retourner les tâches en tant que réponse JSON
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        // Valider la requête
        $request->validate([
            'name' => 'required|string|max:255',
            'completed' => 'boolean',
        ]);
         // Vérifier si une tâche avec le même nom existe déjà
    $existingTask = tasks::where('name', $request->input('name'))->first();

    if ($existingTask) {
        // Retourner un message indiquant que la tâche existe déjà
        return response()->json(['message' => 'La tâche existe déjà.'], 422);
    }

        // Créer une nouvelle tâche
        $task = tasks::create([
            'name' => $request->input('name'),
            'completed' => $request->input('completed', false),
        ]);

        // Retourner la nouvelle tâche en tant que réponse JSON
        return response()->json($task, 201);
    }

  
    public function update($id, Request $request)
    {
        try {
            $task = tasks::findOrFail($id);
    
            // Sauvegarde des valeurs avant la mise à jour
            $oldName = $task->name;
            $oldCompleted = $task->completed;
    
            $task->name = $request->input('name');
            $task->completed = $request->input('completed', false);
            $task->save();
    
            // Comparaison des valeurs avant et après la mise à jour
            if ($oldName === $task->name && $oldCompleted === $task->completed) {
                // Aucune mise à jour n'a été effectuée
                return response()->json(['status' => 'error', 'message' => 'Rien à mettre à jour.']);
            }
    
            return response()->json(['status' => 'success', 'message' => 'La tâche a été mise à jour avec succès.']);
        } catch (\Exception $e) {
            // Gestion de l'erreur lorsqu'une tâche n'est pas trouvée
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de la mise à jour de la tâche.']);
        }
    }
    

    public function destroy($id)
    {
        // Trouver la tâche à supprimer
        $task = tasks::findOrFail($id);

        // Supprimer la tâche
        $task->delete();

        // Retourner une réponse JSON
        return response()->json(['message' => 'Tâche supprimée avec succès']);
    }

    public function getById($id)
    {
        try {
            // Trouver la tâche par son ID
            $task = tasks::findOrFail($id);
    
            // Retourner la tâche en tant que réponse JSON
            return response()->json($task);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Retourner une réponse 404 si la tâche n'est pas trouvée
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        } catch (\Exception $e) {
            // Retourner une réponse 500 en cas d'erreur
            return response()->json(['message' => 'Erreur lors de la récupération de la tâche'], 500);
        }
    }
    
    
}
