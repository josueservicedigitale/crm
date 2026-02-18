<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Societe;
use App\Models\Activite;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    /**
     * Recherche globale dans toute l'application
     */
    public function global(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query) || strlen($query) < 2) {
            return redirect()->back()->with('error', 'Veuillez saisir au moins 2 caractères');
        }
        
        Log::info('🔍 Recherche globale', [
            'query' => $query,
            'user_id' => auth()->id()
        ]);
        
  
       // =================================================================
// 1. RECHERCHE DOCUMENTS - COUVRE TOUS LES CHAMPS DE LA TABLE
// =================================================================
$documents = Document::query()
    ->where(function($q) use ($query) {
        // Identifiants et références
        $q->where('id', 'LIKE', "%{$query}%")
          ->orWhere('devis_id', 'LIKE', "%{$query}%")
          ->orWhere('reference', 'LIKE', "%{$query}%")
          ->orWhere('reference_devis', 'LIKE', "%{$query}%")
          ->orWhere('reference_facture', 'LIKE', "%{$query}%")
          ->orWhere('linked_devis', 'LIKE', "%{$query}%")
          ->orWhere('linked_facture', 'LIKE', "%{$query}%")
          
          // Sociétés et activités
          ->orWhere('society', 'LIKE', "%{$query}%")
          ->orWhere('activity', 'LIKE', "%{$query}%")
          ->orWhere('type', 'LIKE', "%{$query}%")
          
          // Adresses et lieux
          ->orWhere('adresse_travaux', 'LIKE', "%{$query}%")
          ->orWhere('adresse_travaux_1', 'LIKE', "%{$query}%")
          ->orWhere('adresse_travaux_2', 'LIKE', "%{$query}%")
          ->orWhere('boite_postale_1', 'LIKE', "%{$query}%")
          ->orWhere('nom_residence', 'LIKE', "%{$query}%")
          ->orWhere('zone_climatique', 'LIKE', "%{$query}%")
          
          // Parcelles
          ->orWhere('parcelle_1', 'LIKE', "%{$query}%")
          ->orWhere('parcelle_2', 'LIKE', "%{$query}%")
          ->orWhere('parcelle_3', 'LIKE', "%{$query}%")
          ->orWhere('parcelle_4', 'LIKE', "%{$query}%")
          
          // Informations techniques
          ->orWhere('numero_immatriculation', 'LIKE', "%{$query}%")
          ->orWhere('puissance_chaudiere', 'LIKE', "%{$query}%")
          ->orWhere('volume_circuit', 'LIKE', "%{$query}%")
          ->orWhere('volume_total', 'LIKE', "%{$query}%")
          ->orWhere('wh_cumac', 'LIKE', "%{$query}%")
          ->orWhere('details_batiments', 'LIKE', "%{$query}%")
          ->orWhere('dates_previsionnelles', 'LIKE', "%{$query}%")
          
          // Dates (recherche textuelle)
          ->orWhere('date_devis', 'LIKE', "%{$query}%")
          ->orWhere('date_travaux', 'LIKE', "%{$query}%")
          ->orWhere('date_facture', 'LIKE', "%{$query}%")
          ->orWhere('date_signature', 'LIKE', "%{$query}%")
          
          // Montants et nombres (recherche textuelle)
          ->orWhere('montant_ht', 'LIKE', "%{$query}%")
          ->orWhere('montant_tva', 'LIKE', "%{$query}%")
          ->orWhere('montant_ttc', 'LIKE', "%{$query}%")
          ->orWhere('prime_cee', 'LIKE', "%{$query}%")
          ->orWhere('reste_a_charge', 'LIKE', "%{$query}%")
          ->orWhere('somme', 'LIKE', "%{$query}%")
          
          // Nombres (convertir en string pour la recherche)
          ->orWhere(DB::raw('CAST(nombre_batiments AS CHAR)'), 'LIKE', "%{$query}%")
          ->orWhere(DB::raw('CAST(nombre_logements AS CHAR)'), 'LIKE', "%{$query}%")
          ->orWhere(DB::raw('CAST(nombre_emetteurs AS CHAR)'), 'LIKE', "%{$query}%")
          ->orWhere(DB::raw('CAST(nombre_filtres AS CHAR)'), 'LIKE', "%{$query}%")
          
          // Fichiers
          ->orWhere('file_path', 'LIKE', "%{$query}%")
          
          // Dates de création/modification
          ->orWhere(DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y %H:%i")'), 'LIKE', "%{$query}%")
          ->orWhere(DB::raw('DATE_FORMAT(updated_at, "%d/%m/%Y %H:%i")'), 'LIKE', "%{$query}%")
          ->orWhere(DB::raw('DATE_FORMAT(pdf_generated_at, "%d/%m/%Y %H:%i")'), 'LIKE', "%{$query}%");
    })
    ->with(['user', 'parent'])
    ->withCount('children')
    ->latest()
    ->limit(30)
    ->get()
    ->map(function($doc) use ($query) {
        // Trouver le champ qui correspond le mieux à la recherche
        $matchedField = $this->findBestMatch($doc, $query);
        
        return [
            'id' => $doc->id,
            'type' => 'document',
            'type_label' => $this->getDocumentTypeLabel($doc->type),
            'title' => $doc->reference ?? 'Document #' . $doc->id,
            'subtitle' => $this->getDocumentSubtitle($doc),
            'excerpt' => $this->getExcerpt($matchedField['value'] ?? '', $query),
            'match_field' => $matchedField['field'] ?? null,
            'match_field_label' => $this->getFieldLabel($matchedField['field'] ?? ''),
            'url' => route('back.document.show', [
                $doc->activity, $doc->society, $doc->type, $doc->id
            ]),
            'icon' => $this->getDocumentIcon($doc->type),
            'color' => $this->getDocumentColor($doc->type),
            'date' => $doc->created_at->format('d/m/Y'),
            'badge' => $doc->type,
            'society' => $doc->society,
            'activity' => $doc->activity,
            'montant' => $doc->montant_ttc ? number_format($doc->montant_ttc, 2) . ' €' : null,
            'has_parent' => !is_null($doc->parent_id),
            'has_children' => $doc->children_count > 0,
            'has_pdf' => !is_null($doc->file_path),
        ];
    });
        
        // =================================================================
        // 2. RECHERCHE SOCIÉTÉS
        // =================================================================
        $societes = Societe::query()
            ->where(function($q) use ($query) {
                $q->where('nom', 'LIKE', "%{$query}%")
                  ->orWhere('code', 'LIKE', "%{$query}%")
                  ->orWhere('display_name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('telephone', 'LIKE', "%{$query}%")
                  ->orWhere('ville', 'LIKE', "%{$query}%")
                  ->orWhere('code_postal', 'LIKE', "%{$query}%")
                  ->orWhere('siret', 'LIKE', "%{$query}%")
                  ->orWhere('adresse', 'LIKE', "%{$query}%");
            })
            ->withCount('documents')
            ->limit(10)
            ->get()
            ->map(function($soc) {
                return [
                    'id' => $soc->id,
                    'type' => 'societe',
                    'type_label' => 'Société',
                    'title' => $soc->display_name ?? $soc->nom,
                    'subtitle' => $soc->ville ?: $soc->code,
                    'excerpt' => $soc->adresse,
                    'url' => route('back.societes.show', $soc->code),
                    'icon' => $soc->icon ?? 'fa-building',
                    'color' => 'primary',
                    'badge' => $soc->documents_count . ' doc(s)',
                ];
            });
        
        // =================================================================
        // 3. RECHERCHE ACTIVITÉS
        // =================================================================
        $activites = Activite::query()
            ->where(function($q) use ($query) {
                $q->where('nom', 'LIKE', "%{$query}%")
                  ->orWhere('code', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->withCount('documents')
            ->limit(10)
            ->get()
            ->map(function($act) {
                return [
                    'id' => $act->id,
                    'type' => 'activite',
                    'type_label' => 'Activité',
                    'title' => $act->nom,
                    'subtitle' => $act->code,
                    'excerpt' => $act->description,
                    'url' => route('back.activites.show', $act->code),
                    'icon' => $act->icon ?? 'fa-tasks',
                    'color' => 'success',
                    'badge' => $act->documents_count . ' doc(s)',
                ];
            });
        
        // =================================================================
        // 4. RECHERCHE UTILISATEURS
        // =================================================================
        $users = collect();
        if (auth()->user() && auth()->user()->estAdministrateur()) {
            $users = User::query()
                ->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('email', 'LIKE', "%{$query}%")
                      ->orWhere('telephone', 'LIKE', "%{$query}%");
                })
                ->limit(10)
                ->get()
                ->map(function($user) {
                    return [
                        'id' => $user->id,
                        'type' => 'user',
                        'type_label' => 'Utilisateur',
                        'title' => $user->name,
                        'subtitle' => $user->email,
                        'excerpt' => $user->telephone,
                        'url' => route('back.users.edit', $user->id),
                        'icon' => 'fa-user',
                        'color' => 'info',
                        'badge' => $user->est_actif ? 'Actif' : 'Inactif',
                    ];
                });
        }
        
        // =================================================================
        // 5. RECHERCHE MESSAGES
        // =================================================================
        $messages = Message::query()
            ->where('body', 'LIKE', "%{$query}%")
            ->with(['user', 'conversation'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($msg) use ($query) {
                return [
                    'id' => $msg->id,
                    'type' => 'message',
                    'type_label' => 'Message',
                    'title' => $this->getExcerpt($msg->body, $query, 60),
                    'subtitle' => $msg->user->name ?? 'Inconnu',
                    'excerpt' => $msg->body,
                    'url' => route('back.messagerie.show', $msg->conversation_id),
                    'icon' => $msg->file_path ? 'fa-file' : 'fa-comment',
                    'color' => $msg->file_path ? 'warning' : 'secondary',
                    'date' => $msg->created_at->format('d/m/Y H:i'),
                    'has_file' => !is_null($msg->file_path),
                ];
            });
        
        // =================================================================
        // 6. RECHERCHE DANS CORBEILLE (admin uniquement)
        // =================================================================
        $corbeille = collect();
        if (auth()->user() && auth()->user()->estAdministrateur()) {
            $corbeille = DB::table('corbeille')
                ->where('donnees', 'LIKE', "%{$query}%")
                ->orWhere('type_element', 'LIKE', "%{$query}%")
                ->latest('supprime_le')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    $donnees = json_decode($item->donnees, true);
                    return [
                        'id' => $item->id,
                        'type' => 'corbeille',
                        'type_label' => 'Corbeille',
                        'title' => $donnees['nom'] ?? $donnees['reference'] ?? 'Élément supprimé',
                        'subtitle' => $item->type_element,
                        'excerpt' => 'Supprimé le ' . \Carbon\Carbon::parse($item->supprime_le)->format('d/m/Y'),
                        'url' => route('back.corbeille.afficher', $item->id),
                        'icon' => 'fa-trash',
                        'color' => 'danger',
                    ];
                });
        }
        
        // =================================================================
        // 7. STATISTIQUES DE RECHERCHE
        // =================================================================
        $stats = [
            'documents' => $documents->count(),
            'societes' => $societes->count(),
            'activites' => $activites->count(),
            'users' => $users->count(),
            'messages' => $messages->count(),
            'corbeille' => $corbeille->count(),
            'total' => $documents->count() + $societes->count() + $activites->count() + 
                       $users->count() + $messages->count() + $corbeille->count()
        ];
        
        // Fusionner tous les résultats
        $results = collect()
            ->concat($documents)
            ->concat($societes)
            ->concat($activites)
            ->concat($users)
            ->concat($messages)
            ->concat($corbeille);
        
        return view('back.search.results', compact(
            'query',
            'documents',
            'societes',
            'activites',
            'users',
            'messages',
            'corbeille',
            'stats',
            'results'
        ));
    }
    
    /**
     * API de recherche AJAX pour suggestions en direct
     */
    public function ajax(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }
        
        // Suggestions rapides (limitées à 3 par catégorie)
        $documents = Document::where('reference', 'LIKE', "%{$query}%")
            ->orWhere('nom_residence', 'LIKE', "%{$query}%")
            ->latest()
            ->limit(3)
            ->get()
            ->map(fn($d) => [
                'type' => 'document',
                'type_label' => ucfirst($d->type),
                'text' => $d->reference,
                'subtext' => $d->nom_residence ?? $d->adresse_travaux,
                'url' => route('back.document.show', [$d->activity, $d->society, $d->type, $d->id]),
                'icon' => $this->getDocumentIcon($d->type),
            ]);
        
        $societes = Societe::where('nom', 'LIKE', "%{$query}%")
            ->orWhere('display_name', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(fn($s) => [
                'type' => 'societe',
                'type_label' => 'Société',
                'text' => $s->display_name ?? $s->nom,
                'subtext' => $s->ville,
                'url' => route('back.societes.show', $s->code),
                'icon' => 'fa-building',
            ]);
        
        $activites = Activite::where('nom', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(fn($a) => [
                'type' => 'activite',
                'type_label' => 'Activité',
                'text' => $a->nom,
                'subtext' => $a->code,
                'url' => route('back.activites.show', $a->code),
                'icon' => 'fa-tasks',
            ]);
        
        return response()->json([
            'results' => $documents->concat($societes)->concat($activites)->take(8)
        ]);
    }
    
  /**
 * Trouve le champ qui correspond le mieux à la recherche
 */
private function findBestMatch($document, $query)
{
    $fields = [
        'reference' => $document->reference,
        'adresse_travaux' => $document->adresse_travaux,
        'nom_residence' => $document->nom_residence,
        'reference_devis' => $document->reference_devis,
        'reference_facture' => $document->reference_facture,
        'numero_immatriculation' => $document->numero_immatriculation,
        'parcelle_1' => $document->parcelle_1,
        'parcelle_2' => $document->parcelle_2,
        'parcelle_3' => $document->parcelle_3,
        'parcelle_4' => $document->parcelle_4,
        'puissance_chaudiere' => $document->puissance_chaudiere,
        'zone_climatique' => $document->zone_climatique,
        'wh_cumac' => $document->wh_cumac,
    ];
    
    $bestMatch = ['field' => null, 'value' => null, 'score' => 0];
    
    foreach ($fields as $field => $value) {
        if (empty($value)) continue;
        
        $pos = stripos($value, $query);
        if ($pos !== false) {
            $score = strlen($query) / max(strlen($value), 1) * 100;
            $score += (100 - $pos); // Plus le match est tôt, mieux c'est
            
            if ($score > $bestMatch['score']) {
                $bestMatch = [
                    'field' => $field,
                    'value' => $value,
                    'score' => $score
                ];
            }
        }
    }
    
    return $bestMatch;
}

/**
 * Obtenir un libellé lisible pour un champ
 */
private function getFieldLabel($field)
{
    $labels = [
        'reference' => 'Référence',
        'adresse_travaux' => 'Adresse',
        'nom_residence' => 'Résidence',
        'reference_devis' => 'Réf. Devis',
        'reference_facture' => 'Réf. Facture',
        'numero_immatriculation' => 'N° Immatriculation',
        'parcelle_1' => 'Parcelle 1',
        'parcelle_2' => 'Parcelle 2',
        'parcelle_3' => 'Parcelle 3',
        'parcelle_4' => 'Parcelle 4',
        'puissance_chaudiere' => 'Puissance',
        'zone_climatique' => 'Zone climatique',
        'wh_cumac' => 'WH Cumac',
    ];
    
    return $labels[$field] ?? ucfirst(str_replace('_', ' ', $field));
}

/**
 * Obtenir le sous-titre du document
 */
private function getDocumentSubtitle($doc)
{
    $parts = [];
    if ($doc->society) $parts[] = strtoupper($doc->society);
    if ($doc->activity) $parts[] = ucfirst($doc->activity);
    if ($doc->nom_residence) $parts[] = $doc->nom_residence;
    if ($doc->adresse_travaux) $parts[] = substr($doc->adresse_travaux, 0, 30);
    
    return implode(' • ', $parts);
}

/**
 * Obtenir un extrait du texte avec le mot recherché en contexte
 */
private function getExcerpt($text, $query, $length = 100)
{
    if (empty($text)) return '';
    
    $text = strip_tags($text);
    $position = mb_stripos($text, $query);
    
    if ($position !== false) {
        $start = max(0, $position - 40);
        $excerpt = mb_substr($text, $start, $length);
        
        if ($start > 0) $excerpt = '...' . $excerpt;
        if (mb_strlen($text) > $start + $length) $excerpt .= '...';
        
        // Mettre en évidence le terme recherché
        $excerpt = preg_replace('/(' . preg_quote($query, '/') . ')/iu', '<mark>$1</mark>', $excerpt);
        
        return $excerpt;
    }
    
    return mb_strlen($text) > $length ? mb_substr($text, 0, $length) . '...' : $text;
}

/**
 * Obtenir l'icône selon le type de document
 */
private function getDocumentIcon($type)
{
    return match($type) {
        'devis' => 'fa-file-invoice',
        'facture' => 'fa-file-invoice-dollar',
        'rapport' => 'fa-chart-line',
        'cahier_des_charges' => 'fa-book',
        'attestation_realisation', 'attestation_signataire' => 'fa-certificate',
        default => 'fa-file-alt'
    };
}

/**
 * Obtenir la couleur selon le type de document
 */
private function getDocumentColor($type)
{
    return match($type) {
        'devis' => 'primary',
        'facture' => 'success',
        'rapport' => 'info',
        'cahier_des_charges' => 'dark',
        'attestation_realisation', 'attestation_signataire' => 'warning',
        default => 'secondary'
    };
}

/**
 * Obtenir le libellé du type de document
 */
private function getDocumentTypeLabel($type)
{
    return match($type) {
        'devis' => 'Devis',
        'facture' => 'Facture',
        'rapport' => 'Rapport',
        'cahier_des_charges' => 'Cahier des charges',
        'attestation_realisation' => 'Attestation réalisation',
        'attestation_signataire' => 'Attestation signataire',
        default => ucfirst($type)
    };
}
}