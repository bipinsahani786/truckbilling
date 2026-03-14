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
        Schema::create('trips', function (Blueprint $table) {
           $table->id();
            // Multi-tenancy
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            
            // Core Relationships
            $table->foreignId('driver_id')->constrained('users');
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->foreignId('dealer_id')->nullable()->constrained('dealers');
            
            // Routing & Material Details
            $table->string('from_location');
            $table->string('to_location');
            $table->string('material_description')->nullable(); // e.g., "Iron Rods", "FMCG"
            $table->decimal('weight_tons', 8, 2)->nullable();
            
            // Financials
            $table->decimal('party_freight_amount', 10, 2)->default(0.00); // Total fixed amount from dealer
            $table->decimal('driver_advance', 10, 2)->default(0.00); // Kharchi given initially
            
            // Lifecycle Tracking
            $table->enum('status', ['scheduled', 'loaded', 'in_transit', 'unloaded', 'completed', 'settled'])->default('scheduled');
            $table->enum('pod_status', ['pending', 'received', 'verified'])->default('pending');
            $table->string('pod_document_path')->nullable(); // LR/Bilty photo
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
