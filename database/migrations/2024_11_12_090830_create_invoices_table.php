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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id')->nullable()->references('id')->on('jobs')->onDelete(action: 'cascade');
            $table->unsignedBigInteger('driver_id')->nullable()->references('id')->on('users'); // Optional if not all jobs have drivers
            $table->decimal('total_hours', 15, 2)->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->boolean('is_approved')->default(false)->references(column: 'id')->on('users');
            $table->unsignedBigInteger('approved_by')->nullable(); // Foreign key to users table for approver
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
