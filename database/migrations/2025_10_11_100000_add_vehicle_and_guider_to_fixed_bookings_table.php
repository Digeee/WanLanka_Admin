<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVehicleAndGuiderToFixedBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('fixed_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('vehicle_id')->nullable()->after('status');
            $table->unsignedBigInteger('guider_id')->nullable()->after('vehicle_id');

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('set null');
            $table->foreign('guider_id')->references('id')->on('guiders')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('fixed_bookings', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropForeign(['guider_id']);
            $table->dropColumn(['vehicle_id', 'guider_id']);
        });
    }
}
