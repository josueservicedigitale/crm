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
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = replica;');
        }
    }

    private function enableFkChecks(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        if ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = origin;');
        }
    }

    public function up(): void
    {
        $this->disableFkChecks();

        $existingUsers = Schema::hasTable('users')
            ? DB::table('users')->get()
            : collect();

        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('role')->default('user');
            $table->boolean('est_actif')->default(true);
            $table->timestamp('derniere_connexion')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
            $table->index('role');
            $table->index('est_actif');
            $table->index('deleted_at');
        });

        if ($existingUsers->isNotEmpty()) {
            foreach ($existingUsers as $user) {
                DB::table('users')->insert([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'password' => $user->password,
                    'telephone' => $user->telephone ?? null,
                    'avatar' => $user->avatar ?? null,
                    'role' => $user->role ?? 'user',
                    'est_actif' => isset($user->est_actif) ? (bool) $user->est_actif : true,
                    'derniere_connexion' => $user->derniere_connexion ?? null,
                    'remember_token' => $user->remember_token ?? null,
                    'created_at' => $user->created_at ?? now(),
                    'updated_at' => $user->updated_at ?? now(),
                    'deleted_at' => $user->deleted_at ?? null,
                ]);
            }
        }

        $this->enableFkChecks();
    }

    public function down(): void
    {
        $this->disableFkChecks();

        $existingUsers = Schema::hasTable('users')
            ? DB::table('users')->get()
            : collect();

        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        if ($existingUsers->isNotEmpty()) {
            foreach ($existingUsers as $user) {
                DB::table('users')->insert([
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'password' => $user->password,
                    'remember_token' => $user->remember_token ?? null,
                    'created_at' => $user->created_at ?? now(),
                    'updated_at' => $user->updated_at ?? now(),
                ]);
            }
        }

        $this->enableFkChecks();
    }
};