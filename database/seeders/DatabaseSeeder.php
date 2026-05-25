<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Catalog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Matikan pembuatan user bawaan agar tidak bentrok dengan akun yang sudah ada
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 2. Data Awal Katalog Harga Sampah
        $catalogs = [
            [
                'name' => 'Plastik', 
                'description' => 'Botol, Gelas, Kemasan, Kresek', 
                'icon_class' => 'fa-recycle', 
                'color_class' => 'blue', 
                'price_b2c' => 500, 
                'price_b2b' => 800,
            ],
            [
                'name' => 'Kertas', 
                'description' => 'Kardus, Buku, Koran, HVS', 
                'icon_class' => 'fa-box-open', 
                'color_class' => 'yellow', 
                'price_b2c' => 400, 
                'price_b2b' => 600,
            ],
            [
                'name' => 'Logam', 
                'description' => 'Kaleng minuman, Paku, Panci', 
                'icon_class' => 'fa-oil-can', 
                'color_class' => 'gray', 
                'price_b2c' => 1200, 
                'price_b2b' => 1500,
            ],
            [
                'name' => 'Kaca', 
                'description' => 'Botol kaca utuh (tidak pecah)', 
                'icon_class' => 'fa-wine-glass', 
                'color_class' => 'teal', 
                'price_b2c' => 300, 
                'price_b2b' => 500,
            ]
        ];

        // 3. Masukkan ke database secara aman (Tidak akan dobel jika di-seed ulang)
        foreach ($catalogs as $item) {
            Catalog::updateOrCreate(
                ['name' => $item['name']], // Cek apakah nama limbah sudah ada
                $item // Jika belum ada buat baru, jika sudah ada maka perbarui harganya
            );
        }

        // Tampilkan pesan sukses di terminal
        $this->command->info('Katalog harga berhasil ditambahkan/diperbarui secara aman!');
    }
}