<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('dep_id');
            $table->date('date');
            $table->timestamp('time');
            $table->boolean('is_asap')->default(false);
            $table->enum('status', ['booked', 'canceled', 'completed'])->default('booked');
            $table->text('user_notes')->nullable();
            $table->text('doctor_notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('dep_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
