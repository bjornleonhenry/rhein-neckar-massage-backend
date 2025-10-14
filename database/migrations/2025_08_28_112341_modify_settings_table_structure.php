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
        Schema::table('settings', function (Blueprint $table) {
            // Drop old Spatie Laravel Settings columns
            $table->dropUnique(['group', 'name']);
            $table->dropColumn(['group', 'name', 'locked', 'payload']);

            // Add new columns
            $table->string('key')->unique();
            $table->string('title');
            $table->text('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['key', 'title', 'value']);

            // Restore old Spatie Laravel Settings columns
            $table->string('group');
            $table->string('name');
            $table->boolean('locked')->default(false);
            $table->json('payload');

            $table->unique(['group', 'name']);
        });
    }
};
