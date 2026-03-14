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
        Schema::create('dealers', function (Blueprint $table) {
           $table->id();
            // Multi-tenancy link
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            
            // Business Details
            $table->string('company_name'); 
            $table->string('contact_person_name')->nullable(); 
            
            // Billing Details
            $table->string('gstin', 15)->nullable(); 
            $table->string('pan_number', 10)->nullable();
            
            // Contact Info
            $table->string('phone_number')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('email')->nullable();
            
            // Location Details
            $table->text('billing_address')->nullable();
            // e.g., Set default to Patna or leave null for inter-state clients
            $table->string('city')->nullable(); 
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};
