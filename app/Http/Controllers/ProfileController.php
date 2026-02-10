<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Models\Utilisateur;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire de modification du profil
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $statistiques = [
            'societes' => $user->societes()->count(),
            'activites' => $user->activites()->count(),
            'documents' => $user->documents()->count(),
        ];
        
        return view('profile.edit', compact('user', 'statistiques'));
    }

    /**
     * Mettre à jour les informations du profil
     */
    public function update(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs,email,' . $user->id],
            'telephone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->only(['nom', 'email', 'telephone']);
        
        // Gérer l'upload de l'avatar
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
            
            // Supprimer l'ancien avatar si existant
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
        }

        $user->update($data);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    /**
     * Supprimer le compte utilisateur
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}