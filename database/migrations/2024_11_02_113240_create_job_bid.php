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
        Schema::create('job_bid', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->references('id')->on('driver_job')->onDelete('cascade');
            $table->foreignId('driver_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('bid_date')->nullable(); // Nullable if not applicable
            $table->boolean('assigned')->default(0); // Default to 0 (not assigned)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_bid');
    }
};
