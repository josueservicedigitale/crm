<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('societes', function (Blueprint $table) {
            // ✅ AJOUT DU CHAMP POUR LE NOM FORMATÉ
            $table->string('display_name')->nullable()->after('nom');
            
            // ✅ OPTIONNEL: Ajouter d'autres champs utiles
            $table->string('template_pdf_folder')->nullable()->after('code');
            $table->json('metadata')->nullable()->after('icon'); // Pour stocker des infos supplémentaires
        });
    }

    public function down()
    {
        Schema::table('societes', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'template_pdf_folder', 'metadata']);
        });
    }
};