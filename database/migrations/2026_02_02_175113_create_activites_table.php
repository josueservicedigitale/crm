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
        // Désactiver temporairement les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Supprimer la table si elle existe déjà (avec ses contraintes)
        Schema::dropIfExists('activites');
        
        // Créer la nouvelle table
        Schema::create('activites', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->boolean('est_active')->default(true);
            $table->string('couleur', 7)->default('#3B82F6');
            $table->string('icon', 50)->default('fa-tools');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Ajouter des données de test
        $this->seedActivites();
    }
    
    /**
     * Seed initial des activités
     */
    private function seedActivites(): void
    {
        $activites = [
            [
                'nom' => 'Désembouage',
                'code' => 'desembouage',
                'description' => 'Nettoyage et désembouage des circuits de chauffage',
                'est_active' => true,
                'couleur' => '#3B82F6',
                'icon' => 'fa-broom',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Rééquilibrage',
                'code' => 'reequilibrage',
                'description' => 'Rééquilibrage des circuits hydrauliques',
                'est_active' => true,
                'couleur' => '#10B981',
                'icon' => 'fa-tools',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Maintenance Chaudière',
                'code' => 'maintenance-chaudiere',
                'description' => 'Maintenance préventive et curative des chaudières',
                'est_active' => true,
                'couleur' => '#F59E0B',
                'icon' => 'fa-fire',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        DB::table('activites')->insert($activites);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('activites');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};