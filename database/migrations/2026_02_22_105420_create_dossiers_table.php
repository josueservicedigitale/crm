<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            
            // Informations de base
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            
            // Relations
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('societe_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('activite_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('parent_id')->nullable()->references('id')->on('dossiers')->onDelete('cascade');
            
            // Visibilité et partage
            $table->boolean('est_visible')->default(false); // Privé par défaut
            $table->boolean('est_partage')->default(false);
            $table->json('partage_avec')->nullable(); // IDs des utilisateurs avec qui partager
            
            // Statistiques
            $table->integer('nombre_fichiers')->default(0);
            $table->bigInteger('taille_totale')->default(0); // en octets
            
            // Métadonnées
            $table->string('couleur')->nullable();
            $table->string('icon')->nullable();
            $table->json('metadata')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['user_id', 'est_visible']);
            $table->index(['societe_id', 'activite_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossiers');
    }
};