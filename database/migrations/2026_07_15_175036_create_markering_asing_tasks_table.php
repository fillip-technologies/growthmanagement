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
        Schema::create('markering_asing_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mrk_project_id')->constrained('marketing_projects')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markering_asing_tasks');
    }
};
