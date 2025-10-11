<?php
require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Update the status column in custom_packages table
try {
    DB::statement("ALTER TABLE custom_packages MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'active', 'inactive') NOT NULL DEFAULT 'pending'");
    echo "Successfully updated the status column in custom_packages table.\n";
} catch (Exception $e) {
    echo "Error updating the status column: " . $e->getMessage() . "\n";
}