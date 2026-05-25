<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kolom untuk identifikasi alamat (Misal: "Gudang A", "Rumah Mertua", dll)
            $table->string('label_name'); 
            
            // Detail Kontak dan Alamat
            $table->string('pic_name')->nullable(); // Boleh kosong jika B2C
            $table->string('phone');
            $table->string('city');
            $table->text('full_address');
            $table->string('postal_code')->nullable();
            
            // Penanda alamat utama
            $table->boolean('is_primary')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};