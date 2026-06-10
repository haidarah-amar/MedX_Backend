<?php

use App\Models\Clinic;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default(User::ROLE_USER)->after('password');
        });

        Schema::table('clinics', function (Blueprint $table) {
            $table->string('approval_status')
                ->default(Clinic::STATUS_PENDING)
                ->after('is_approved');
            $table->text('rejection_reason')->nullable()->after('approval_status');
        });

        DB::table('clinics')
            ->where('is_approved', true)
            ->update(['approval_status' => Clinic::STATUS_APPROVED]);
    }

    public function down(): void
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropColumn(['approval_status', 'rejection_reason']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
