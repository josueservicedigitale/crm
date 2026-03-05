<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function disableFkChecks(): void
{
    $driver = DB::getDriverName();
    if ($driver === 'mysql') {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    } elseif ($driver === 'pgsql') {
        DB::statement('SET session_replication_role = replica;');
    }
}

private function enableFkChecks(): void
{
    $driver = DB::getDriverName();
    if ($driver === 'mysql') {
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    } elseif ($driver === 'pgsql') {
        DB::statement('SET session_replication_role = origin;');
    }
}
    public function up(): void
    {
        // ⚠️ En prod, on ne drop pas une table automatiquement.
        // Si tu veux vraiment recreer, fais-le via migrate:fresh en local.
        if (!Schema::hasTable('activites')) {
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
        }

        // Seed seulement si table vide (évite doublons au redeploy)
        if (DB::table('activites')->count() === 0) {
            DB::table('activites')->insert([
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
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('activites');
    }
};