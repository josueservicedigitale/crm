<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // ✅ Vérifier si la colonne existe avant de l'ajouter
            if (!Schema::hasColumn('documents', 'pompe_type')) {
                $table->string('pompe_type')->nullable()->after('reste_a_charge');
            }
            
            if (!Schema::hasColumn('documents', 'pompe_autre_texte')) {
                $table->string('pompe_autre_texte')->nullable()->after('pompe_type');
            }
            
            if (!Schema::hasColumn('documents', 'reactif_desembouant')) {
                $table->string('reactif_desembouant')->nullable()->after('pompe_autre_texte');
            }
            
            // Ces colonnes existent déjà de la première migration
            // Donc on ne les ajoute PAS ici
            
            if (!Schema::hasColumn('documents', 'filtre_type')) {
                $table->string('filtre_type')->nullable()->after('autre_produit_inhibiteur');
            }
            
            if (!Schema::hasColumn('documents', 'filtre_autre_texte')) {
                $table->string('filtre_autre_texte')->nullable()->after('filtre_type');
            }

            // ✅ CRITÈRES (vérifier avant d'ajouter)
            if (!Schema::hasColumn('documents', 'batiment_existant')) {
                $table->string('batiment_existant')->nullable()->after('filtre_autre_texte');
            }
            
            if (!Schema::hasColumn('documents', 'type_logement')) {
                $table->string('type_logement')->nullable()->after('batiment_existant');
            }
            
            if (!Schema::hasColumn('documents', 'installation_collective')) {
                $table->string('installation_collective')->nullable()->after('type_logement');
            }
            
            if (!Schema::hasColumn('documents', 'type_generateur')) {
                $table->string('type_generateur')->nullable()->after('installation_collective');
            }
            
            // autre_type_generateur existe déjà
            // autre_nature_reseau existe déjà
            
            if (!Schema::hasColumn('documents', 'surface_plancher_chauffant')) {
                $table->decimal('surface_plancher_chauffant', 10, 2)->nullable()->after('autre_nature_reseau');
            }

            // ✅ ÉTAPES (vérifier avant d'ajouter)
            if (!Schema::hasColumn('documents', 'etapes_realisees')) {
                $table->json('etapes_realisees')->nullable()->after('surface_plancher_chauffant');
            }

            // ✅ NOTES (vérifier avant d'ajouter)
            if (!Schema::hasColumn('documents', 'notes_complementaires')) {
                $table->text('notes_complementaires')->nullable()->after('etapes_realisees');
            }

            // ✅ IMAGES (vérifier avant d'ajouter)
            if (!Schema::hasColumn('documents', 'cachet_image')) {
                $table->string('cachet_image')->nullable()->after('notes_complementaires');
            }
            
            if (!Schema::hasColumn('documents', 'signature_image')) {
                $table->string('signature_image')->nullable()->after('cachet_image');
            }
            
            if (!Schema::hasColumn('documents', 'sentinel_logo')) {
                $table->string('sentinel_logo')->nullable()->after('signature_image');
            }
            
            if (!Schema::hasColumn('documents', 'icone_1')) {
                $table->string('icone_1')->nullable()->after('sentinel_logo');
            }
            
            if (!Schema::hasColumn('documents', 'icone_2')) {
                $table->string('icone_2')->nullable()->after('icone_1');
            }
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // On ne supprime que les colonnes qu'on a ajoutées dans cette migration
            $columns = [
                'pompe_type',
                'pompe_autre_texte',
                'reactif_desembouant',
                'filtre_type',
                'filtre_autre_texte',
                'batiment_existant',
                'type_logement',
                'installation_collective',
                'type_generateur',
                'surface_plancher_chauffant',
                'etapes_realisees',
                'notes_complementaires',
                'cachet_image',
                'signature_image',
                'sentinel_logo',
                'icone_1',
                'icone_2',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('documents', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};