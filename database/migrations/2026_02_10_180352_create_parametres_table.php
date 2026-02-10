<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_parametres_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            $table->string('cle')->unique();
            $table->text('valeur')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json, text
            $table->string('groupe')->default('general');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->json('options')->nullable(); // Options pour les select, etc.
            $table->integer('ordre')->default(0);
            $table->boolean('est_actif')->default(true);
            $table->boolean('est_systeme')->default(false); // Paramètre système non modifiable
            $table->timestamps();
            
            // Index pour les performances
            $table->index(['groupe', 'est_actif']);
            $table->index('ordre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parametres');
    }
};