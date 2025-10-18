<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['Beauty and Personal Care', 'Beauty and Personal Care', 'spa'],
            ['Health and Wellness', 'Health and Wellness', 'favorite'],
            ['Sports and Outdoors', 'Sports and Outdoors', 'sports_soccer'],
            ['Electronics', 'Electronics', 'devices'],
            ['Food and Beverage', 'Food and Beverage', 'restaurant'],
            ['Baby and Kids', 'Baby and Kids', 'child_care'],
            ['Automobiles', 'Automobiles', 'directions_car'],
            ['Office Supplies', 'Office Supplies', 'description'],
            ['Books', 'Books', 'menu_book'],
            ['Phoness & Accessories', 'Phoness & Accessories', 'smartphone'],
            ['Toys and Games', 'Toys and Games', 'sports_esports'],
            ['Agro Products', 'Agro Products', 'grass'],
            ['Furniture', 'Furniture', 'chair'],
            ['Hospitality', 'Hospitality', 'local_hotel'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'category_name' => $cat[0],
                'name' => $cat[1],
                'image' => $cat[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
