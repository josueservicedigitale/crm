<?php
// app/Http/Controllers/Back/CorbeilleController.php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Corbeille;
use App\Models\Utilisateur;
use App\Models\Societe;
use App\Models\Activite;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CorbeilleController extends Controller
{
    /**
     * Afficher la liste des éléments dans la corbeille
     */
    public function index(Request $requete)
    {
        // Requête pour récupérer les éléments
        $elementsCorbeille = Corbeille::with('supprimePar')
            ->orderBy('supprime_le', 'desc');
        
        // Filtrer par type d'élément
        if ($requete->has('type')) {
            $elementsCorbeille->where('type_element', $requete->type);
        }
        
        // Recherche
        if ($requete->has('recherche')) {
            $recherche = $requete->recherche;
            $elementsCorbeille->where(function($q) use ($recherche) {
                $q->where('donnees', 'like', "%{$recherche}%")
                  ->orWhereHas('supprimePar', function($q) use ($recherche) {
                      $q->where('nom', 'like', "%{$recherche}%")
                        ->orWhere('email', 'like', "%{$recherche}%");
                  });
            });
        }
        
        // Filtrer par date
        if ($requete->has('date_debut')) {
            $elementsCorbeille->where('supprime_le', '>=', $requete->date_debut);
        }
        
        if ($requete->has('date_fin')) {
            $elementsCorbeille->where('supprime_le', '<=', $requete->date_fin);
        }
        
        $elementsCorbeille = $elementsCorbeille->paginate(25);
        
        // Statistiques
        $statistiques = [
            'total' => Corbeille::count(),
            'utilisateurs' => Corbeille::where('type_element', Utilisateur::class)->count(),
            'societes' => Corbeille::where('type_element', Societe::class)->count(),
            'activites' => Corbeille::where('type_element', Activite::class)->count(),
            'documents' => Corbeille::where('type_element', 'like', '%Document%')->count(),
        ];
        
        // Types disponibles pour le filtre
        $typesDisponibles = [
            Utilisateur::class => 'Utilisateurs',
            Societe::class => 'Sociétés',
            Activite::class => 'Activités',
            Document::class => 'Documents',
        ];
        
        return view('back.corbeille.index', compact('elementsCorbeille', 'statistiques', 'typesDisponibles'));
    }
    
    /**
     * Afficher les détails d'un élément de la corbeille
     */
    public function afficher($id)
    {
        $element = Corbeille::with('supprimePar')->findOrFail($id);
        
        // Décoder les données
        $donnees = $element->donnees ? json_decode($element->donnees, true) : [];
        
        return view('back.corbeille.afficher', compact('element', 'donnees'));
    }
    
    /**
     * Restaurer un élément spécifique
     */
    public function restaurer($id)
    {
        $element = Corbeille::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $classeModele = $element->type_element;
            
            if (!class_exists($classeModele)) {
                throw new \Exception("Classe modèle '{$classeModele}' non trouvée.");
            }
            
            // Vérifier si le modèle utilise SoftDeletes
            $reflection = new \ReflectionClass($classeModele);
            $traits = $reflection->getTraitNames();
            
            if (!in_array('Illuminate\Database\Eloquent\SoftDeletes', $traits)) {
                throw new \Exception("Le modèle '{$classeModele}' n'utilise pas la suppression douce.");
            }
            
            // Restaurer le modèle
            $modele = $classeModele::withTrashed()->find($element->element_id);
            
            if (!$modele) {
                // Créer un nouveau modèle depuis les données sauvegardées
                if ($element->donnees) {
                    $donnees = json_decode($element->donnees, true);
                    
                    // Supprimer les champs Laravel
                    unset($donnees['created_at'], $donnees['updated_at'], $donnees['deleted_at']);
                    
                    $modele = $classeModele::create($donnees);
                } else {
                    throw new \Exception("Données de l'élément non disponibles.");
                }
            } else {
                $modele->restore();
            }
            
            // Supprimer de la corbeille
            $element->delete();
            
            DB::commit();
            
            // Journaliser l'action
            activity()
                ->causedBy(Auth::user())
                ->performedOn($modele)
                ->log("a restauré {$element->nom_type} depuis la corbeille");
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('succes', "{$element->nom_type} restauré avec succès.");
                
        } catch (\Exception $exception) {
            DB::rollBack();
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('erreur', "Erreur lors de la restauration : " . $exception->getMessage());
        }
    }
    
    /**
     * Supprimer définitivement un élément
     */
    public function supprimerDefinitivement($id)
    {
        $element = Corbeille::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $classeModele = $element->type_element;
            $nomType = $element->nom_type;
            
            if (class_exists($classeModele)) {
                $modele = $classeModele::withTrashed()->find($element->element_id);
                
                if ($modele) {
                    // Suppression définitive
                    $modele->forceDelete();
                    
                    // Journaliser l'action
                    activity()
                        ->causedBy(Auth::user())
                        ->performedOn($modele)
                        ->log("a définitivement supprimé {$nomType} depuis la corbeille");
                }
            }
            
            // Supprimer de la corbeille
            $element->delete();
            
            DB::commit();
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('succes', "{$nomType} supprimé définitivement.");
                
        } catch (\Exception $exception) {
            DB::rollBack();
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('erreur', "Erreur lors de la suppression : " . $exception->getMessage());
        }
    }
    
    /**
     * Vider toute la corbeille
     */
    public function viderCorbeille()
    {
        if (!request()->has('confirmation') || request('confirmation') !== 'JE_VEUX_VIDER_LA_CORBEILLE') {
            return redirect()
                ->route('back.corbeille.index')
                ->with('erreur', 'Confirmation requise pour vider la corbeille.');
        }
        
        DB::beginTransaction();
        try {
            $compteur = 0;
            $erreurs = 0;
            
            Corbeille::chunk(100, function ($elements) use (&$compteur, &$erreurs) {
                foreach ($elements as $element) {
                    try {
                        $classeModele = $element->type_element;
                        
                        if (class_exists($classeModele)) {
                            $modele = $classeModele::withTrashed()->find($element->element_id);
                            
                            if ($modele) {
                                $modele->forceDelete();
                            }
                        }
                        
                        $element->delete();
                        $compteur++;
                    } catch (\Exception $exception) {
                        $erreurs++;
                        // Continuer avec les autres éléments
                    }
                }
            });
            
            DB::commit();
            
            $message = "Corbeille vidée avec succès. {$compteur} éléments supprimés.";
            
            if ($erreurs > 0) {
                $message .= " {$erreurs} erreurs rencontrées.";
            }
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('succes', $message);
                
        } catch (\Exception $exception) {
            DB::rollBack();
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('erreur', 'Erreur lors du vidage : ' . $exception->getMessage());
        }
    }
    
    /**
     * Restaurer tous les éléments
     */
    public function restaurerTous()
    {
        if (!request()->has('confirmation') || request('confirmation') !== 'JE_VEUX_TOUT_RESTAURER') {
            return redirect()
                ->route('back.corbeille.index')
                ->with('erreur', 'Confirmation requise pour restaurer tous les éléments.');
        }
        
        DB::beginTransaction();
        try {
            $compteur = 0;
            $erreurs = 0;
            
            Corbeille::chunk(100, function ($elements) use (&$compteur, &$erreurs) {
                foreach ($elements as $element) {
                    try {
                        $classeModele = $element->type_element;
                        
                        if (class_exists($classeModele)) {
                            $modele = $classeModele::withTrashed()->find($element->element_id);
                            
                            if ($modele) {
                                $modele->restore();
                                $element->delete();
                                $compteur++;
                            }
                        }
                    } catch (\Exception $exception) {
                        $erreurs++;
                        // Continuer avec les autres éléments
                    }
                }
            });
            
            DB::commit();
            
            $message = "{$compteur} éléments restaurés avec succès.";
            
            if ($erreurs > 0) {
                $message .= " {$erreurs} erreurs rencontrées.";
            }
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('succes', $message);
                
        } catch (\Exception $exception) {
            DB::rollBack();
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('erreur', 'Erreur lors de la restauration : ' . $exception->getMessage());
        }
    }
    
    /**
     * Afficher les éléments par type
     */
    public function parType($type)
    {
        $elementsCorbeille = Corbeille::where('type_element', $type)
            ->with('supprimePar')
            ->orderBy('supprime_le', 'desc')
            ->paginate(25);
            
        $nomType = (new Corbeille())->nom_type;
        
        // Statistiques pour ce type
        $statistiquesType = [
            'total' => Corbeille::where('type_element', $type)->count(),
            'aujourdhui' => Corbeille::where('type_element', $type)
                ->whereDate('supprime_le', today())
                ->count(),
            'cette_semaine' => Corbeille::where('type_element', $type)
                ->where('supprime_le', '>=', now()->startOfWeek())
                ->count(),
        ];
        
        return view('back.corbeille.par-type', compact('elementsCorbeille', 'nomType', 'type', 'statistiquesType'));
    }
    
    /**
     * Télécharger un rapport de la corbeille
     */
    public function telechargerRapport(Request $requete)
    {
        $elements = Corbeille::with('supprimePar')
            ->when($requete->type, function($q, $type) {
                return $q->where('type_element', $type);
            })
            ->when($requete->date_debut, function($q, $date) {
                return $q->where('supprime_le', '>=', $date);
            })
            ->when($requete->date_fin, function($q, $date) {
                return $q->where('supprime_le', '<=', $date);
            })
            ->orderBy('supprime_le', 'desc')
            ->get();
        
        $csvContent = "ID,Type,Élément ID,Supprimé par,Date suppression,Expire le\n";
        
        foreach ($elements as $element) {
            $csvContent .= implode(',', [
                $element->id,
                $element->nom_type,
                $element->element_id,
                $element->supprimePar->nom ?? 'Système',
                $element->supprime_le->format('d/m/Y H:i'),
                $element->expire_le ? $element->expire_le->format('d/m/Y') : 'Illimité',
            ]) . "\n";
        }
        
        $nomFichier = 'corbeille-rapport-' . date('Y-m-d-H-i') . '.csv';
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"{$nomFichier}\"");
    }
    
    /**
     * Afficher le formulaire de vidage de la corbeille
     */
    public function formulaireVider()
    {
        $nombreElements = Corbeille::count();
        
        return view('back.corbeille.vider', compact('nombreElements'));
    }
    
    /**
     * Afficher le formulaire de restauration totale
     */
    public function formulaireRestaurerTous()
    {
        $nombreElements = Corbeille::count();
        
        return view('back.corbeille.restaurer-tous', compact('nombreElements'));
    }
    
    /**
     * Actions groupées
     */
    public function actionsGroupées(Request $requete)
    {
        $action = $requete->action;
        $ids = $requete->ids ?? [];
        
        if (empty($ids)) {
            return redirect()->back()->with('erreur', 'Aucun élément sélectionné.');
        }
        
        DB::beginTransaction();
        try {
            $compteur = 0;
            $erreurs = 0;
            
            foreach ($ids as $id) {
                try {
                    $element = Corbeille::find($id);
                    
                    if (!$element) continue;
                    
                    if ($action === 'restaurer') {
                        $classeModele = $element->type_element;
                        
                        if (class_exists($classeModele)) {
                            $modele = $classeModele::withTrashed()->find($element->element_id);
                            
                            if ($modele) {
                                $modele->restore();
                                $element->delete();
                                $compteur++;
                            }
                        }
                    } elseif ($action === 'supprimer') {
                        $classeModele = $element->type_element;
                        
                        if (class_exists($classeModele)) {
                            $modele = $classeModele::withTrashed()->find($element->element_id);
                            
                            if ($modele) {
                                $modele->forceDelete();
                            }
                        }
                        
                        $element->delete();
                        $compteur++;
                    }
                } catch (\Exception $exception) {
                    $erreurs++;
                }
            }
            
            DB::commit();
            
            $message = "Action '{$action}' effectuée sur {$compteur} éléments.";
            
            if ($erreurs > 0) {
                $message .= " {$erreurs} erreurs rencontrées.";
            }
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('succes', $message);
                
        } catch (\Exception $exception) {
            DB::rollBack();
            
            return redirect()
                ->route('back.corbeille.index')
                ->with('erreur', 'Erreur lors de l\'action groupée : ' . $exception->getMessage());
        }
    }
}