<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
          $sizes = [
            // UK Sizes
            ['name' => 'UK 6'],
            ['name' => 'UK 8'],
            ['name' => 'UK 10'],
            ['name' => 'UK 12'],
            ['name' => 'UK 14'],
            ['name' => 'UK 16'],
            ['name' => 'UK 18'],
            ['name' => 'UK 20'],

            // Letter Sizes
            ['name' => 'XS'],
            ['name' => 'S'],
            ['name' => 'M'],
            ['name' => 'L'],
            ['name' => 'XL'],
        ];

        DB::table('sizes')->insert($sizes);
    }
}
