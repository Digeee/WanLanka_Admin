<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuiderIdToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('guider_id')->nullable()->after('guider');
            $table->foreign('guider_id')->references('id')->on('guiders')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['guider_id']);
            $table->dropColumn('guider_id');
        });
    }
}
