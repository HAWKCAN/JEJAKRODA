<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('rental_owners', function (Blueprint $table) {
            $table->string('operating_hours')->nullable()->after('verification_status');
            $table->string('whatsapp_number')->nullable()->after('operating_hours');
            $table->boolean('auto_confirm_booking')->default(false)->after('whatsapp_number');
        });
    }

    public function down(): void {
        Schema::table('rental_owners', function (Blueprint $table) {
            $table->dropColumn(['operating_hours', 'whatsapp_number', 'auto_confirm_booking']);
        });
    }
};