<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('place_id');
            $table->string('pickup_district');
            $table->string('pickup_location');
            $table->integer('people_count');
            $table->date('date');
            $table->time('time');
            $table->integer('vehicle_id');
            $table->decimal('total_price', 8, 2);
            $table->enum('guider', ['yes', 'no'])->nullable(); // Added for guider
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
