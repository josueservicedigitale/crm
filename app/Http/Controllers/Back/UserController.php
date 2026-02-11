<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Constructeur avec middleware pour vérifier le rôle admin
     */
    public function __construct()
    {
        // Seuls les administrateurs peuvent accéder à ces pages
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role !== 'admin') {
                abort(403, 'Accès non autorisé.');
            }
            return $next($request);
        });
    }

    /**
     * Liste tous les utilisateurs
     */
    public function index()
    {
        $users = User::withTrashed() // inclut les soft-deleted
                     ->orderBy('created_at', 'desc')
                     ->paginate(20);

        $stats = [
            'total' => User::count(),
            'actifs' => User::where('est_actif', true)->count(),
            'inactifs' => User::where('est_actif', false)->count(),
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'corbeille' => User::onlyTrashed()->count(),
        ];

        return view('back.users.index', compact('users', 'stats'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('back.users.create');
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'est_actif' => 'sometimes|boolean',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telephone' => $request->telephone,
                'role' => $request->role,
                'est_actif' => $request->has('est_actif'),
            ]);

            Log::info('✅ Utilisateur créé', [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('back.users.index')
                ->with('success', 'Utilisateur créé avec succès.');
        } catch (\Exception $e) {
            Log::error('❌ Erreur création utilisateur', [
                'error' => $e->getMessage(),
                'data' => $request->except('password', 'password_confirmation')
            ]);

            return back()->withInput()
                ->withErrors('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('back.users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'est_actif' => 'sometimes|boolean',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'role' => $request->role,
                'est_actif' => $request->has('est_actif'),
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            Log::info('🔄 Utilisateur mis à jour', [
                'id' => $user->id,
                'email' => $user->email,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('back.users.index')
                ->with('success', 'Utilisateur mis à jour.');
        } catch (\Exception $e) {
            Log::error('❌ Erreur modification utilisateur', [
                'id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->withInput()
                ->withErrors('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Suppression douce (soft delete)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Empêcher l'utilisateur de se supprimer lui-même
        if ($user->id === auth()->id()) {
            return back()->withErrors('Vous ne pouvez pas supprimer votre propre compte.');
        }

        try {
            $user->delete();

            Log::info('🗑️ Utilisateur supprimé (soft)', [
                'id' => $user->id,
                'email' => $user->email,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('back.users.index')
                ->with('success', 'Utilisateur déplacé dans la corbeille.');
        } catch (\Exception $e) {
            Log::error('❌ Erreur suppression utilisateur', [
                'id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->withErrors('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Bascule le statut actif/inactif
     */
    public function toggleStatus($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        // Empêcher de désactiver son propre compte
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas modifier votre propre statut.'
            ], 403);
        }

        $user->est_actif = !$user->est_actif;
        $user->save();

        Log::info('🔄 Statut utilisateur basculé', [
            'id' => $user->id,
            'nouveau_statut' => $user->est_actif,
            'user_id' => auth()->id()
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'est_actif' => $user->est_actif,
                'message' => $user->est_actif ? 'Utilisateur activé' : 'Utilisateur désactivé'
            ]);
        }

        return redirect()->route('back.users.index')
            ->with('success', $user->est_actif ? 'Utilisateur activé.' : 'Utilisateur désactivé.');
    }

    /**
     * Restaurer un utilisateur supprimé
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        Log::info('♻️ Utilisateur restauré', [
            'id' => $user->id,
            'email' => $user->email,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('back.users.index')
            ->with('success', 'Utilisateur restauré.');
    }

    /**
     * Suppression définitive (force delete)
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        // Supprimer l'avatar si existant
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->forceDelete();

        Log::info('💀 Utilisateur supprimé définitivement', [
            'id' => $user->id,
            'email' => $user->email,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('back.users.index')
            ->with('success', 'Utilisateur supprimé définitivement.');
    }
}