<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // ← AJOUTEZ CET IMPORT

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'society',
        'activity',
        'type',
        'parent_id',

        // Devis
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

        // Montants
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
        'volume_total',
        'date_travaux',
        'date_facture',
        'date_signature',
        // Rapport / Liens
        'reference_facture',
        'adresse_travaux_1',
        'boite_postale_1',
        'adresse_travaux_2',
        'linked_devis',
        'linked_facture',

        // PDF
        'file_path',

        // User
        'user_id',
    ];
protected $casts = [
    'date_devis'     => 'date',
    'date_facture'   => 'date',
    'date_travaux'   => 'date',
    'date_signature' => 'date',

    'montant_ht'     => 'decimal:2',
    'montant_tva'    => 'decimal:2',
    'montant_ttc'    => 'decimal:2',
    'prime_cee'      => 'decimal:2',
    'reste_a_charge' => 'decimal:2',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function devis()
    {
        return $this->belongsTo(Document::class, 'linked_devis', 'reference');
    }

    public function facture()
    {
        return $this->belongsTo(Document::class, 'linked_facture', 'reference');
    }

    
    public function setReferenceAttribute($value)
    {
        $this->attributes['reference'] = strtoupper($value);
    }

    public function scopeBySociety($query, $society)
    {
        return $query->where('society', $society);
    }

    public function scopeByActivity($query, $activity)
    {
        return $query->where('activity', $activity);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }


    public function hasPdf(): bool
    {
        return $this->file_path
            && Storage::disk('public')->exists(
                str_replace('storage/', '', $this->file_path)
            );
    }

    public function getPdfUrlAttribute(): ?string
    {
        return $this->file_path ? asset($this->file_path) : null;
    }

    public function getPdfFullPathAttribute(): ?string
    {
        return $this->file_path
            ? Storage::disk('public')->path(
                str_replace('storage/', '', $this->file_path)
            )
            : null;
    }

    public function getPdfData(): array
    {
        return $this->only($this->fillable);
    }


    public static function generateReference(string $society, string $type): string
    {
        return strtoupper($society)
            . '-' . strtoupper(substr($type, 0, 3))
            . '-' . time();
    }


    public function parent()
{
    return $this->belongsTo(Document::class, 'parent_id');
}

public function children()
{
    return $this->hasMany(Document::class, 'parent_id');
}

}





//  public function generate(string $template, array $fields, string $outputPath): void