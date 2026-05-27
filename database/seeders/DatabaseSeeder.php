<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Catalog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'driver@ecocycle.com'],
            [
                'name' => 'Driver EcoCycle',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'driver',
            ]
        );

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

        foreach ($catalogs as $item) {
            Catalog::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }

        foreach ($catalogs as $item) {
            \App\Models\WasteCategory::updateOrCreate(
                ['name' => $item['name']],
                [
                    'name' => $item['name'],
                    'point_reward_per_kg' => $item['price_b2c'],
                    'price_to_factory_per_kg' => $item['price_b2b'],
                ]
            );
        }

        $this->command->info('Katalog harga & Kategori sampah berhasil ditambahkan/diperbarui secara aman!');
    }
}