<?php


namespace App\Traits;

use App\Models\Corbeille;

trait SuppressionDouce
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    
    protected static function bootSuppressionDouce()
    {
        static::deleting(function ($modele) {
            // Si c'est une suppression définitive, ne rien faire
            if ($modele->forceDeleting) {
                return;
            }
            
            // Sauvegarder dans la corbeille
            Corbeille::create([
                'type_element' => get_class($modele),
                'element_id' => $modele->id,
                'donnees' => $modele->toJson(),
                'supprime_par' => auth()->id(),
                'supprime_le' => now(),
                'expire_le' => now()->addDays(config('app.jours_conservation_corbeille', 30)),
            ]);
        });
    }
    
    public function restaurer()
    {
        // Supprimer de la corbeille avant restauration
        Corbeille::where('type_element', get_class($this))
            ->where('element_id', $this->id)
            ->delete();
            
        return parent::restaurer();
    }
}