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
        Schema::create('project_infra_resources', function (Blueprint $table) {
             $table->id();
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->onDelete('cascade');
            $table->string('domain_name')->nullable();
            $table->string('domain_registrar')->nullable();
            $table->string('hosting_provider')->nullable();
            $table->string('hosting_account_owner')->nullable();
            $table->string('ssl_certificate')->nullable();
            $table->string('email_service_provider')->nullable();
            $table->string('dns_management')->nullable();
            $table->string('cdn_provider')->nullable();
            $table->text('third_party_apis')->nullable();
            $table->date('renewal_date')->nullable();
            $table->string('responsible_team_member')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_infra_resources');
    }
};
