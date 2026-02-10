<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'file_path',  // TRÈS IMPORTANT !
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
        
    ];

    // Si vous avez un $guarded, assurez-vous qu'il est vide ou ne contient pas file_path
    protected $guarded = []; // Doit être vide
    
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
}