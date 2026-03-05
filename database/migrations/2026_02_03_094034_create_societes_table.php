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
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        if ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = replica');
        }
    }

    private function enableFkChecks(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        if ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = origin');
        }
    }

    public function up(): void
    {
        $this->disableFkChecks();

        Schema::dropIfExists('activite_societe');
        Schema::dropIfExists('societes');

        Schema::create('societes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->unique();
            $table->text('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('siret')->nullable();
            $table->string('tva_intracommunautaire')->nullable();
            $table->string('logo_path')->nullable();
            $table->boolean('est_active')->default(true);
            $table->string('couleur',7)->default('#3B82F6');
            $table->string('icon',50)->default('fa-building');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('activite_societe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('societe_id')->constrained()->onDelete('cascade');
            $table->foreignId('activite_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['societe_id','activite_id']);
        });

        $this->enableFkChecks();

        $this->seedSocietes();
    }

    private function seedSocietes(): void
    {
        $societes = [
            [
                'nom'=>'Énergie Nova',
                'code'=>'nova',
                'adresse'=>'60 Rue François 1er',
                'ville'=>'Paris',
                'code_postal'=>'75008',
                'telephone'=>'0767847049',
                'email'=>'direction@energie-nova.com',
                'siret'=>'933 487 795 00017',
                'tva_intracommunautaire'=>'FR12345678901',
                'est_active'=>true,
                'couleur'=>'#3B82F6',
                'icon'=>'fa-industry',
                'user_id'=>null,
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'nom'=>'MyHouse Solutions',
                'code'=>'house',
                'adresse'=>'5051 Rue du Pont Long',
                'ville'=>'Buros',
                'code_postal'=>'64160',
                'telephone'=>'05 59 60 21 51',
                'email'=>'contact@myhouse64.fr',
                'siret'=>'89155600300046',
                'tva_intracommunautaire'=>'FR98765432109',
                'est_active'=>true,
                'couleur'=>'#10B981',
                'icon'=>'fa-home',
                'user_id'=>null,
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
        ];

        DB::table('societes')->insert($societes);

        $this->seedActiviteSocieteRelations();
    }

    private function seedActiviteSocieteRelations(): void
    {
        $activites = DB::table('activites')->pluck('id','code')->toArray();
        $societes = DB::table('societes')->pluck('id','code')->toArray();

        $relations = [
            [
                'societe_id'=>$societes['nova'] ?? 1,
                'activite_id'=>$activites['desembouage'] ?? 1,
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
            [
                'societe_id'=>$societes['house'] ?? 2,
                'activite_id'=>$activites['reequilibrage'] ?? 2,
                'created_at'=>now(),
                'updated_at'=>now(),
            ],
        ];

        foreach ($relations as $relation) {
            DB::table('activite_societe')->insertOrIgnore($relation);
        }
    }

    public function down(): void
    {
        $this->disableFkChecks();

        Schema::dropIfExists('activite_societe');
        Schema::dropIfExists('societes');

        $this->enableFkChecks();
    }

};