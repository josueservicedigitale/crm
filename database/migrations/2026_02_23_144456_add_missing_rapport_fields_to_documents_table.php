<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // ✅ Colonnes manquantes
            if (!Schema::hasColumn('documents', 'reactif_inhibiteur')) {
                $table->string('reactif_inhibiteur')->nullable()->after('autre_produit_desembouant');
            }
            
            if (!Schema::hasColumn('documents', 'nature_reseau')) {
                $table->string('nature_reseau')->nullable()->after('autre_type_generateur');
            }
            
            // ✅ Vérifie aussi ces colonnes au cas où
            if (!Schema::hasColumn('documents', 'pompe_type')) {
                $table->string('pompe_type')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'filtre_type')) {
                $table->string('filtre_type')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'batiment_existant')) {
                $table->string('batiment_existant')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'type_logement')) {
                $table->string('type_logement')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'installation_collective')) {
                $table->string('installation_collective')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'type_generateur')) {
                $table->string('type_generateur')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'etapes_realisees')) {
                $table->json('etapes_realisees')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'notes_complementaires')) {
                $table->text('notes_complementaires')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'cachet_image')) {
                $table->string('cachet_image')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'signature_image')) {
                $table->string('signature_image')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'sentinel_logo')) {
                $table->string('sentinel_logo')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'icone_1')) {
                $table->string('icone_1')->nullable();
            }
            
            if (!Schema::hasColumn('documents', 'icone_2')) {
                $table->string('icone_2')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn([
                'reactif_inhibiteur',
                'nature_reseau',
                'pompe_type',
                'filtre_type',
                'batiment_existant',
                'type_logement',
                'installation_collective',
                'type_generateur',
                'etapes_realisees',
                'notes_complementaires',
                'cachet_image',
                'signature_image',
                'sentinel_logo',
                'icone_1',
                'icone_2',
            ]);
        });
    }
};