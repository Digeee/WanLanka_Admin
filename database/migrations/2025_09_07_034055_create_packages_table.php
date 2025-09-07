<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable();
            $table->date('starting_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->json('places')->nullable(); // For backward compatibility
            $table->integer('days');
            $table->json('day_plans')->nullable();
            $table->json('inclusions')->nullable();
            $table->foreignId('vehicle_type_id')->nullable()->constrained('vehicles')->onDelete('set null');
            $table->enum('package_type', ['low_budget', 'high_budget', 'custom']);
            $table->enum('status', ['active', 'inactive', 'draft'])->default('draft');
            $table->decimal('rating', 3, 1)->nullable();
            $table->json('reviews')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
