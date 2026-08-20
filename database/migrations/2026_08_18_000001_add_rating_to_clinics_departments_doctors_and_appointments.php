<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('appointments', 'rating')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->decimal('rating', 3, 2)->nullable();
            });
        }

        if (!Schema::hasColumn('doctors', 'rating')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->decimal('rating', 3, 2)->nullable();
            });
        }

        if (!Schema::hasColumn('departments', 'rating')) {
            Schema::table('departments', function (Blueprint $table) {
                $table->decimal('rating', 3, 2)->nullable();
            });
        }

        if (!Schema::hasColumn('clinics', 'rating')) {
            Schema::table('clinics', function (Blueprint $table) {
                $table->decimal('rating', 3, 2)->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('appointments', 'rating')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('rating');
            });
        }

        if (Schema::hasColumn('doctors', 'rating')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropColumn('rating');
            });
        }

        if (Schema::hasColumn('departments', 'rating')) {
            Schema::table('departments', function (Blueprint $table) {
                $table->dropColumn('rating');
            });
        }

        if (Schema::hasColumn('clinics', 'rating')) {
            Schema::table('clinics', function (Blueprint $table) {
                $table->dropColumn('rating');
            });
        }
    }
};
