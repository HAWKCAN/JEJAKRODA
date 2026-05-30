<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_owner_id')->constrained('rental_owners')->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['motor', 'mobil']);
            $table->string('plate_number')->unique();
            $table->decimal('price_per_day', 10, 2);
            $table->string('location');
            $table->enum('status', ['available', 'rented', 'inactive'])->default('available');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
