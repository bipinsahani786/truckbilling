<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add missing unique constraints to various tables.
     * Fixes: BUG 13 (wallet driver_id), BUG 14 (expense_categories name), BUG 30 (dealer GSTIN/PAN)
     */
    public function up(): void
    {
        // BUG 13: One driver should have only one wallet
        Schema::table('wallets', function (Blueprint $table) {
            $indexes = Schema::getIndexes('wallets');
            $indexNames = array_column($indexes, 'name');
            if (!in_array('wallets_driver_id_unique', $indexNames)) {
                $table->unique('driver_id');
            }
        });

        // BUG 14: Same owner should not have duplicate expense category names
        Schema::table('expense_categories', function (Blueprint $table) {
            $indexes = Schema::getIndexes('expense_categories');
            $indexNames = array_column($indexes, 'name');
            if (!in_array('expense_categories_owner_id_name_unique', $indexNames)) {
                $table->unique(['owner_id', 'name']);
            }
        });

        // BUG 30: GSTIN and PAN should be unique across all dealers
        Schema::table('dealers', function (Blueprint $table) {
            $indexes = Schema::getIndexes('dealers');
            $indexNames = array_column($indexes, 'name');
            if (!in_array('dealers_gstin_unique', $indexNames)) {
                $table->unique('gstin');
            }
            if (!in_array('dealers_pan_number_unique', $indexNames)) {
                $table->unique('pan_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropUnique(['driver_id']);
        });

        Schema::table('expense_categories', function (Blueprint $table) {
            $table->dropUnique(['owner_id', 'name']);
        });

        Schema::table('dealers', function (Blueprint $table) {
            $table->dropUnique(['gstin']);
            $table->dropUnique(['pan_number']);
        });
    }
};
