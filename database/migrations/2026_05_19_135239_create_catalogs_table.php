<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plastik, Kertas, dll
            $table->string('description'); // Deskripsi limbah
            $table->string('icon_class'); // Ikon FontAwesome
            $table->string('color_class'); // Warna tema (blue, yellow, dll)
            $table->integer('price_b2c'); // Harga per Kg untuk Personal
            $table->integer('price_b2b'); // Harga per Kg untuk Bisnis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalogs');
    }
};