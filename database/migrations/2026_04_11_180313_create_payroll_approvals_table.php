<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id')->constrained('payroll')->onDelete('cascade');
            $table->foreignId('approved_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['approved', 'rejected']);
            $table->text('remarks')->nullable();
            $table->timestamp('acted_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_approvals');
    }
};