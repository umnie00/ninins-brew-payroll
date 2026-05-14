<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->boolean('is_overtime')->default(false)->after('hours_worked');
        });
    }

    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropColumn('is_overtime');
        });
    }
};