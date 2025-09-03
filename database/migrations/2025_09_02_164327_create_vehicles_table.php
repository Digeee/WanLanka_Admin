<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->enum('vehicle_type', ['bike', 'three_wheeler', 'car', 'van', 'bus']);
            $table->string('number_plate')->unique();
            $table->string('photo')->nullable();
            $table->integer('seat_count')->default(1);
            $table->string('model')->nullable();
            $table->integer('year')->nullable();
            $table->string('color')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
