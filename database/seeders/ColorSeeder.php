<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['Black', '#0000'],
            ['Blue', '#2986cc'],
            ['Yellow', '#f1c232'],
            ['Red', '#ff6347'],
        ];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'color' => $color[0],
                'code' => $color[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
