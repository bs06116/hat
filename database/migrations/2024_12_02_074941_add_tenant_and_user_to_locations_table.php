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
        Schema::table('locations', function (Blueprint $table) {
            // Add tenant_id and user_id columns
            $table->text('tenant_id')->nullable()->after('address');
            $table->unsignedBigInteger('user_id')->nullable()->after('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['tenant_id']);
            $table->dropForeign(['user_id']);
            // Then drop the columns
            $table->dropColumn(['tenant_id', 'user_id']);
        });
    }
};
