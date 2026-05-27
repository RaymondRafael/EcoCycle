<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('photo')->nullable();
            $table->text('driver_notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropColumn(['driver_id', 'photo', 'driver_notes']);
        });
    }
};
