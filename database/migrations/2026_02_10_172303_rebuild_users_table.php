<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users','telephone')) {
                $table->string('telephone')->nullable();
            }

            if (!Schema::hasColumn('users','avatar')) {
                $table->string('avatar')->nullable();
            }

            if (!Schema::hasColumn('users','role')) {
                $table->string('role')->default('user');
            }

            if (!Schema::hasColumn('users','est_actif')) {
                $table->boolean('est_actif')->default(true);
            }

            if (!Schema::hasColumn('users','derniere_connexion')) {
                $table->timestamp('derniere_connexion')->nullable();
            }

            if (!Schema::hasColumn('users','deleted_at')) {
                $table->softDeletes();
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users','telephone')) {
                $table->dropColumn('telephone');
            }

            if (Schema::hasColumn('users','avatar')) {
                $table->dropColumn('avatar');
            }

            if (Schema::hasColumn('users','role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users','est_actif')) {
                $table->dropColumn('est_actif');
            }

            if (Schema::hasColumn('users','derniere_connexion')) {
                $table->dropColumn('derniere_connexion');
            }

            if (Schema::hasColumn('users','deleted_at')) {
                $table->dropSoftDeletes();
            }

        });
    }
};