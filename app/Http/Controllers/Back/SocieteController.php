<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SocieteController extends Controller
{
    /**
     * Liste toutes les sociétés
     */
    public function index()
    {
        Log::info('🏢 Liste des sociétés consultée', ['user_id' => auth()->id()]);
        
        // Utiliser les méthodes du modèle Document
        $societes = [
            'nova' => [
                'nom' => 'Énergie Nova',
                'adresse' => '123 Avenue des Entrepreneurs, 75000 Paris',
                'telephone' => '01 23 45 67 89',
                'email' => 'contact@nova-energie.fr',
                'siret' => '123 456 789 00012',
                'documents_count' => Document::where('society', 'nova')->count(),
                'statistiques' => Document::getSocietyStats('nova') // Nouvelle méthode
            ],
            'house' => [
                'nom' => 'MyHouse Solutions',
                'adresse' => '456 Avenue des Métiers, 69000 Lyon',
                'telephone' => '04 56 78 90 12',
                'email' => 'contact@myhouse.fr',
                'siret' => '987 654 321 00098',
                'documents_count' => Document::where('society', 'house')->count(),
                'statistiques' => Document::getSocietyStats('house') // Nouvelle méthode
            ]
        ];
        
        return view('back.societes.index', compact('societes'));
    }
    
    /**
     * Affiche le détail d'une société
     */
    public function show($societe)
    {
        Log::info('🔍 Détail société consulté', ['societe' => $societe]);
        
        // Utiliser la nouvelle méthode getSocietyStats du modèle
        $stats = Document::getSocietyStats($societe);
        
        // Récupérer les documents récents pour cette société
        $documentsRecents = Document::where('society', $societe)
            ->with(['user', 'parent'])
            ->latest()
            ->take(10)
            ->get();
        
        // Récupérer les meilleurs clients (si vous avez des infos clients dans vos documents)
        $clientsFrequents = $this->getFrequentClients($societe);
        
        $nomSociete = match($societe) {
            'nova' => 'Énergie Nova',
            'house' => 'MyHouse Solutions',
            default => ucfirst($societe)
        };
        
        // Récupérer les coordonnées de la société
        $infosSociete = $this->getCompanyInfo($societe);
        
        return view('back.societes.show', compact(
            'societe', 
            'nomSociete', 
            'stats',
            'documentsRecents',
            'clientsFrequents',
            'infosSociete'
        ));
    }
    
    /**
     * Affiche le formulaire de création d'une nouvelle société
     */
    public function create()
    {
        Log::info('➕ Formulaire création société affiché');
        
        return view('back.societes.create');
    }
    
    /**
     * Enregistre une nouvelle société
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'code' => 'required|string|max:50|alpha_dash|unique:documents,society', // Utilise le champ existant
            'adresse' => 'required|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'siret' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048'
        ]);
        
        try {
            // Note: Comme pour les activités, vous pourriez gérer cela via configuration
            
            // Gérer l'upload du logo
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos/societes', 'public');
            }
            
            Log::info('✅ Configuration société créée', [
                'nom' => $request->nom,
                'code' => $request->code,
                'logo' => $logoPath,
                'user_id' => auth()->id()
            ]);
            
            return redirect()->route('back.societe.index')
                ->with('success', 'Configuration de société créée avec succès !');
                
        } catch (\Exception $e) {
            Log::error('❌ Erreur création société', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            return back()->withErrors('Erreur lors de la création : ' . $e->getMessage());
        }
    }
    
    /**
     * Affiche le formulaire d'édition d'une société
     */
    public function edit($societe)
    {
        Log::info('✏️ Formulaire édition société', ['societe' => $societe]);
        
        // Récupérer les statistiques actuelles
        $stats = Document::getSocietyStats($societe);
        
        $infosSociete = $this->getCompanyInfo($societe);
        
        return view('back.societes.edit', compact('societe', 'infosSociete', 'stats'));
    }
    
    /**
     * Met à jour une société existante
     */
    public function update(Request $request, $societe)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'adresse' => 'required|string',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'siret' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048'
        ]);
        
        try {
            // Note: Mettre à jour la configuration, pas les documents existants
            
            Log::info('🔄 Configuration société mise à jour', [
                'societe' => $societe,
                'nouveau_nom' => $request->nom,
                'user_id' => auth()->id()
            ]);
            
            return redirect()->route('back.societe.show', ['societe' => $societe])
                ->with('success', 'Configuration mise à jour avec succès !');
                
        } catch (\Exception $e) {
            Log::error('❌ Erreur mise à jour société', [
                'error' => $e->getMessage(),
                'societe' => $societe
            ]);
            
            return back()->withErrors('Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
    
    /**
     * Supprime une société (configuration uniquement)
     */
    public function destroy($societe)
    {
        try {
            // Vérifier qu'il n'y a pas de documents liés
            $documentsCount = Document::where('society', $societe)->count();
            
            if ($documentsCount > 0) {
                return back()->withErrors('Impossible de supprimer cette société : ' . $documentsCount . ' documents y sont liés.');
            }
            
            Log::info('🗑️ Configuration société supprimée', [
                'societe' => $societe,
                'user_id' => auth()->id()
            ]);
            
            // Supprimer la configuration uniquement
            // Note: Les documents ne sont pas affectés
            
            return redirect()->route('back.societe.index')
                ->with('success', 'Configuration de société supprimée avec succès !');
                
        } catch (\Exception $e) {
            Log::error('❌ Erreur suppression société', [
                'error' => $e->getMessage(),
                'societe' => $societe
            ]);
            
            return back()->withErrors('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
    
    /**
     * Récupère les documents d'une société avec filtres
     */
    public function documents($societe, Request $request)
    {
        Log::info('📄 Documents par société', [
            'societe' => $societe,
            'filtres' => $request->all()
        ]);
        
        $query = Document::where('society', $societe)
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
        
        $documents = $query->latest()
            ->paginate(20)
            ->withQueryString();
        
        $nomSociete = match($societe) {
            'nova' => 'Énergie Nova',
            'house' => 'MyHouse Solutions',
            default => ucfirst($societe)
        };
        
        return view('back.societes.documents', compact(
            'societe',
            'nomSociete',
            'documents'
        ));
    }
    
    /**
     * Récupère les informations d'une société
     */
    private function getCompanyInfo(string $societe): array
    {
        return match($societe) {
            'nova' => [
                'nom' => 'Énergie Nova',
                'code' => 'nova',
                'adresse' => '123 Avenue des Entrepreneurs, 75000 Paris',
                'telephone' => '01 23 45 67 89',
                'email' => 'contact@nova-energie.fr',
                'siret' => '123 456 789 00012',
                'tva' => 'FR 12 345 678 901',
                'logo' => asset('storage/logos/nova-logo.png') // Si vous avez un logo
            ],
            'house' => [
                'nom' => 'MyHouse Solutions',
                'code' => 'house',
                'adresse' => '456 Avenue des Métiers, 69000 Lyon',
                'telephone' => '04 56 78 90 12',
                'email' => 'contact@myhouse.fr',
                'siret' => '987 654 321 00098',
                'tva' => 'FR 98 765 432 109',
                'logo' => asset('storage/logos/house-logo.png') // Si vous avez un logo
            ],
            default => [
                'nom' => ucfirst($societe),
                'code' => $societe,
                'adresse' => '',
                'telephone' => '',
                'email' => '',
                'siret' => '',
                'tva' => '',
                'logo' => null
            ]
        };
    }
    
    /**
     * Récupère les clients les plus fréquents pour une société
     */
    private function getFrequentClients(string $societe): array
    {
        // Récupère les adresses les plus fréquentes dans les documents
        $clients = Document::where('society', $societe)
            ->whereNotNull('adresse_travaux')
            ->selectRaw('adresse_travaux, COUNT(*) as total')
            ->groupBy('adresse_travaux')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        
        return $clients->map(function ($client) {
            return [
                'adresse' => $client->adresse_travaux,
                'total_documents' => $client->total
            ];
        })->toArray();
    }
}