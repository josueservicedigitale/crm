<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('conversation_user', function (Blueprint $table) {
            if (!Schema::hasColumn('conversation_user', 'last_read_at')) {
                $table->timestamp('last_read_at')->nullable()->after('user_id');
            }
        });
    }

    public function down()
    {
        Schema::table('conversation_user', function (Blueprint $table) {
            $table->dropColumn('last_read_at');
        });
    }
};