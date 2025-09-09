<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayPlansTable extends Migration
{
    public function up()
    {
        Schema::create('day_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->integer('day_number');
            $table->text('plan')->nullable();
            $table->foreignId('accommodation_id')->nullable()->constrained('accommodations');
            $table->text('description')->nullable();
            $table->json('photos')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('day_plans');
    }
}
