<?php

namespace App\Http\Controllers;

use App\Enums\ProductImageType;
use App\helpers\R2Helper;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    /* =====================================================
     | CATEGORY SEO
     ===================================================== */
    public function getCategoryRelatedKeywords(string $slug)
    {
        \Log::info("Category SEO called: {$slug}");

        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::query()
            ->where('status', 'active')
            ->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category->id);
            })
            ->with([
                'variants.color:id,name',
            ])
            ->limit(20)
            ->get();

        return $this->buildSeoResponse($category->name, $products);
    }
    private function buildSeoResponse(string $name, $products)
    {
        return response()->json([
            'category' => $name,
            'keywords' => $this->generateKeywords($name, $products),
            'top_products' => $products
                ->pluck('name')
                ->filter()
                ->unique()
                ->take(5)
                ->values(),
        ]);
    }


    /* =====================================================
     | COLLECTION SEO  ⭐ NEW
     ===================================================== */
    public function getCollectionRelatedKeywords(string $slug)
    {
        \Log::info("Collection SEO called: {$slug}");

        // 1️⃣ Get collection
        $collection = Collection::where('slug', $slug)->firstOrFail();

        // 2️⃣ Get products via pivot table
        $products = $collection->products()
            ->with(['variants.color'])
            ->where('status', 'active')
            ->limit(20)
            ->get();

        return response()->json([
            'collection' => $collection->name,
            'keywords' => $this->generateKeywords($collection->name, $products),
            'top_products' => $products->pluck('name')->unique()->take(5)->values(),
        ]);
    }

    /* =====================================================
     | KEYWORD GENERATOR (REUSABLE)
     ===================================================== */
    private function generateKeywords(string $parentName, $products)
    {
        $keywords = [];

        foreach ($products as $product) {
            $productName = Str::lower($product->name);

            $keywords[] = $productName;
            $keywords[] = "{$parentName} {$productName}";

            $colors = $product->variants
                ->pluck('color.name')
                ->filter()
                ->unique();

            foreach ($colors as $color) {
                $color = Str::lower($color);
                $keywords[] = "{$color} {$productName}";
                $keywords[] = "{$color} {$parentName} {$productName}";
                $keywords[] = "{$parentName} {$productName} {$color}";
            }

            if ($product->keywords) {
                $stored = json_decode($product->keywords, true);
                if (is_array($stored)) {
                    foreach ($stored as $kw) {
                        $keywords[] = Str::lower(trim($kw));
                    }
                }
            }
        }

        // Parent-level SEO keywords
        $keywords[] = "{$parentName} fashion Sri Lanka";
        $keywords[] = "buy {$parentName} clothes online";
        $keywords[] = "{$parentName} clothing store Sri Lanka";

        return collect($keywords)
            ->map(fn($k) => (string) Str::of($k)->replace('-', ' ')->lower())
            ->unique()
            ->values()
            ->take(25);
    }


    // for the product seo

    // In your ProductController
    // Add this method to your ProductController or SeoController
    public function getProductSeoData(string $slug)
    {
        try {
            $product = Product::query()
                ->where('slug', $slug)
                ->with([
                    'images:id,product_id,image_path,image_type',
                    'variants:id,product_id,color_id,size_id',
                    'variants.color:id,name',
                    'variants.size:id,name',
                    'categories:id,name,slug',
                ])
                ->firstOrFail();

            /**
             * -------------------------------------
             * OG IMAGE (DEFAULT_MAIN → fallback)
             * -------------------------------------
             */
            $defaultMainImage = $product->images
                ->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

            $ogImageUrl = $defaultMainImage
                ? $this->resolveOgImageUrl($defaultMainImage->image_path)
                : optional($product->images->first(), function ($image) {
                    return $this->resolveOgImageUrl($image->image_path);
                });

            $fallbackProductOgImage = asset('images/shop-fallback.jpg');
            $ogImageUrl = $this->getWhatsAppSafeOgImage($ogImageUrl, $fallbackProductOgImage);

            /**
             * -------------------------------------
             * CATEGORY DATA (PRIMARY FOR SEO)
             * -------------------------------------
             */
            $primaryCategory = $product->categories->first();

            $categoryName = $primaryCategory?->name;
            $categorySlug = $primaryCategory?->slug;

            /**
             * -------------------------------------
             * KEYWORDS (AUTO + STORED)
             * -------------------------------------
             */
            $generatedKeywords = $this->generateProductKeywords($product);

            if ($categoryName) {
                $generatedKeywords[] = strtolower($categoryName);
                $generatedKeywords[] = strtolower($product->name . ' ' . $categoryName);
            }

            $storedKeywords = [];

            if ($product->meta_keywords) {
                $decoded = is_string($product->meta_keywords)
                    ? json_decode($product->meta_keywords, true)
                    : $product->meta_keywords;

                if (is_array($decoded)) {
                    $storedKeywords = array_map('strtolower', $decoded);
                }
            }

            $allKeywords = collect($generatedKeywords)
                ->merge($storedKeywords)
                ->filter()
                ->unique()
                ->take(30)
                ->values()
                ->all();

            /**
             * -------------------------------------
             * SEO TITLE & DESCRIPTION
             * -------------------------------------
             */
            $seoTitle = $product->seo_title
                ?? trim(
                    $product->name
                        . ($categoryName ? " | {$categoryName}" : '')
                        . ' | Buy Online in Sri Lanka'
                );

            $metaDescription = $product->meta_description
                ?? "Buy {$product->name}"
                . ($categoryName ? " in {$categoryName}" : '')
                . " online in Sri Lanka. Best price, fast delivery, premium quality.";

            return response()->json([
                'success' => true,
                'data' => [
                    'title' => $seoTitle,
                    'meta_description' => $metaDescription,
                    'meta_keywords' => $allKeywords,
                    'og_image' => $ogImageUrl,
                    'canonical_url' => url("/product/{$product->slug}"),
                    'category' => $categoryName,
                    'generated_keywords' => $generatedKeywords,
                ],
            ]);
        } catch (\Throwable $e) {
            \Log::warning("Product SEO not found: {$slug}", [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }
    }

    /* =====================================================
   | PRODUCT-SPECIFIC KEYWORD GENERATOR
   ===================================================== */
    private function generateProductKeywords(Product $product)
    {
        $name = Str::lower($product->name);

        // PRIMARY CATEGORY (from pivot)
        $categoryName = optional($product->categories->first())->name;
        $category = $categoryName ? Str::lower($categoryName) : 'clothing';

        // BRAND (unchanged)
        $brand = $product->brand?->name
            ? Str::lower($product->brand->name)
            : null;

        // COLORS (name ONLY – no slug)
        $colors = $product->variants
            ->pluck('color.name')
            ->filter()
            ->unique()
            ->map(fn($c) => Str::lower($c));

        $keywords = [];

        /* -----------------------------
     | Base product intent
     |----------------------------- */
        $keywords[] = $name;
        $keywords[] = "{$name} sri lanka";
        $keywords[] = "buy {$name} online";
        $keywords[] = "{$name} fashion sri lanka";

        /* -----------------------------
     | Category intent
     |----------------------------- */
        $keywords[] = "{$name} {$category}";
        $keywords[] = "{$category} {$name} sri lanka";
        $keywords[] = "best {$name} in sri lanka";
        $keywords[] = "buy {$category} online sri lanka";

        /* -----------------------------
     | Brand intent
     |----------------------------- */
        if ($brand) {
            $keywords[] = "{$brand} {$name}";
            $keywords[] = "{$brand} {$name} sri lanka";
        }

        /* -----------------------------
     | Color intent (NO slug)
     |----------------------------- */
        foreach ($colors as $color) {
            $keywords[] = "{$color} {$name}";
            $keywords[] = "{$color} {$name} sri lanka";
            $keywords[] = "buy {$color} {$name} online";
            $keywords[] = "{$color} {$category} {$name}";

            if ($brand) {
                $keywords[] = "{$brand} {$color} {$name}";
            }
        }

        /* -----------------------------
     | General commerce intent
     |----------------------------- */
        $keywords[] = "premium {$name}";
        $keywords[] = "{$name} for men";
        $keywords[] = "{$name} for women";

        return collect($keywords)
            ->map(fn($k) => (string) Str::of($k)->replace(['-', '_'], ' ')->trim())
            ->unique()
            ->values()
            ->take(40)
            ->all();
    }

    // for the collections data seo keywords

    public function getAllCollectionsSeo()
    {
        return Cache::remember('seo_all_collections_page', 60 * 60 * 12, function () {
            // Get all active collections with images
            $collectionsWithImages = Collection::where('is_active', true)
                ->whereNotNull('image')
                ->get();

            // Always have a fallback image ready
            $fallbackImage = asset('images/collections-fallback.jpg');

            // If we have any collection with an image → pick one randomly
            if ($collectionsWithImages->isNotEmpty()) {
                $randomCollection = $collectionsWithImages->random();
                $ogImage = $this->resolveOgImageUrl($randomCollection->image) ?? $fallbackImage;
            } else {
                // No collections with images → use fallback
                $ogImage = $fallbackImage;
            }

            $ogImage = $this->getWhatsAppSafeOgImage($ogImage, $fallbackImage);

            // Build keywords (same as before)
            $keywords = [
                'fashion collections sri lanka',
                'latest clothing collections',
                'shop collections online sri lanka',
                'women fashion collections',
                'men fashion collections',
                'new arrivals collections',
                'buy clothes online sri lanka',
            ];

            foreach ($collectionsWithImages as $c) {
                $lowerName = Str::lower($c->name);
                $keywords[] = "{$lowerName} collection sri lanka";
                $keywords[] = "buy {$lowerName} clothes online";
            }

            return [
                'title' => 'All Collections | Premium Fashion in Sri Lanka',
                'meta_description' => 'Explore our latest fashion collections in Sri Lanka. Shop premium clothing, new arrivals, and exclusive styles online with fast delivery.',
                'meta_keywords' => collect($keywords)
                    ->unique()
                    ->take(30)
                    ->values()
                    ->all(),
                'og_image' => $ogImage,
                'canonical_url' => url('/collections'),
            ];
        });
    }

    /**
     * SEO for main Shop page (all products)
     */
    public function getAllProductsSeo()
    {
        return Cache::remember('seo_all_products_page', 60 * 60 * 12, function () {

            // Get active products with images for OG image selection
            $productsWithImages = Product::query()
                ->where('status', 'active')
                ->whereHas('images', function ($q) {
                    $q->whereNotNull('image_path');
                })
                ->with([
                    'images',
                    'categories:id,name',
                    'variants.color:id,name',
                ])
                ->inRandomOrder()
                ->limit(20)
                ->get();

            // Fallback OG image
            $fallbackOgImage = asset('images/shop-fallback.jpg');

            // Pick random product image (prefer DEFAULT_MAIN)
            $ogImage = $fallbackOgImage;

            if ($productsWithImages->isNotEmpty()) {
                $randomProduct = $productsWithImages->random();

                $mainImage = $randomProduct->images
                    ->firstWhere('image_type', ProductImageType::DEFAULT_MAIN)
                    ?? $randomProduct->images->first();

                if ($mainImage) {
                    $ogImage = $this->resolveOgImageUrl($mainImage->image_path) ?? $fallbackOgImage;
                }
            }

            $ogImage = $this->getWhatsAppSafeOgImage($ogImage, $fallbackOgImage);

            // Base high-intent keywords
            $keywords = [
                'buy clothes online sri lanka',
                'online fashion store sri lanka',
                'premium clothing sri lanka',
                'latest fashion trends sri lanka',
                'women clothing online sri lanka',
                'men fashion sri lanka',
                'new arrivals clothing',
                'best online clothing store sri lanka',
                'fast delivery clothes sri lanka',
                'affordable fashion sri lanka',
            ];

            // Dynamic keywords from products
            foreach ($productsWithImages as $product) {
                $name = Str::lower($product->name);

                // PRIMARY CATEGORY (pivot-safe)
                $categoryName = optional($product->categories->first())->name;
                $category = $categoryName ? Str::lower($categoryName) : 'fashion';

                $keywords[] = $name;
                $keywords[] = "{$name} sri lanka";
                $keywords[] = "buy {$name} online";
                $keywords[] = "{$category} {$name}";

                // Colors (NO slug)
                $colors = $product->variants
                    ->pluck('color.name')
                    ->filter()
                    ->unique();

                foreach ($colors as $color) {
                    $color = Str::lower($color);
                    $keywords[] = "{$color} {$name}";
                    $keywords[] = "{$color} {$name} sri lanka";
                    $keywords[] = "buy {$color} {$category} online";
                }

                // Stored product keywords (unchanged)
                if ($product->keywords) {
                    $stored = json_decode($product->keywords, true);
                    if (is_array($stored)) {
                        foreach ($stored as $kw) {
                            $keywords[] = Str::lower(trim($kw));
                        }
                    }
                }
            }

            return [
                'title' => 'Shop All | Premium Fashion Clothing in Sri Lanka',
                'meta_description' =>
                'Shop the latest fashion online in Sri Lanka. Premium quality clothes for men and women with fast delivery and best prices.',
                'meta_keywords' => collect($keywords)
                    ->map(fn($k) => (string) Str::of($k)->replace(['-', '_'], ' ')->trim())
                    ->unique()
                    ->take(40)
                    ->values()
                    ->all(),
                'og_image' => $ogImage,
                'canonical_url' => url('/shop'),
            ];
        });
    }

    public function getNewArrivalsSeo()
    {
        return Cache::remember('seo_new_arrivals_page', 60 * 60 * 12, function () {

            // Fetch recent active products with relations (pivot-safe)
            $products = Product::query()
                ->where('status', 'active')
                ->whereHas('showAreas', fn($q) => $q->where('key', 'new_arrival'))
                ->with([
                    'images',
                    'categories:id,name',
                    'variants.color:id,name',
                ])
                ->orderByDesc('created_at')
                ->limit(30)
                ->get();

            // Fallback OG image
            $fallbackOgImage = asset('images/new-arrivals-fallback.jpg');

            // Pick best OG image (DEFAULT_MAIN preferred)
            $ogImage = $fallbackOgImage;

            if ($products->isNotEmpty()) {
                $randomProduct = $products->random();

                $mainImage = $randomProduct->images
                    ->firstWhere('image_type', ProductImageType::DEFAULT_MAIN)
                    ?? $randomProduct->images->first();

                if ($mainImage) {
                    $ogImage = $this->resolveOgImageUrl($mainImage->image_path) ?? $fallbackOgImage;
                }
            }

            $ogImage = $this->getWhatsAppSafeOgImage($ogImage, $fallbackOgImage);

            // Base high-intent keywords for New Arrivals
            $keywords = [
                'new arrivals sri lanka',
                'latest fashion sri lanka',
                'new clothing arrivals',
                'new fashion trends 2026',
                'latest clothes online sri lanka',
                'new collection sri lanka',
                'shop new arrivals online',
                'new season fashion sri lanka',
                'trending new clothes',
                'fresh arrivals clothing sri lanka',
            ];

            // Dynamic keywords from actual products
            foreach ($products as $product) {
                $name = Str::lower($product->name);

                // PRIMARY CATEGORY (from pivot)
                $categoryName = optional($product->categories->first())->name;
                $category = $categoryName ? Str::lower($categoryName) : 'fashion';

                /* -----------------------------
             | Product name intent
             |----------------------------- */
                $keywords[] = $name;
                $keywords[] = "new {$name}";
                $keywords[] = "{$name} new arrival";
                $keywords[] = "latest {$name} sri lanka";
                $keywords[] = "buy new {$name} online";

                /* -----------------------------
             | Category intent
             |----------------------------- */
                $keywords[] = "new {$category}";
                $keywords[] = "new {$category} arrivals";
                $keywords[] = "latest {$category} sri lanka";

                /* -----------------------------
             | Color intent (NO slug)
             |----------------------------- */
                $colors = $product->variants
                    ->pluck('color.name')
                    ->filter()
                    ->unique()
                    ->map(fn($c) => Str::lower($c));

                foreach ($colors as $color) {
                    $keywords[] = "new {$color} {$name}";
                    $keywords[] = "{$color} new arrival";
                    $keywords[] = "latest {$color} {$category}";
                    $keywords[] = "new {$color} clothing sri lanka";
                }

                /* -----------------------------
             | Stored product keywords
             |----------------------------- */
                if ($product->keywords) {
                    $stored = json_decode($product->keywords, true);
                    if (is_array($stored)) {
                        foreach ($stored as $kw) {
                            $keywords[] = 'new ' . Str::lower(trim($kw));
                        }
                    }
                }
            }

            // Clean & unique keywords
            $finalKeywords = collect($keywords)
                ->map(fn($k) => (string) Str::of($k)->replace(['-', '_'], ' ')->trim())
                ->unique()
                ->take(40)
                ->values()
                ->all();

            return [
                'title' => 'New Arrivals | Latest Fashion Clothing in Sri Lanka',
                'meta_description' =>
                'Discover the newest fashion arrivals in Sri Lanka. Shop the latest trends in clothing with premium quality and fast delivery across the island.',
                'meta_keywords' => $finalKeywords,
                'og_image' => $ogImage,
                'canonical_url' => url('/new-arrivals'),
            ];
        });
    }


    public function getCollectionSeo($slug)
    {
        return Cache::remember("seo_collection_{$slug}", 60 * 60 * 12, function () use ($slug) {
            // Get the collection by slug
            $collection = Collection::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            // Fetch products in this collection
            $products = $collection->products()
                ->with(['images', 'variants.color'])
                ->where('status', 'active')
                ->orderByDesc('created_at')
                ->limit(30)
                ->get();

            // Fallback OG image
            $fallbackOgImage = asset('images/collection-fallback.jpg');

            // Try collection image first (if you have an image field)
            $ogImage = $collection->image
                ? ($this->resolveOgImageUrl($collection->image) ?? $fallbackOgImage)
                : $fallbackOgImage;

            // If no collection image, pick from products
            if (!$collection->image && $products->isNotEmpty()) {
                $randomProduct = $products->random();

                $mainImage = $randomProduct->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN)
                    ?? $randomProduct->images->first();

                if ($mainImage) {
                    $ogImage = $this->resolveOgImageUrl($mainImage->image_path) ?? $fallbackOgImage;
                }
            }

            // Keep OG image within WhatsApp-friendly size limits when possible.
            $ogImage = $this->getWhatsAppSafeOgImage($ogImage, $fallbackOgImage);

            // Base high-intent keywords for collections
            $collectionName = $collection->name;
            $lowerName = Str::lower($collectionName);

            $keywords = [
                "{$lowerName} collection sri lanka",
                "shop {$lowerName} online",
                "buy {$lowerName} clothes sri lanka",
                "{$lowerName} fashion collection",
                "latest {$lowerName} sri lanka",
                "{$lowerName} new arrivals",
                "premium {$lowerName} clothing",
                "{$lowerName} online store sri lanka",
            ];

            // Dynamic keywords from products in the collection
            foreach ($products as $product) {
                $productName = Str::lower($product->name);

                // Product + collection
                $keywords[] = "{$productName} {$lowerName}";
                $keywords[] = "{$lowerName} {$productName}";
                $keywords[] = "{$productName} in {$lowerName} collection";

                // Colors
                $colors = $product->variants
                    ->pluck('color.name')
                    ->filter()
                    ->unique()
                    ->map(fn($c) => Str::lower($c));

                foreach ($colors as $color) {
                    $keywords[] = "{$color} {$productName} {$lowerName}";
                    $keywords[] = "{$color} {$lowerName} collection";
                    $keywords[] = "buy {$color} {$productName} in {$lowerName}";
                }

                // Stored product keywords
                if ($product->keywords) {
                    $stored = json_decode($product->keywords, true);
                    if (is_array($stored)) {
                        foreach ($stored as $kw) {
                            $keywords[] = Str::lower(trim($kw)) . " {$lowerName}";
                        }
                    }
                }
            }

            // Clean & unique keywords
            $finalKeywords = collect($keywords)
                ->map(fn($k) => (string) Str::of($k)->replace(['-', '_'], ' ')->trim())
                ->unique()
                ->take(40)
                ->values()
                ->all();

                \Log::info($collectionName);

            return [
                'title' => "{$collectionName} Collection | Premium Fashion in Sri Lanka",
                'meta_description' => "Explore our exclusive {$collectionName} collection. Shop the latest trends in premium fashion with fast delivery across Sri Lanka.",
                'meta_keywords' => $finalKeywords,
                'og_image' => $ogImage,
                'canonical_url' => url("/collection/{$slug}"),
            ];
        });
    }


    public function getSectionSeo($slug)
    {
        return Cache::remember("seo_section_{$slug}", 60 * 60 * 12, function () use ($slug) {
            // ✅ Get the section by slug
            $section = \App\Models\NewSection::where('slug', $slug)
                ->where('status', true)
                ->firstOrFail();

            // ✅ Fetch products in this section
            $products = $section->products()
                ->with(['images', 'category', 'variants.color'])
                ->where('status', 'active')
                ->orderByDesc('created_at')
                ->limit(30)
                ->get();

            // ✅ Fallback OG image
            $fallbackOgImage = asset('images/section-fallback.jpg');

            // ✅ Try section image first (if you have image field)
            $ogImage = $section->image
                ? ($this->resolveOgImageUrl($section->image) ?? $fallbackOgImage)
                : $fallbackOgImage;

            // ✅ If no section image, pick from products
            if (!$section->image && $products->isNotEmpty()) {
                $randomProduct = $products->random();

                $mainImage = $randomProduct->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN)
                    ?? $randomProduct->images->first();

                if ($mainImage) {
                    $ogImage = $this->resolveOgImageUrl($mainImage->image_path) ?? $fallbackOgImage;
                }
            }

            $ogImage = $this->getWhatsAppSafeOgImage($ogImage, $fallbackOgImage);

            // ✅ Base high-intent keywords for sections
            $sectionName = $section->name;
            $lowerName = Str::lower($sectionName);

            $keywords = [
                "{$lowerName} sri lanka",
                "shop {$lowerName} online",
                "buy {$lowerName} clothes sri lanka",
                "{$lowerName} fashion",
                "latest {$lowerName} sri lanka",
                "{$lowerName} offers",
                "{$lowerName} sale sri lanka",
                "{$lowerName} online store sri lanka",
            ];

            // ✅ Dynamic keywords from products in the section
            foreach ($products as $product) {
                $productName = Str::lower($product->name);
                $category = $product->category?->name ? Str::lower($product->category->name) : 'fashion';

                // Product + section
                $keywords[] = "{$productName} {$lowerName}";
                $keywords[] = "{$lowerName} {$productName}";
                $keywords[] = "{$productName} in {$lowerName}";

                // Colors
                $colors = $product->variants
                    ->pluck('color.name')
                    ->filter()
                    ->unique()
                    ->map(fn($c) => Str::lower($c));

                foreach ($colors as $color) {
                    $keywords[] = "{$color} {$productName} {$lowerName}";
                    $keywords[] = "{$color} {$lowerName}";
                    $keywords[] = "buy {$color} {$productName} in {$lowerName}";
                }

                // Stored product keywords
                if ($product->keywords) {
                    $stored = json_decode($product->keywords, true);
                    if (is_array($stored)) {
                        foreach ($stored as $kw) {
                            $keywords[] = Str::lower(trim($kw)) . " {$lowerName}";
                        }
                    }
                }
            }

            // ✅ Clean & unique keywords
            $finalKeywords = collect($keywords)
                ->map(fn($k) => (string) Str::of($k)->replace(['-', '_'], ' ')->trim())
                ->unique()
                ->take(40)
                ->values()
                ->all();

            return [
                'title' => "{$sectionName} | Premium Fashion in Sri Lanka",
                'meta_description' => "Explore our {$sectionName}. Shop the latest fashion trends with fast delivery across Sri Lanka.",
                'meta_keywords' => $finalKeywords,
                'og_image' => $ogImage,
                'canonical_url' => url("/section/{$slug}"),
            ];
        });
    }

    /**
     * Keep original OG image if <= 600KB. If larger, return cached optimized copy.
     */
    private function getWhatsAppSafeOgImage(?string $primaryImageUrl, string $fallbackImageUrl, int $maxBytes = 614400): string
    {
        if (!$primaryImageUrl) {
            return $fallbackImageUrl;
        }

        $optimizedUrl = $this->getOptimizedOgImageUrl($primaryImageUrl, $maxBytes);

        return $optimizedUrl ?? $primaryImageUrl;
    }

    /**
     * OG-only URL resolver. Keeps global R2 URL behavior untouched for the rest of the project.
     */
    private function resolveOgImageUrl(?string $filePath): ?string
    {
        if (!$filePath) {
            return null;
        }

        if (Str::startsWith($filePath, ['http://', 'https://'])) {
            return $filePath;
        }

        return R2Helper::getFileUrl($filePath);
    }

    private function getOptimizedOgImageUrl(string $imageUrl, int $maxBytes): ?string
    {
        return Cache::remember('seo_og_optimized_v2_' . md5($imageUrl . '|' . $maxBytes), 60 * 60 * 24 * 30, function () use ($imageUrl, $maxBytes) {
            try {
                $head = Http::timeout(2)->head($imageUrl);
                $contentLength = (int) $head->header('Content-Length', 0);
                $contentType = Str::lower((string) $head->header('Content-Type', ''));
                $isWebp = str_contains($contentType, 'image/webp') || Str::endsWith(Str::lower(parse_url($imageUrl, PHP_URL_PATH) ?? ''), '.webp');

                if ($head->successful() && !$isWebp && $contentLength > 0 && $contentLength <= $maxBytes) {
                    return $imageUrl;
                }

                $download = Http::timeout(8)->get($imageUrl);

                if (!$download->successful()) {
                    return $imageUrl;
                }

                $rawImage = (string) $download->body();

                if (!$isWebp && strlen($rawImage) <= $maxBytes) {
                    return $imageUrl;
                }

                $optimizedBinary = $this->compressImageToTargetSize($rawImage, $maxBytes);

                if (!$optimizedBinary) {
                    return $imageUrl;
                }

                $relativePath = 'og-cache/' . md5($imageUrl) . '.jpg';
                $stored = Storage::disk('s3')->put($relativePath, $optimizedBinary, ['ContentType' => 'image/jpeg']);

                if (!$stored) {
                    return $imageUrl;
                }

                return R2Helper::getFileUrl($relativePath);
            } catch (\Throwable $e) {
                return $imageUrl;
            }
        });
    }

    private function compressImageToTargetSize(string $binary, int $maxBytes): ?string
    {
        if (!function_exists('imagecreatefromstring')) {
            return null;
        }

        $source = @imagecreatefromstring($binary);

        if (!$source) {
            return null;
        }

        $canvas = $this->createJpegCanvas($source);
        imagedestroy($source);

        $result = $this->encodeJpegWithinLimit($canvas, $maxBytes);

        if ($result !== null) {
            imagedestroy($canvas);

            return $result;
        }

        $width = imagesx($canvas);
        $height = imagesy($canvas);

        for ($i = 0; $i < 3; $i++) {
            $newWidth = max(300, (int) floor($width * 0.85));
            $newHeight = max(300, (int) floor($height * 0.85));

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            $white = imagecolorallocate($resized, 255, 255, 255);
            imagefill($resized, 0, 0, $white);
            imagecopyresampled($resized, $canvas, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            imagedestroy($canvas);
            $canvas = $resized;
            $width = $newWidth;
            $height = $newHeight;

            $result = $this->encodeJpegWithinLimit($canvas, $maxBytes);
            if ($result !== null) {
                imagedestroy($canvas);

                return $result;
            }
        }

        imagedestroy($canvas);

        return null;
    }

    private function createJpegCanvas($source)
    {
        $width = imagesx($source);
        $height = imagesy($source);

        $canvas = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopy($canvas, $source, 0, 0, 0, 0, $width, $height);

        return $canvas;
    }

    private function encodeJpegWithinLimit($image, int $maxBytes): ?string
    {
        foreach ([85, 75, 65, 55, 45, 35] as $quality) {
            ob_start();
            imagejpeg($image, null, $quality);
            $jpeg = ob_get_clean();

            if ($jpeg !== false && strlen($jpeg) <= $maxBytes) {
                return $jpeg;
            }
        }

        return null;
    }


    public function getCategorySeo($slug)
    {
        return Cache::remember("seo_category_{$slug}", 60 * 60 * 12, function () use ($slug) {

            $category = \App\Models\Category::where('slug', $slug)->firstOrFail();

            // Products via pivot (already correct)
            $products = $category->products()
                ->where('status', 'active')
                ->with([
                    'images',
                    'variants.color:id,name',
                ])
                ->limit(30)
                ->get();

            // Fallback OG image
            $fallbackOgImage = asset('images/category-fallback.jpg');

            // Pick OG image (DEFAULT_MAIN preferred)
            $ogImage = $fallbackOgImage;

            if ($products->isNotEmpty()) {
                $randomProduct = $products->random();

                $mainImage = $randomProduct->images
                    ->firstWhere('image_type', ProductImageType::DEFAULT_MAIN)
                    ?? $randomProduct->images->first();

                if ($mainImage) {
                    $ogImage = $this->resolveOgImageUrl($mainImage->image_path) ?? $fallbackOgImage;
                }
            }

            $ogImage = $this->getWhatsAppSafeOgImage($ogImage, $fallbackOgImage);

            // Base category-level keywords
            $categoryName = Str::lower($category->name);

            $keywords = [
                "{$categoryName} fashion sri lanka",
                "buy {$categoryName} clothes online",
                "best {$categoryName} clothing sri lanka",
                "{$categoryName} collection",
                "premium {$categoryName} wear",
            ];

            // Product-driven keywords
            foreach ($products as $product) {
                $name = Str::lower($product->name);

                $keywords[] = "{$name} {$categoryName}";
                $keywords[] = "{$categoryName} {$name} sri lanka";
                $keywords[] = "buy {$name} online sri lanka";

                // Colors (name only)
                $colors = $product->variants
                    ->pluck('color.name')
                    ->filter()
                    ->unique();

                foreach ($colors as $color) {
                    $color = Str::lower($color);
                    $keywords[] = "{$color} {$name} {$categoryName}";
                    $keywords[] = "{$color} {$categoryName} clothing";
                }
            }

            // Clean, unique, SEO-safe keywords
            $finalKeywords = collect($keywords)
                ->map(fn($k) => (string) Str::of($k)->replace(['-', '_'], ' ')->trim())
                ->unique()
                ->take(40)
                ->values()
                ->all();

            return [
                'title' => "{$category->name} | Premium Fashion Clothing in Sri Lanka",
                'meta_description' =>
                "Shop the finest {$category->name} fashion online in Sri Lanka. Premium quality, latest trends, fast delivery.",
                'meta_keywords' => $finalKeywords,
                'og_image' => $ogImage,
                'canonical_url' => url("/shop/{$slug}"),
            ];
        });
    }
}
