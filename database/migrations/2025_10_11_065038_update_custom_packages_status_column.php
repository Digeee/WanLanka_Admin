<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the table exists before trying to modify it
        if (Schema::hasTable('custom_packages')) {
            // Modify the column to have the proper default and order
            DB::statement("ALTER TABLE custom_packages MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'active', 'inactive') NOT NULL DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('custom_packages')) {
            // Revert the column change
            DB::statement("ALTER TABLE custom_packages MODIFY COLUMN status ENUM('active', 'inactive', 'pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending'");
        }
    }
};