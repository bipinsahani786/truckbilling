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
        Schema::create('users', function (Blueprint $table) {
           $table->id();
            // Multi-tenancy: Links a driver to their specific owner
            $table->foreignId('owner_id')->nullable()->constrained('users')->cascadeOnDelete();
            
            // --- Common Fields (Admin, Owner, Driver) ---
            $table->string('name');
            $table->string('email')->unique()->nullable(); // Drivers might not always have email
            $table->string('mobile_number')->unique();
            $table->text('address')->nullable(); // e.g., Patna, Bihar
            $table->string('password');
            
            // --- Owner Specific Fields ---
            $table->string('company_name')->nullable(); // e.g., Zytrixon Tech Logistics
            
            // --- Driver Specific KYC Fields ---
            $table->string('blood_group', 5)->nullable();
            $table->string('aadhar_number', 20)->nullable()->unique();
            $table->string('license_number', 50)->nullable()->unique();
            
            // --- Document Upload Paths ---
            // Storing the file paths of uploaded images/PDFs
            $table->string('aadhar_document_path')->nullable();
            $table->string('license_document_path')->nullable();
            $table->string('profile_photo_path')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
