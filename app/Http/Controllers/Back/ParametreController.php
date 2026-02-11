<?php
// app/Http\Controllers/Back\ParametreController.php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ParametreController extends Controller
{
    /**
     * Afficher la liste des paramètres
     */
    public function index(Request $request)
    {
        // Récupérer tous les groupes distincts
        $groupes = Parametre::select('groupe')
            ->distinct()
            ->orderBy('groupe')
            ->pluck('groupe');
        
        // Groupe actif (par défaut le premier)
        $groupeActif = $request->get('groupe', $groupes->first());
        
        // Récupérer les paramètres du groupe actif
        $parametres = Parametre::where('groupe', $groupeActif)
            ->orderBy('ordre')
            ->orderBy('titre')
            ->get();
        
        // Utilisez les fonctions globales
        $nomApp = parametre('nom_application', 'Mon CRM');
        $joursCorbeille = parametre('jours_conservation_corbeille', 30);
        
        return view('back.parametres.index', compact(
            'parametres', 
            'groupes', 
            'groupeActif',
            'nomApp',
            'joursCorbeille'
        ));
    }
    
    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $types = [
            'string' => 'Texte court',
            'text' => 'Texte long',
            'integer' => 'Nombre entier',
            'float' => 'Nombre décimal',
            'boolean' => 'Oui/Non',
            'json' => 'JSON',
            'array' => 'Tableau',
            'select' => 'Liste déroulante',
            'email' => 'Email',
            'url' => 'URL',
        ];
        
        $groupes = Parametre::select('groupe')
            ->distinct()
            ->orderBy('groupe')
            ->pluck('groupe')
            ->toArray();
        
        // Groupes par défaut
        $groupesParDefaut = [
            'general' => 'Général',
            'apparence' => 'Apparence',
            'email' => 'Emails',
            'securite' => 'Sécurité',
            'systeme' => 'Système',
            'corbeille' => 'Corbeille',
            'documents' => 'Documents',
            'societes' => 'Sociétés',
            'activites' => 'Activités',
        ];
        
        $tousGroupes = array_unique(array_merge($groupesParDefaut, $groupes));
        
        return view('back.parametres.create', compact('types', 'tousGroupes'));
    }
    
    /**
     * Enregistrer un nouveau paramètre
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cle' => 'required|string|max:100|unique:parametres,cle',
            'titre' => 'required|string|max:200',
            'description' => 'nullable|string',
            'groupe' => 'required|string|max:50',
            'type' => 'required|string|in:string,text,integer,float,boolean,json,array,select,email,url',
            'valeur' => 'nullable',
            'ordre' => 'nullable|integer',
            'est_actif' => 'boolean',
            'est_systeme' => 'boolean',
            'options' => 'nullable|json',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Convertir la valeur selon le type
        $valeur = $request->valeur;
        if ($request->type === 'boolean') {
            $valeur = $request->boolean('valeur') ? '1' : '0';
        }
        
        // Utilisez la fonction globale définir_parametre
        $parametre = definir_parametre($request->cle, $valeur, [
            'titre' => $request->titre,
            'description' => $request->description,
            'groupe' => $request->groupe,
            'type' => $request->type,
            'ordre' => $request->ordre ?? 0,
            'est_actif' => $request->boolean('est_actif'),
            'est_systeme' => $request->boolean('est_systeme'),
            'options' => $request->options,
        ]);
        
        Cache::flush(); // Effacer tout le cache
        
        return redirect()->route('back.parametres.index')
            ->with('success', 'Paramètre créé avec succès.');
    }
    
    /**
     * Afficher un paramètre
     */
    public function show(Parametre $parametre)
    {
        return view('back.parametres.show', compact('parametre'));
    }
    
    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Parametre $parametre)
    {
        $types = [
            'string' => 'Texte court',
            'text' => 'Texte long',
            'integer' => 'Nombre entier',
            'float' => 'Nombre décimal',
            'boolean' => 'Oui/Non',
            'json' => 'JSON',
            'array' => 'Tableau',
            'select' => 'Liste déroulante',
            'email' => 'Email',
            'url' => 'URL',
        ];
        
        $groupes = Parametre::select('groupe')
            ->distinct()
            ->orderBy('groupe')
            ->pluck('groupe')
            ->toArray();
        
        $groupesParDefaut = [
            'general' => 'Général',
            'apparence' => 'Apparence',
            'email' => 'Emails',
            'securite' => 'Sécurité',
            'systeme' => 'Système',
            'corbeille' => 'Corbeille',
            'documents' => 'Documents',
            'societes' => 'Sociétés',
            'activites' => 'Activités',
        ];
        
        $tousGroupes = array_unique(array_merge($groupesParDefaut, $groupes));
        
        return view('back.parametres.edit', compact('parametre', 'types', 'tousGroupes'));
    }
    
    /**
     * Mettre à jour un paramètre
     */
    public function update(Request $request, Parametre $parametre)
    {
        if ($parametre->est_systeme) {
            return redirect()->route('back.parametres.index')
                ->with('error', 'Les paramètres système ne peuvent pas être modifiés.');
        }
        
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:200',
            'description' => 'nullable|string',
            'groupe' => 'required|string|max:50',
            'type' => 'required|string|in:string,text,integer,float,boolean,json,array,select,email,url',
            'valeur' => 'nullable',
            'ordre' => 'nullable|integer',
            'est_actif' => 'boolean',
            'options' => 'nullable|json',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Convertir la valeur selon le type
        $valeur = $request->valeur;
        if ($request->type === 'boolean') {
            $valeur = $request->boolean('valeur') ? '1' : '0';
        }
        
        // Utilisez la fonction globale définir_parametre
        $parametre = definir_parametre($parametre->cle, $valeur, [
            'titre' => $request->titre,
            'description' => $request->description,
            'groupe' => $request->groupe,
            'type' => $request->type,
            'ordre' => $request->ordre ?? 0,
            'est_actif' => $request->boolean('est_actif'),
            'options' => $request->options,
        ]);
        
        Cache::flush();
        
        return redirect()->route('back.parametres.index')
            ->with('success', 'Paramètre mis à jour avec succès.');
    }
    
    /**
     * Supprimer un paramètre
     */
    public function destroy(Parametre $parametre)
    {
        if ($parametre->est_systeme) {
            return redirect()->route('back.parametres.index')
                ->with('error', 'Les paramètres système ne peuvent pas être supprimés.');
        }
        
        $parametre->delete();
        
        Cache::flush();
        
        return redirect()->route('back.parametres.index')
            ->with('success', 'Paramètre supprimé avec succès.');
    }
    
    /**
     * Mettre à jour plusieurs paramètres en masse
     */
    public function updateEnMasse(Request $request)
    {
        $parametres = $request->except('_token');
        
        foreach ($parametres as $cle => $valeur) {
            $parametre = Parametre::where('cle', $cle)->first();
            
            if ($parametre && !$parametre->est_systeme) {
                // Utilisez la fonction globale définir_parametre
                definir_parametre($cle, $valeur);
            }
        }
        
        Cache::flush();
        
        return redirect()->route('back.parametres.index')
            ->with('success', 'Paramètres mis à jour avec succès.');
    }
    
    /**
     * Restaurer les paramètres par défaut
     */
    public function restaurerDefauts()
    {
        // Supprimer tous les paramètres non-système
        Parametre::where('est_systeme', false)->delete();
        
        // Créer les paramètres par défaut
        $this->creerParametresDefauts();
        
        Cache::flush();
        
        return redirect()->route('back.parametres.index')
            ->with('success', 'Paramètres restaurés avec succès.');
    }
    
    /**
     * Créer les paramètres par défaut
     */
    private function creerParametresDefauts()
    {
        $parametresDefauts = [
            // Général
            [
                'cle' => 'nom_application',
                'titre' => 'Nom de l\'application',
                'description' => 'Nom affiché dans l\'en-tête et les emails',
                'groupe' => 'general',
                'type' => 'string',
                'valeur' => 'Mon CRM',
                'ordre' => 1,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            [
                'cle' => 'description_application',
                'titre' => 'Description de l\'application',
                'description' => 'Description courte affichée dans le footer',
                'groupe' => 'general',
                'type' => 'text',
                'valeur' => 'Gestion complète de vos documents et sociétés',
                'ordre' => 2,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            [
                'cle' => 'timezone',
                'titre' => 'Fuseau horaire',
                'description' => 'Fuseau horaire par défaut',
                'groupe' => 'general',
                'type' => 'string',
                'valeur' => 'Europe/Paris',
                'ordre' => 3,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            
            // Apparence
            [
                'cle' => 'theme_couleur',
                'titre' => 'Couleur du thème',
                'description' => 'Couleur principale de l\'interface',
                'groupe' => 'apparence',
                'type' => 'string',
                'valeur' => '#3b82f6',
                'ordre' => 1,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            [
                'cle' => 'logo_url',
                'titre' => 'URL du logo',
                'description' => 'URL vers le logo de l\'application',
                'groupe' => 'apparence',
                'type' => 'url',
                'valeur' => '/assets/img/logo.png',
                'ordre' => 2,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            [
                'cle' => 'favicon_url',
                'titre' => 'URL du favicon',
                'description' => 'URL vers le favicon',
                'groupe' => 'apparence',
                'type' => 'url',
                'valeur' => '/favicon.ico',
                'ordre' => 3,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            
            // Corbeille
            [
                'cle' => 'jours_conservation_corbeille',
                'titre' => 'Jours de conservation corbeille',
                'description' => 'Nombre de jours avant suppression définitive',
                'groupe' => 'corbeille',
                'type' => 'integer',
                'valeur' => '30',
                'ordre' => 1,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            [
                'cle' => 'notifications_corbeille',
                'titre' => 'Notifications corbeille',
                'description' => 'Activer les notifications pour la corbeille',
                'groupe' => 'corbeille',
                'type' => 'boolean',
                'valeur' => '1',
                'ordre' => 2,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            
            // Documents
            [
                'cle' => 'taille_max_fichier',
                'titre' => 'Taille maximum des fichiers',
                'description' => 'Taille maximum en Mo pour les uploads',
                'groupe' => 'documents',
                'type' => 'integer',
                'valeur' => '10',
                'ordre' => 1,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            [
                'cle' => 'extensions_autorisees',
                'titre' => 'Extensions autorisées',
                'description' => 'Extensions de fichiers autorisées (séparées par des virgules)',
                'groupe' => 'documents',
                'type' => 'string',
                'valeur' => 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
                'ordre' => 2,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            
            // Sécurité
            [
                'cle' => 'force_mot_de_passe',
                'titre' => 'Force minimale mot de passe',
                'description' => 'Exiger un mot de passe fort',
                'groupe' => 'securite',
                'type' => 'boolean',
                'valeur' => '1',
                'ordre' => 1,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            [
                'cle' => 'duree_session',
                'titre' => 'Durée de session (minutes)',
                'description' => 'Durée avant déconnexion automatique',
                'groupe' => 'securite',
                'type' => 'integer',
                'valeur' => '120',
                'ordre' => 2,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            
            // Emails
            [
                'cle' => 'email_expediteur',
                'titre' => 'Email expéditeur',
                'description' => 'Email utilisé pour envoyer les notifications',
                'groupe' => 'email',
                'type' => 'email',
                'valeur' => 'noreply@example.com',
                'ordre' => 1,
                'est_actif' => true,
                'est_systeme' => false,
            ],
            [
                'cle' => 'nom_expediteur',
                'titre' => 'Nom expéditeur',
                'description' => 'Nom affiché dans les emails',
                'groupe' => 'email',
                'type' => 'string',
                'valeur' => 'Mon CRM',
                'ordre' => 2,
                'est_actif' => true,
                'est_systeme' => false,
            ],
        ];
        
        foreach ($parametresDefauts as $param) {
            // Utilisez la fonction globale définir_parametre
            definir_parametre($param['cle'], $param['valeur'], [
                'titre' => $param['titre'],
                'description' => $param['description'],
                'groupe' => $param['groupe'],
                'type' => $param['type'],
                'ordre' => $param['ordre'],
                'est_actif' => $param['est_actif'],
                'est_systeme' => $param['est_systeme'],
            ]);
        }
    }
    
    /**
     * Tester les paramètres
     */
    public function tester()
    {
        // Test des fonctions globales
        $tests = [
            'nom_application' => parametre('nom_application', 'Défaut'),
            'jours_corbeille' => parametre('jours_conservation_corbeille', 30),
            'theme_couleur' => parametre('theme_couleur', '#000000'),
            'parametres_general' => parametres_groupe('general'),
        ];
        
        return response()->json([
            'status' => 'success',
            'tests' => $tests,
            'message' => 'Tests des paramètres effectués avec succès.'
        ]);
    }
}