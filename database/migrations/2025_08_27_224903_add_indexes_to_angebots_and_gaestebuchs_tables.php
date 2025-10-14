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
        // Add indexes to angebots table
        Schema::table('angebots', function (Blueprint $table) {
            $table->index(['is_active', 'created_at'], 'angebots_active_created_at_index');
            $table->index('category', 'angebots_category_index');
        });

        // Add indexes to gaestebuchs table
        Schema::table('gaestebuchs', function (Blueprint $table) {
            $table->index(['verified', 'created_at'], 'gaestebuchs_verified_created_at_index');
            $table->index('rating', 'gaestebuchs_rating_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('angebots', function (Blueprint $table) {
            $table->dropIndex('angebots_active_created_at_index');
            $table->dropIndex('angebots_category_index');
        });

        Schema::table('gaestebuchs', function (Blueprint $table) {
            $table->dropIndex('gaestebuchs_verified_created_at_index');
            $table->dropIndex('gaestebuchs_rating_index');
        });
    }
};
