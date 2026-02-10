<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Exécuter les migrations.
     */
    public function up(): void
    {
        // 1. Désactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 2. Sauvegarder les données existantes
        $existingUsers = DB::table('users')->get();
        
        // 3. Supprimer la table existante
        Schema::dropIfExists('users');
        
        // 4. Recréer la table avec la nouvelle structure
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('role')->default('user');
            $table->boolean('est_actif')->default(true);
            $table->timestamp('derniere_connexion')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour les performances
            $table->index('email');
            $table->index('role');
            $table->index('est_actif');
            $table->index('deleted_at');
        });
        
        // 5. Réinsérer les données existantes
        foreach ($existingUsers as $user) {
            DB::table('users')->insert([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'password' => $user->password,
                'telephone' => $user->telephone ?? null,
                'avatar' => $user->avatar ?? null,
                'role' => $user->role ?? 'user',
                'est_actif' => isset($user->est_actif) ? $user->est_actif : true,
                'derniere_connexion' => $user->derniere_connexion ?? null,
                'remember_token' => $user->remember_token,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'deleted_at' => $user->deleted_at ?? null,
            ]);
        }
        
        // 6. Réactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Inverser les migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Sauvegarder les données
        $existingUsers = DB::table('users')->get();
        
        // Recréer l'ancienne structure (simplifiée)
        Schema::dropIfExists('users');
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        
        // Réinsérer les données (sans les nouveaux champs)
        foreach ($existingUsers as $user) {
            DB::table('users')->insert([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'password' => $user->password,
                'remember_token' => $user->remember_token,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};