<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sample data for categories
        $categories = [
            [
                'category_name' => 'Handphone',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'category_name' => 'Aksesoris',
                'created_by' => 1,
                'updated_by' => 1,             ],
        ];

        foreach ($categories as $category) {
            DB::table('category_product')->insert($category);
        }
    }
}
