<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Activite; // Si vous créez un modèle Activite
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ActiviteController extends Controller
{
    /**
     * Liste toutes les activités
     */
    public function index()
    {
        Log::info('📋 Liste des activités consultée', ['user_id' => auth()->id()]);
        
        // Liste des activités (à remplacer par un modèle si nécessaire)
        $activites = [
            'desembouage' => [
                'nom' => 'Désembouage',
                'description' => 'Nettoyage et désembouage des circuits de chauffage',
                'created_at' => '2024-01-01',
                'documents_count' => 150
            ],
            'reequilibrage' => [
                'nom' => 'Rééquilibrage',
                'description' => 'Rééquilibrage des circuits hydrauliques',
                'created_at' => '2024-01-01',
                'documents_count' => 120
            ]
        ];
        
        return view('back.activites.index', compact('activites'));
    }
    
    /**
     * Affiche le détail d'une activité
     */
    public function show($activite)
    {
        Log::info('🔍 Détail activité consulté', ['activite' => $activite]);
        
        // Récupérer les statistiques de cette activité
        $stats = [
            'total_documents' => \App\Models\Document::where('activity', $activite)->count(),
            'devis_count' => \App\Models\Document::where('activity', $activite)->where('type', 'devis')->count(),
            'factures_count' => \App\Models\Document::where('activity', $activite)->where('type', 'facture')->count(),
            'societes' => [
                'nova' => \App\Models\Document::where('activity', $activite)->where('society', 'nova')->count(),
                'house' => \App\Models\Document::where('activity', $activite)->where('society', 'house')->count()
            ]
        ];
        
        $nomActivite = match($activite) {
            'desembouage' => 'Désembouage',
            'reequilibrage' => 'Rééquilibrage',
            default => ucfirst($activite)
        };
        
        return view('back.activites.show', compact('activite', 'nomActivite', 'stats'));
    }
    
    /**
     * Affiche le formulaire de création d'une nouvelle activité
     */
    public function create()
    {
        Log::info('➕ Formulaire création activité affiché');
        
        return view('back.activites.create');
    }
    
    /**
     * Enregistre une nouvelle activité
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:activites,code',
            'description' => 'nullable|string'
        ]);
        
        try {
            // Si vous avez un modèle Activite, décommentez ceci :
            /*
            $activite = Activite::create([
                'nom' => $request->nom,
                'code' => $request->code,
                'description' => $request->description,
                'user_id' => auth()->id()
            ]);
            */
            
            Log::info('✅ Activité créée', [
                'nom' => $request->nom,
                'code' => $request->code,
                'user_id' => auth()->id()
            ]);
            
            return redirect()->route('back.activite.index')
                ->with('success', 'Activité créée avec succès !');
                
        } catch (\Exception $e) {
            Log::error('❌ Erreur création activité', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return back()->withErrors('Erreur lors de la création de l\'activité : ' . $e->getMessage());
        }
    }
    
    /**
     * Affiche le formulaire d'édition d'une activité
     */
    public function edit($activite)
    {
        Log::info('✏️ Formulaire édition activité', ['activite' => $activite]);
        
        // Récupérer les données de l'activité
        $donneesActivite = [
            'nom' => match($activite) {
                'desembouage' => 'Désembouage',
                'reequilibrage' => 'Rééquilibrage',
                default => ucfirst($activite)
            },
            'code' => $activite,
            'description' => 'Description de l\'activité ' . $activite
        ];
        
        return view('back.activites.edit', compact('activite', 'donneesActivite'));
    }
    
    /**
     * Met à jour une activité existante
     */
    public function update(Request $request, $activite)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string'
        ]);
        
        try {
            Log::info('🔄 Activité mise à jour', [
                'activite' => $activite,
                'nouveau_nom' => $request->nom
            ]);
            
            // Logique de mise à jour ici
            
            return redirect()->route('back.activite.show', ['activite' => $activite])
                ->with('success', 'Activité mise à jour avec succès !');
                
        } catch (\Exception $e) {
            Log::error('❌ Erreur mise à jour activité', [
                'error' => $e->getMessage(),
                'activite' => $activite
            ]);
            
            return back()->withErrors('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
    
    /**
     * Supprime une activité
     */
    public function destroy($activite)
    {
        try {
            // Vérifier qu'il n'y a pas de documents liés
            $documentsCount = \App\Models\Document::where('activity', $activite)->count();
            
            if ($documentsCount > 0) {
                return back()->withErrors('Impossible de supprimer cette activité : ' . $documentsCount . ' documents y sont liés.');
            }
            
            Log::info('🗑️ Activité supprimée', ['activite' => $activite]);
            
            // Logique de suppression ici
            
            return redirect()->route('back.activite.index')
                ->with('success', 'Activité supprimée avec succès !');
                
        } catch (\Exception $e) {
            Log::error('❌ Erreur suppression activité', [
                'error' => $e->getMessage(),
                'activite' => $activite
            ]);
            
            return back()->withErrors('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}