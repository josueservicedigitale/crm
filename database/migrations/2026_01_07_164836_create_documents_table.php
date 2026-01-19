<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('society'); // nova, house
            $table->string('activity'); // desembouage, reequilibrage
            $table->string('type'); // devis, facture, attestation_realisation, attestation_signataire, cahier_charge, rapport
            
            // Champs principaux du devis
            $table->string('reference_devis')->nullable();
            $table->date('date_devis')->nullable();
            $table->text('adresse_travaux')->nullable();
            $table->string('numero_immatriculation')->nullable();
            $table->string('nom_residence')->nullable();
            $table->string('parcelle_1')->nullable();
            $table->string('parcelle_2')->nullable();
            $table->string('parcelle_3')->nullable();
            $table->string('parcelle_4')->nullable();
            $table->string('dates_previsionnelles')->nullable();
            $table->integer('nombre_batiments')->nullable();
            $table->text('details_batiments')->nullable();
            
            // Montants
            $table->decimal('montant_ht', 10, 2)->nullable();
            $table->decimal('montant_tva', 10, 2)->nullable();
            $table->decimal('montant_ttc', 10, 2)->nullable();
            $table->decimal('prime_cee', 10, 2)->nullable();
            $table->decimal('reste_a_charge', 10, 2)->nullable();
            
            // Informations techniques
            $table->string('puissance_chaudiere')->nullable();
            $table->integer('nombre_logements')->nullable();
            $table->integer('nombre_emetteurs')->nullable();
            $table->string('zone_climatique')->nullable();
            $table->string('volume_circuit')->nullable();
            $table->integer('nombre_filtres')->nullable();
            $table->string('wh_cumac')->nullable();
            $table->decimal('somme', 10, 2)->nullable();
            
            // Pour attestation réalisation
            $table->string('puissance_nominale')->nullable();
            $table->string('volume_total')->nullable();
            $table->date('date_travaux')->nullable();
            $table->text('details_batiment')->nullable();
            $table->date('date_facture')->nullable();
            $table->date('date_signataire')->nullable();
            
            // Pour rapport
            $table->string('reference_facture')->nullable();
            $table->string('adresse_travaux_1')->nullable();
            $table->string('boite_postale_1')->nullable();
            $table->string('adresse_travaux_2')->nullable();
            
            // Liens entre documents
            $table->string('linked_devis')->nullable(); // Pour facture
            $table->string('linked_facture')->nullable(); // Pour attestation
            
            // Chemin du fichier PDF
            $table->string('file_path')->nullable();
            
            // Utilisateur qui a créé le document
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
            // Index pour les recherches
            $table->index(['society', 'activity', 'type']);
            $table->index('reference_devis');
            $table->index('linked_devis');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};