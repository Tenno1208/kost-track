<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Pengeluaran
            ['name' => 'Makan & Minum', 'type' => 'expense', 'icon' => 'utensils', 'color' => '#C65B55'],
            ['name' => 'Sewa Kos', 'type' => 'expense', 'icon' => 'home', 'color' => '#174D3A'],
            ['name' => 'Listrik & Air', 'type' => 'expense', 'icon' => 'zap', 'color' => '#E0A96D'],
            ['name' => 'Transportasi', 'type' => 'expense', 'icon' => 'bus', 'color' => '#4A7C59'],
            ['name' => 'Internet / Wi-Fi', 'type' => 'expense', 'icon' => 'wifi', 'color' => '#3D5A80'],
            ['name' => 'Belanja Bulanan', 'type' => 'expense', 'icon' => 'shopping-cart', 'color' => '#98C1D9'],
            ['name' => 'Hiburan & Nongkrong', 'type' => 'expense', 'icon' => 'coffee', 'color' => '#F4A261'],
            ['name' => 'Lain-lain', 'type' => 'expense', 'icon' => 'more-horizontal', 'color' => '#777D75'],

            // Pemasukan
            ['name' => 'Kiriman Orang Tua', 'type' => 'income', 'icon' => 'wallet', 'color' => '#174D3A'],
            ['name' => 'Gaji / Freelance', 'type' => 'income', 'icon' => 'briefcase', 'color' => '#2A9D8F'],
            ['name' => 'Pemasukan Lain', 'type' => 'income', 'icon' => 'plus-circle', 'color' => '#4A7C59'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}