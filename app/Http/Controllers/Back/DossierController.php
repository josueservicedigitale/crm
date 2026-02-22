<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use App\Models\Societe;
use App\Models\Activite;
use App\Models\Fichier;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use ZipArchive;


class DossierController extends Controller
{
    /**
     * Vue principale des dossiers
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Query de base
        $query = Dossier::pourUtilisateur($user->id)
            ->with(['user', 'societe', 'activite', 'enfants', 'fichiers'])
            ->withCount(['enfants', 'fichiers']);

        // Filtres
        if ($request->filled('societe')) {
            $query->where('societe_id', $request->societe);
        }

        if ($request->filled('activite')) {
            $query->where('activite_id', $request->activite);
        }

        if ($request->filled('visibilite')) {
            if ($request->visibilite === 'public') {
                $query->where('est_visible', true);
            } elseif ($request->visibilite === 'prive') {
                $query->where('est_visible', false);
            }
        }

        if ($request->filled('search')) {
            $query->where('nom', 'LIKE', '%' . $request->search . '%');
        }

        // Dossiers racines uniquement pour la vue principale
        $dossiers = $query->racines()
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        // Statistiques
        $stats = [
            'total' => Dossier::pourUtilisateur($user->id)->count(),
            'publics' => Dossier::pourUtilisateur($user->id)->visibles()->count(),
            'prives' => Dossier::pourUtilisateur($user->id)->prives()->count(),
            'fichiers' => Fichier::whereHas('dossier', function ($q) use ($user) {
                $q->pourUtilisateur($user->id);
            })->count(),
            'taille_totale' => Fichier::whereHas('dossier', function ($q) use ($user) {
                $q->pourUtilisateur($user->id);
            })->sum('taille'),
        ];

        // Données pour les filtres
        $societes = Societe::active()->orderBy('nom')->get();
        $activites = Activite::active()->orderBy('nom')->get();

        return view('back.dossier.index', compact('dossiers', 'stats', 'societes', 'activites'))
            ->with('formatBytes', [$this, 'formatBytes']);
    }

    /**
     * Afficher un dossier spécifique
     */
    public function show($slug)
    {
        $dossier = Dossier::where('slug', $slug)
            ->with(['user', 'societe', 'activite', 'parent'])
            ->withCount(['enfants', 'fichiers'])
            ->firstOrFail();

        // Vérifier les permissions
        if (!$dossier->estAccessiblePar(Auth::id())) {
            abort(403, 'Vous n\'avez pas accès à ce dossier');
        }

        // Sous-dossiers et fichiers
        $enfants = $dossier->enfants()
            ->withCount(['enfants', 'fichiers'])
            ->orderBy('nom')
            ->get();

        $fichiers = $dossier->fichiers()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('back.dossier.show', compact('dossier', 'enfants', 'fichiers'));
    }

    /**
     * Formulaire de création
     */
    public function create(Request $request)
    {
        try {
            $parent = null;
            if ($request->filled('parent')) {
                $parent = Dossier::find($request->parent);
            }

            $societes = Societe::active()->orderBy('nom')->get();
            $activites = Activite::active()->orderBy('nom')->get();

            return view('back.dossier.create', compact('parent', 'societes', 'activites'));
        } catch (\Exception $e) {
            // Affiche l'erreur directement dans le navigateur (à enlever après)
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * Enregistrer un nouveau dossier
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:dossiers,id',
            'societe_id' => 'nullable|exists:societes,id',
            'activite_id' => 'nullable|exists:activites,id',
            'est_visible' => 'boolean',
            'couleur' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $dossier = Dossier::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'slug' => Str::slug($request->nom) . '-' . uniqid(),
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'societe_id' => $request->societe_id,
            'activite_id' => $request->activite_id,
            'est_visible' => $request->boolean('est_visible'),
            'couleur' => $request->couleur,
            'icon' => $request->icon,
        ]);

        Log::info('📁 Nouveau dossier créé', [
            'dossier_id' => $dossier->id,
            'nom' => $dossier->nom,
            'user_id' => Auth::id()
        ]);

        $redirect = $dossier->parent
            ? route('back.dossiers.show', $dossier->parent->slug)
            : route('back.dossiers.index');

        return redirect($redirect)->with('success', 'Dossier créé avec succès');
    }

    /**
     * Formulaire d'édition
     */
    public function edit($id)
    {
        $dossier = Dossier::findOrFail($id);

        if ($dossier->user_id !== Auth::id()) {
            abort(403);
        }

        $societes = Societe::active()->orderBy('nom')->get();
        $activites = Activite::active()->orderBy('nom')->get();

        return view('back.dossier.edit', compact('dossier', 'societes', 'activites'));
    }

    /**
     * Mettre à jour un dossier
     */
    public function update(Request $request, $id)
    {
        $dossier = Dossier::findOrFail($id);

        if ($dossier->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'societe_id' => 'nullable|exists:societes,id',
            'activite_id' => 'nullable|exists:activites,id',
            'est_visible' => 'boolean',
            'couleur' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
        ]);

        $dossier->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'societe_id' => $request->societe_id,
            'activite_id' => $request->activite_id,
            'est_visible' => $request->boolean('est_visible'),
            'couleur' => $request->couleur,
            'icon' => $request->icon,
        ]);

        return redirect()->route('back.dossiers.show', $dossier->slug)
            ->with('success', 'Dossier mis à jour');
    }

    /**
     * Supprimer un dossier
     */
    public function destroy($id)
    {
        $dossier = Dossier::findOrFail($id);

        if ($dossier->user_id !== Auth::id()) {
            abort(403);
        }

        $parentSlug = $dossier->parent?->slug;

        $dossier->delete();

        $redirect = $parentSlug
            ? route('back.dossiers.show', $parentSlug)
            : route('back.dossiers.index');

        return redirect($redirect)->with('success', 'Dossier supprimé');
    }

    /**
     * Upload de fichiers dans un dossier
     */
    public function upload(Request $request, $id)
    {
        $dossier = Dossier::findOrFail($id);

        if (!$dossier->peutEcrire(Auth::id())) {
            abort(403);
        }

        $request->validate([
            'fichiers' => 'required|array',
            'fichiers.*' => 'required|file|max:10240', // 10MB max
        ]);

        $uploaded = [];

        foreach ($request->file('fichiers') as $file) {
            $nomOriginal = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $nom = time() . '_' . uniqid() . '.' . $extension;

            $chemin = $file->storeAs(
                "dossiers/{$dossier->id}",
                $nom,
                'public'
            );

            $fichier = Fichier::create([
                'nom' => $nom,
                'nom_original' => $nomOriginal,
                'extension' => $extension,
                'mime_type' => $file->getMimeType(),
                'taille' => $file->getSize(),
                'chemin' => $chemin,
                'url' => Storage::url($chemin),
                'dossier_id' => $dossier->id,
                'user_id' => Auth::id(),
                'est_visible' => $dossier->est_visible,
            ]);

            $uploaded[] = $fichier;
        }

        // Mettre à jour les stats
        $dossier->mettreAJourStats();

        return response()->json([
            'success' => true,
            'message' => count($uploaded) . ' fichier(s) uploadé(s)',
            'fichiers' => $uploaded
        ]);
    }

    /**
     * Télécharger un fichier
     */
    public function downloadFichier($id)
    {
        $fichier = Fichier::findOrFail($id);

        if (!$fichier->estAccessiblePar(Auth::id())) {
            abort(403);
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        return $disk->download($fichier->chemin, $fichier->nom_original);
    }

    /**
     * Télécharger tout un dossier en ZIP
     */
    public function downloadDossier($id)
    {
        $dossier = Dossier::with('fichiers')->findOrFail($id);

        if (!$dossier->estAccessiblePar(Auth::id())) {
            abort(403);
        }

        $zip = new ZipArchive();
        $zipName = storage_path("app/temp/{$dossier->slug}.zip");

        if (!file_exists(dirname($zipName))) {
            mkdir(dirname($zipName), 0755, true);
        }

        if ($zip->open($zipName, ZipArchive::CREATE) === TRUE) {
            foreach ($dossier->fichiers as $fichier) {
                $path = Storage::disk('public')->path($fichier->chemin);
                if (file_exists($path)) {
                    $zip->addFile($path, $fichier->nom_original);
                }
            }

            $zip->close();

            return response()->download($zipName, $dossier->nom . '.zip')->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Erreur lors de la création du ZIP');
    }

    /**
     * Basculer la visibilité d'un dossier
     */
    public function toggleVisibilite($id)
    {
        $dossier = Dossier::findOrFail($id);

        if ($dossier->user_id !== Auth::id()) {
            abort(403);
        }

        $dossier->est_visible = !$dossier->est_visible;
        $dossier->save();

        // Propager aux fichiers
        $dossier->fichiers()->update(['est_visible' => $dossier->est_visible]);

        return response()->json([
            'success' => true,
            'est_visible' => $dossier->est_visible,
            'message' => $dossier->est_visible ? 'Dossier public' : 'Dossier privé'
        ]);
    }

    /**
     * Partager un dossier avec d'autres utilisateurs
     */
    public function partager(Request $request, $id)
    {
        $dossier = Dossier::findOrFail($id);

        if (!$dossier->peutAdmin(Auth::id())) {
            abort(403);
        }

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'permission' => 'required|in:lecture,ecriture'
        ]);

        foreach ($request->user_ids as $userId) {
            $dossier->utilisateursPartages()->syncWithoutDetaching([
                $userId => ['permission' => $request->permission]
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Dossier partagé avec succès'
        ]);
    }
    private function formatBytes($bytes, $precision = 2)
    {
        if ($bytes <= 0) {
            return '0 o';
        }

        $units = ['o', 'Ko', 'Mo', 'Go', 'To'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
