<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Fichier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom',
        'nom_original',
        'extension',
        'mime_type',
        'taille',
        'chemin',
        'url',
        'dossier_id',
        'user_id',
        'document_id',
        'est_visible',
        'metadata',
        'crc32'
    ];

    protected $casts = [
        'est_visible' => 'boolean',
        'metadata' => 'array',
        'taille' => 'integer',
    ];

    protected $appends = [
        'taille_formatee',
        'icone',
        'url_telechargement',
        'est_image'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fichier) {
            $fichier->crc32 = hash_file('crc32', Storage::disk('public')->path($fichier->chemin));
        });

        static::deleted(function ($fichier) {
            // Supprimer le fichier physique
            Storage::disk('public')->delete($fichier->chemin);

            // Mettre à jour les stats du dossier
            if ($fichier->dossier) {
                $fichier->dossier->mettreAJourStats();
            }
        });
    }
    protected static function booted()
    {
        static::deleted(function ($fichier) {
            if (!$fichier->trashed())
                return;

            Corbeille::create([
                'type_element' => self::class,
                'element_id' => $fichier->id,
                'donnees' => $fichier->toArray(),
                'supprime_par' => Auth::id(),
                'supprime_le' => now(),
                'expire_le' => now()->addDays(config('app.jours_conservation_corbeille', 30)),
            ]);
        });
    }
    // =============================
    // RELATIONS
    // =============================

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    // =============================
    // ACCESSORS
    // =============================

    public function getTailleFormateeAttribute()
    {
        $size = $this->taille;
        $units = ['o', 'Ko', 'Mo', 'Go'];
        $i = 0;

        while ($size >= 1024 && $i < 3) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    public function getIconeAttribute()
    {
        if ($this->est_image)
            return 'fa-file-image';

        return match ($this->extension) {
            'pdf' => 'fa-file-pdf',
            'doc', 'docx' => 'fa-file-word',
            'xls', 'xlsx' => 'fa-file-excel',
            'zip', 'rar' => 'fa-file-archive',
            default => 'fa-file'
        };
    }

    public function getEstImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function getUrlTelechargementAttribute()
    {
        return route('back.fichiers.download', $this->id);
    }

    public function getUrlVisionneuseAttribute()
    {
        return $this->est_image ? Storage::url($this->chemin) : null;
    }

    // =============================
    // MÉTHODES
    // =============================

    public function estAccessiblePar($userId)
    {
        return $this->dossier && $this->dossier->estAccessiblePar($userId);
    }
}