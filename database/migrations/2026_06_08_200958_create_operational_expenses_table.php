<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operational_expenses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('clinic_id')->constrained('clinics')->cascadeOnDelete();

            $table->index('clinic_id');

            $table->enum('category', [
                'medical_supplies',
                'equipment_maintenance',
                'administrative'
            ]);

            $table->decimal('amount',10,2);

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->text('description')->nullable();

            $table->date('expense_date');

            $table->timestamps();

            $table->index('expense_date');
            $table->index('department_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_expenses');
    }
};