<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->decimal('rating', 3, 2)->nullable()->after('doctor_notes');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->decimal('rating', 3, 2)->nullable()->after('working_hours');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->decimal('rating', 3, 2)->nullable()->after('location_en');
        });

        Schema::table('clinics', function (Blueprint $table) {
            $table->decimal('rating', 3, 2)->nullable()->after('percentage');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('rating');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('rating');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('rating');
        });

        Schema::table('clinics', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
