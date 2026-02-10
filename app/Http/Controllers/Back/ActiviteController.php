<?php

namespace App\Http\Controllers\Back;
use App\Models\Document;
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

    public function stats()
{
    $stats = [
        'total' => Activite::count(),
        'actives' => Activite::where('est_active', true)->count(),
        'inactives' => Activite::where('est_active', false)->count(),
        'documents_total' => Document::count(),
    ];
    
    return response()->json($stats);
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
/**
 * Basculer l'état actif/inactif
 */
public function toggle(Activite $activite)
{
    try {
        // Vérifier si c'est la dernière activité active
        if ($activite->est_active) {
            $activeCount = Activite::where('est_active', true)->count();

            if ($activeCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ Impossible de désactiver cette activité : au moins une activité doit rester active.',
                    'refresh' => false // Pas besoin de rafraîchir
                ]);
            }
        }

        // Basculer le statut
        $activite->est_active = !$activite->est_active;
        $activite->save();
        $activite->refresh();

        Log::info('✅ Activité basculée', [
            'id' => $activite->id,
            'nom' => $activite->nom,
            'nouveau_statut' => $activite->est_active ? 'active' : 'inactive'
        ]);

        return response()->json([
            'success' => true,
            'est_active' => (bool) $activite->est_active,
            'message' => $activite->est_active ? '✅ Activité activée' : '✅ Activité désactivée',
            'refresh' => true, // Indique au front de rafraîchir
            'refresh_delay' => 1000 // 1 seconde avant rafraîchissement
        ]);

    } catch (\Exception $e) {
        Log::error('❌ Erreur toggle activité', [
            'id' => $activite->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => '❌ Erreur technique: ' . $e->getMessage(),
            'refresh' => false
        ], 500);
    }
}
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