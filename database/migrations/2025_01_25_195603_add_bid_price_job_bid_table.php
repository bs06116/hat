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
        Schema::table('job_bid', function (Blueprint $table) {
            $table->decimal('bid_price', 8, 2)->nullable()->after('assigned');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_bid', function (Blueprint $table) {
            //
        });
    }
};
