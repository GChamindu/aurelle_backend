<?php

namespace App\Http\Controllers;

use App\Enums\ProductImageType;
use App\helpers\R2Helper;
use App\Models\Category;
use App\Models\Collection;
use App\Models\NewSection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{

    // app/Http/Controllers/SitemapController.php

    // public function index()
    // {

    //     \Log::info('Sitemap called');
    //     return Cache::remember('sitemap_full', now()->addHours(12), function () {
    //         // Products – most frequent updates
    //         $products = Product::query()
    //             ->select('slug', 'updated_at')
    //             ->where('status', 'active')
    //             ->whereNotNull('slug')
    //             ->latest('updated_at')
    //             ->get(['slug', 'updated_at']);

    //         // Categories & Collections – can be heavier, but usually fewer rows
    //         $categories = Category::query()
    //             ->select('slug', 'updated_at')
    //             ->whereNotNull('slug')
    //             ->get(['slug', 'updated_at']);

    //         $collections = Collection::query()
    //             ->select('slug', 'updated_at')
    //             ->whereNotNull('slug')
    //             ->get(['slug', 'updated_at']);

    //         $baseUrl = config('app.frontend_url', 'https://copper.lk');

    //         $items = [];

    //         // Optional: add static / high-priority pages first
    //         $items[] = [
    //             'loc'        => $baseUrl . '/',
    //             'lastmod'    => now()->toAtomString(),
    //             'changefreq' => 'daily',
    //             'priority'   => '1.0',
    //         ];
    //         $items[] = [
    //             'loc'        => $baseUrl . '/shop',
    //             'lastmod'    => now()->toAtomString(),
    //             'changefreq' => 'daily',
    //             'priority'   => '0.9',
    //         ];
    //         // ... add more static pages if needed

    //         // Products (highest update frequency)
    //         foreach ($products as $product) {
    //             $items[] = [
    //                 'loc'        => $baseUrl . '/products/' . $product->slug,
    //                 'lastmod'    => $product->updated_at?->toAtomString(),
    //                 'changefreq' => 'daily',
    //                 'priority'   => '0.8',
    //             ];
    //         }

    //         // Categories
    //         foreach ($categories as $cat) {
    //             $items[] = [
    //                 'loc'        => $baseUrl . '/shop/' . $cat->slug,
    //                 'lastmod'    => $cat->updated_at?->toAtomString(),
    //                 'changefreq' => 'weekly',
    //                 'priority'   => '0.7',
    //             ];
    //         }

    //         // Collections
    //         foreach ($collections as $col) {
    //             $items[] = [
    //                 'loc'        => $baseUrl . '/collections/' . $col->slug,
    //                 'lastmod'    => $col->updated_at?->toAtomString(),
    //                 'changefreq' => 'weekly',
    //                 'priority'   => '0.7',
    //             ];
    //         }

    //         return ['items' => $items];
    //     });
    // }



    public function index()
    {
        \Log::info('Sitemap called');

        return Cache::remember('sitemap_full', now()->addMinutes(30), function () {

            $baseUrl = "https://copper.lk";

            $items = [];

            // PRODUCTS
            $products = Product::where('status', 'active')
                ->whereNotNull('slug')
                ->select('id', 'slug', 'updated_at')
                ->with([
                    'images' => fn($query) => $query->select('product_id', 'image_path', 'image_type'),
                ])
                ->get();

            foreach ($products as $product) {
                $items[] = [
                    'loc'        => $baseUrl . '/product/' . $product->slug,
                    'lastmod'    => optional($product->updated_at)->toAtomString(),
                    'changefreq' => 'daily',
                    'priority'   => '0.8',
                    'image'      => $this->resolveSitemapProductImageUrl($product),
                ];
            }

            // CATEGORIES
            $categories = Category::whereNotNull('slug')
                ->select('slug', 'updated_at')
                ->get();

            foreach ($categories as $category) {
                $items[] = [
                    'loc'        => $baseUrl . '/shop/' . $category->slug,
                    'lastmod'    => optional($category->updated_at)->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.7',
                ];
            }

            // COLLECTIONS
            $collections = Collection::whereNotNull('slug')
                ->select('slug', 'updated_at')
                ->get();

            foreach ($collections as $collection) {
                $items[] = [
                    'loc'        => $baseUrl . '/collection/' . $collection->slug,
                    'lastmod'    => optional($collection->updated_at)->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.7',
                ];
            }


            $collections = Collection::whereNotNull('slug')
                ->select('slug', 'updated_at')
                ->get();

            foreach ($collections as $collection) {
                $items[] = [
                    'loc'        => $baseUrl . '/collection/' . $collection->slug,
                    'lastmod'    => optional($collection->updated_at)->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.7',
                ];
            }



            // $sections = NewSection::whereNotNull('slug')
            //     ->select('slug', 'updated_at')
            //     ->get();

            // foreach ($sections as $section) {
            //     $items[] = [
            //         'loc'        => $baseUrl . '/section/' . $section->slug,
            //         'lastmod'    => optional($section->updated_at)->toAtomString(),
            //         'changefreq' => 'weekly',
            //         'priority'   => '0.7',
            //     ];
            // }

            // \Log::info('Sitemap generated');
            // \Log::info($items);

            return [
                'items' => $items,
            ];
        });
    }


    public function products()
    {
        return Cache::remember('sitemap_products', now()->addHours(12), function () {
            $products = Product::query()
                ->select('id', 'slug', 'updated_at')
                ->where('status', 'active')
                ->whereNotNull('slug')
                ->with([
                    'images' => fn($query) => $query->select('product_id', 'image_path', 'image_type'),
                ])
                ->latest('updated_at')
                ->get();

            $items = $products->map(function ($product) {
                return [
                    'loc'        => config('app.frontend_url', 'https://copper.lk') . '/products/' . $product->slug,
                    'lastmod'    => $product->updated_at?->toAtomString(),
                    'changefreq' => 'daily',
                    'priority'   => '0.8',
                    'image'      => $this->resolveSitemapProductImageUrl($product),
                ];
            });

            return ['items' => $items];
        });
    }

    private function resolveSitemapProductImageUrl(Product $product): ?string
    {
        $priorityByType = [
            ProductImageType::DEFAULT_MAIN->value => 1,
            ProductImageType::VARIANT_MAIN->value => 2,
            ProductImageType::GALLERY->value => 3,
            ProductImageType::DEFAULT_HOVER->value => 4,
        ];

        $bestImage = $product->images
            ->filter(fn($image) => !empty($image->image_path))
            ->sortBy(function ($image) use ($priorityByType) {
                $typeValue = $image->image_type instanceof ProductImageType
                    ? $image->image_type->value
                    : (int) $image->image_type;

                return $priorityByType[$typeValue] ?? 999;
            })
            ->first();

        if (!$bestImage) {
            return null;
        }

        return R2Helper::getFileUrl($bestImage->image_path);
    }

    public function categories()
    {
        return Cache::remember('sitemap_categories', now()->addHours(24), function () {
            $categories = Category::query()
                ->select('slug', 'updated_at')
                ->whereNotNull('slug')
                ->get();

            $items = $categories->map(function ($cat) {
                return [
                    'loc'        => config('app.frontend_url', 'https://copper.lk') . '/shop/' . $cat->slug,
                    'lastmod'    => $cat->updated_at?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.7',
                ];
            });

            return ['items' => $items];
        });
    }

    public function collections()
    {
        return Cache::remember('sitemap_collections', now()->addHours(24), function () {
            $collections = Collection::query()
                ->select('slug', 'updated_at')
                ->whereNotNull('slug')
                ->get();

            $items = $collections->map(function ($col) {
                return [
                    'loc'        => config('app.frontend_url', 'https://copper.lk') . '/collections/' . $col->slug,
                    'lastmod'    => $col->updated_at?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority'   => '0.7',
                ];
            });

            return ['items' => $items];
        });
    }
}
