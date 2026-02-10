<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCorbeille extends Migration
{
    public function up()
    {
        Schema::create('corbeille', function (Blueprint $table) {
            $table->id();
            $table->string('type_element'); // Ex: Utilisateur, Société, Activité, Document
            $table->unsignedBigInteger('element_id');
            $table->json('donnees')->nullable(); // Données sérialisées de l'élément
            $table->unsignedBigInteger('supprime_par')->nullable(); // ID de l'utilisateur qui a supprimé
            $table->timestamp('supprime_le');
            $table->timestamp('expire_le')->nullable(); // Date d'expiration (nettoyage auto)
            $table->timestamps();
            
            // Index pour les performances
            $table->index(['type_element', 'element_id']);
            $table->index('supprime_le');
        });
    }

    public function down()
    {
        Schema::dropIfExists('corbeille');
    }
}