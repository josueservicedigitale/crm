<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('activite_societe')) {
            Schema::create('activite_societe', function (Blueprint $table) {
                $table->id();
                $table->foreignId('activite_id')->constrained()->cascadeOnDelete();
                $table->foreignId('societe_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['activite_id', 'societe_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activite_societe');
    }
};
