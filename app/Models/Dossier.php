<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\Corbeille;
use Illuminate\Support\Facades\Auth;

class Dossier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom',
        'description',
        'slug',
        'user_id',
        'societe_id',
        'activite_id',
        'parent_id',
        'est_visible',
        'est_partage',
        'partage_avec',
        'nombre_fichiers',
        'taille_totale',
        'couleur',
        'icon',
        'metadata',
        'statut',
    ];

    protected $casts = [
        'est_visible' => 'boolean',
        'est_partage' => 'boolean',
        'partage_avec' => 'array',
        'metadata' => 'array',
        'taille_totale' => 'integer',
    ];

    protected $appends = [
        'taille_formatee',
        'chemin_complet',
        'url_partage'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($dossier) {
            if (empty($dossier->slug)) {
                $dossier->slug = Str::slug($dossier->nom) . '-' . uniqid();
            }

            if (empty($dossier->icon)) {
                $dossier->icon = 'fa-folder';
            }

            if (empty($dossier->couleur)) {
                $dossier->couleur = '#FFB700'; // Or INVESTCALORIS
            }
            if (empty($dossier->statut)) {
                $dossier->statut = 'brouillon';
            }

        });
        static::deleted(function ($dossier) {
            // Évite double log si forceDelete (optionnel)
            if (!$dossier->trashed())
                return;

            Corbeille::create([
                'type_element' => self::class,
                'element_id' => $dossier->id,
                'donnees' => $dossier->toArray(),
                'supprime_par' => Auth::id(),
                'supprime_le' => now(),
                'expire_le' => now()->addDays(config('app.jours_conservation_corbeille', 30)),
            ]);
        });

    }

    // =============================
    // RELATIONS
    // =============================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function societe()
    {
        return $this->belongsTo(Societe::class);
    }

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }

    public function parent()
    {
        return $this->belongsTo(Dossier::class, 'parent_id');
    }

    public function enfants()
    {
        return $this->hasMany(Dossier::class, 'parent_id');
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'dossier_document');
    }

    public function utilisateursPartages()
    {
        return $this->belongsToMany(User::class, 'dossier_user')
            ->withPivot('permission')
            ->withTimestamps();
    }

    // =============================
    // SCOPES
    // =============================

    public function scopeVisibles($query)
    {
        return $query->where('est_visible', true);
    }

    public function scopePrives($query)
    {
        return $query->where('est_visible', false);
    }

    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where('user_id', $userId)
            ->orWhereHas('utilisateursPartages', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
    }

    public function scopeParSociete($query, $societeId)
    {
        return $query->where('societe_id', $societeId);
    }

    public function scopeParActivite($query, $activiteId)
    {
        return $query->where('activite_id', $activiteId);
    }

    public function scopeRacines($query)
    {
        return $query->whereNull('parent_id');
    }

    // =============================
    // ACCESSORS
    // =============================

    public function getTailleFormateeAttribute()
    {
        $size = $this->taille_totale;
        $units = ['o', 'Ko', 'Mo', 'Go'];
        $i = 0;

        while ($size >= 1024 && $i < 3) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    public function getCheminCompletAttribute()
    {
        $path = [];
        $dossier = $this;

        while ($dossier) {
            array_unshift($path, $dossier->nom);
            $dossier = $dossier->parent;
        }

        return implode(' / ', $path);
    }

    public function getUrlPartageAttribute()
    {
        if (!$this->est_visible)
            return null;

        return \Route::has('back.dossiers.public')
            ? route('back.dossiers.public', $this->slug)
            : null;
    }

    public function getIconeClasseAttribute()
    {
        return $this->icon ?? ($this->est_visible ? 'fa-folder-open' : 'fa-folder');
    }

    // =============================
    // MÉTHODES
    // =============================

    public function estAccessiblePar($userId)
    {
        if ($this->user_id == $userId) {
            return true;
        }

        if ($this->est_visible) {
            return true;
        }

        return $this->utilisateursPartages()->where('user_id', $userId)->exists();
    }

    public function permissionPour($userId)
    {
        if ($this->user_id == $userId) {
            return 'admin';
        }

        $partage = $this->utilisateursPartages()->where('user_id', $userId)->first();

        return $partage ? $partage->pivot->permission : null;
    }

    public function peutEcrire($userId)
    {
        $permission = $this->permissionPour($userId);
        return in_array($permission, ['ecriture', 'admin']);
    }

    public function peutAdmin($userId)
    {
        return $this->permissionPour($userId) === 'admin';
    }

    public function mettreAJourStats()
    {
        $this->nombre_fichiers = $this->fichiers()->count();
        $this->taille_totale = $this->fichiers()->sum('taille');
        $this->saveQuietly();
    }

    public function ajouterFichier($file, $document = null)
    {
        // Logique d'upload
    }

    // Dans app/Models/Dossier.php
    public function getAncestors()
    {
        $ancestors = collect();
        $current = $this->parent;

        while ($current) {
            $ancestors->prepend($current);
            $current = $current->parent;
        }

        return $ancestors;
    }

    public function getStatutBadgeClassAttribute()
    {
        return match ($this->statut) {
            'brouillon' => 'secondary',
            'valide' => 'success',
            'ferme' => 'dark',
            default => 'secondary',
        };
    }

    public function canBeDeletedBy($user)
    {
        return $user
            && $user->role === 'admin'
            && $this->statut === 'ferme';
    }
}