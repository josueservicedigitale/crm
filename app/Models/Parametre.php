<?php
// app/Models/Parametre.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Parametre extends Model
{
    use HasFactory;

    protected $fillable = [
        'cle',
        'valeur',
        'type',
        'groupe',
        'titre',
        'description',
        'options',
        'ordre',
        'est_actif',
        'est_systeme',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'est_systeme' => 'boolean',
        'options' => 'array',
        'ordre' => 'integer',
    ];

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Effacer le cache lors des modifications
        static::saved(function ($parametre) {
            Cache::forget('parametre_' . $parametre->cle);
            Cache::forget('parametres_groupe_' . $parametre->groupe);
            Cache::forget('parametres_tous');
        });

        static::deleted(function ($parametre) {
            Cache::forget('parametre_' . $parametre->cle);
            Cache::forget('parametres_groupe_' . $parametre->groupe);
            Cache::forget('parametres_tous');
        });
    }

    /**
     * Obtenir la valeur castée selon le type
     */
    public function getValeurCastAttribute()
    {
        return match($this->type) {
            'integer' => (int) $this->valeur,
            'boolean' => filter_var($this->valeur, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($this->valeur, true),
            'array' => json_decode($this->valeur, true),
            'float' => (float) $this->valeur,
            default => $this->valeur,
        };
    }

    /**
     * Scope pour les paramètres actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('est_actif', true);
    }

    /**
     * Scope pour les paramètres système
     */
    public function scopeSysteme($query)
    {
        return $query->where('est_systeme', true);
    }

    /**
     * Scope pour les paramètres non-système
     */
    public function scopeNonSysteme($query)
    {
        return $query->where('est_systeme', false);
    }

    /**
     * Scope par groupe
     */
    public function scopeGroupe($query, $groupe)
    {
        return $query->where('groupe', $groupe);
    }

    /**
     * Obtenir tous les paramètres avec cache
     */
    public static function obtenirTous()
    {
        return Cache::remember('parametres_tous', 3600, function () {
            return self::actifs()->nonSysteme()->get()->keyBy('cle');
        });
    }

    /**
     * Obtenir un paramètre spécifique avec cache
     */
    public static function obtenir($cle, $defaut = null)
    {
        return Cache::remember('parametre_' . $cle, 3600, function () use ($cle, $defaut) {
            $parametre = self::where('cle', $cle)->actifs()->first();
            return $parametre ? $parametre->valeur_cast : $defaut;
        });
    }

    /**
     * Définir un paramètre
     */
    public static function definir($cle, $valeur, $options = [])
    {
        $parametre = self::firstOrNew(['cle' => $cle]);
        
        $parametre->fill(array_merge([
            'valeur' => is_array($valeur) || is_object($valeur) ? json_encode($valeur) : $valeur,
            'type' => is_array($valeur) ? 'json' : gettype($valeur),
            'titre' => ucfirst(str_replace('_', ' ', $cle)),
            'est_actif' => true,
        ], $options));
        
        $parametre->save();
        
        return $parametre;
    }

    /**
     * Obtenir les paramètres par groupe
     */
    public static function parGroupe($groupe)
    {
        return Cache::remember('parametres_groupe_' . $groupe, 3600, function () use ($groupe) {
            return self::where('groupe', $groupe)
                ->actifs()
                ->nonSysteme()
                ->orderBy('ordre')
                ->get()
                ->mapWithKeys(function ($param) {
                    return [$param->cle => $param->valeur_cast];
                })
                ->toArray();
        });
    }
}