<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('fcm_token_id')
                ->nullable()
                ->after('user_id')
                ->constrained('fcm_tokens')
                ->cascadeOnDelete();

            $table->index(['fcm_token_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['fcm_token_id']);
            $table->dropIndex(['fcm_token_id', 'created_at']);
            $table->dropColumn('fcm_token_id');
        });
    }
};
