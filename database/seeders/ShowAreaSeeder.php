<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            [
                'key'       => 'new_arrival',
                'name'      => 'New Arrival',
                'priority'  => 1,
            ],
            [
                'key'       => 'trending',
                'name'      => 'Trending',
                'priority'  => 2,
            ],
            [
                'key'       => 'best_sale',
                'name'      => 'Best Sale',
                'priority'  => 3,
            ],
            [
                'key'       => 'featured',
                'name'      => 'Featured',
                'priority'  => 4,
            ],
            [
                'key'       => 'people_bought',
                'name'      => 'People Also Bought',
                'priority'  => 5,
            ],
            [
                'key'       => 'recently_viewed',
                'name'      => 'Recently Viewed',
                'priority'  => 6,
            ],
            [
                'key'       => 'shop_gram',
                'name'      => 'Shop Gram',
                'priority'  => 6,
            ],
        ];

        foreach ($areas as $area) {
            DB::table('show_areas')->updateOrInsert(
                ['key' => $area['key']], // unique key
                [
                    'name'       => $area['name'],
                    'priority'   => $area['priority'],
                    'is_active'  => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
