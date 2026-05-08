<?php

use App\Models\Category;
use App\Models\Collection;
use App\Models\Coloer;
use App\Models\NewSection;
use App\Models\Product;
use App\Models\ShowArea;
use App\Models\Size;
use Illuminate\Support\Facades\Cache;

if (!function_exists('getAllSizes')) {
    function getAllSizes($useCache = true)
    {
        if ($useCache) {
            return Cache::remember('all_sizes_formatted', now()->addHour(), function () {
                return Size::query()
                    ->orderByRaw("
                        CASE
                            WHEN name LIKE 'UK %' THEN 1
                            WHEN name IN ('XS','S','M','L','XL','XXL') THEN 2
                            ELSE 3
                        END ASC,
                        CASE
                            WHEN name REGEXP '^UK [0-9]+$' THEN CAST(SUBSTRING(name, 4) AS UNSIGNED)
                            WHEN name IN ('XS','S','M','L','XL','XXL') THEN FIELD(name, 'XS','S','M','L','XL','XXL')
                            ELSE name
                        END ASC
                    ")
                    ->get()
                    ->map(function ($size) {
                        $name = trim($size->name);

                        // Optional: nicer display if you want
                        $display = $name;
                        // You can add more rules here if needed, e.g.:
                        // if (str_starts_with($name, 'UK ')) $display = 'UK ' . substr($name, 3);

                        return (object) [
                            'id'   => $size->id,
                            'name' => $name,
                            'display' => $display,
                        ];
                    });
            });
        }

        // No cache version (for admin/debug)
        return Size::query()
            ->orderByRaw("... same orderByRaw as above ...")
            ->get()
            ->map(fn($size) => (object) [
                'id'   => $size->id,
                'name' => $size->name,
                'display' => $size->name, // or formatted
            ]);
    }
}


// if (!function_exists('getCategories')) {
//     function getAllCategories()
//     {
//         return Cache::remember('all_categories', 60 * 60, function () {
//             return Category::orderBy('id')->get();
//         });
//     }
// }



if (!function_exists('getAllCategories')) {
    function getAllCategories()
    {
        return Cache::remember('all_categories', 60 * 60, function () {
            return Category::orderByRaw('`order` IS NULL, `order` ASC')
                ->orderBy('id', 'ASC')
                ->get();
        });
    }
}

if (!function_exists('getCollections')) {
    function getAllCollections()
    {
        return Cache::remember('all_collections', 60 * 60, function () {
            return Collection::orderBy('id')->get();
        });
    }
}



// if (!function_exists('getSections')) {
//     function getAllSections()
//     {
//         return Cache::remember('all_sections', 60 * 60, function () {
//             return NewSection::orderBy('id')->get();
//         });
//     }
// }



if (!function_exists('getAllSections')) {
    function getAllSections()
    {
        return Cache::remember('header_sections', 60 * 60, function () {
            return Collection::where('show_in_header', true)
                ->orderBy('id')
                ->get();
        });
    }
}

if (!function_exists('getActiveSections')) {
    function getActiveSections()
    {
        return Cache::remember('active_sections', 60 * 60, function () {
            return Collection::where('show_in_header', true)
                ->orderBy('id')
                ->get(['id', 'name', 'slug']);
        });
    }
}

if (!function_exists('getCollections')) {
    function getCollections()
    {
        return Cache::remember('all_collections', 60 * 60, function () {
            return Collection::orderBy('id')->get();
        });
    }
}


if (!function_exists('getAllShowAreas')) {
    function getAllShowAreas()
    {
        return Cache::remember('all_show_areas', 60 * 60, function () {
            return ShowArea::where('is_active', true)
                ->orderBy('priority')
                ->get();
        });
    }
}


if (!function_exists('getAllSections')) {
    function getAllSections()
    {
        return Cache::remember('all_sections', 60 * 60, function () {
            return NewSection::where('status', 1)
                ->orderByDesc('id') // latest first
                ->get();
        });
    }
}

if (!function_exists('getAllColors')) {
    function getAllColors()
    {
        return Cache::remember('all_colors', 60 * 60 * 24, function () {
            return Coloer::select('id', 'name', 'code')->orderBy('name')->get();
        });
    }
}


// if (!function_exists('getShopFilters')) {
//     /**
//      * Get all filter options for the shop page (cached)
//      */
//     function getShopFilters()
//     {
//         return Cache::remember('shop_filters', 60 * 60 * 6, function () {
//             return [
//                 'colors' => Coloer::select('name', 'code')
//                     ->orderBy('name')
//                     ->get(),

//                 'sizes' => Size::select('name')
//                     ->orderBy('name')
//                     ->get(['name']),

//                 'collections' => Collection::select('name', 'slug')
//                     ->orderBy('name')
//                     ->get(),

//                 'categories' => Category::select('name', 'slug')
//                     ->orderBy('name')
//                     ->get(),

//                 'price_range' => [
//                     'min' => Product::min('base_price') ?? 0,
//                     'max' => Product::max('base_price') ?? 10000,
//                 ],
//             ];
//         });
//     }
// }

if (!function_exists('getShopFilters')) {
    function getShopFilters()
    {
        return Cache::remember('shop_filters', 60 * 60 * 6, function () {
            $colors = Coloer::select('id', 'name', 'code')
                ->orderBy('name')
                ->get()
                ->map(function ($color) {
                    // Generate colorClass like "bg_orange-3", "bg_black"
                    $className = strtolower(str_replace([' ', '#'], ['', ''], $color->name));
                    $className = preg_replace('/[^a-z0-9]/', '-', $className);
                    $colorClass = 'bg_' . $className;

                    return [
                        'id'         => $color->id,
                        'name'       => $color->name,
                        'code'       => $color->code,
                        'colorClass' => $colorClass, // ← For your exact style
                    ];
                });

            return [
                'colors' => $colors,

                'sizes' => Size::select('id', 'name')
                    ->orderBy('name')
                    ->get()
                    ->map(fn($size) => $size->name), // ← Array of strings: ["S", "M", "L"]

                // 'collections' => Collection::select('id', 'name', 'slug')
                //     ->orderBy('name')
                //     ->get()
                //     ->map(fn($c) => [
                //         'id'       => $c->id,
                //         'name'     => $c->name,
                //         'link'     => '/collection/' . $c->slug,
                //         'isActive' => false,
                //     ]),

                'collections' => Collection::select('id', 'name', 'slug')
                    ->orderBy('name')
                    ->get()
                    ->map(fn($c) => [
                        'id'   => $c->id,
                        'name' => $c->name,
                        'slug' => $c->slug, // ✅ ADD THIS
                    ]),


                'categories' => Category::select('id', 'name', 'slug')
                    ->orderBy('name')
                    ->get()
                    ->map(fn($c) => [
                        'id'       => $c->id,
                        'name'     => $c->name,
                        'link'     => '/category/' . $c->slug,
                        'isActive' => false,
                        'slug'     => $c->slug,
                    ]),


                'sections' => NewSection::select('id', 'name', 'slug')
                    ->orderBy('name')
                    ->where('status', 1)
                    ->get()
                    ->map(fn($c) => [
                        'id'       => $c->id,
                        'name'     => $c->name,
                        'link'     => '/section/' . $c->slug,
                        'isActive' => false,
                        'slug'     => $c->slug,
                    ]),

                'brands' => ['Ecomus', 'M&H'], // ← Keep your brands

                'availabilities' => [
                    ['id' => 1, 'isAvailable' => true,  'text' => 'Available',    'count' => 0],
                    ['id' => 2, 'isAvailable' => false, 'text' => 'Out of Stock', 'count' => 0],
                ],

                'price_range' => [
                    'min' => Product::min('base_price') ?? 0,
                    'max' => Product::max('base_price') ?? 10000,
                ],
            ];
        });
    }



    if (!function_exists('getSizeChrtImage')) {
        function getSizeChartImage($slug) {}
    }





    if (!function_exists('getQuickLinks')) {
        function getQuickLinks()
        {
            return Cache::remember('quick_links', now()->addHours(24), function () {

                // Categories
                $categories = Category::query()
                    ->select('name', 'slug')
                    ->where('is_active', 1)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'type' => 'category',
                            'name' => $item->name,
                            'slug' => $item->slug,
                        ];
                    });

                // Collections
                $collections = Collection::query()
                    ->select('name', 'slug')
                    ->where('is_active', 1)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'type' => 'collection',
                            'name' => $item->name,
                            'slug' => $item->slug,
                        ];
                    });

                return $categories
                    ->merge($collections)
                    ->values()
                    ->toArray();
            });
        }
    }
}
