<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('documents', 'volume_total')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->string('volume_total')->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('documents', 'volume_total')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->dropColumn('volume_total');
            });
        }
    }
};

