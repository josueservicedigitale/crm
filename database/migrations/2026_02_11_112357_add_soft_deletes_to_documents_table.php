<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'deleted_at')) {
                $table->softDeletes(); // Ajoute deleted_at
            }
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};