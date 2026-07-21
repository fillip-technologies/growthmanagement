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
        Schema::create('taskfor_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leaddata_id')->constrained('lead_creates')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assing_by')->constrained('users')->cascadeOnDelete();
            $table->longText('task_des')->nullable();
            $table->date('due_date');
            $table->enum('priority',['medium','high','low']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taskfor_sales');
    }
};
