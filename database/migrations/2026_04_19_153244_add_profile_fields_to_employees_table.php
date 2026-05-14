<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('address')->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('address');
            $table->string('gender')->nullable()->after('date_of_birth');
            $table->string('emergency_name')->nullable()->after('gender');
            $table->string('emergency_relationship')->nullable()->after('emergency_name');
            $table->string('emergency_phone')->nullable()->after('emergency_relationship');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'date_of_birth',
                'gender',
                'emergency_name',
                'emergency_relationship',
                'emergency_phone',
            ]);
        });
    }
};