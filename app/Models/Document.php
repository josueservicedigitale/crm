<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        // Champs existants
        'file_path',
        'reference',
        'society',
        'activity',
        'type',
        'reference_devis',
        'date_devis',
        'adresse_travaux',
        'numero_immatriculation',
        'nom_residence',
        'parcelle_1',
        'parcelle_2',
        'parcelle_3',
        'parcelle_4',
        'dates_previsionnelles',
        'nombre_batiments',
        'details_batiments',
        'montant_ht',
        'montant_tva',
        'montant_ttc',
        'prime_cee',
        'reste_a_charge',
        'puissance_chaudiere',
        'nombre_logements',
        'nombre_emetteurs',
        'zone_climatique',
        'volume_circuit',
        'nombre_filtres',
        'wh_cumac',
        'somme',
        'date_facture',
        'date_signature',
        'reference_facture',
        'user_id',
        'parent_id',

        'nature_travaux',
        'fiche_cee',
        'date_engagement',

        // ✅ NOUVEAUX CHAMPS (à ajouter)
        'produits_utilises',
        'checkboxes',
        'images',
        'autre_produit_desembouant',
        'autre_produit_inhibiteur',
        'autre_type_generateur',
        'autre_nature_reseau',
        'pompe_type',
        'pompe_autre_texte',
        'reactif_desembouant',
        'reactif_inhibiteur',
        'filtre_type',
        'filtre_autre_texte',
        'batiment_existant',
        'type_logement',
        'installation_collective',
        'type_generateur',
        'nature_reseau',
        'etapes_realisees',
        'notes_complementaires',
        'surface_plancher_chauffant',
        'cachet_image',
        'signature_image',
        'sentinel_logo',
        'icone_1',
        'icone_2'
    ];

    // Si vous avez un $guarded, assurez-vous qu'il est vide ou ne contient pas les nouveaux champs
    protected $guarded = [];

    // =============================
    // CASTS - TRÈS IMPORTANT POUR LES JSON
    // =============================
    protected $casts = [
        'produits_utilises' => 'array',
        'checkboxes' => 'array',
        'images' => 'array',
        'etapes_realisees' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'date_devis' => 'date',
        'date_facture' => 'date',
        'date_signature' => 'date',
        'date_engagement' => 'date',
        'prime_cee' => 'decimal:2',
        'bon_achat' => 'decimal:2',
        'pret_bonifie' => 'decimal:2',
        'pret_teg' => 'decimal:2',
        'audit_valeur' => 'decimal:2',
        'produit_offert_valeur' => 'decimal:2',
    ];



    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le parent
    public function parent()
    {
        return $this->belongsTo(Document::class, 'parent_id');
    }

    // Relation avec les enfants
    public function children()
    {
        return $this->hasMany(Document::class, 'parent_id');
    }

    // Méthode pour générer une référence
    public static function generateReference($society, $type)
    {
        $prefix = strtoupper($society) . '-' . strtoupper(substr($type, 0, 3)) . '-' . date('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        return $prefix . '-' . $random;
    }
    public function activite()
    {
        return $this->belongsTo(Activite::class, 'activity', 'code');
    }
}