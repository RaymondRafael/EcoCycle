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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            // Menghubungkan penarikan dengan tabel users (jika user dihapus, riwayat penarikannya juga ikut terhapus)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Detail Penarikan
            $table->integer('amount_points'); // Jumlah poin yang ditarik (1 poin = Rp 1)
            $table->string('payment_method'); // DANA, OVO, GOPAY, BANK BCA, dll.
            $table->string('account_number'); // Nomor HP atau Nomor Rekening
            $table->string('account_name');   // Nama pemilik rekening/akun
            
            // Status pengajuan
            $table->enum('status', ['pending', 'success', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};