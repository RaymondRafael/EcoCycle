<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->decimal('weight_plastic', 8, 2)->nullable()->after('status');
            $table->decimal('weight_paper', 8, 2)->nullable()->after('weight_plastic');
            $table->decimal('weight_metal', 8, 2)->nullable()->after('weight_paper');
            $table->decimal('weight_glass', 8, 2)->nullable()->after('weight_metal');
            
            // Baris total_points_earned dihapus karena sudah ada di database
        });
    }

    public function down(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            // Hapus juga dari daftar dropColumn
            $table->dropColumn(['weight_plastic', 'weight_paper', 'weight_metal', 'weight_glass']);
        });
    }
};