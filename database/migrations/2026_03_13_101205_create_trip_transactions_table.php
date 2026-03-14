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
        Schema::create('trip_transactions', function (Blueprint $table) {
           $table->id();
            $table->foreignId('trip_id')->constrained()->cascadeOnDelete();
            
            // Kisne add kiya? Owner ne ya Driver ne apne mobile app se?
            $table->foreignId('added_by')->constrained('users'); 
            
            $table->enum('transaction_type', ['expense', 'recovery']);
            
            // Industry specific categories
            $table->foreignId('expense_category_id')->nullable()->constrained('expense_categories')->nullOnDelete();
            
            $table->decimal('amount', 10, 2);
            
            // PAYMENT MODE: Very important logic here.
            // Agar 'wallet' hai -> Driver ka balance katega.
            // Agar 'fastag' ya 'owner_bank' hai -> Direct owner ka kharcha hai, driver ka hisab effect nahi hoga.
            $table->enum('payment_mode', ['cash', 'wallet', 'fastag', 'owner_bank'])->default('wallet');
            
            $table->string('bill_image_path')->nullable(); 
            $table->text('remarks')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_transactions');
    }
};
