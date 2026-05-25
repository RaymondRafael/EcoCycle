<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('pickup_date');

            // Kolom krusial untuk menyimpan alamat dinamis saat itu (bukan mengikat ke profil user terus menerus)
            $table->text('pickup_address'); 

            $table->enum('status', ['pending', 'on_the_way', 'completed', 'cancelled'])->default('pending');
            $table->integer('total_points_earned')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickups');
    }
};
