<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assing_tasks', function (Blueprint $table) {
        $table->foreignId('assigned_by')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('assing_tasks', function (Blueprint $table) {
            //
        });
    }
};
