<?php
// app/Models/Corbeille.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corbeille extends Model
{
    use HasFactory;
    
    protected $table = 'corbeille';
    
    protected $fillable = [
        'type_element',
        'element_id',
        'donnees',
        'supprime_par',
        'supprime_le',
        'expire_le'
    ];
    
    protected $casts = [
        'donnees' => 'array',
        'supprime_le' => 'datetime',
        'expire_le' => 'datetime',
    ];
    
    /**
     * Relation avec l'utilisateur qui a supprimé
     */
    public function supprimePar()
    {
        return $this->belongsTo(Utilisateur::class, 'supprime_par');
    }
    
    /**
     * Récupérer l'élément supprimé
     */
    public function element()
    {
        return $this->morphTo('element', 'type_element', 'element_id');
    }
    
    /**
     * Obtenir le nom affichable du type d'élément
     */
    public function getNomTypeAttribute()
    {
        $types = [
            'App\Models\Utilisateur' => 'Utilisateur',
            'App\Models\Societe' => 'Société',
            'App\Models\Activite' => 'Activité',
            'App\Models\Document' => 'Document',
            'App\Models\Devis' => 'Devis',
            'App\Models\Facture' => 'Facture',
            'App\Models\Attestation' => 'Attestation',
            'App\Models\Rapport' => 'Rapport',
        ];
        
        return $types[$this->type_element] ?? 'Élément';
    }
    
    /**
     * Vérifier si l'élément a expiré
     */
    public function getAExpireAttribute()
    {
        if (!$this->expire_le) {
            return false;
        }
        
        return $this->expire_le->isPast();
    }
    
    /**
     * Nombre de jours restants avant expiration
     */
    public function getJoursRestantsAttribute()
    {
        if (!$this->expire_le) {
            return null;
        }
        
        return now()->diffInDays($this->expire_le, false);
    }
}