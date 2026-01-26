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
    Schema::create('societes', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('slug')->unique();
        $table->text('adresse')->nullable();
        $table->string('telephone')->nullable();
        $table->string('email')->nullable();
        $table->string('ville')->nullable();
        $table->string('code_postal')->nullable();
        $table->string('siret')->nullable();
        $table->string('tva_intracommunautaire')->nullable();
        $table->string('logo_path')->nullable();
        $table->enum('statut', ['actif', 'inactif'])->default('actif');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societes');
    }
};
