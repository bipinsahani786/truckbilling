<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            // Ek driver ka ek hi wallet hoga
            $table->foreignId('driver_id')->constrained('users')->cascadeOnDelete();
            
            // Decimal format for accurate currency calculation
            $table->decimal('balance', 10, 2)->default(0.00); 
            $table->enum('status', ['active', 'frozen'])->default('active');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};