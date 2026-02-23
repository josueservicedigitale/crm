<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // ✅ Produits dynamiques (stockés en JSON)
            $table->json('produits_utilises')->nullable()->after('reste_a_charge');
            
            // ✅ Checkboxes (stockés en JSON)
            $table->json('checkboxes')->nullable()->after('produits_utilises');
            
            // ✅ Images uploadées (chemins en JSON)
            $table->json('images')->nullable()->after('checkboxes');
            
            // ✅ Champs texte libres
            $table->string('autre_produit_desembouant')->nullable();
            $table->string('autre_produit_inhibiteur')->nullable();
            $table->string('autre_type_generateur')->nullable();
            $table->string('autre_nature_reseau')->nullable();
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['produits_utilises', 'checkboxes', 'images', 
                               'autre_produit_desembouant', 'autre_produit_inhibiteur',
                               'autre_type_generateur', 'autre_nature_reseau']);
        });
    }
};