<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up()
       {
           Schema::create('guiders', function (Blueprint $table) {
               $table->id();
               $table->string('first_name');
               $table->string('last_name');
               $table->string('email')->unique();
               $table->string('phone')->nullable();
               $table->text('address')->nullable();
               $table->string('city')->nullable();
               $table->json('languages')->nullable();
               $table->json('specializations')->nullable();
               $table->integer('experience_years')->default(0);
               $table->decimal('hourly_rate', 10, 2)->default(0);
               $table->boolean('availability')->default(true);
               $table->text('description')->nullable();
               $table->string('image')->nullable();
               $table->string('nic_number')->nullable();
               $table->string('driving_license_photo')->nullable();
               $table->json('vehicle_types')->nullable();
               $table->enum('status', ['active', 'inactive'])->default('active');
               $table->timestamps();
           });
       }

       public function down()
       {
           Schema::dropIfExists('guiders');
       }
   };
