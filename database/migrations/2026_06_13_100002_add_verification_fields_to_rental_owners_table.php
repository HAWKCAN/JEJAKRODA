<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rental_owners', function (Blueprint $table) {
            $table->string('nib')->nullable()->after('tax_number');
            $table->string('ktp_image')->nullable()->after('nib');
        });
    }

    public function down(): void
    {
        Schema::table('rental_owners', function (Blueprint $table) {
            $table->dropColumn(['nib', 'ktp_image']);
        });
    }
};