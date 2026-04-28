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
        Schema::table('trips', function (Blueprint $table) {
            $table->unsignedInteger('trip_number')->after('owner_id')->nullable();
        });

        // Backfill existing data
        $owners = \Illuminate\Support\Facades\DB::table('trips')->select('owner_id')->distinct()->pluck('owner_id');
        foreach ($owners as $ownerId) {
            $trips = \Illuminate\Support\Facades\DB::table('trips')->where('owner_id', $ownerId)->orderBy('id')->get();
            $index = 1;
            foreach ($trips as $trip) {
                \Illuminate\Support\Facades\DB::table('trips')->where('id', $trip->id)->update(['trip_number' => $index++]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('trip_number');
        });
    }
};
