<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductListSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $mobilePhones = [
            ['product_name' => 'Samsung Galaxy S23', 'quantity' => 150, 'price' => 15000000.00, 'category_id' => 1, 'discount' => 10.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'iPhone 14 Pro Max', 'quantity' => 200, 'price' => 17500000.00, 'category_id' => 1, 'discount' => 5.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Google Pixel 7 Pro', 'quantity' => 120, 'price' => 13500000.00, 'category_id' => 1, 'discount' => 15.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Samsung Galaxy A54', 'quantity' => 180, 'price' => 8500000.00, 'category_id' => 1, 'discount' => 12.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'iPhone 14', 'quantity' => 160, 'price' => 14500000.00, 'category_id' => 1, 'discount' => 8.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'OnePlus 11', 'quantity' => 140, 'price' => 12500000.00, 'category_id' => 1, 'discount' => 7.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Xiaomi Mi 12', 'quantity' => 130, 'price' => 11000000.00, 'category_id' => 1, 'discount' => 10.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Sony Xperia 5 IV', 'quantity' => 100, 'price' => 17000000.00, 'category_id' => 1, 'discount' => 9.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Oppo Find X5 Pro', 'quantity' => 110, 'price' => 14000000.00, 'category_id' => 1, 'discount' => 6.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Asus ROG Phone 6', 'quantity' => 90, 'price' => 20000000.00, 'category_id' => 1, 'discount' => 14.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Huawei P50 Pro', 'quantity' => 80, 'price' => 15500000.00, 'category_id' => 1, 'discount' => 11.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Realme GT 2 Pro', 'quantity' => 150, 'price' => 12500000.00, 'category_id' => 1, 'discount' => 13.00, 'created_by' => 1, 'updated_by' => 1],
        ];

        $accessories = [
            ['product_name' => 'Wireless Charger', 'quantity' => 300, 'price' => 500000.00, 'category_id' => 2, 'discount' => 20.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Bluetooth Headset', 'quantity' => 250, 'price' => 750000.00, 'category_id' => 2, 'discount' => 15.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Protective Case', 'quantity' => 400, 'price' => 200000.00, 'category_id' => 2, 'discount' => 10.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Portable Power Bank', 'quantity' => 500, 'price' => 350000.00, 'category_id' => 2, 'discount' => 25.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Screen Protector', 'quantity' => 600, 'price' => 150000.00, 'category_id' => 2, 'discount' => 30.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Earbuds', 'quantity' => 200, 'price' => 650000.00, 'category_id' => 2, 'discount' => 18.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Car Phone Mount', 'quantity' => 350, 'price' => 250000.00, 'category_id' => 2, 'discount' => 22.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Charging Cable', 'quantity' => 400, 'price' => 100000.00, 'category_id' => 2, 'discount' => 20.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Smartwatch', 'quantity' => 150, 'price' => 850000.00, 'category_id' => 2, 'discount' => 12.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Laptop Stand', 'quantity' => 180, 'price' => 300000.00, 'category_id' => 2, 'discount' => 14.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Tablet Case', 'quantity' => 220, 'price' => 350000.00, 'category_id' => 2, 'discount' => 17.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'USB Hub', 'quantity' => 250, 'price' => 200000.00, 'category_id' => 2, 'discount' => 15.00, 'created_by' => 1, 'updated_by' => 1],
            ['product_name' => 'Gaming Mouse', 'quantity' => 130, 'price' => 450000.00, 'category_id' => 2, 'discount' => 19.00, 'created_by' => 1, 'updated_by' => 1],
        ];

        // Insert mobile phones data
        foreach ($mobilePhones as $product) {
            DB::table('product_list')->insert($product);
        }

        // Insert accessories data
        foreach ($accessories as $product) {
            DB::table('product_list')->insert($product);
        }
    }
}
