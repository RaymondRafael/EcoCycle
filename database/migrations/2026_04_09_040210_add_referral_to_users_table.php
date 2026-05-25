<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kode unik milik user ini (bisa kosong untuk user lama/admin)
            $table->string('referral_code')->unique()->nullable()->after('point_balance');
            // ID user yang mengundang dia (nullable jika mendaftar sendiri)
            $table->foreignId('referred_by')->nullable()->constrained('users')->after('referral_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn(['referral_code', 'referred_by']);
        });
    }
};