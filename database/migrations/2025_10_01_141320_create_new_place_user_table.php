<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPlaceUserTable extends Migration
{
    public function up()
    {
Schema::create('new_place_user', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->string('user_name');
    $table->string('user_email');
    $table->string('place_name');
    $table->string('google_map_link');
    $table->string('province');
    $table->string('district');
    $table->string('location');
    $table->string('nearest_city');
    $table->text('description');
    $table->string('best_suited_for');
    $table->text('activities_offered');
    $table->integer('rating');
    $table->string('image')->nullable();
    $table->enum('status', ['pending','approved','rejected'])->default('pending');
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('new_place_user');
    }
}
