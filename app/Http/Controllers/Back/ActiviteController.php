<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Activite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class ActiviteController extends Controller
{
    /**
     * Liste toutes les activités
     */
    public function index()
    {
        Log::info('📋 Liste des activités consultée', ['user_id' => auth()->id()]);
        // Pagination pour la vue (15 par page)
        $activites = Activite::withCount('documents')
            ->orderBy('est_active', 'desc')
            ->orderBy('nom', 'asc')
            ->paginate(15);

        // Statistiques globales (calculées sur l'ensemble des enregistrements)
        $all = Activite::withCount('documents')->get();
        $stats = [
            'total' => $all->count(),
            'actives' => $all->where('est_active', true)->count(),
            'inactives' => $all->where('est_active', false)->count(),
            'documents_total' => $all->sum('documents_count'),
        ];

        return view('back.activites.index', compact('activites', 'stats'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        Log::info('➕ Formulaire création activité affiché');

        $couleurs = [
            '#3B82F6' => 'Bleu',
            '#10B981' => 'Vert',
            '#F59E0B' => 'Orange',
            '#EF4444' => 'Rouge',
            '#8B5CF6' => 'Violet',
            '#EC4899' => 'Rose',
        ];

        $icones = [
            'fa-broom' => 'Balai',
            'fa-fire' => 'Flamme',
            'fa-water' => 'Eau',
            'fa-tools' => 'Outils',
            'fa-cogs' => 'Engrenages',
            'fa-wrench' => 'Clé',
            'fa-thermometer-half' => 'Thermomètre',
        ];

        return view('back.activites.create', compact('couleurs', 'icones'));
    }

    /**
     * Enregistre une nouvelle activité
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:activites,code',
            'description' => 'nullable|string',
            'couleur' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'est_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $activite = Activite::create([
                'nom' => $request->nom,
                'code' => $request->code,
                'description' => $request->description,
                'couleur' => $request->couleur ?? '#3B82F6',
                'icon' => $request->icon ?? 'fa-tools',
                'est_active' => $request->has('est_active'),
                'user_id' => auth()->id(),
            ]);

            DB::commit();

            Log::info('✅ Activité créée', [
                'id' => $activite->id,
                'nom' => $activite->nom,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('back.activites.index')
                ->with('success', 'Activité créée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Erreur création activité', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return back()
                ->withInput()
                ->withErrors('Erreur lors de la création de l\'activité : ' . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Activite $activite)
    {
        Log::info('✏️ Formulaire édition activité', ['activite_id' => $activite->id]);

        $couleurs = [
            '#3B82F6' => 'Bleu',
            '#10B981' => 'Vert',
            '#F59E0B' => 'Orange',
            '#EF4444' => 'Rouge',
            '#8B5CF6' => 'Violet',
            '#EC4899' => 'Rose',
        ];

        $icones = [
            'fa-broom' => 'Balai',
            'fa-fire' => 'Flamme',
            'fa-water' => 'Eau',
            'fa-tools' => 'Outils',
            'fa-cogs' => 'Engrenages',
            'fa-wrench' => 'Clé',
            'fa-thermometer-half' => 'Thermomètre',
        ];

        return view('back.activites.edit', compact('activite', 'couleurs', 'icones'));
    }

    /**
     * Met à jour une activité
     */
    public function update(Request $request, Activite $activite)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:activites,code,' . $activite->id,
            'description' => 'nullable|string',
            'couleur' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'est_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $activite->update([
                'nom' => $request->nom,
                'code' => $request->code,
                'description' => $request->description,
                'couleur' => $request->couleur,
                'icon' => $request->icon,
                'est_active' => $request->has('est_active'),
            ]);

            DB::commit();

            Log::info('🔄 Activité mise à jour', [
                'id' => $activite->id,
                'nom' => $activite->nom,
                'est_active' => $activite->est_active
            ]);

            return redirect()->route('back.activites.index')
                ->with('success', 'Activité mise à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Erreur mise à jour activité', [
                'error' => $e->getMessage(),
                'activite_id' => $activite->id
            ]);

            return back()
                ->withInput()
                ->withErrors('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Basculer l'état actif/inactif
     */
public function toggle(Activite $activite)
{
    try {
        // DEBUG: log avant
        Log::info('🔄 Début toggle', [
            'id' => $activite->id,
            'nom' => $activite->nom,
            'avant' => $activite->est_active ? 'true' : 'false'
        ]);
        
        // Méthode
        $activite->est_active = !$activite->est_active;
        $activite->save();
        
        $activite->refresh();
        
        // DEBUG: log après
        Log::info('🔄 Fin toggle', [
            'id' => $activite->id,
            'nom' => $activite->nom,
            'après' => $activite->est_active ? 'true' : 'false'
        ]);
        
        return response()->json([
            'success' => true,
            'est_active' => (bool)$activite->est_active, // Cast en booléen
            'message' => $activite->est_active ? 'Activité activée' : 'Activité désactivée'
        ]);
        
    } catch (\Exception $e) {
        Log::error('❌ Erreur basculement statut', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'activite_id' => $activite->id
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Erreur technique: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Supprime une activité
     */

    /**
 * Basculer l'état actif/inactif
 */
    public function destroy(Activite $activite)
    {
        try {
            // Vérifier qu'il n'y a pas de documents liés
            if ($activite->documents()->exists()) {
                return back()->withErrors('Impossible de supprimer cette activité : des documents y sont liés.');
            }

            $nom = $activite->nom;
            $activite->delete();

            Log::info('🗑️ Activité supprimée', [
                'id' => $activite->id,
                'nom' => $nom
            ]);

            return redirect()->route('back.activites.index')
                ->with('success', 'Activité supprimée avec succès !');

        } catch (\Exception $e) {
            Log::error('❌ Erreur suppression activité', [
                'error' => $e->getMessage(),
                'activite_id' => $activite->id
            ]);

            return back()->withErrors('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}