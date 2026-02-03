<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Désactiver temporairement les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // 2. Supprimer les tables si elles existent déjà
        Schema::dropIfExists('activite_societe');
        Schema::dropIfExists('societes');
        
        // 3. Recréer la table societes
        Schema::create('societes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->unique(); // Renommé de 'slug' à 'code'
            $table->text('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('siret')->nullable();
            $table->string('tva_intracommunautaire')->nullable();
            $table->string('logo_path')->nullable();
            $table->boolean('est_active')->default(true); // Changé de enum à boolean
            $table->string('couleur', 7)->default('#3B82F6'); // Nouveau champ
            $table->string('icon', 50)->default('fa-building'); // Nouveau champ
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Nouveau champ
            $table->timestamps();
            $table->softDeletes(); // Nouveau : suppression douce
        });

        // 4. Recréer la table pivot societe_activite
        Schema::create('activite_societe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('societe_id')->constrained()->onDelete('cascade');
            $table->foreignId('activite_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['societe_id', 'activite_id']);
        });
        
        // 5. Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // 6. Ajouter des données de test (optionnel)
        $this->seedSocietes();
    }
    
    /**
     * Seed initial des sociétés
     */
    private function seedSocietes(): void
    {
        $societes = [
            [
                'nom' => 'Énergie Nova',
                'code' => 'nova',
                'adresse' => '60 Rue François 1er',
                'ville' => 'Paris',
                'code_postal' => '75008',
                'telephone' => '0767847049',
                'email' => 'direction@energie-nova.com',
                'siret' => '933 487 795 00017',
                'tva_intracommunautaire' => 'FR12345678901',
                'est_active' => true,
                'couleur' => '#3B82F6', // Bleu
                'icon' => 'fa-industry',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'MyHouse Solutions',
                'code' => 'house',
                'adresse' => '5051 Rue du Pont Long',
                'ville' => 'Buros',
                'code_postal' => '64160',
                'telephone' => '05 59 60 21 51',
                'email' => 'contact@myhouse64.fr',
                'siret' => '89155600300046',
                'tva_intracommunautaire' => 'FR98765432109',
                'est_active' => true,
                'couleur' => '#10B981', // Vert
                'icon' => 'fa-home',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'BBR Maintenance',
                'code' => 'bbr-maintenance',
                'adresse' => '78 Avenue des Champs Elysées',
                'ville' => 'Paris',
                'code_postal' => '75008',
                'telephone' => '01 23 45 67 89',
                'email' => 'tech@bbrmaintenance.fr',
                'siret' => '93146162800030',
                'tva_intracommunautaire' => 'FR45678912345',
                'est_active' => true,
                'couleur' => '#F59E0B', // Orange
                'icon' => 'fa-tools',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        // Insérer les données de test
        foreach ($societes as $societe) {
            DB::table('societes')->insert($societe);
        }
        
        // Ajouter des relations activités-sociétés (optionnel)
        $this->seedActiviteSocieteRelations();
    }
    
    /**
     * Seed des relations activités-sociétés
     */
    private function seedActiviteSocieteRelations(): void
    {
        // Récupérer les IDs des activités existantes
        $activites = DB::table('activites')->pluck('id', 'code')->toArray();
        
        // Récupérer les IDs des sociétés existantes
        $societes = DB::table('societes')->pluck('id', 'code')->toArray();
        
        $relations = [
            // Énergie Nova - Désembouage
            [
                'societe_id' => $societes['nova'] ?? 1,
                'activite_id' => $activites['desembouage'] ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Énergie Nova - Rééquilibrage
            [
                'societe_id' => $societes['nova'] ?? 1,
                'activite_id' => $activites['reequilibrage'] ?? 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // MyHouse Solutions - Désembouage
            [
                'societe_id' => $societes['house'] ?? 2,
                'activite_id' => $activites['desembouage'] ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // MyHouse Solutions - Maintenance Chaudière
            [
                'societe_id' => $societes['house'] ?? 2,
                'activite_id' => $activites['maintenance-chaudiere'] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // BBR Maintenance - Rééquilibrage
            [
                'societe_id' => $societes['bbr-maintenance'] ?? 3,
                'activite_id' => $activites['reequilibrage'] ?? 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($relations as $relation) {
            DB::table('activite_societe')->insertOrIgnore($relation);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Désactiver temporairement les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Supprimer les tables dans l'ordre inverse (d'abord les dépendances)
        Schema::dropIfExists('activite_societe');
        Schema::dropIfExists('societes');
        
        // Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};