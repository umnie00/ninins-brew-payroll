<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_hours',    7, 2)->default(0);
            $table->decimal('overtime_hours', 7, 2)->default(0);
            $table->decimal('hourly_rate',    8, 2)->default(0);
            $table->decimal('gross_pay',      10, 2)->default(0);
            $table->decimal('overtime_pay',   10, 2)->default(0);
            $table->decimal('tax_amount',     10, 2)->default(0);
            $table->decimal('net_pay',        10, 2)->default(0);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll');
    }
};