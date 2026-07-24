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
        Schema::create('team_head_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('lead_creates')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status',['pending','completed','ongoing','testing','live']);
            $table->enum('priority',['medium','low','high']);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_head_tasks');
    }
};
