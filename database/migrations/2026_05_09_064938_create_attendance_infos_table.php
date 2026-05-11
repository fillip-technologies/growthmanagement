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
        Schema::create('attendance_infos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('project_id')
                ->nullable()
                ->constrained('projects')
                ->nullOnDelete();

            $table->date('date')->nullable();
            $table->string('day')->nullable();

            $table->time('start_work')->nullable();
            $table->time('end_work')->nullable();

            $table->time('lunch_start')->nullable();
            $table->time('lunch_out')->nullable();

            $table->string('total_hours')->nullable();

            $table->enum('status', [
                'present',
                'absent',
                'half_day',
                'leave'
            ])->default('present');

            $table->string('leave')->nullable();
            $table->text('reasion')->nullable();

            $table->longText('today_works')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_infos');
    }
};
