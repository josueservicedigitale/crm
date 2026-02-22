<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fichiers', function (Blueprint $table) {
            $table->id();
            
            // Informations du fichier
            $table->string('nom');
            $table->string('nom_original');
            $table->string('extension', 20);
            $table->string('mime_type');
            $table->bigInteger('taille'); // en octets
            $table->string('chemin');
            $table->string('url')->nullable();
            
            // Relations
            $table->foreignId('dossier_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('document_id')->nullable()->constrained()->onDelete('set null');
            
            // Visibilité (héritée du dossier ou spécifique)
            $table->boolean('est_visible')->default(false);
            
            // Métadonnées
            $table->json('metadata')->nullable();
            $table->string('crc32')->nullable(); // Pour vérification d'intégrité
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index(['dossier_id', 'est_visible']);
            $table->index('user_id');
            $table->index('document_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fichiers');
    }
};