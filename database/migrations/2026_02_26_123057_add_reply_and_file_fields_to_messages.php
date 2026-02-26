<?php
// database/migrations/2026_02_26_123057_add_reply_and_file_fields_to_messages.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('messages', function (Blueprint $table) {
            // Ajout de reply_to_id (clé étrangère) seulement si elle n'existe pas
            if (!Schema::hasColumn('messages', 'reply_to_id')) {
                $table->foreignId('reply_to_id')
                      ->nullable()
                      ->constrained('messages')
                      ->nullOnDelete();
            }

            // Vérification pour file_path
            if (!Schema::hasColumn('messages', 'file_path')) {
                $table->string('file_path')->nullable();
            }

            // Vérification pour file_name
            if (!Schema::hasColumn('messages', 'file_name')) {
                $table->string('file_name')->nullable();
            }

            // Vérification pour file_type
            if (!Schema::hasColumn('messages', 'file_type')) {
                $table->string('file_type')->nullable();
            }

            // Vérification pour file_size
            if (!Schema::hasColumn('messages', 'file_size')) {
                $table->unsignedBigInteger('file_size')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('messages', function (Blueprint $table) {
            // Suppression de la clé étrangère seulement si elle existe
            if (Schema::hasColumn('messages', 'reply_to_id')) {
                $table->dropConstrainedForeignId('reply_to_id');
            }

            // Collecte des colonnes à supprimer
            $columnsToDrop = [];
            if (Schema::hasColumn('messages', 'file_path')) {
                $columnsToDrop[] = 'file_path';
            }
            if (Schema::hasColumn('messages', 'file_name')) {
                $columnsToDrop[] = 'file_name';
            }
            if (Schema::hasColumn('messages', 'file_type')) {
                $columnsToDrop[] = 'file_type';
            }
            if (Schema::hasColumn('messages', 'file_size')) {
                $columnsToDrop[] = 'file_size';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};