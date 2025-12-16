<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Perangkat electronik seperti smartphone',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion Pria',
                'slug' => 'fashion-pria',
                'description' => 'Pakaian, sepatu, dan aksesoris untuk pria',
                'is_active' => true,
            ],
            [
                'name' => 'Rumah Tangga',
                'slug' => 'rumah-tangga',
                'description' => 'Peralatan rumah tangga dan dekorasi',
                'is_active' => true,
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'slug' => 'kesehatan-kecantikan',
                'description' => 'Produk kesehatan, skincare, dan kosmetik',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
        $this->command->info('Categories seeded successfully!');
    }
}
