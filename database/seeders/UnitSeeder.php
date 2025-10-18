<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            'pc', 'Box', 'pair', 'bag', 'cm', 'dz', 'ft', 'g', 'in',
            'kg', 'km', 'mg', 'yard', 'portion', 'bowl', 'carton', 'bottle'
        ];

        foreach ($units as $unit) {
            DB::table('units')->insert([
                'unit' => $unit,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
