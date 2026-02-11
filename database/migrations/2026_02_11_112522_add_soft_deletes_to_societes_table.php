<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('societes', function (Blueprint $table) {
        if (!Schema::hasColumn('societes', 'deleted_at')) {
            $table->softDeletes();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('societes', function (Blueprint $table) {
            //
        });
    }
};
