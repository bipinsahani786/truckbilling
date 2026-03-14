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
        Schema::create('vehicles', function (Blueprint $table) {
           $table->id();
            // Multi-tenancy link
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            
            // Basic Details
            $table->string('truck_number')->unique(); 
            $table->string('truck_type')->nullable(); // e.g., 10-Tyre, Container
            $table->decimal('capacity_tons', 8, 2)->nullable(); 
            
            // Registration & Engine Details
            $table->string('rc_number')->unique()->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('engine_number')->nullable();
            
            // Expiry Dates (Alerts ke liye)
            $table->date('insurance_expiry_date')->nullable();
            $table->date('fitness_expiry_date')->nullable();
            $table->date('national_permit_expiry_date')->nullable();
            $table->date('pollution_expiry_date')->nullable();
            
            // Documents
            $table->string('rc_document_path')->nullable();
            $table->string('insurance_document_path')->nullable();
            $table->string('fitness_document_path')->nullable();
            $table->string('truck_photo_path')->nullable();

            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
