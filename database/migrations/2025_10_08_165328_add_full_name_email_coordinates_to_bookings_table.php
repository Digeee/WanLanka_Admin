<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('pickup_location');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('full_name')->after('longitude');
            $table->string('email')->after('full_name');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'full_name', 'email']);
        });
    }
};
