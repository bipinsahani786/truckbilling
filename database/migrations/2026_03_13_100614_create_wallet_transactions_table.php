<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            
            $table->enum('type', ['credit', 'debit']); // Credit = Advance received, Debit = Expense done
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable(); // e.g., "Advance for Delhi Trip"
            
            // Polymorphic relation: Is transaction ka source kya tha? 
            // Ye kisi Trip se link ho sakta hai ya direct Hisab/Settlement se.
            $table->nullableMorphs('reference'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};