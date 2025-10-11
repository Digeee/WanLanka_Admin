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
        Schema::table('custom_packages', function (Blueprint $table) {
            $table->unsignedBigInteger('guider_id')->nullable()->after('user_id');
            $table->string('guider_name')->nullable()->after('guider_id');
            $table->string('guider_email')->nullable()->after('guider_name');
            $table->foreign('guider_id')->references('id')->on('guiders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_packages', function (Blueprint $table) {
            $table->dropForeign(['guider_id']);
            $table->dropColumn(['guider_id', 'guider_name', 'guider_email']);
        });
    }
};