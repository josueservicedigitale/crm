<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Societe;
use App\Models\Activite;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SocieteController extends Controller
{
    /**
     * Liste toutes les sociétés
     */// SocieteController.php - méthode index()
public function index()
{
    Log::info('🏢 Liste des sociétés consultée', ['user_id' => auth()->id()]);
    
    $societes = Societe::withCount('documents')
        ->with('activites')
        ->orderBy('est_active', 'desc')
        ->orderBy('nom', 'asc')
        ->paginate(15); // <-- Utilisez paginate() au lieu de get()
    
    // Statistiques globales (vous pouvez garder get() pour les stats)
    $allSocietes = Societe::get();
    $stats = [
        'total' => $allSocietes->count(),
        'actives' => $allSocietes->where('est_active', true)->count(),
        'inactives' => $allSocietes->where('est_active', false)->count(),
        'documents_total' => $allSocietes->sum('documents_count'),
        'chiffre_affaires_total' => Document::sum('montant_ttc'),
    ];
    
    return view('back.societes.index', compact('societes', 'stats'));
}
    /**
     * Affiche le détail d'une société
     */
// public function show($code)
// {
//     // Récupérer la société
//     $societeModel = Societe::where('code', $code)
//         ->with('user')
//         ->firstOrFail();
    
//     // Variables pour la vue
//     $nomSociete = $societeModel->nom_formate ?? $societeModel->nom;
//     $societe = $societeModel->code;
    
//     // ✅ STATISTIQUES DANS LE FORMAT ATTENDU PAR LA VUE
//     $stats = [
//         'total' => $societeModel->documents()->count(),
//         'devis' => $societeModel->documents()->where('type', 'devis')->count(),
//         'facture' => $societeModel->documents()->where('type', 'facture')->count(),
//         'rapport' => $societeModel->documents()->where('type', 'rapport')->count(),
//         'cahier_des_charges' => $societeModel->documents()->where('type', 'cahier_des_charges')->count(),
//         'desembouage' => $societeModel->documents()->where('activity', 'desembouage')->count(),
//         'reequilibrage' => $societeModel->documents()->where('activity', 'reequilibrage')->count(),
//     ];
    
//     // Documents récents
//     $documentsRecents = $societeModel->documents()
//         ->with(['user'])
//         ->latest()
//         ->limit(10)
//         ->get();
    
//     // Clients fréquents (adresses les plus utilisées)
//     $clientsFrequents = $societeModel->documents()
//         ->whereNotNull('adresse_travaux')
//         ->where('adresse_travaux', '!=', '')
//         ->select('adresse_travaux', DB::raw('COUNT(*) as total'), DB::raw('MAX(created_at) as dernier'))
//         ->groupBy('adresse_travaux')
//         ->orderByDesc('total')
//         ->limit(6)
//         ->get()
//         ->map(function ($item) {
//             return [
//                 'adresse' => $item->adresse_travaux,
//                 'total_documents' => (int) $item->total,
//                 'dernier_document' => $item->dernier ? \Carbon\Carbon::parse($item->dernier) : null,
//             ];
//         })
//         ->toArray();
    
//     return view('back.societes.show', compact(
//         'societeModel',
//         'nomSociete',
//         'societe',
//         'stats',           // ✅ Maintenant avec les bonnes clés !
//         'documentsRecents',
//         'clientsFrequents'
//     ));
// }
 /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        Log::info('➕ Formulaire création société affiché');
        
        $couleurs = [
            '#3B82F6' => 'Bleu',
            '#10B981' => 'Vert',
            '#F59E0B' => 'Orange',
            '#EF4444' => 'Rouge',
            '#8B5CF6' => 'Violet',
            '#EC4899' => 'Rose',
        ];
        
        $icones = [
            'fa-building' => 'Bâtiment',
            'fa-industry' => 'Industrie',
            'fa-store' => 'Magasin',
            'fa-briefcase' => 'Porte-documents',
            'fa-handshake' => 'Poignée de main',
            'fa-chart-line' => 'Graphique',
        ];
        
        $activites = Activite::active()->get();
        
        return view('back.societes.create', compact('couleurs', 'icones', 'activites'));
    }
    
    /**
     * Enregistre une nouvelle société
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'ville' => 'nullable|string|max:50',
            'code_postal' => 'nullable|string|max:10',
            'siret' => 'nullable|string|max:14',
            'tva_intracommunautaire' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
            'couleur' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'est_active' => 'boolean',
            'activites' => 'nullable|array',
            'activites.*' => 'exists:activites,id',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Gérer le logo
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }
            
            $societe = Societe::create([
                'nom' => $request->nom,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'ville' => $request->ville,
                'code_postal' => $request->code_postal,
                'siret' => $request->siret,
                'tva_intracommunautaire' => $request->tva_intracommunautaire,
                'logo_path' => $logoPath,
                'couleur' => $request->couleur ?? '#3B82F6',
                'icon' => $request->icon ?? 'fa-building',
                'est_active' => $request->has('est_active'),
                'user_id' => auth()->id(),
            ]);
            
            // Synchroniser les activités
            if ($request->has('activites')) {
                $societe->activites()->sync($request->activites);
            }
            
            DB::commit();
            
            Log::info('✅ Société créée', [
                'id' => $societe->id,
                'nom' => $societe->nom,
                'user_id' => auth()->id()
            ]);
            
            return redirect()->route('back.societes.index')
                ->with('success', 'Société créée avec succès !');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('❌ Erreur création société', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return back()
                ->withInput()
                ->withErrors('Erreur lors de la création de la société : ' . $e->getMessage());
        }
    }
    
    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Societe $societe)
    {
        Log::info('✏️ Formulaire édition société', ['societe_id' => $societe->id]);
        
        $couleurs = [
            '#3B82F6' => 'Bleu',
            '#10B981' => 'Vert',
            '#F59E0B' => 'Orange',
            '#EF4444' => 'Rouge',
            '#8B5CF6' => 'Violet',
            '#EC4899' => 'Rose',
        ];
        
        $icones = [
            'fa-building' => 'Bâtiment',
            'fa-industry' => 'Industrie',
            'fa-store' => 'Magasin',
            'fa-briefcase' => 'Porte-documents',
            'fa-handshake' => 'Poignée de main',
            'fa-chart-line' => 'Graphique',
        ];
        
        $activites = Activite::active()->get();
        
        return view('back.societes.edit', compact('societe', 'couleurs', 'icones', 'activites'));
    }
    
    /**
     * Met à jour une société
     */
    public function update(Request $request, Societe $societe)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'ville' => 'nullable|string|max:50',
            'code_postal' => 'nullable|string|max:10',
            'siret' => 'nullable|string|max:14',
            'tva_intracommunautaire' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
            'couleur' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'est_active' => 'boolean',
            'activites' => 'nullable|array',
            'activites.*' => 'exists:activites,id',
        ]);
        
        try {
            DB::beginTransaction();
            
            // Gérer le logo
            if ($request->hasFile('logo')) {
                // Supprimer l'ancien logo s'il existe
                if ($societe->logo_path) {
                    Storage::disk('public')->delete($societe->logo_path);
                }
                
                $logoPath = $request->file('logo')->store('logos', 'public');
                $societe->logo_path = $logoPath;
            }
            
            $societe->update([
                'nom' => $request->nom,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'ville' => $request->ville,
                'code_postal' => $request->code_postal,
                'siret' => $request->siret,
                'tva_intracommunautaire' => $request->tva_intracommunautaire,
                'couleur' => $request->couleur,
                'icon' => $request->icon,
                'est_active' => $request->has('est_active'),
            ]);
            
            // Synchroniser les activités
            $societe->activites()->sync($request->activites ?? []);
            
            DB::commit();
            
            Log::info('🔄 Société mise à jour', [
                'id' => $societe->id,
                'nom' => $societe->nom,
                'est_active' => $societe->est_active
            ]);
            
            return redirect()->route('back.societes.index')
                ->with('success', 'Société mise à jour avec succès !');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('❌ Erreur mise à jour société', [
                'error' => $e->getMessage(),
                'societe_id' => $societe->id
            ]);
            
            return back()
                ->withInput()
                ->withErrors('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
    
    /**
     * Basculer l'état actif/inactif
     */
// Dans app/Http\Controllers\Back\SocieteController.php
public function toggle(Societe $societe)
{
    try {
        // LOG pour debug
        \Log::info('Toggle société appelé - ID: ' . $societe->id . 
                   ', Avant: ' . ($societe->est_active ? 'true' : 'false'));
        
        // SIMPLE et DIRECT
        $societe->est_active = !$societe->est_active;
        $societe->save();
        
        \Log::info('Toggle société réussi - ID: ' . $societe->id . 
                   ', Après: ' . ($societe->est_active ? 'true' : 'false'));
        
        return response()->json([
            'success' => true,
            'est_active' => (bool)$societe->est_active,
            'message' => $societe->est_active ? 'Société activée' : 'Société désactivée'
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Toggle société erreur: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Erreur: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Supprime une société
     */
    public function destroy(Societe $societe)
    {
        try {
            // Vérifier qu'il n'y a pas de documents liés
            if ($societe->documents()->exists()) {
                return back()->withErrors('Impossible de supprimer cette société : des documents y sont liés.');
            }
            
            // Supprimer le logo s'il existe
            if ($societe->logo_path) {
                Storage::disk('public')->delete($societe->logo_path);
            }
            
            $nom = $societe->nom;
            $societe->delete();
            
            Log::info('🗑️ Société supprimée', [
                'id' => $societe->id,
                'nom' => $nom
            ]);
            
            return redirect()->route('back.societes.index')
                ->with('success', 'Société supprimée avec succès !');
                
        } catch (\Exception $e) {
            Log::error('❌ Erreur suppression société', [
                'error' => $e->getMessage(),
                'societe_id' => $societe->id
            ]);
            
            return back()->withErrors('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
    
    /**
     * Récupère les documents d'une société avec filtres
     */
    public function documents(Societe $societe, Request $request)
    {
        Log::info('📄 Documents par société', [
            'societe_id' => $societe->id,
            'filtres' => $request->all()
        ]);
        
        $query = $societe->documents()
            ->with(['user', 'parent']);
        
        // Filtres
        if ($request->filled('activity')) {
            $query->where('activity', $request->activity);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference', 'LIKE', "%{$search}%")
                  ->orWhere('adresse_travaux', 'LIKE', "%{$search}%")
                  ->orWhere('reference_devis', 'LIKE', "%{$search}%")
                  ->orWhere('reference_facture', 'LIKE', "%{$search}%");
            });
        }
        
        $documents = $query->latest()
            ->paginate(20)
            ->withQueryString();
        
        // Options de filtres
        $activites = $societe->documents()
            ->select('activity')
            ->distinct()
            ->pluck('activity');
        
        $types = $societe->documents()
            ->select('type')
            ->distinct()
            ->pluck('type');
        
        return view('back.societes.documents', compact(
            'societe',
            'documents',
            'activites',
            'types'
        ));
    }
    
    /**
     * Exporte les documents d'une société
     */
    public function export(Societe $societe, Request $request)
    {
        Log::info('📤 Export documents société', ['societe_id' => $societe->id]);
        
        $query = $societe->documents();
        
        // Appliquer les mêmes filtres que la page documents
        if ($request->filled('activity')) {
            $query->where('activity', $request->activity);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        
        $documents = $query->get();
        
        // Générer le CSV
        $fileName = "documents_{$societe->code}_" . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];
        
        $callback = function() use ($documents) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, [
                'Référence',
                'Type',
                'Activité',
                'Adresse travaux',
                'Montant TTC',
                'Date création',
                'Référence devis',
                'Référence facture',
                'Créé par'
            ]);
            
            // Données
            foreach ($documents as $document) {
                fputcsv($file, [
                    $document->reference,
                    $document->type_name,
                    $document->activity_name,
                    $document->adresse_travaux,
                    $document->montant_ttc,
                    $document->created_at->format('d/m/Y'),
                    $document->reference_devis,
                    $document->reference_facture,
                    $document->user->name ?? 'Inconnu'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Affiche les statistiques détaillées d'une société
     */
    public function stats(Societe $societe)
    {
        Log::info('📊 Statistiques société consultées', ['societe_id' => $societe->id]);
        
        $stats = $societe->getStats();
        
        // Évolution mensuelle
        $evolution = Document::where('society', $societe->code)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count, SUM(montant_ttc) as total_ttc')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        
        // Répartition par activité
        $repartitionActivite = $societe->documents()
            ->selectRaw('activity, COUNT(*) as count, SUM(montant_ttc) as total_ttc')
            ->groupBy('activity')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->activity => [
                        'count' => $item->count,
                        'total_ttc' => $item->total_ttc
                    ]
                ];
            })
            ->toArray();
        
        // Top 10 des documents par montant
        $topDocuments = $societe->documents()
            ->whereNotNull('montant_ttc')
            ->orderByDesc('montant_ttc')
            ->limit(10)
            ->get();
        
        return view('back.societes.stats', compact(
            'societe',
            'stats',
            'evolution',
            'repartitionActivite',
            'topDocuments'
        ));
    }

     public function show($code)
    {
        // Récupérer la société avec ses relations
        $societeModel = Societe::with(['user', 'documents' => function($query) {
                $query->latest()->limit(10);
            }])
            ->where('code', $code)
            ->firstOrFail();
        
        // Nom de la société pour l'affichage
        $nomSociete = $societeModel->nom;
        
        // Code de la société pour les routes
        $societe = $societeModel->code;
        
        // Récupérer les statistiques
        $stats = $this->getStatistiques($societeModel);
        
        // Récupérer les documents récents
        $documentsRecents = $societeModel->documents()
            ->with(['user', 'activite'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Récupérer les clients/adresses fréquents
        $clientsFrequents = $this->getClientsFrequents($societeModel);
        
        return view('back.societes.show', compact(
            'societeModel',
            'nomSociete',
            'societe',
            'stats',
            'documentsRecents',
            'clientsFrequents'
        ));
    }
    
    /**
     * Get statistics for a society.
     */
    private function getStatistiques(Societe $societe): array
    {
        // Total des documents
        $totalDocuments = $societe->documents()->count();
        
        // Statistiques par type de document
        $statsByType = $societe->documents()
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type')
            ->toArray();
        
        // Statistiques par activité
        $statsByActivity = $societe->documents()
            ->select('activity', DB::raw('count(*) as total'))
            ->groupBy('activity')
            ->pluck('total', 'activity')
            ->toArray();
        
        // Construire le tableau des statistiques
        return [
            'total' => $totalDocuments,
            'devis' => $statsByType['devis'] ?? 0,
            'facture' => $statsByType['facture'] ?? 0,
            'rapport' => $statsByType['rapport'] ?? 0,
            'cahier_des_charges' => $statsByType['cahier_des_charges'] ?? 0,
            'desembouage' => $statsByActivity['desembouage'] ?? 0,
            'reequilibrage' => $statsByActivity['reequilibrage'] ?? 0,
        ];
    }
    
    /**
     * Get frequent clients/addresses for a society.
     */
    private function getClientsFrequents(Societe $societe): array
    {
        // Récupérer les adresses les plus fréquentes dans les documents
        $adressesFrequentes = $societe->documents()
            ->select('adresse_travaux', DB::raw('count(*) as total'), DB::raw('MAX(created_at) as dernier'))
            ->whereNotNull('adresse_travaux')
            ->where('adresse_travaux', '!=', '')
            ->groupBy('adresse_travaux')
            ->orderByDesc('total')
            ->limit(6)
            ->get();
        
        $clientsFrequents = [];
        
        foreach ($adressesFrequentes as $adresse) {
            $clientsFrequents[] = [
                'adresse' => $adresse->adresse_travaux,
                'total_documents' => $adresse->total,
                'dernier_document' => $adresse->dernier ? \Carbon\Carbon::parse($adresse->dernier) : null,
            ];
        }
        
        return $clientsFrequents;
    }


}