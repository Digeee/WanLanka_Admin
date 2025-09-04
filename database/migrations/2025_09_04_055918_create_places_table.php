<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->text('description')->nullable();
            $table->string('weather')->nullable();
            $table->string('travel_type')->nullable();
            $table->string('season')->nullable();
            $table->string('slug')->unique();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('gallery')->nullable();
            $table->decimal('entry_fee', 8, 2)->nullable();
            $table->string('opening_hours')->nullable();
            $table->string('best_time_to_visit')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
