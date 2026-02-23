<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // ✅ Champs manquants
            if (!Schema::hasColumn('documents', 'nature_travaux')) {
                $table->text('nature_travaux')->nullable()->after('icone_2');
            }
            
            if (!Schema::hasColumn('documents', 'fiche_cee')) {
                $table->string('fiche_cee', 50)->nullable()->after('nature_travaux');
            }
            
            if (!Schema::hasColumn('documents', 'date_engagement')) {
                $table->date('date_engagement')->nullable()->after('fiche_cee');
            }
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $columns = ['nature_travaux', 'fiche_cee', 'date_engagement'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('documents', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};