<?php

namespace App\Http\Controllers;

use App\Enums\ProductImageType;
use App\Enums\ProductVariantAvailabilityStatus;
use App\helpers\R2Helper;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Coloer;
use App\Models\NewSection;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantAvailability;
use App\Models\ShowArea;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\String\Slugger\SluggerInterface;
use Illuminate\Pagination\LengthAwarePaginator;


class ProductController extends Controller
{





    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name'                  => 'required|string|max:255',
    //         'category_id'           => 'required|exists:categories,id',
    //         'description'           => 'required|string',
    //         'base_price'            => 'required|numeric|min:0',
    //         'sizes'                 => 'required|array|min:1',
    //         'sizes.*'               => 'integer|exists:sizes,id',
    //         'main_image'            => 'required|string',  // path only (e.g. products/abc.png)
    //         'hover_image'           => 'required|string',  // path only
    //         'slug'                  => 'nullable|string|max:200|regex:/^[a-z0-9-]+$/|unique:products,slug',
    //         'keywords'              => 'nullable|string',
    //         'show_areas'   => 'nullable|array',
    //         'show_areas.*' => 'exists:show_areas,id',

    //         // 'main_image_color' => 'required|string',
    //         // 'main_image_color_code' => 'required|string|regex:/^#?[0-9A-Fa-f]{6}$/',

    //         'main_image_colorname' => 'required|string',
    //         'main_image_color_code' => 'required|string|regex:/^#?[0-9A-Fa-f]{6}$/',
    //         'main_other_images' => 'nullable|array',

    //         'product_id' => 'required',


    //         // Color variants
    //         'colors'                        => 'present|array',
    //         'colors.*.name'                 => 'required_with:colors.*|string|max:100',
    //         'colors.*.code'                 => 'required_with:colors.*|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
    //         'colors.*.main_image'           => 'required_with:colors.*|string',
    //         'colors.*.other_images'         => 'nullable|array',
    //         'colors.*.other_images.*'       => 'string',


    //     ]);



    //     return DB::transaction(function () use ($validated) {
    //         // Generate unique slug
    //         $slug = $validated['slug'] ?? $this->generateUniqueSlug($validated['name'], $validated['category_id']);

    //         // 1. Create product with main & hover images in products table
    //         $product = Product::create([
    //             'category_id' => $validated['category_id'],
    //             'product_id' => $validated['product_id'],
    //             'name'        => $validated['name'],
    //             'slug'        => $slug,
    //             'description' => $validated['description'],
    //             'base_price'  => $validated['base_price'],
    //             'main_image'  => $validated['main_image'],
    //             'hover_image' => $validated['hover_image'],
    //             'keywords'   => $validated['keywords'] ? json_encode(array_map('trim', explode(',', $validated['keywords']))) : null,
    //             'status'      => 'active',
    //         ]);

    //         if (!empty($validated['show_areas'])) {
    //             $product->showAreas()->sync($validated['show_areas']);
    //         }


    //         $mainColorCode = strtoupper(preg_replace('/^#/', '', $validated['main_image_color_code']));


    //         $storedMainColorCode = Coloer::updateOrCreate(
    //             ['code' => $mainColorCode],
    //             ['name' => trim($validated['main_image_colorname'])]
    //         );


    //         $images = [];

    //         foreach ($validated['main_other_images'] as $path) {
    //             $images[] = [
    //                 'product_id' => $product->id,
    //                 'color_id'   => $storedMainColorCode->id,
    //                 'image_path' => $path,
    //                 'image_type' => ProductImageType::GALLERY,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ];
    //         }

    //         ProductImage::insert($images);


    //         ProductImage::create([
    //             'product_id' => $product->id,
    //             'color_id'   => $storedMainColorCode->id,
    //             'image_path' => $validated['main_image'],
    //             'image_type' => ProductImageType::DEFAULT_MAIN,
    //         ]);

    //         ProductImage::create([
    //             'product_id' => $product->id,
    //             'color_id'   => null,
    //             'image_path' => $validated['hover_image'],
    //             'image_type' => ProductImageType::DEFAULT_HOVER,
    //         ]);


    //         // 3. Process color variants only if provided
    //         if (!empty($validated['colors'])) {
    //             foreach ($validated['colors'] as $colorData) {
    //                 // Skip if required fields are missing (safety)
    //                 if (empty($colorData['name']) || empty($colorData['code']) || empty($colorData['main_image'])) {
    //                     continue;
    //                 }

    //                 // Clean the color code: remove # if present, force uppercase, ensure 6 chars
    //                 $cleanCode = strtoupper(preg_replace('/^#/', '', $colorData['code']));

    //                 // Validate it's exactly 6 hex digits
    //                 if (!preg_match('/^[0-9A-F]{6}$/', $cleanCode)) {
    //                     continue; // Skip invalid codes
    //                 }

    //                 $color = Coloer::updateOrCreate(
    //                     ['code' => $cleanCode],
    //                     ['name' => trim($colorData['name'])]
    //                 );

    //                 // Save main image for this color
    //                 ProductImage::create([
    //                     'product_id' => $product->id,
    //                     'color_id'   => $color->id,
    //                     'image_path' => $colorData['main_image'],
    //                     'image_type' => ProductImageType::VARIANT_MAIN,
    //                 ]);

    //                 // Save other images for this color
    //                 if (!empty($colorData['other_images'])) {
    //                     foreach ($colorData['other_images'] as $otherImagePath) {
    //                         if (!empty($otherImagePath)) {
    //                             ProductImage::create([
    //                                 'product_id' => $product->id,
    //                                 'color_id'   => $color->id,
    //                                 'image_path' => $otherImagePath,
    //                                 'image_type' => ProductImageType::GALLERY,
    //                             ]);
    //                         }
    //                     }
    //                 }


    //                 // Create product variants for each selected size
    //                 foreach ($validated['sizes'] as $sizeId) {
    //                     ProductVariant::create([
    //                         'product_id' => $product->id,
    //                         'color_id'   => $color->id,
    //                         'size_id'    => $sizeId,
    //                         'price'      => $validated['base_price'],
    //                         'stock'      => 0,
    //                     ]);
    //                 }
    //             }
    //         }
    //         return redirect()->route('admin.products')
    //             ->with('success', 'Product added successfully!');
    //     });
    // }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            // 'category_id'           => 'required|exists:categories,id',

            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'description'           => 'required|string',
            'base_price'            => 'required|numeric|min:0',
            'old_price'             => 'nullable|numeric|min:0',
            'sizes'                 => 'required|array|min:1',
            'sizes.*'               => 'integer|exists:sizes,id',
            'main_image'            => 'required|string',
            'hover_image'           => 'required|string',
            'slug'                  => 'nullable|string|max:200|regex:/^[a-z0-9-]+$/|unique:products,slug',
            'keywords'              => 'nullable|string',
            'show_areas'            => 'nullable|array',
            'show_areas.*'          => 'exists:show_areas,id',

            'main_image_colorname'  => 'required|string',
            'main_image_color_code' => 'required|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
            'main_other_images'     => 'nullable|array',
            'main_other_images.*'   => 'string',
            'size_chart_image' => 'nullable|string',

            'product_id'            => 'required|string|max:100|unique:products,product_id',

            // Colors can be completely empty — 'present|array' allows empty array
            'colors'                        => 'nullable|array',
            'colors.*.name'                 => 'required_with:colors.*|string|max:100',
            'colors.*.code'                 => 'required_with:colors.*|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
            'colors.*.main_image'           => 'required_with:colors.*|string',
            'colors.*.other_images'         => 'nullable|array',
            'colors.*.other_images.*'       => 'string',

            'main_unavailable_sizes'              => 'nullable|array',
            'main_unavailable_sizes.*'            => 'exists:sizes,id',

            'colors.*.unavailable_sizes'          => 'nullable|array',
            'colors.*.unavailable_sizes.*'        => 'exists:sizes,id',
        ]);

        return DB::transaction(function () use ($validated) {
            // Generate unique slug
            // $slug = $validated['slug'] ?? $this->generateUniqueSlug($validated['name'], $validated['category_id']);

            $primaryCategoryId = $validated['categories'][0];

            $slug = $validated['slug']
                ?? $this->generateUniqueSlug(
                    $validated['name'],
                    $primaryCategoryId
                );


            // 1. Create the main product
            $product = Product::create([
                'category_id' => "1",
                'product_id'  => $validated['product_id'],
                'name'        => $validated['name'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'base_price'  => $validated['base_price'],
                'old_price'   => $validated['old_price'],
                'main_image'  => $validated['main_image'],
                'hover_image' => $validated['hover_image'],
                'keywords'    => $validated['keywords']
                    ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
                    : null,
                'status'      => 'active',
                'size_chart_image' => $validated['size_chart_image'],
                'product_id' => $validated['product_id'],
            ]);

            // Sync show areas if provided
            if (!empty($validated['show_areas'])) {
                $product->showAreas()->sync($validated['show_areas']);
            }

            $product->categories()->sync($validated['categories']);

            // 2. Handle MAIN (default) color — ALWAYS required
            $mainColorCode = strtoupper(preg_replace('/^#/', '', $validated['main_image_color_code']));

            $mainColor = Coloer::updateOrCreate(
                ['code' => $mainColorCode],
                ['name' => trim($validated['main_image_colorname'])]
            );

            if (!empty($validated['main_unavailable_sizes'])) {
                $this->storeUnavailableSizes(
                    productId: $product->id,
                    colorId: $mainColor->id,
                    unavailableSizeIds: $validated['main_unavailable_sizes']
                );
            }

            // Save main image as DEFAULT_MAIN
            ProductImage::create([
                'product_id' => $product->id,
                'color_id'   => $mainColor->id,
                'image_path' => $validated['main_image'],
                'image_type' => ProductImageType::DEFAULT_MAIN,
            ]);

            // Save hover image (no color)
            ProductImage::create([
                'product_id' => $product->id,
                'color_id'   => null,
                'image_path' => $validated['hover_image'],
                'image_type' => ProductImageType::DEFAULT_HOVER,
            ]);

            // Save main other/gallery images under main color
            if (!empty($validated['main_other_images'])) {
                $galleryImages = [];
                foreach ($validated['main_other_images'] as $path) {
                    if (!empty(trim($path))) {
                        $galleryImages[] = [
                            'product_id'  => $product->id,
                            'color_id'    => $mainColor->id,
                            'image_path'  => $path,
                            'image_type'  => ProductImageType::GALLERY,
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ];
                    }
                }
                if (!empty($galleryImages)) {
                    ProductImage::insert($galleryImages);
                }
            }



            // 3. Process COLOR VARIANTS — ONLY IF PROVIDED
            if (!empty($validated['colors'])) {
                foreach ($validated['colors'] as $colorData) {
                    // Safety check
                    if (empty($colorData['name']) || empty($colorData['code']) || empty($colorData['main_image'])) {
                        continue;
                    }

                    $cleanCode = strtoupper(preg_replace('/^#/', '', $colorData['code']));
                    if (!preg_match('/^[0-9A-F]{6}$/', $cleanCode)) {
                        continue;
                    }

                    $color = Coloer::updateOrCreate(
                        ['code' => $cleanCode],
                        ['name' => trim($colorData['name'])]
                    );

                    if (!empty($colorData['unavailable_sizes'])) {
                        $this->storeUnavailableSizes(
                            productId: $product->id,
                            colorId: $color->id,
                            unavailableSizeIds: $colorData['unavailable_sizes']
                        );
                    }

                    // Save variant main image
                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id'   => $color->id,
                        'image_path' => $colorData['main_image'],
                        'image_type' => ProductImageType::VARIANT_MAIN,
                    ]);

                    // Save variant gallery images
                    if (!empty($colorData['other_images'])) {
                        foreach ($colorData['other_images'] as $path) {
                            if (!empty(trim($path))) {
                                ProductImage::create([
                                    'product_id' => $product->id,
                                    'color_id'   => $color->id,
                                    'image_path' => $path,
                                    'image_type' => ProductImageType::GALLERY,
                                ]);
                            }
                        }
                    }

                    // Create variants (color + size)
                    foreach ($validated['sizes'] as $sizeId) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_id'   => $color->id,
                            'size_id'    => $sizeId,
                            'price'      => $validated['base_price'],
                            'stock'      => 0,
                        ]);
                    }
                }
            } else {
                // NO COLOR VARIANTS — create variants using only the MAIN color
                foreach ($validated['sizes'] as $sizeId) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id'   => $mainColor->id,
                        'size_id'    => $sizeId,
                        'price'      => $validated['base_price'],
                        'stock'      => 0,
                    ]);
                }
            }

            return redirect()->route('admin.products')
                ->with('success', 'Product added successfully!');
        });
    }

    private function storeUnavailableSizes(
        int $productId,
        int $colorId,
        array $unavailableSizeIds
    ): void {
        foreach ($unavailableSizeIds as $sizeId) {
            ProductVariantAvailability::updateOrCreate(
                [
                    'product_id' => $productId,
                    'color_id'   => $colorId,
                    'size_id'    => $sizeId,
                ],
                [
                    'status' => ProductVariantAvailabilityStatus::UNAVAILABLE->value,
                ]
            );
        }
    }

    private function updateUnavailableSizes(
        int $productId,
        int $colorId,
        array $unavailableSizeIds
    ): void {
        // 1️⃣ Remove any previously unavailable sizes that are NOT in the new list
        ProductVariantAvailability::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->whereNotIn('size_id', $unavailableSizeIds)
            ->delete();

        // 2️⃣ Insert or update current unavailable sizes
        foreach ($unavailableSizeIds as $sizeId) {
            ProductVariantAvailability::updateOrCreate(
                [
                    'product_id' => $productId,
                    'color_id'   => $colorId,
                    'size_id'    => $sizeId,
                ],
                [
                    'status' => ProductVariantAvailabilityStatus::UNAVAILABLE->value,
                ]
            );
        }
    }



    // public function edit(Product $product)
    // {
    //     $relations = [
    //         'images',
    //         'showAreas',
    //         'categories', // ✅ LOAD CATEGORIES
    //     ];

    //     $hasVariantMainImages = $product->images()
    //         ->where('image_type', ProductImageType::VARIANT_MAIN)
    //         ->exists();

    //     if ($hasVariantMainImages) {
    //         $relations[] = 'variants.color';
    //         $relations[] = 'variants.size';
    //     }

    //     $product->load($relations);

    //     $mainImage = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
    //     $mainColor = $mainImage?->color;

    //     $categories = getAllCategories(); // or Category::active()->get()

    //     return view('products.edit', compact(
    //         'product',
    //         'mainColor',
    //         'categories'
    //     ));
    // }

    public function edit(Product $product)
    {
        $relations = [
            'images',
            'showAreas',
            'categories',
            'variants.color',
            'variants.size',
        ];

        $product->load($relations);

        // MAIN COLOR
        $mainImage = $product->images->firstWhere(
            'image_type',
            ProductImageType::DEFAULT_MAIN
        );
        $mainColor = $mainImage?->color;

        // 🔑 UNAVAILABLE SIZES (grouped by color_id)
        $unavailableSizesByColor = ProductVariantAvailability::where(
            'product_id',
            $product->id
        )
            ->where(
                'status',
                ProductVariantAvailabilityStatus::UNAVAILABLE->value
            )
            ->get()
            ->groupBy('color_id')
            ->map(fn($rows) => $rows->pluck('size_id')->toArray());

        $categories = getAllCategories();

        return view('products.edit', compact(
            'product',
            'mainColor',
            'categories',
            'unavailableSizesByColor'
        ));
    }


    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'category_id' => 'required|exists:categories,id',
            // 'description' => 'required|string',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'description' => 'required|string',


            'base_price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'exists:sizes,id',

            'main_image' => 'required|string',
            'hover_image' => 'required|string',

            'product_id' => 'required',

            'slug' => 'nullable|string|max:200',
            'keywords' => 'nullable|string',

            'show_areas' => 'nullable|array',

            'main_image_colorname' => 'required|string',
            'main_image_color_code' => 'required|string',

            'main_other_images' => 'nullable|array',
            'size_chart_image'          => 'nullable|string',

            'colors' => 'nullable|array',
            'colors.*.name' => 'required_with:colors.*',
            'colors.*.code' => 'required_with:colors.*',
            'colors.*.main_image' => 'required_with:colors.*',
            'colors.*.other_images' => 'nullable|array',

            'main_unavailable_sizes'              => 'nullable|array',
            'main_unavailable_sizes.*'            => 'exists:sizes,id',
            'colors.*.unavailable_sizes'          => 'nullable|array',
            'colors.*.unavailable_sizes.*'        => 'exists:sizes,id',


        ]);

        return DB::transaction(function () use ($validated, $product) {

            /* -----------------------------
             | UPDATE PRODUCT
             -----------------------------*/
            $product->update([
                'name' => $validated['name'],
                'category_id' => "1",
                'product_id'  => $validated['product_id'],
                'description' => $validated['description'],
                'base_price' => $validated['base_price'],
                'old_price' => $validated['old_price'] ?? null,
                'slug' => $validated['slug'] ?? $product->slug,
                'size_chart_image'          => $validated['size_chart_image'],
                'keywords' => $validated['keywords']
                    ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
                    : null,
            ]);

            /* -----------------------------
             | SHOW AREAS
             -----------------------------*/
            $product->showAreas()->sync($validated['show_areas'] ?? []);

            $product->categories()->sync($validated['categories']);

            /* -----------------------------
             | CLEAN OLD DATA
             -----------------------------*/
            ProductImage::where('product_id', $product->id)->delete();
            ProductVariant::where('product_id', $product->id)->delete();

            /* -----------------------------
             | MAIN COLOR
             -----------------------------*/
            $mainColorCode = strtoupper(ltrim($validated['main_image_color_code'], '#'));

            $mainColor = Coloer::updateOrCreate(
                ['code' => $mainColorCode],
                ['name' => $validated['main_image_colorname']]
            );

            // Store unavailable sizes for main color
            $this->updateUnavailableSizes(
                productId: $product->id,
                colorId: $mainColor->id,
                unavailableSizeIds: $validated['main_unavailable_sizes'] ?? []
            );

            /* -----------------------------
             | MAIN COLOR VARIANTS
             -----------------------------*/
            foreach ($validated['sizes'] as $sizeId) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id'   => $mainColor->id,
                    'size_id'    => $sizeId,
                    'price'      => $validated['base_price'],
                    'stock'      => 0,
                ]);
            }

            /* -----------------------------
             | MAIN + HOVER IMAGES
             -----------------------------*/
            ProductImage::create([
                'product_id' => $product->id,
                'color_id' => $mainColor->id,
                'image_path' => $validated['main_image'],
                'image_type' => ProductImageType::DEFAULT_MAIN,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'color_id' => null,
                'image_path' => $validated['hover_image'],
                'image_type' => ProductImageType::DEFAULT_HOVER,
            ]);

            /* -----------------------------
             | MAIN GALLERY
             -----------------------------*/
            foreach ($validated['main_other_images'] ?? [] as $path) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => $mainColor->id,
                    'image_path' => $path,
                    'image_type' => ProductImageType::GALLERY,
                ]);
            }

            /* -----------------------------
             | COLOR VARIANTS
             -----------------------------*/
            if (!empty($validated['colors'])) {
                foreach ($validated['colors'] as $colorData) {

                    $code = strtoupper(ltrim($colorData['code'], '#'));

                    $color = Coloer::updateOrCreate(
                        ['code' => $code],
                        ['name' => $colorData['name']]
                    );


                    $this->updateUnavailableSizes(
                        productId: $product->id,
                        colorId: $color->id,
                        unavailableSizeIds: $colorData['unavailable_sizes']
                    );


                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'image_path' => $colorData['main_image'],
                        'image_type' => ProductImageType::VARIANT_MAIN,
                    ]);

                    foreach ($colorData['other_images'] ?? [] as $img) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'color_id' => $color->id,
                            'image_path' => $img,
                            'image_type' => ProductImageType::GALLERY,
                        ]);
                    }

                    foreach ($validated['sizes'] as $sizeId) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_id' => $color->id,
                            'size_id' => $sizeId,
                            'price' => $validated['base_price'],
                            'stock' => 0,
                        ]);
                    }
                }
            }


            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully'
            ]);            // return redirect()
            //     ->route('admin.products')
            //     ->with('success', 'Product updated successfully');
        });
    }

    public function updateProductCollections(Request $request, Product $product)
    {
        $validated = $request->validate([
            // 'name' => 'required|string|max:255',
            // 'category_id' => 'required|exists:categories,id',
            // 'description' => 'required|string',
            // 'base_price' => 'required|numeric|min:0',
            // 'sizes' => 'required|array|min:1',
            // 'sizes.*' => 'exists:sizes,id',
            // 'collection_id' => 'required|exists:collections,id',

            // 'main_image' => 'nullable|string',
            // 'hover_image' => 'nullable|string',
            // 'size_chart_image' => 'nullable|string',

            // 'main_image_colorname' => 'required|string',
            // 'main_image_color_code' => 'required|string',

            // 'colors' => 'nullable|array',
            // 'colors.*.name' => 'required_with:colors.*',
            // 'colors.*.code' => 'required_with:colors.*',
            // 'colors.*.main_image' => 'required_with:colors.*',
            // 'colors.*.other_images' => 'nullable|array',











            'name' => 'required|string|max:255',
            'collection_id' => 'required|exists:collections,id',

            // 'category_id' => 'required|exists:categories,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'exists:sizes,id',

            'main_image' => 'required|string',
            'hover_image' => 'required|string',

            'product_id' => 'required',

            'slug' => 'nullable|string|max:200',
            'keywords' => 'nullable|string',

            'show_areas' => 'nullable|array',

            'main_image_colorname' => 'required|string',
            'main_image_color_code' => 'required|string',

            'main_other_images' => 'nullable|array',
            'size_chart_image'          => 'nullable|string',

            'colors' => 'nullable|array',
            'colors.*.name' => 'required_with:colors.*',
            'colors.*.code' => 'required_with:colors.*',
            'colors.*.main_image' => 'required_with:colors.*',
            'colors.*.other_images' => 'nullable|array',

            'main_unavailable_sizes'              => 'nullable|array',
            'main_unavailable_sizes.*'            => 'exists:sizes,id',
            'colors.*.unavailable_sizes'          => 'nullable|array',
            'colors.*.unavailable_sizes.*'        => 'exists:sizes,id',

        ]);

        return DB::transaction(function () use ($validated, $product) {

            /* ============================
         UPDATE PRODUCT BASIC DATA
        ============================ */
            $product->update([
                'name' => $validated['name'],
                'category_id' => "1",
                'product_id'  => $validated['product_id'],
                'description' => $validated['description'],
                'base_price' => $validated['base_price'],
                'old_price' => $validated['old_price'] ?? null,
                'slug' => $validated['slug'] ?? $product->slug,
                'size_chart_image'          => $validated['size_chart_image'],
                'keywords' => $validated['keywords']
                    ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
                    : null,
            ]);

            $product->collections()->sync([$validated['collection_id']]);
            $product->showAreas()->sync($validated['show_areas'] ?? []);
            $product->categories()->sync($validated['categories']);


            /* ============================
         HANDLE MAIN COLOR
        ============================ */
            $mainColorCode = strtoupper(ltrim($validated['main_image_color_code'], '#'));

            $mainColor = Coloer::updateOrCreate(
                ['code' => $mainColorCode],
                ['name' => $validated['main_image_colorname']]
            );

            // Store unavailable sizes for main color
            $this->updateUnavailableSizes(
                productId: $product->id,
                colorId: $mainColor->id,
                unavailableSizeIds: $validated['main_unavailable_sizes'] ?? []
            );


            /* ============================
         KEEP TRACK OF ACTIVE COLORS
        ============================ */
            $activeColorIds = [$mainColor->id];

            /* ============================
         SYNC SIZES FOR MAIN COLOR
        ============================ */
            ProductVariant::where('product_id', $product->id)
                ->where('color_id', $mainColor->id)
                ->delete();

            foreach ($validated['sizes'] as $sizeId) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id'   => $mainColor->id,
                    'size_id'    => $sizeId,
                    'price'      => $validated['base_price'],
                    'stock'      => 0,
                ]);
            }

            /* ============================
         HANDLE MAIN IMAGES (UPDATE OR CREATE)
        ============================ */
            if (!empty($validated['main_image'])) {
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'color_id' => $mainColor->id,
                        'image_type' => ProductImageType::DEFAULT_MAIN,
                    ],
                    ['image_path' => $validated['main_image']]
                );
            }

            if (!empty($validated['hover_image'])) {
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'image_type' => ProductImageType::DEFAULT_HOVER,
                    ],
                    ['image_path' => $validated['hover_image']]
                );
            }

            /* ============================
         HANDLE COLOR VARIANTS (SMART SYNC)
        ============================ */
            $incomingColors = collect($validated['colors'] ?? []);

            foreach ($incomingColors as $colorData) {

                $code = strtoupper(ltrim($colorData['code'], '#'));

                $color = Coloer::updateOrCreate(
                    ['code' => $code],
                    ['name' => $colorData['name']]
                );

                $this->updateUnavailableSizes(
                    productId: $product->id,
                    colorId: $color->id,
                    unavailableSizeIds: $colorData['unavailable_sizes'] ?? []
                );

                $activeColorIds[] = $color->id;

                // Variant main image
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'image_type' => ProductImageType::VARIANT_MAIN,
                    ],
                    ['image_path' => $colorData['main_image']]
                );

                // Remove old gallery images for this color
                ProductImage::where('product_id', $product->id)
                    ->where('color_id', $color->id)
                    ->where('image_type', ProductImageType::GALLERY)
                    ->delete();

                // Add new gallery images
                foreach ($colorData['other_images'] ?? [] as $img) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'image_path' => $img,
                        'image_type' => ProductImageType::GALLERY,
                    ]);
                }

                // Sync sizes for this color
                ProductVariant::where('product_id', $product->id)
                    ->where('color_id', $color->id)
                    ->delete();

                foreach ($validated['sizes'] as $sizeId) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'size_id' => $sizeId,
                        'price' => $validated['base_price'],
                        'stock' => 0,
                    ]);
                }
            }

            /* ============================
         DELETE REMOVED COLORS (IMPORTANT FIX)
        ============================ */
            ProductVariant::where('product_id', $product->id)
                ->whereNotIn('color_id', $activeColorIds)
                ->delete();

            ProductImage::where('product_id', $product->id)
                ->whereNotIn('color_id', $activeColorIds)
                ->whereNotNull('color_id')
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully (no variant bugs 🎉)'
            ]);
        });
    }

    public function updateProductSections(Request $request, Product $product)
    {
        $validated = $request->validate([



            'name' => 'required|string|max:255',
            'section_id' => 'required|exists:new_sections,id',

            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'sizes' => 'required|array|min:1',
            'sizes.*' => 'exists:sizes,id',

            'main_image' => 'required|string',
            'hover_image' => 'required|string',

            'product_id' => 'required',

            'slug' => 'nullable|string|max:200',
            'keywords' => 'nullable|string',

            'show_areas' => 'nullable|array',

            'main_image_colorname' => 'required|string',
            'main_image_color_code' => 'required|string',

            'main_other_images' => 'nullable|array',
            'size_chart_image'          => 'nullable|string',

            'colors' => 'nullable|array',
            'colors.*.name' => 'required_with:colors.*',
            'colors.*.code' => 'required_with:colors.*',
            'colors.*.main_image' => 'required_with:colors.*',
            'colors.*.other_images' => 'nullable|array',
        ]);

        return DB::transaction(function () use ($validated, $product) {

            /* ============================
         UPDATE PRODUCT BASIC DATA
        ============================ */
            $product->update([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'product_id'  => $validated['product_id'],
                'description' => $validated['description'],
                'base_price' => $validated['base_price'],
                'old_price' => $validated['old_price'] ?? null,
                'slug' => $validated['slug'] ?? $product->slug,
                'size_chart_image'          => $validated['size_chart_image'],
                'keywords' => $validated['keywords']
                    ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
                    : null,
            ]);

            // $product->collections()->sync([$validated['collection_id']]);


            if (!empty($validated['section_id'])) {
                $product->sections()->sync($validated['section_id']);
            }
            // Sync show areas if provided
            if (!empty($validated['show_areas'])) {
                $product->showAreas()->sync($validated['show_areas']);
            }


            /* ============================
         HANDLE MAIN COLOR
        ============================ */
            $mainColorCode = strtoupper(ltrim($validated['main_image_color_code'], '#'));

            $mainColor = Coloer::updateOrCreate(
                ['code' => $mainColorCode],
                ['name' => $validated['main_image_colorname']]
            );

            /* ============================
         KEEP TRACK OF ACTIVE COLORS
        ============================ */
            $activeColorIds = [$mainColor->id];

            /* ============================
         HANDLE MAIN IMAGES (UPDATE OR CREATE)
        ============================ */
            if (!empty($validated['main_image'])) {
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'color_id' => $mainColor->id,
                        'image_type' => ProductImageType::DEFAULT_MAIN,
                    ],
                    ['image_path' => $validated['main_image']]
                );
            }

            if (!empty($validated['hover_image'])) {
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'image_type' => ProductImageType::DEFAULT_HOVER,
                    ],
                    ['image_path' => $validated['hover_image']]
                );
            }

            /* ============================
         HANDLE COLOR VARIANTS (SMART SYNC)
        ============================ */
            $incomingColors = collect($validated['colors'] ?? []);

            foreach ($incomingColors as $colorData) {

                $code = strtoupper(ltrim($colorData['code'], '#'));

                $color = Coloer::updateOrCreate(
                    ['code' => $code],
                    ['name' => $colorData['name']]
                );

                $activeColorIds[] = $color->id;

                // Variant main image
                ProductImage::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'image_type' => ProductImageType::VARIANT_MAIN,
                    ],
                    ['image_path' => $colorData['main_image']]
                );

                // Remove old gallery images for this color
                ProductImage::where('product_id', $product->id)
                    ->where('color_id', $color->id)
                    ->where('image_type', ProductImageType::GALLERY)
                    ->delete();

                // Add new gallery images
                foreach ($colorData['other_images'] ?? [] as $img) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'image_path' => $img,
                        'image_type' => ProductImageType::GALLERY,
                    ]);
                }

                // Sync sizes for this color
                ProductVariant::where('product_id', $product->id)
                    ->where('color_id', $color->id)
                    ->delete();

                foreach ($validated['sizes'] as $sizeId) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'size_id' => $sizeId,
                        'price' => $validated['base_price'],
                        'stock' => 0,
                    ]);
                }
            }

            /* ============================
         DELETE REMOVED COLORS (IMPORTANT FIX)
        ============================ */
            ProductVariant::where('product_id', $product->id)
                ->whereNotIn('color_id', $activeColorIds)
                ->delete();

            ProductImage::where('product_id', $product->id)
                ->whereNotIn('color_id', $activeColorIds)
                ->whereNotNull('color_id')
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully (no variant bugs 🎉)'
            ]);
        });
    }



    public function editSectionProducts(Product $product)
    {
        $relations = [
            'images',
            'showAreas',
            'sections' // ✅ load sections instead of collections
        ];

        $hasVariantMainImages = $product->images()
            ->where('image_type', ProductImageType::VARIANT_MAIN)
            ->exists();

        if ($hasVariantMainImages) {
            $relations[] = 'variants.color';
            $relations[] = 'variants.size';
        }

        $product->load($relations);

        $mainImage = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
        $mainColor = $mainImage?->color;

        $sections = NewSection::all(); // ✅ get all sections

        return view('sections.edit', compact(
            'product',
            'mainColor',
            'sections'
        ));
    }

    // public function updateProductCollections(Request $request, Product $product)
    // {
    //     $validated = $request->validate([
    //         // 'name' => 'required|string|max:255',
    //         // 'category_id' => 'required|exists:categories,id',
    //         // 'description' => 'required|string',
    //         // 'base_price' => 'required|numeric|min:0',
    //         // 'sizes' => 'required|array|min:1',
    //         // 'sizes.*' => 'exists:sizes,id',

    //         // 'main_image' => 'required|string',
    //         // 'hover_image' => 'required|string',

    //         // 'collection_id'         => 'required|exists:collections,id',

    //         // 'product_id' => 'required',

    //         // 'slug' => 'nullable|string|max:200',
    //         // 'keywords' => 'nullable|string',

    //         // 'show_areas' => 'nullable|array',

    //         // 'main_image_colorname' => 'required|string',
    //         // 'main_image_color_code' => 'required|string',

    //         // 'main_other_images' => 'nullable|array',

    //         // 'colors' => 'nullable|array',
    //         // 'colors.*.name' => 'required_with:colors.*',
    //         // 'colors.*.code' => 'required_with:colors.*',
    //         // 'colors.*.main_image' => 'required_with:colors.*',
    //         // 'colors.*.other_images' => 'nullable|array',


    //         'collection_id'         => 'required|exists:collections,id',



    //         'name'                  => 'required|string|max:255',
    //         'category_id'           => 'required|exists:categories,id',
    //         'description'           => 'required|string',
    //         'base_price'            => 'required|numeric|min:0',
    //         'sizes'                 => 'required|array|min:1',
    //         'sizes.*'               => 'integer|exists:sizes,id',
    //         'main_image'            => 'required|string',
    //         'hover_image'           => 'required|string',
    //         'slug'                  => 'nullable|string|max:200|regex:/^[a-z0-9-]+$/|unique:products,slug',
    //         'keywords'              => 'nullable|string',
    //         'show_areas'            => 'nullable|array',
    //         'show_areas.*'          => 'exists:show_areas,id',

    //         'main_image_colorname'  => 'required|string',
    //         'main_image_color_code' => 'required|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
    //         'main_other_images'     => 'nullable|array',
    //         'main_other_images.*'   => 'string',
    //         'product_id'            => 'required',

    //         'product_id' => 'required|string|max:100|unique:products,product_id',
    //         // Colors can be completely empty — 'present|array' allows empty array
    //         'colors'                        => 'nullable|array',
    //         'colors.*.name'                 => 'required_with:colors.*|string|max:100',
    //         'colors.*.code'                 => 'required_with:colors.*|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
    //         'colors.*.main_image'           => 'required_with:colors.*|string',
    //         'colors.*.other_images'         => 'nullable|array',
    //         'colors.*.other_images.*'       => 'string',






    //     ]);

    //     return DB::transaction(function () use ($validated, $product) {

    //         /* -----------------------------
    //          | UPDATE PRODUCT
    //          -----------------------------*/
    //         $product->update([
    //             'name' => $validated['name'],
    //             'category_id' => $validated['category_id'],
    //             'product_id'  => $validated['product_id'],
    //             'description' => $validated['description'],
    //             'base_price' => $validated['base_price'],
    //             'slug' => $validated['slug'] ?? $product->slug,
    //             'keywords' => $validated['keywords']
    //                 ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
    //                 : null,
    //         ]);

    //         $product->collections()->sync([$validated['collection_id']]);

    //         /* -----------------------------
    //          | SHOW AREAS
    //          -----------------------------*/
    //         $product->showAreas()->sync($validated['show_areas'] ?? []);

    //         /* -----------------------------
    //          | CLEAN OLD DATA
    //          -----------------------------*/
    //         ProductImage::where('product_id', $product->id)->delete();
    //         ProductVariant::where('product_id', $product->id)->delete();

    //         /* -----------------------------
    //          | MAIN COLOR
    //          -----------------------------*/
    //         $mainColorCode = strtoupper(ltrim($validated['main_image_color_code'], '#'));

    //         $mainColor = Coloer::updateOrCreate(
    //             ['code' => $mainColorCode],
    //             ['name' => $validated['main_image_colorname']]
    //         );

    //         /* -----------------------------
    //          | MAIN + HOVER IMAGES
    //          -----------------------------*/
    //         ProductImage::create([
    //             'product_id' => $product->id,
    //             'color_id' => $mainColor->id,
    //             'image_path' => $validated['main_image'],
    //             'image_type' => ProductImageType::DEFAULT_MAIN,
    //         ]);

    //         ProductImage::create([
    //             'product_id' => $product->id,
    //             'color_id' => null,
    //             'image_path' => $validated['hover_image'],
    //             'image_type' => ProductImageType::DEFAULT_HOVER,
    //         ]);

    //         /* -----------------------------
    //          | MAIN GALLERY
    //          -----------------------------*/
    //         foreach ($validated['main_other_images'] ?? [] as $path) {
    //             ProductImage::create([
    //                 'product_id' => $product->id,
    //                 'color_id' => $mainColor->id,
    //                 'image_path' => $path,
    //                 'image_type' => ProductImageType::GALLERY,
    //             ]);
    //         }

    //         /* -----------------------------
    //          | COLOR VARIANTS
    //          -----------------------------*/
    //         if (!empty($validated['colors'])) {
    //             foreach ($validated['colors'] as $colorData) {

    //                 $code = strtoupper(ltrim($colorData['code'], '#'));

    //                 $color = Coloer::updateOrCreate(
    //                     ['code' => $code],
    //                     ['name' => $colorData['name']]
    //                 );

    //                 ProductImage::create([
    //                     'product_id' => $product->id,
    //                     'color_id' => $color->id,
    //                     'image_path' => $colorData['main_image'],
    //                     'image_type' => ProductImageType::VARIANT_MAIN,
    //                 ]);

    //                 foreach ($colorData['other_images'] ?? [] as $img) {
    //                     ProductImage::create([
    //                         'product_id' => $product->id,
    //                         'color_id' => $color->id,
    //                         'image_path' => $img,
    //                         'image_type' => ProductImageType::GALLERY,
    //                     ]);
    //                 }

    //                 foreach ($validated['sizes'] as $sizeId) {
    //                     ProductVariant::create([
    //                         'product_id' => $product->id,
    //                         'color_id' => $color->id,
    //                         'size_id' => $sizeId,
    //                         'price' => $validated['base_price'],
    //                         'stock' => 0,
    //                     ]);
    //                 }
    //             }
    //         } else {
    //             foreach ($validated['sizes'] as $sizeId) {
    //                 ProductVariant::create([
    //                     'product_id' => $product->id,
    //                     'color_id' => $mainColor->id,
    //                     'size_id' => $sizeId,
    //                     'price' => $validated['base_price'],
    //                     'stock' => 0,
    //                 ]);
    //             }
    //         }


    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Product updated successfully'
    //         ]);            // return redirect()
    //         //     ->route('admin.products')
    //         //     ->with('success', 'Product updated successfully');
    //     });
    // }



    // public function updateProductCollections(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name'                  => 'required|string|max:255',
    //         'category_id'           => 'required|exists:categories,id',
    //         'description'           => 'required|string',
    //         'base_price'            => 'required|numeric|min:0',
    //         'sizes'                 => 'required|array|min:1',
    //         'sizes.*'               => 'integer|exists:sizes,id',
    //         'main_image'            => 'required|string',
    //         'hover_image'           => 'required|string',
    //         'slug' => 'nullable|string|max:200',
    //         'keywords'              => 'nullable|string',
    //         'show_areas'            => 'nullable|array',
    //         'show_areas.*'          => 'exists:show_areas,id',

    //         'collection_id'         => 'required|exists:collections,id',

    //         'main_image_colorname'  => 'required|string',
    //         'main_image_color_code' => 'required|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
    //         'main_other_images'     => 'nullable|array',
    //         'main_other_images.*'   => 'string',
    //         'size_chart_image'      => 'nullable|string',

    //         'product_id'            => 'required',

    //         // FIXED: nullable allows missing field when no variants
    //         'colors'                => 'nullable|array',
    //         'colors.*.name'         => 'required_with:colors.*|string|max:100',
    //         'colors.*.code'         => 'required_with:colors.*|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
    //         'colors.*.main_image'   => 'required_with:colors.*|string',
    //         'colors.*.other_images' => 'nullable|array',
    //         'colors.*.other_images.*' => 'string',
    //     ]);

    //     return DB::transaction(function () use ($validated) {
    //         // Generate unique slug
    //         $slug = $validated['slug'] ?? $this->generateUniqueSlug($validated['name'], $validated['category_id']);

    //         // 1. Create the main product
    //         // $product = Product::update([
    //         //     'category_id' => $validated['category_id'],
    //         //     'product_id'  => $validated['product_id'],
    //         //     'name'        => $validated['name'],
    //         //     'slug'        => $slug,
    //         //     'description' => $validated['description'],
    //         //     'base_price'  => $validated['base_price'],
    //         //     'main_image'  => $validated['main_image'],
    //         //     'hover_image' => $validated['hover_image'],
    //         //     'keywords'    => $validated['keywords']
    //         //         ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
    //         //         : null,
    //         //     'status'      => 'active',
    //         //     'size_chart_image' => $validated['size_chart_image'],
    //         //     'product_id' => $validated['product_id'],
    //         // ]);



    //         $product = Product::findOrFail($validated['product_id']); // or route id

    //         $product->update([
    //             'category_id' => $validated['category_id'],
    //             'product_id'  => $validated['product_id'],
    //             'name'        => $validated['name'],
    //             'slug'        => $slug,
    //             'description' => $validated['description'],
    //             'base_price'  => $validated['base_price'],
    //             'main_image'  => $validated['main_image'],
    //             'hover_image' => $validated['hover_image'],
    //             'keywords'    => $validated['keywords']
    //                 ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
    //                 : null,
    //             'status'      => 'active',
    //             'size_chart_image' => $validated['size_chart_image'],
    //         ]);

    //         $product->collections()->sync([$validated['collection_id']]);


    //         // Sync show areas if provided
    //         if (!empty($validated['show_areas'])) {
    //             $product->showAreas()->sync($validated['show_areas']);
    //         }

    //         // 2. Handle MAIN (default) color — ALWAYS required
    //         $mainColorCode = strtoupper(preg_replace('/^#/', '', $validated['main_image_color_code']));

    //         $mainColor = Coloer::updateOrCreate(
    //             ['code' => $mainColorCode],
    //             ['name' => trim($validated['main_image_colorname'])]
    //         );

    //         // Save main image as DEFAULT_MAIN
    //         ProductImage::create([
    //             'product_id' => $product->id,
    //             'color_id'   => $mainColor->id,
    //             'image_path' => $validated['main_image'],
    //             'image_type' => ProductImageType::DEFAULT_MAIN,
    //         ]);

    //         // Save hover image (no color)
    //         ProductImage::create([
    //             'product_id' => $product->id,
    //             'color_id'   => null,
    //             'image_path' => $validated['hover_image'],
    //             'image_type' => ProductImageType::DEFAULT_HOVER,
    //         ]);

    //         // Save main other/gallery images under main color
    //         if (!empty($validated['main_other_images'])) {
    //             $galleryImages = [];
    //             foreach ($validated['main_other_images'] as $path) {
    //                 if (!empty(trim($path))) {
    //                     $galleryImages[] = [
    //                         'product_id'  => $product->id,
    //                         'color_id'    => $mainColor->id,
    //                         'image_path'  => $path,
    //                         'image_type'  => ProductImageType::GALLERY,
    //                         'created_at'  => now(),
    //                         'updated_at'  => now(),
    //                     ];
    //                 }
    //             }
    //             if (!empty($galleryImages)) {
    //                 ProductImage::insert($galleryImages);
    //             }
    //         }

    //         // 3. Process COLOR VARIANTS — ONLY IF PROVIDED
    //         if (!empty($validated['colors'])) {
    //             foreach ($validated['colors'] as $colorData) {
    //                 // Safety check
    //                 if (empty($colorData['name']) || empty($colorData['code']) || empty($colorData['main_image'])) {
    //                     continue;
    //                 }

    //                 $cleanCode = strtoupper(preg_replace('/^#/', '', $colorData['code']));
    //                 if (!preg_match('/^[0-9A-F]{6}$/', $cleanCode)) {
    //                     continue;
    //                 }

    //                 $color = Coloer::updateOrCreate(
    //                     ['code' => $cleanCode],
    //                     ['name' => trim($colorData['name'])]
    //                 );

    //                 // Save variant main image
    //                 ProductImage::create([
    //                     'product_id' => $product->id,
    //                     'color_id'   => $color->id,
    //                     'image_path' => $colorData['main_image'],
    //                     'image_type' => ProductImageType::VARIANT_MAIN,
    //                 ]);

    //                 // Save variant gallery images
    //                 if (!empty($colorData['other_images'])) {
    //                     foreach ($colorData['other_images'] as $path) {
    //                         if (!empty(trim($path))) {
    //                             ProductImage::create([
    //                                 'product_id' => $product->id,
    //                                 'color_id'   => $color->id,
    //                                 'image_path' => $path,
    //                                 'image_type' => ProductImageType::GALLERY,
    //                             ]);
    //                         }
    //                     }
    //                 }

    //                 // Create variants (color + size)
    //                 foreach ($validated['sizes'] as $sizeId) {
    //                     ProductVariant::create([
    //                         'product_id' => $product->id,
    //                         'color_id'   => $color->id,
    //                         'size_id'    => $sizeId,
    //                         'price'      => $validated['base_price'],
    //                         'stock'      => 0,
    //                     ]);
    //                 }
    //             }
    //         } else {
    //             // NO COLOR VARIANTS — create variants using only the MAIN color
    //             foreach ($validated['sizes'] as $sizeId) {
    //                 ProductVariant::create([
    //                     'product_id' => $product->id,
    //                     'color_id'   => $mainColor->id,
    //                     'size_id'    => $sizeId,
    //                     'price'      => $validated['base_price'],
    //                     'stock'      => 0,
    //                 ]);
    //             }
    //         }

    //         return redirect()->route('admin.products')
    //             ->with('success', 'Product added successfully!');
    //     });
    // }



    public function updateProductCollectionss(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',

            'sizes' => 'required|array|min:1',
            'sizes.*' => 'exists:sizes,id',

            'main_image' => 'required|string',
            'hover_image' => 'required|string',

            'slug' => 'nullable|string|max:200',
            'keywords' => 'nullable|string',

            'show_areas' => 'nullable|array',
            'show_areas.*' => 'exists:show_areas,id',

            'collection_id' => 'required|exists:collections,id',

            'main_image_colorname' => 'required|string',
            'main_image_color_code' => 'required|string',

            'main_other_images' => 'nullable|array',
            'size_chart_image' => 'nullable|string',

            'product_id' => 'required',

            'colors' => 'nullable|array',
            'colors.*.name' => 'required_with:colors.*',
            'colors.*.code' => 'required_with:colors.*',
            'colors.*.main_image' => 'required_with:colors.*',
            'colors.*.other_images' => 'nullable|array',
        ]);

        return DB::transaction(function () use ($validated) {

            /* -----------------------------
         | FIND PRODUCT
         -----------------------------*/
            $product = Product::findOrFail($validated['product_id']);

            /* -----------------------------
         | UPDATE PRODUCT
         -----------------------------*/
            $product->update([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'],
                'base_price' => $validated['base_price'],
                'slug' => $validated['slug'] ?? $product->slug,
                'size_chart_image' => $validated['size_chart_image'],
                'keywords' => $validated['keywords']
                    ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
                    : null,
            ]);

            /* -----------------------------
         | COLLECTION SYNC
         -----------------------------*/
            $product->collections()->sync([$validated['collection_id']]);

            /* -----------------------------
         | SHOW AREAS SYNC
         -----------------------------*/
            $product->showAreas()->sync($validated['show_areas'] ?? []);

            /* -----------------------------
         | CLEAN OLD DATA (IMPORTANT ✅)
         -----------------------------*/
            ProductImage::where('product_id', $product->id)->delete();
            ProductVariant::where('product_id', $product->id)->delete();

            /* -----------------------------
         | MAIN COLOR
         -----------------------------*/
            $mainColorCode = strtoupper(ltrim($validated['main_image_color_code'], '#'));

            $mainColor = Coloer::updateOrCreate(
                ['code' => $mainColorCode],
                ['name' => $validated['main_image_colorname']]
            );

            /* -----------------------------
         | MAIN + HOVER IMAGES
         -----------------------------*/
            ProductImage::create([
                'product_id' => $product->id,
                'color_id' => $mainColor->id,
                'image_path' => $validated['main_image'],
                'image_type' => ProductImageType::DEFAULT_MAIN,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'color_id' => null,
                'image_path' => $validated['hover_image'],
                'image_type' => ProductImageType::DEFAULT_HOVER,
            ]);

            /* -----------------------------
         | MAIN GALLERY IMAGES
         -----------------------------*/
            foreach ($validated['main_other_images'] ?? [] as $path) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => $mainColor->id,
                    'image_path' => $path,
                    'image_type' => ProductImageType::GALLERY,
                ]);
            }

            /* -----------------------------
         | COLOR VARIANTS
         -----------------------------*/
            if (!empty($validated['colors'])) {

                foreach ($validated['colors'] as $colorData) {

                    $code = strtoupper(ltrim($colorData['code'], '#'));

                    $color = Coloer::updateOrCreate(
                        ['code' => $code],
                        ['name' => $colorData['name']]
                    );

                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id' => $color->id,
                        'image_path' => $colorData['main_image'],
                        'image_type' => ProductImageType::VARIANT_MAIN,
                    ]);

                    foreach ($colorData['other_images'] ?? [] as $img) {
                        ProductImage::create([
                            'product_id' => $product->id,
                            'color_id' => $color->id,
                            'image_path' => $img,
                            'image_type' => ProductImageType::GALLERY,
                        ]);
                    }

                    foreach ($validated['sizes'] as $sizeId) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_id' => $color->id,
                            'size_id' => $sizeId,
                            'price' => $validated['base_price'],
                            'stock' => 0,
                        ]);
                    }
                }
            } else {
                // NO COLOR VARIANTS
                foreach ($validated['sizes'] as $sizeId) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id' => $mainColor->id,
                        'size_id' => $sizeId,
                        'price' => $validated['base_price'],
                        'stock' => 0,
                    ]);
                }
            }

            return redirect()->route('admin.products')
                ->with('success', 'Product updated successfully!');
        });
    }









    public function destroySectionProducts(Product $product)
    {
        // Optional: Add authorization check
        // $this->authorize('delete', $product);

        try {
            DB::transaction(function () use ($product) {

                // Finally delete the product
                $product->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 500);
        }
    }




    public function destroy(Product $product)
    {
        // Optional: Add authorization check
        // $this->authorize('delete', $product);

        try {
            DB::transaction(function () use ($product) {

                // Finally delete the product
                $product->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 500);
        }
    }




    public function storeCollectionProducts(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            // 'category_id'           => 'required|exists:categories,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'description'           => 'required|string',
            'base_price'            => 'required|numeric|min:0',
            'old_price'             => 'nullable|numeric|min:0',
            'sizes'                 => 'required|array|min:1',
            'sizes.*'               => 'integer|exists:sizes,id',
            'main_image'            => 'required|string',
            'hover_image'           => 'required|string',
            'slug'                  => 'nullable|string|max:200|regex:/^[a-z0-9-]+$/|unique:products,slug',
            'keywords'              => 'nullable|string',
            'show_areas'            => 'nullable|array',
            'show_areas.*'          => 'exists:show_areas,id',

            'main_image_colorname'  => 'required|string',
            'main_image_color_code' => 'required|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
            'main_other_images'     => 'nullable|array',
            'main_other_images.*'   => 'string',
            'size_chart_image' => 'nullable|string',

            'product_id'            => 'required|string|max:100|unique:products,product_id',
            'collection_id'         => 'required|exists:collections,id',


            // Colors can be completely empty — 'present|array' allows empty array
            'colors'                        => 'nullable|array',
            'colors.*.name'                 => 'required_with:colors.*|string|max:100',
            'colors.*.code'                 => 'required_with:colors.*|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
            'colors.*.main_image'           => 'required_with:colors.*|string',
            'colors.*.other_images'         => 'nullable|array',
            'colors.*.other_images.*'       => 'string',


            'main_unavailable_sizes'              => 'nullable|array',
            'main_unavailable_sizes.*'            => 'exists:sizes,id',

            'colors.*.unavailable_sizes'          => 'nullable|array',
            'colors.*.unavailable_sizes.*'        => 'exists:sizes,id',
        ]);

        return DB::transaction(function () use ($validated) {
            // Generate unique slug
            // $slug = $validated['slug'] ?? $this->generateUniqueSlug($validated['name'], $validated['category_id']);

            $primaryCategoryId = $validated['categories'][0];

            $slug = $validated['slug']
                ?? $this->generateUniqueSlug(
                    $validated['name'],
                    $primaryCategoryId
                );

            // 1. Create the main product
            $product = Product::create([
                'category_id' => "1",
                'product_id'  => $validated['product_id'],
                'name'        => $validated['name'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'base_price'  => $validated['base_price'],
                'old_price'   => $validated['old_price'],
                'main_image'  => $validated['main_image'],
                'hover_image' => $validated['hover_image'],
                'keywords'    => $validated['keywords']
                    ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
                    : null,
                'status'      => 'active',
                'size_chart_image' => $validated['size_chart_image'],
                'product_id' => $validated['product_id'],
            ]);


            $product->collections()->sync([$validated['collection_id']]);

            $product->categories()->sync($validated['categories']);


            // Sync show areas if provided
            if (!empty($validated['show_areas'])) {
                $product->showAreas()->sync($validated['show_areas']);
            }

            // 2. Handle MAIN (default) color — ALWAYS required
            $mainColorCode = strtoupper(preg_replace('/^#/', '', $validated['main_image_color_code']));

            $mainColor = Coloer::updateOrCreate(
                ['code' => $mainColorCode],
                ['name' => trim($validated['main_image_colorname'])]
            );

            if (!empty($validated['main_unavailable_sizes'])) {
                $this->storeUnavailableSizes(
                    productId: $product->id,
                    colorId: $mainColor->id,
                    unavailableSizeIds: $validated['main_unavailable_sizes']
                );
            }

            // Save main image as DEFAULT_MAIN
            ProductImage::create([
                'product_id' => $product->id,
                'color_id'   => $mainColor->id,
                'image_path' => $validated['main_image'],
                'image_type' => ProductImageType::DEFAULT_MAIN,
            ]);

            // Save hover image (no color)
            ProductImage::create([
                'product_id' => $product->id,
                'color_id'   => null,
                'image_path' => $validated['hover_image'],
                'image_type' => ProductImageType::DEFAULT_HOVER,
            ]);

            // Save main other/gallery images under main color
            if (!empty($validated['main_other_images'])) {
                $galleryImages = [];
                foreach ($validated['main_other_images'] as $path) {
                    if (!empty(trim($path))) {
                        $galleryImages[] = [
                            'product_id'  => $product->id,
                            'color_id'    => $mainColor->id,
                            'image_path'  => $path,
                            'image_type'  => ProductImageType::GALLERY,
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ];
                    }
                }
                if (!empty($galleryImages)) {
                    ProductImage::insert($galleryImages);
                }
            }

            // 3. Process COLOR VARIANTS — ONLY IF PROVIDED
            if (!empty($validated['colors'])) {
                foreach ($validated['colors'] as $colorData) {
                    // Safety check
                    if (empty($colorData['name']) || empty($colorData['code']) || empty($colorData['main_image'])) {
                        continue;
                    }

                    $cleanCode = strtoupper(preg_replace('/^#/', '', $colorData['code']));
                    if (!preg_match('/^[0-9A-F]{6}$/', $cleanCode)) {
                        continue;
                    }

                    $color = Coloer::updateOrCreate(
                        ['code' => $cleanCode],
                        ['name' => trim($colorData['name'])]
                    );


                    if (!empty($colorData['unavailable_sizes'])) {
                        $this->storeUnavailableSizes(
                            productId: $product->id,
                            colorId: $color->id,
                            unavailableSizeIds: $colorData['unavailable_sizes']
                        );
                    }

                    // Save variant main image
                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id'   => $color->id,
                        'image_path' => $colorData['main_image'],
                        'image_type' => ProductImageType::VARIANT_MAIN,
                    ]);

                    // Save variant gallery images
                    if (!empty($colorData['other_images'])) {
                        foreach ($colorData['other_images'] as $path) {
                            if (!empty(trim($path))) {
                                ProductImage::create([
                                    'product_id' => $product->id,
                                    'color_id'   => $color->id,
                                    'image_path' => $path,
                                    'image_type' => ProductImageType::GALLERY,
                                ]);
                            }
                        }
                    }

                    // Create variants (color + size)
                    foreach ($validated['sizes'] as $sizeId) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_id'   => $color->id,
                            'size_id'    => $sizeId,
                            'price'      => $validated['base_price'],
                            'stock'      => 0,
                        ]);
                    }
                }
            } else {
                // NO COLOR VARIANTS — create variants using only the MAIN color
                foreach ($validated['sizes'] as $sizeId) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id'   => $mainColor->id,
                        'size_id'    => $sizeId,
                        'price'      => $validated['base_price'],
                        'stock'      => 0,
                    ]);
                }
            }

            return redirect()->route('admin.products')
                ->with('success', 'Product added successfully!');
        });
    }

    // public function editCollectionProducts(Product $product)
    // {
    //     $relations = [
    //         'images',
    //         'showAreas',
    //         'collections',
    //         'categories'
    //     ];


    //     $hasVariantMainImages = $product->images()
    //         ->where('image_type', ProductImageType::VARIANT_MAIN)
    //         ->exists();

    //     if ($hasVariantMainImages) {

    //         $relations[] = 'variants.color';
    //         $relations[] = 'variants.size';
    //     }

    //     $product->load($relations);

    //     $mainImage = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
    //     $mainColor = $mainImage?->color;

    //     $collections = Collection::all();
    //     $categories = getAllCategories();


    //     return view('products.collection.edit', compact(
    //         'product',
    //         'mainColor',
    //         'collections',
    //         'categories',

    //     ));
    // }

    public function editCollectionProducts(Product $product)
    {
        // Base relations
        $relations = [
            'images',
            'showAreas',
            'collections',
            'categories',
        ];

        // Check if product has variant main images
        $hasVariantMainImages = $product->images()
            ->where('image_type', ProductImageType::VARIANT_MAIN)
            ->exists();

        if ($hasVariantMainImages) {
            $relations[] = 'variants.color';
            $relations[] = 'variants.size';
        }

        // Load relations
        $product->load($relations);

        // MAIN IMAGE & COLOR
        $mainImage = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
        $mainColor = $mainImage?->color;

        // 🔑 UNAVAILABLE SIZES (grouped by color_id)
        $unavailableSizesByColor = ProductVariantAvailability::where('product_id', $product->id)
            ->where('status', ProductVariantAvailabilityStatus::UNAVAILABLE->value)
            ->get()
            ->groupBy('color_id')
            ->map(fn($rows) => $rows->pluck('size_id')->toArray());

        // Collections & categories for select dropdowns
        $collections = Collection::all();
        $categories = getAllCategories();

        return view('products.collection.edit', compact(
            'product',
            'mainColor',
            'collections',
            'categories',
            'unavailableSizesByColor'
        ));
    }


    public function storeSectionProducts(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'category_id'           => 'required|exists:categories,id',
            'description'           => 'required|string',
            'base_price'            => 'required|numeric|min:0',
            'old_price'             => 'nullable|numeric|min:0',
            'sizes'                 => 'required|array|min:1',
            'sizes.*'               => 'integer|exists:sizes,id',
            'main_image'            => 'required|string',
            'hover_image'           => 'required|string',
            'slug'                  => 'nullable|string|max:200|regex:/^[a-z0-9-]+$/|unique:products,slug',
            'keywords'              => 'nullable|string',
            'show_areas'            => 'nullable|array',
            'show_areas.*'          => 'exists:show_areas,id',

            'main_image_colorname'  => 'required|string',
            'main_image_color_code' => 'required|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
            'main_other_images'     => 'nullable|array',
            'main_other_images.*'   => 'string',
            'size_chart_image' => 'nullable|string',

            'product_id'            => 'required|string|max:100|unique:products,product_id',
            'section_id'         => 'required|exists:new_sections,id',


            // Colors can be completely empty — 'present|array' allows empty array
            'colors'                        => 'nullable|array',
            'colors.*.name'                 => 'required_with:colors.*|string|max:100',
            'colors.*.code'                 => 'required_with:colors.*|string|regex:/^#?[0-9A-Fa-f]{6}$/i',
            'colors.*.main_image'           => 'required_with:colors.*|string',
            'colors.*.other_images'         => 'nullable|array',
            'colors.*.other_images.*'       => 'string',
        ]);

        return DB::transaction(function () use ($validated) {
            // Generate unique slug
            $slug = $validated['slug'] ?? $this->generateUniqueSlug($validated['name'], $validated['category_id']);

            // 1. Create the main product
            $product = Product::create([
                'category_id' => $validated['category_id'],
                'product_id'  => $validated['product_id'],
                'name'        => $validated['name'],
                'slug'        => $slug,
                'description' => $validated['description'],
                'base_price'  => $validated['base_price'],
                'old_price'   => $validated['old_price'],
                'main_image'  => $validated['main_image'],
                'hover_image' => $validated['hover_image'],
                'keywords'    => $validated['keywords']
                    ? json_encode(array_map('trim', explode(',', $validated['keywords'])))
                    : null,
                'status'      => 'active',
                'size_chart_image' => $validated['size_chart_image'],
                'product_id' => $validated['product_id'],
            ]);


            if (!empty($validated['section_id'])) {
                $product->sections()->sync($validated['section_id']);
            }
            // Sync show areas if provided
            if (!empty($validated['show_areas'])) {
                $product->showAreas()->sync($validated['show_areas']);
            }

            // 2. Handle MAIN (default) color — ALWAYS required
            $mainColorCode = strtoupper(preg_replace('/^#/', '', $validated['main_image_color_code']));

            $mainColor = Coloer::updateOrCreate(
                ['code' => $mainColorCode],
                ['name' => trim($validated['main_image_colorname'])]
            );

            // Save main image as DEFAULT_MAIN
            ProductImage::create([
                'product_id' => $product->id,
                'color_id'   => $mainColor->id,
                'image_path' => $validated['main_image'],
                'image_type' => ProductImageType::DEFAULT_MAIN,
            ]);

            // Save hover image (no color)
            ProductImage::create([
                'product_id' => $product->id,
                'color_id'   => null,
                'image_path' => $validated['hover_image'],
                'image_type' => ProductImageType::DEFAULT_HOVER,
            ]);

            // Save main other/gallery images under main color
            if (!empty($validated['main_other_images'])) {
                $galleryImages = [];
                foreach ($validated['main_other_images'] as $path) {
                    if (!empty(trim($path))) {
                        $galleryImages[] = [
                            'product_id'  => $product->id,
                            'color_id'    => $mainColor->id,
                            'image_path'  => $path,
                            'image_type'  => ProductImageType::GALLERY,
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ];
                    }
                }
                if (!empty($galleryImages)) {
                    ProductImage::insert($galleryImages);
                }
            }

            // 3. Process COLOR VARIANTS — ONLY IF PROVIDED
            if (!empty($validated['colors'])) {
                foreach ($validated['colors'] as $colorData) {
                    // Safety check
                    if (empty($colorData['name']) || empty($colorData['code']) || empty($colorData['main_image'])) {
                        continue;
                    }

                    $cleanCode = strtoupper(preg_replace('/^#/', '', $colorData['code']));
                    if (!preg_match('/^[0-9A-F]{6}$/', $cleanCode)) {
                        continue;
                    }

                    $color = Coloer::updateOrCreate(
                        ['code' => $cleanCode],
                        ['name' => trim($colorData['name'])]
                    );

                    // Save variant main image
                    ProductImage::create([
                        'product_id' => $product->id,
                        'color_id'   => $color->id,
                        'image_path' => $colorData['main_image'],
                        'image_type' => ProductImageType::VARIANT_MAIN,
                    ]);

                    // Save variant gallery images
                    if (!empty($colorData['other_images'])) {
                        foreach ($colorData['other_images'] as $path) {
                            if (!empty(trim($path))) {
                                ProductImage::create([
                                    'product_id' => $product->id,
                                    'color_id'   => $color->id,
                                    'image_path' => $path,
                                    'image_type' => ProductImageType::GALLERY,
                                ]);
                            }
                        }
                    }

                    // Create variants (color + size)
                    foreach ($validated['sizes'] as $sizeId) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'color_id'   => $color->id,
                            'size_id'    => $sizeId,
                            'price'      => $validated['base_price'],
                            'stock'      => 0,
                        ]);
                    }
                }
            } else {
                // NO COLOR VARIANTS — create variants using only the MAIN color
                foreach ($validated['sizes'] as $sizeId) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id'   => $mainColor->id,
                        'size_id'    => $sizeId,
                        'price'      => $validated['base_price'],
                        'stock'      => 0,
                    ]);
                }
            }

            return redirect()->route('admin.products')
                ->with('success', 'Product added successfully!');
        });
    }




    private function generateUniqueSlug(string $name, int $categoryId): string
    {
        $category = Category::findOrFail($categoryId);
        $categorySlug = Str::slug($category->name);
        $productSlug  = Str::slug($name);

        $baseSlug = $categorySlug . '-' . $productSlug;

        if (strlen($baseSlug) > 100) {
            $baseSlug = substr($baseSlug, 0, 100);
            $baseSlug = rtrim($baseSlug, '-');
        }

        $slug = $baseSlug;

        if (Product::where('slug', $slug)->exists()) {
            $counter = 1;
            do {
                $candidateSlug = "{$baseSlug}-{$counter}";
                $counter++;
            } while (Product::where('slug', $candidateSlug)->exists());

            $slug = $candidateSlug;
        }

        return $slug;
    }





    // for the dataTable

    // public function adminCollectionProductsList()
    // {
    //     $products = Product::with(['category', 'collections', 'showAreas'])
    //         ->whereHas('collections') // ONLY collection products
    //         ->latest('created_at')
    //         ->get();

    //     return response()->json([
    //         'data' => $this->formatAdminProducts($products)
    //     ]);
    // }

    public function adminCollectionProductsList()
    {
        $products = Product::with(['categories', 'collections', 'showAreas'])
            ->whereHas('collections') // ONLY collection products
            ->latest('created_at')
            ->get();

        // Inject category name string for formatter compatibility
        $products->each(function ($product) {
            $product->setRelation(
                'category',
                (object)[
                    'name' => $product->categories->pluck('name')->implode(', ')
                ]
            );
        });

        return response()->json([
            'data' => $this->formatAdminProducts($products)
        ]);
    }


    public function adminSectionProductsList()
    {
        $products = Product::with(['category', 'sections', 'showAreas'])
            ->whereHas('sections') // ONLY section products
            ->latest('created_at')
            ->get();

        return response()->json([
            'data' => $this->formatAdminSectionProducts($products)
        ]);
    }

    public function toggleCollectionProductSoldOut(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sold_out' => 'required|boolean',
        ]);

        $product->sold_out = (bool) $validated['sold_out'];
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Sold out status updated successfully.',
            'sold_out' => (bool) $product->sold_out,
        ]);
    }


    private function formatAdminSectionProducts($products)
    {
        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => $product->category?->name ?? '-',

                // Sections only ✅
                'sections' => $product->sections->isNotEmpty()
                    ? $product->sections->pluck('name')->implode(', ')
                    : '-',

                // Show areas
                'show_areas' => $product->showAreas->isNotEmpty()
                    ? $product->showAreas->pluck('name')->implode(', ')
                    : '-',
            ];
        });
    }



    // public function adminProductsListview()
    // {
    //     // $products = Product::with(['category', 'collections', 'showAreas'])
    //     //     ->latest('created_at')
    //     //     ->get();


    //     $products = Product::with(['category', 'collections', 'showAreas'])
    //         ->whereNotIn('id', function ($query) {
    //             $query->select('product_id')->from('collection_product');
    //         })
    //         ->latest('created_at')
    //         ->get();


    //     return response()->json([
    //         'data' => $this->formatAdminProducts($products)
    //     ]);
    // }

    public function adminProductsListview()
    {
        $products = Product::with(['categories', 'collections', 'showAreas'])
            ->whereNotIn('id', function ($query) {
                $query->select('product_id')->from('collection_product');
            })
            ->latest('created_at')
            ->get();

        return response()->json([
            'data' => $this->formatAdminProducts($products)
        ]);
    }

    private function formatAdminProducts($products)
    {
        return $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => $product->categories->isNotEmpty()
                    ? $product->categories->pluck('name')->implode(', ')
                    : '-',
                // Collections (empty if none)
                'collections' => $product->collections->isNotEmpty()
                    ? $product->collections->pluck('name')->implode(', ')
                    : '-',
                'sold_out' => (bool) $product->sold_out,

                // Show areas (empty if none)
                'show_areas' => $product->showAreas->isNotEmpty()
                    ? $product->showAreas->pluck('name')->implode(', ')
                    : '-',
            ];
        });
    }







    // for the frontend


    public function getNewAFashion(Request $request)
    {
        $perPage = $request->input('per_page', 20); // Allow frontend to control (like shop page)

        $products = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereHas('showAreas', function ($query) {
                $query->where('key', 'new_arrival');
            })
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->paginate($perPage);

        $formatted = $products->getCollection()->map(fn($product) => $this->prepareProductFormat($product));

        \Log::info($formatted);

        return response()->json([
            'data'         => $formatted,
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
            'total'        => $products->total(),
            'per_page'     => $perPage,
            // You can include filters if needed, but not required for New Arrivals
            // 'filters'   => getShopFilters(),
        ]);
    }



    public function getNewArrivals(Request $request)
    {
        $perPage = 4;

        // \Log::info($request->all());

        $products = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereHas('showAreas', function ($query) {
                $query->where('key', 'new_arrival'); // filter by show_area key
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);



        // \Log::info($products);


        $formatted = $products->map(function ($product) {
            return $this->prepareProductFormat($product);
        });



        // \Log::info($formatted->toArray());



        return response()->json([
            'data' => $formatted,
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'total' => $products->total(),
            'per_page' => $perPage,
        ]);
    }

    public function getTrendingNow()
    {
        $perPage = 4;

        $products = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereHas('showAreas', function ($query) {
                $query->where('key', 'trending');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $formatted = $products->map(function ($product) {
            return $this->prepareProductFormat($product);
        });


        // \Log::info($formatted);
        return response()->json([
            'data' => $formatted,
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'total' => $products->total(),
            'per_page' => $perPage,
        ]);
    }

    public function getBestSales()
    {

        $perPage = 4;

        $products = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereHas('showAreas', function ($query) {
                $query->where('key', 'best_sale'); // filter by show_area key
            })
            ->paginate($perPage);

        $formatted = $products->map(function ($product) {
            return $this->prepareProductFormat($product);
        });


        // \Log::info($formatted);
        return response()->json([
            'data' => $formatted,
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'total' => $products->total(),
            'per_page' => $perPage,
        ]);
    }



    public function getShopGrams()
    {
        $perPage = 5;

        $products = Product::with(['images', 'showAreas'])
            ->whereHas('showAreas', function ($query) {
                $query->where('key', 'shop_gram');
            })
            ->latest()
            ->paginate($perPage);

        $formatted = $products->getCollection()->map(function ($product) {
            return $this->shopGramFormat($product);
        });

        return response()->json([
            'data'         => $formatted,
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
            'total'        => $products->total(),
            'per_page'     => $perPage,
        ]);
    }


    private function shopGramFormat(Product $product)
    {
        // Load only what we need
        $product->loadMissing(['images']);

        /* ---------------------------------------
     | MAIN IMAGE (DEFAULT_MAIN)
     ---------------------------------------*/
        $mainImageRecord = $product->images
            ->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

        $mainImage = $mainImageRecord
            ? R2Helper::getFileUrl($mainImageRecord->image_path)
            : null;

        /* ---------------------------------------
     | SHOP GRAM FORMAT
     ---------------------------------------*/
        return [
            'slug'   => $product->slug,
            'imgSrc' => $mainImage,
            'alt'    => $product->name,
            'title'  => $product->name,
        ];
    }






    public function getRecentviews(Request $request)
    {
        $perPage = 4;         // number of products per page
        $randomCount = 10;    // number of random products to add
        $page = max((int) $request->get('page', 1), 1);

        /* ---------------- RECENTLY VIEWED (ROTATING) ---------------- */
        $recentQuery = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereHas('showAreas', function ($query) {
                $query->where('key', 'recently_viewed');
            })
            ->orderBy('created_at', 'asc');

        $recentTotal = $recentQuery->count();
        $offset = ($page - 1) * $perPage;

        if ($offset >= $recentTotal) {
            $offset = 0;   // restart rotation if offset exceeds total
            $page = 1;
        }

        $recentProducts = $recentQuery
            ->skip($offset)
            ->take($perPage)
            ->get();

        // Format recent products
        $recentFormatted = collect($recentProducts)->map(function ($product) {
            return $this->prepareProductFormat($product);
        });

        /* ---------------- RANDOM PRODUCTS ---------------- */
        $excludeIds = $recentProducts->pluck('id')->toArray();

        $randomProducts = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereNotIn('id', $excludeIds)
            ->inRandomOrder()
            ->limit($randomCount)
            ->get();

        // Format random products
        $randomFormatted = collect($randomProducts)->map(function ($product) {
            return $this->prepareProductFormat($product);
        });

        /* ---------------- MERGE BOTH ---------------- */
        $mergedProducts = $recentFormatted->merge($randomFormatted)->values();

        /* ---------------- PAGINATE MERGED ---------------- */
        $paginator = new LengthAwarePaginator(
            $mergedProducts,
            $mergedProducts->count(),  // total items for paginator
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        /* ---------------- RESPONSE ---------------- */
        return response()->json([
            'data' => $paginator->items(),     // merged products
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
        ]);
    }



    public function getPeopleBoughts(Request $request)
    {
        $perPage = 4;
        $page = max((int) $request->get('page', 1), 1);

        /* ----------------------------------------------------
     | 1. PRODUCTS FROM ORDERS (MOST BOUGHT / RECENT)
     ---------------------------------------------------- */
        $orderedProductIds = DB::table('order_items')
            ->whereNotNull('product_id')
            ->select('product_id', DB::raw('COUNT(*) as total'))
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->pluck('product_id')
            ->toArray();

        $orderedProducts = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereIn('id', $orderedProductIds)
            ->get();

        /* ----------------------------------------------------
     | 2. PRODUCTS FROM SHOW AREA (people_bought)
     ---------------------------------------------------- */
        $showAreaProducts = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereHas('showAreas', function ($q) {
                $q->where('key', 'people_bought');
            })
            ->get();

        /* ----------------------------------------------------
     | 3. RANDOM PRODUCTS (EXCLUDING ABOVE)
     ---------------------------------------------------- */
        $excludeIds = collect($orderedProducts)
            ->merge($showAreaProducts)
            ->pluck('id')
            ->unique()
            ->toArray();

        $randomProducts = Product::with(['images', 'variants.color', 'variants.size', 'showAreas'])
            ->whereNotIn('id', $excludeIds)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        /* ----------------------------------------------------
     | 4. MERGE + SHUFFLE (VERY IMPORTANT)
     ---------------------------------------------------- */
        $allProducts = collect()
            ->merge($orderedProducts)
            ->merge($showAreaProducts)
            ->merge($randomProducts)
            ->unique('id')
            ->shuffle()
            ->values();

        /* ----------------------------------------------------
     | 5. MANUAL PAGINATION
     ---------------------------------------------------- */
        $total = $allProducts->count();
        $items = $allProducts->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        /* ----------------------------------------------------
     | 6. FORMAT PRODUCTS (KEEP YOUR FORMAT)
     ---------------------------------------------------- */
        $formatted = collect($paginator->items())->map(function ($product) {
            return $this->prepareProductFormat($product);
        });

        /* ----------------------------------------------------
     | 7. ALWAYS SAME RESPONSE FORMAT ✅
     ---------------------------------------------------- */
        return response()->json([
            'data' => $formatted,
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
        ]);
    }

    // this is for the shop  page and other category page items

    // for the product format


    // private function prepareProductFormat(Product $product)
    // {
    //     /* -------------------------------------------------
    //  | EAGER LOAD IMAGES AND RELATIONS
    //  -------------------------------------------------*/
    //     $product->loadMissing(['images', 'variants.color', 'variants.size']);

    //     /* -------------------------------------------------
    //  | DEFAULT MAIN & HOVER IMAGES
    //  -------------------------------------------------*/
    //     $mainImageRecord  = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
    //     $hoverImageRecord = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_HOVER);

    //     $mainImage  = $mainImageRecord ? R2Helper::getFileUrl($mainImageRecord->image_path) : null;
    //     $hoverImage = $hoverImageRecord ? R2Helper::getFileUrl($hoverImageRecord->image_path) : null;

    //     /* -------------------------------------------------
    //  | DEFAULT MAIN COLOR DATA
    //  -------------------------------------------------*/
    //     $mainColorData = null;
    //     if ($mainImageRecord) {
    //         $color = $mainImageRecord->color; // eager loaded

    //         $mainColorData = [
    //             'name'   => $color?->name ?? 'Default',
    //             'code'   => $color?->code ?? null,
    //             'imgSrc' => $mainImage,
    //             'disabledSizes' => [],

    //         ];
    //     }

    //     /* -------------------------------------------------
    //  | VARIANT COLORS (USE COLLECTION FILTER INSTEAD OF QUERY)
    //  -------------------------------------------------*/
    //     // $variantImages = $product->images
    //     //     ->where('image_type', ProductImageType::VARIANT_MAIN)
    //     //     ->keyBy(fn($img) => $img->color_id);

    //     // $variantColors = $product->variants
    //     //     ->groupBy('color_id')
    //     //     ->map(function ($group) use ($variantImages) {
    //     //         $color = $group->first()->color;
    //     //         $image = $variantImages[$color->id] ?? null;

    //     //         return [
    //     //             'name'   => $color->name,
    //     //             'code'   => $color->code,
    //     //             'imgSrc' => $image ? R2Helper::getFileUrl($image->image_path) : null,
    //     //         ];
    //     //     })
    //     //     ->values();



    //     $variantMainImages = $product->images
    //         ->where('image_type', ProductImageType::VARIANT_MAIN)
    //         ->keyBy('color_id');

    //     // Get variant colors — BUT only if there are VARIANT_MAIN images
    //     $variantColors = collect();

    //     if ($variantMainImages->isNotEmpty()) {
    //         $variantColors = $product->variants
    //             ->groupBy('color_id')
    //             ->map(function ($group) use ($variantMainImages, $product) {
    //                 $color = $group->first()->color;
    //                 $image = $variantMainImages->get($color->id);

    //                 $disabledSizes = \App\Models\ProductVariantAvailability::where('product_id', $product->id)
    //                     ->where('color_id', $color->id)
    //                     ->whereIn('status', [
    //                         \App\Enums\ProductVariantAvailabilityStatus::SOLD_OUT->value,
    //                         \App\Enums\ProductVariantAvailabilityStatus::UNAVAILABLE->value,
    //                     ])
    //                     ->pluck('size_id')
    //                     ->toArray();

    //                 return [
    //                     'name'   => $color->name,
    //                     'code'   => $color->code,
    //                     'imgSrc' => $image ? R2Helper::getFileUrl($image->image_path) : null,
    //                     'disabledSizes' => $disabledSizes
    //                 ];
    //             })
    //             ->values();
    //     }



    //     /* -------------------------------------------------
    //  | MERGE DEFAULT MAIN COLOR WITH VARIANTS
    //  -------------------------------------------------*/
    //     $colors = collect();
    //     if ($mainColorData) $colors->push($mainColorData);
    //     $colors = $colors->merge($variantColors)->values();

    //     /* -------------------------------------------------
    //  | UNIQUE SIZES
    // //  -------------------------------------------------*/
    //     //     $sizes = $product->variants
    //     //         ->pluck('size.name')
    //     //         ->unique()
    //     //         ->values()
    //     //         ->toArray();


    //     $sizes = $product->variants
    //         ->map(fn($v) => ['id' => $v->size->id, 'name' => $v->size->name])
    //         ->unique('id')
    //         ->values()
    //         ->toArray();
    //     /* -------------------------------------------------
    //  | CHECK AVAILABILITY
    //  -------------------------------------------------*/
    //     $isAvailable = $product->variants->sum('stock') > 0;

    //     /* -------------------------------------------------
    //  | FILTER CATEGORIES (show_area)
    //  -------------------------------------------------*/
    //     $filterCategories = [];
    //     if ($product->show_area) {
    //         $showAreas = is_array($product->show_area)
    //             ? $product->show_area
    //             : json_decode($product->show_area, true);

    //         if (in_array('new_arrival', $showAreas)) $filterCategories[] = 'New arrivals';
    //         if (in_array('trending', $showAreas)) $filterCategories[] = 'Trending';
    //     }

    //     /* -------------------------------------------------
    //  | FINAL PRODUCT DATA
    //  -------------------------------------------------*/
    //     return [
    //         'id'               => $product->id,
    //         'imgSrc'           => $mainImage,
    //         'imgHoverSrc'      => $hoverImage,
    //         'title'            => $product->name,
    //         'price'            => (float) $product->base_price,
    //         'oldPrice'         => (float) $product->old_price ?? null,
    //         'colors'           => $colors,
    //         'sizes'            => $sizes,
    //         'filterCategories' => $filterCategories,
    //         'brand'            => 'YourBrand',
    //         'isAvailable'      => $isAvailable,
    //         'slug'             => $product->slug,
    //     ];
    // }


    private function prepareProductFormat(Product $product)
    {
        /* -------------------------------------------------
     | EAGER LOAD RELATIONS (IMPORTANT)
     -------------------------------------------------*/
        $product->loadMissing([
            'images.color',
            'variants.color',
            'variants.size',
        ]);

        /* -------------------------------------------------
     | DEFAULT MAIN & HOVER IMAGES
     -------------------------------------------------*/
        $mainImageRecord  = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
        $hoverImageRecord = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_HOVER);

        $mainImage  = $mainImageRecord ? R2Helper::getFileUrl($mainImageRecord->image_path) : null;
        $hoverImage = $hoverImageRecord ? R2Helper::getFileUrl($hoverImageRecord->image_path) : null;

        /* -------------------------------------------------
     | AVAILABILITY MAP (ONE QUERY)
     -------------------------------------------------*/
        $availabilityMap = \App\Models\ProductVariantAvailability::where('product_id', $product->id)
            ->whereIn('status', [
                \App\Enums\ProductVariantAvailabilityStatus::SOLD_OUT->value,
                \App\Enums\ProductVariantAvailabilityStatus::UNAVAILABLE->value,
            ])
            ->get()
            ->groupBy('color_id')
            ->map(fn($rows) => $rows->pluck('size_id')->toArray());

        /* -------------------------------------------------
     | BUILD COLORS COLLECTION
     -------------------------------------------------*/
        $colors = collect();
        $addedColorIds = collect();

        /* ---------- DEFAULT MAIN COLOR ---------- */
        if ($mainImageRecord && $mainImageRecord->color) {
            $color = $mainImageRecord->color;

            $addedColorIds->push($color->id);

            $colors->push([
                'name'          => $color->name ?? 'Default',
                'code'          => $color->code ?? '#cccccc',
                'imgSrc'        => $mainImage,
                'disabledSizes' => $availabilityMap[$color->id] ?? [],
            ]);
        }

        /* ---------- VARIANT COLORS ---------- */
        $variantColors = $product->variants
            ->groupBy('color_id')
            ->map(function ($variants, $colorId) use ($product, $availabilityMap, $addedColorIds) {
                if ($addedColorIds->contains($colorId)) {
                    return null;
                }

                $color = $variants->first()->color;
                if (!$color) return null;

                $addedColorIds->push($colorId);

                $image = $product->images
                    ->where('color_id', $colorId)
                    ->firstWhere('image_type', ProductImageType::VARIANT_MAIN)
                    ?? $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

                return [
                    'name'          => $color->name,
                    'code'          => $color->code ?? '#cccccc',
                    'imgSrc'        => $image ? R2Helper::getFileUrl($image->image_path) : null,
                    'disabledSizes' => $availabilityMap[$colorId] ?? [],
                ];
            })
            ->filter()
            ->values();

        $colors = $colors->merge($variantColors)->values();

        /* -------------------------------------------------
     | UNIQUE SIZES (SAFE ID FORMAT)
     -------------------------------------------------*/
        $sizes = $product->variants
            ->map(fn($v) => [
                'id'   => $v->size->id,
                'name' => $v->size->name,
            ])
            ->unique('id')
            ->values()
            ->toArray();

        /* -------------------------------------------------
     | AVAILABILITY
     -------------------------------------------------*/
        $isAvailable = $product->variants->sum('stock') > 0;

        /* -------------------------------------------------
     | FILTER CATEGORIES
     -------------------------------------------------*/
        $filterCategories = [];
        if ($product->show_area) {
            $showAreas = is_array($product->show_area)
                ? $product->show_area
                : json_decode($product->show_area, true);

            if (in_array('new_arrival', $showAreas)) $filterCategories[] = 'New arrivals';
            if (in_array('trending', $showAreas)) $filterCategories[] = 'Trending';
        }

        /* -------------------------------------------------
     | FINAL RESPONSE
     -------------------------------------------------*/
        return [
            'id'               => $product->id,
            'imgSrc'           => $mainImage,
            'imgHoverSrc'      => $hoverImage,
            'title'            => $product->name,
            'price'            => (float) $product->base_price,
            'oldPrice'         => (float) $product->old_price ?? null,
            'colors'           => $colors,
            'sizes'            => $sizes,
            'filterCategories' => $filterCategories,
            'brand'            => 'YourBrand',
            'isAvailable'      => $isAvailable,
            'soldOut'          => (bool) $product->sold_out,
            'slug'             => $product->slug,
        ];
    }






    // private function prepareProductFormat(Product $product)
    // {
    //     $product->loadMissing(['images', 'variants.color', 'variants.size']);

    //     // --- Default images ---
    //     $mainImageRecord  = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
    //     $hoverImageRecord = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_HOVER);

    //     $mainImage  = $mainImageRecord ? R2Helper::getFileUrl($mainImageRecord->image_path) : null;
    //     $hoverImage = $hoverImageRecord ? R2Helper::getFileUrl($hoverImageRecord->image_path) : null;

    //     // --- Main color ---
    //     $mainColorData = null;
    //     if ($mainImageRecord) {
    //         $color = $mainImageRecord->color;
    //         $mainColorData = [
    //             'id' => $color?->id,
    //             'name'   => $color?->name ?? 'Default',
    //             'code'   => $color?->code ?? null,
    //             'imgSrc' => $mainImage,
    //             'disabledSizes' => [], // We'll fill this next
    //         ];
    //     }

    //     // --- Variant main images ---
    //     $variantMainImages = $product->images
    //         ->where('image_type', ProductImageType::VARIANT_MAIN)
    //         ->keyBy('color_id');

    //     $variantColors = collect();
    //     if ($variantMainImages->isNotEmpty()) {
    //         $variantColors = $product->variants
    //             ->groupBy('color_id')
    //             ->map(function ($group) use ($variantMainImages, $product) {

    //                 $color = $group->first()->color;
    //                 $image = $variantMainImages->get($color->id);

    //                 // Get unavailable size IDs from ProductVariantAvailability table
    //                 $disabledSizes = \App\Models\ProductVariantAvailability::where('product_id', $product->id)
    //                     ->where('color_id', $color->id)
    //                     ->whereIn('status', [
    //                         \App\Enums\ProductVariantAvailabilityStatus::SOLD_OUT->value,
    //                         \App\Enums\ProductVariantAvailabilityStatus::UNAVAILABLE->value,
    //                     ])
    //                     ->pluck('size_id')
    //                     ->toArray();

    //                 return [
    //                     'id' => $color->id,
    //                     'name'   => $color->name,
    //                     'code'   => $color->code,
    //                     'imgSrc' => $image ? R2Helper::getFileUrl($image->image_path) : null,
    //                     'disabledSizes' => $disabledSizes,
    //                 ];
    //             })
    //             ->values();
    //     }

    //     // --- Merge main + variant colors ---
    //     $colors = collect();
    //     if ($mainColorData) $colors->push($mainColorData);
    //     $colors = $colors->merge($variantColors)->values();

    //     // --- Sizes ---
    //     $sizes = $product->variants
    //         ->map(fn($v) => ['id' => $v->size->id, 'name' => $v->size->name])
    //         ->unique('id')
    //         ->values()
    //         ->toArray();

    //     $isAvailable = $product->variants->sum('stock') > 0;

    //     return [
    //         'id' => $product->id,
    //         'slug' => $product->slug,
    //         'title' => $product->name,
    //         'price' => (float) $product->base_price,
    //         'imgSrc' => $mainImage,
    //         'imgHoverSrc' => $hoverImage,
    //         'colors' => $colors,
    //         'sizes' => $sizes,
    //         'isAvailable' => $isAvailable,
    //     ];
    // }


    public function getProductDetails(string $slug)
    {
        \Log::info("Fetching product for slug: $slug");

        try {
            $product = Product::where('slug', $slug)
                ->with([
                    'images.color',
                    'variants.color',
                    'variants.size',
                ])
                ->firstOrFail();

            $data = $this->prepareProductDetailsFormat($product);

            // \Log::info($data)->toArray();

            \Log::info("Product data prepared for slug: $slug"); // ✅ don't log $product directly


            \Log::info(
                'Product details data: ' . json_encode($data, JSON_PRETTY_PRINT)
            );

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::warning("Product not found: $slug");
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        } catch (\Exception $e) {
            \Log::error("Product fetch error: {$e->getMessage()}");
            return response()->json([
                'success' => false,
                'message' => 'Server error',
            ], 500);
        }
    }

    // private function prepareProductDetailsFormat(Product $product)
    // {
    //     // Load relations
    //     $product->loadMissing([
    //         'images.color',
    //         'variants.color',
    //         'variants.size',
    //     ]);

    //     /* -------------------------------------------------
    //  | DEFAULT MAIN & HOVER IMAGES
    //  -------------------------------------------------*/
    //     $defaultMainRecord = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
    //     $defaultHoverRecord = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_HOVER);

    //     $defaultImage = $defaultMainRecord ? R2Helper::getFileUrl($defaultMainRecord->image_path) : null;
    //     $hoverImage   = $defaultHoverRecord ? R2Helper::getFileUrl($defaultHoverRecord->image_path) : $defaultImage;

    //     /* -------------------------------------------------
    //  | GROUP IMAGES BY COLOR
    //  -------------------------------------------------*/
    //     $imagesByColor = $product->images->groupBy('color_id');

    //     /* -------------------------------------------------
    //  | BUILD ALL COLORS (including default main as first color)
    //  -------------------------------------------------*/
    //     $colors = collect();

    //     // 1. Add DEFAULT MAIN as the first color (even if no color_id)
    //     if ($defaultMainRecord) {
    //         $mainColorName = $defaultMainRecord->color?->name ?? 'Default';
    //         $mainColorCode = $defaultMainRecord->color?->code ?? '#cccccc'; // fallback gray

    //         // Gallery for default color
    //         $defaultGalleryImages = ($imagesByColor[$defaultMainRecord->color_id] ?? collect())
    //             ->whereIn('image_type', [ProductImageType::GALLERY, ProductImageType::DEFAULT_MAIN]);

    //         $mainGallery = $defaultGalleryImages
    //             ->map(fn($img) => [
    //                 'id'        => $img->id,
    //                 'imgSrc'    => R2Helper::getFileUrl($img->image_path),
    //                 'imgAlt'    => $mainColorName . ' variant',
    //                 'imgWidth'  => 400,
    //                 'imgHeight' => 400,
    //                 'title'     => $product->name,
    //                 'price'     => (float) $product->base_price,
    //                 'tooltip'   => "Quick View",
    //             ])
    //             ->values()
    //             ->toArray();

    //         $colors->push([
    //             'name'    => $mainColorName,
    //             'code'    => $mainColorCode,        // ← Real hex code
    //             'imgSrc'  => $defaultImage,
    //             'gallery' => $mainGallery,
    //         ]);
    //     }

    //     // 2. Add all variant colors


    //     $variantColors = $product->variants
    //         ->groupBy('color_id')
    //         ->map(function ($variants, $colorId) use ($imagesByColor, $product) {
    //             $color = $variants->first()->color;
    //             $images = $imagesByColor[$colorId] ?? collect();

    //             $mainImage = $images->firstWhere('image_type', ProductImageType::VARIANT_MAIN)
    //                 ?? $images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

    //             $mainImageUrl = $mainImage ? R2Helper::getFileUrl($mainImage->image_path) : null;

    //             $gallery = $images
    //                 ->whereIn('image_type', [ProductImageType::GALLERY, ProductImageType::VARIANT_MAIN])
    //                 ->map(fn($img) => [
    //                     'id'        => $img->id,
    //                     'imgSrc'    => R2Helper::getFileUrl($img->image_path),
    //                     'imgAlt'    => $color->name . ' variant',
    //                     'imgWidth'  => 400,
    //                     'imgHeight' => 400,
    //                     'title'     => $product->name,
    //                     'price'     => (float) $product->base_price,
    //                     'tooltip'   => "Quick View",
    //                 ])
    //                 ->values()
    //                 ->toArray();

    //             return [
    //                 'name'    => $color->name,
    //                 'code'    => $color->code ?? '#cccccc',
    //                 'imgSrc'  => $mainImageUrl,
    //                 'gallery' => $gallery,
    //             ];
    //         })
    //         ->values();

    //     $colors = $colors->merge($variantColors)->values()->toArray();

    //     /* -------------------------------------------------
    //  | SIZES
    //  -------------------------------------------------*/
    //     $sizes = $product->variants
    //         ->pluck('size.name')
    //         ->filter()
    //         ->unique()
    //         ->values()
    //         ->toArray();

    //     /* -------------------------------------------------
    //  | FINAL RESPONSE
    //  -------------------------------------------------*/
    //     return [
    //         'id'           => $product->id,
    //         'slug'         => $product->slug,
    //         'title'        => $product->name ?? 'Unnamed Product',
    //         'price'        => (float) ($product->base_price ?? 0),
    //         'imgSrc'       => $defaultImage,
    //         'imgHoverSrc'  => $hoverImage,
    //         'colors'       => $colors,     // Always includes default main as first
    //         'sizes'        => $sizes,
    //         'isAvailable'  => $product->variants->sum('stock') > 0,
    //         'description'  => $product->description,
    //     ];
    // }


    private function prepareProductDetailsFormat(Product $product)
    {
        // Load relations
        $product->loadMissing([
            'images.color',
            'variants.color',
            'variants.size',
        ]);

        /* -------------------------------------------------
     | DEFAULT MAIN & HOVER IMAGES
     -------------------------------------------------*/
        $defaultMainRecord = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
        $defaultHoverRecord = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_HOVER);

        $defaultImage = $defaultMainRecord ? R2Helper::getFileUrl($defaultMainRecord->image_path) : null;
        $hoverImage   = $defaultHoverRecord ? R2Helper::getFileUrl($defaultHoverRecord->image_path) : $defaultImage;

        /* -------------------------------------------------
     | GROUP IMAGES BY COLOR
     -------------------------------------------------*/
        $imagesByColor = $product->images->groupBy('color_id');

        /* -------------------------------------------------
     | BUILD COLORS COLLECTION
     -------------------------------------------------*/
        $colors = collect();

        // Track already added color_ids to prevent duplicates
        $addedColorIds = collect();

        // 1. Add DEFAULT MAIN as the first color (priority)
        if ($defaultMainRecord) {
            $mainColor = $defaultMainRecord->color;
            $mainColorId = $mainColor?->id;
            $mainColorName = $mainColor?->name ?? 'Default';
            $mainColorCode = $mainColor?->code ?? '#cccccc';

            // Mark this color as added (even if null)
            if ($mainColorId) {
                $addedColorIds->push($mainColorId);
            }

            // Gallery for default color
            $defaultGalleryImages = ($imagesByColor[$mainColorId] ?? collect())
                ->whereIn('image_type', [ProductImageType::GALLERY, ProductImageType::DEFAULT_MAIN]);

            $availabilityMap = \App\Models\ProductVariantAvailability::where('product_id', $product->id)
                ->whereIn('status', [
                    ProductVariantAvailabilityStatus::SOLD_OUT->value,
                    ProductVariantAvailabilityStatus::UNAVAILABLE->value,
                ])
                ->get()
                ->groupBy('color_id')
                ->map(fn($rows) => $rows->pluck('size_id')->toArray());

            $disabledSizeIds = $availabilityMap[$mainColorId] ?? [];


            $mainGallery = $defaultGalleryImages
                ->map(fn($img) => [
                    'id'        => $img->id,
                    'imgSrc'    => R2Helper::getFileUrl($img->image_path),
                    'imgAlt'    => $mainColorName . ' variant',
                    'imgWidth'  => 400,
                    'imgHeight' => 400,
                    'title'     => $product->name,
                    'price'     => (float) $product->base_price,
                    'tooltip'   => "Quick View",
                ])
                ->values()
                ->toArray();

            $colors->push([
                'name'    => $mainColorName,
                'code'    => $mainColorCode,
                'imgSrc'  => $defaultImage,
                'gallery' => $mainGallery,
                'disabledSizes' => $disabledSizeIds,

            ]);
        }

        // 2. Add variant colors (skip if already added via default main)
        $variantColors = $product->variants
            ->groupBy('color_id')
            ->map(function ($variants, $colorId) use ($imagesByColor, $product, $addedColorIds) {
                // Skip if this color was already added as default
                if ($addedColorIds->contains($colorId)) {
                    return null; // Will be filtered out
                }

                $color = $variants->first()->color;
                if (!$color) {
                    return null;
                }

                // Mark as added
                $addedColorIds->push($colorId);

                $images = $imagesByColor[$colorId] ?? collect();

                $mainImage = $images->firstWhere('image_type', ProductImageType::VARIANT_MAIN)
                    ?? $images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

                $mainImageUrl = $mainImage ? R2Helper::getFileUrl($mainImage->image_path) : null;

                $gallery = $images
                    ->whereIn('image_type', [ProductImageType::GALLERY, ProductImageType::VARIANT_MAIN])
                    ->map(fn($img) => [
                        'id'        => $img->id,
                        'imgSrc'    => R2Helper::getFileUrl($img->image_path),
                        'imgAlt'    => $color->name . ' variant',
                        'imgWidth'  => 400,
                        'imgHeight' => 400,
                        'title'     => $product->name,
                        'price'     => (float) $product->base_price,
                        'tooltip'   => "Quick View",
                    ])
                    ->values()
                    ->toArray();

                $availabilityMap = \App\Models\ProductVariantAvailability::where('product_id', $product->id)
                    ->whereIn('status', [
                        ProductVariantAvailabilityStatus::SOLD_OUT->value,
                        ProductVariantAvailabilityStatus::UNAVAILABLE->value,
                    ])
                    ->get()
                    ->groupBy('color_id')
                    ->map(fn($rows) => $rows->pluck('size_id')->toArray());

                $disabledSizeIds = $availabilityMap[$colorId] ?? [];

                return [
                    'name'    => $color->name,
                    'code'    => $color->code ?? '#cccccc',
                    'imgSrc' => $mainImageUrl ?? '',
                    'gallery' => $gallery,
                    'disabledSizes' => $disabledSizeIds
                ];
            })
            ->filter() // Remove null entries (duplicates skipped)
            ->values();

        // Merge and reset keys
        $colors = $colors->merge($variantColors)->values()->toArray();

        /* -------------------------------------------------
     | SIZES
     -------------------------------------------------*/
        // $sizes = $product->variants
        //     ->pluck('size.name')
        //     ->filter()
        //     ->unique()
        //     ->values()
        //     ->toArray();

        $sizes = $product->variants
            ->map(fn($variant) => [
                'id'   => $variant->size->id,
                'name' => $variant->size->name,
            ])
            ->unique('id')
            ->values()
            ->toArray();

        /* -------------------------------------------------
     | FINAL RESPONSE
     -------------------------------------------------*/
        return [
            'id'           => $product->id,
            'slug'         => $product->slug,
            'title'        => $product->name ?? 'Unnamed Product',
            'price'        => (float) ($product->base_price ?? 0),
            'imgSrc'       => $defaultImage,
            'imgHoverSrc'  => $hoverImage,
            'colors'       => $colors,
            'sizes'        => $sizes,
            'isAvailable'  => $product->variants->sum('stock') > 0,
            'soldOut'      => (bool) $product->sold_out,
            'description'  => $product->description,
        ];
    }


    // ###############################################################

    // products for the show pages


    public function getWishlistProducts(Request $request)
    {
        $ids = $request->query('ids');

        if (!$ids || empty(trim($ids))) {
            return response()->json(['data' => []]);
        }

        $idArray = array_filter(array_map('intval', explode(',', $ids)));

        if (empty($idArray)) {
            return response()->json(['data' => []]);
        }

        $products = Product::with(['images', 'variants.color', 'variants.size'])
            ->whereIn('id', $idArray)
            ->where('status', 'active')
            ->get();

        $formatted = $products->map(fn($p) => $this->prepareProductFormat($p));

        return response()->json([
            'data' => $formatted->values()->toArray(),
        ]);
    }

    public function getShopFilters(Request $request)
    {
        return response()->json(getShopFilters());
    }


    // public function shop(Request $request)
    // {
    //     $perPage = 20; // 20 items per page as requested

    //     $query = Product::query()
    //         ->with(['images', 'variants.color', 'variants.size'])
    //         ->where('status', 'active');

    //     // === FILTERS ===
    //     if ($request->filled('color')) {
    //         $query->whereHas('variants.color', fn($q) => $q->whereIn('code', $request->color));
    //     }

    //     if ($request->filled('size')) {
    //         $query->whereHas('variants.size', fn($q) => $q->whereIn('name', $request->size));
    //     }

    //     if ($request->hasAny(['price_min', 'price_max'])) {
    //         $min = $request->input('price_min', 0);
    //         $max = $request->input('price_max', PHP_INT_MAX);
    //         $query->whereBetween('base_price', [$min, $max]);
    //     }

    //     // === ORDER & PAGINATION ===
    //     $products = $query->orderByDesc('id')->paginate($perPage);

    //     // === TRANSFORM USING YOUR EXACT FORMAT ===
    //     $formatted = $products->getCollection()->map(function ($product) {
    //         return $this->prepareProductFormat($product);
    //     });

    //     return response()->json([
    //         'data'         => $formatted,
    //         'current_page' => $products->currentPage(),
    //         'last_page'    => $products->lastPage(),
    //         'total'        => $products->total(),
    //         'per_page'     => $products->perPage(),
    //         'filters'      => getShopFilters(),
    //     ]);
    // }


    public function shop(Request $request)
    {
        $perPage = 20;

        $query = Product::query()
            ->with(['images', 'variants.color', 'variants.size'])
            ->where('status', 'active');

        // === FILTERS BY ID (Recommended & Fastest) ===
        if ($request->filled('color')) {
            $query->whereHas('variants.color', fn($q) => $q->whereIn('code', $request->color));
        }

        if ($request->filled('size')) {
            $query->whereHas('variants.size', fn($q) => $q->whereIn('id', $request->size)); // ← Use ID
        }

        if ($request->filled('collection')) {
            $query->whereHas('collections', fn($q) => $q->whereIn('id', $request->collection)); // ← ID
        }

        // if ($request->filled('category')) {
        //     $query->whereIn('category_id', $request->category); // ← Direct ID column
        // }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->category);
            });
        }

        if ($request->hasAny(['price_min', 'price_max'])) {
            $min = $request->input('price_min', 0);
            $max = $request->input('price_max', PHP_INT_MAX);
            $query->whereBetween('base_price', [$min, $max]);
        }

        $products = $query->orderByDesc('id')->paginate($perPage);

        $formatted = $products->getCollection()->map(fn($p) => $this->prepareProductFormat($p));

        return response()->json([
            'data'    => $formatted,
            'filters' => getShopFilters(), // Already includes id, name, slug
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
            'total'       => $products->total(),
            'per_page'    => $products->perPage(),
        ]);
    }



    // private function prepareProductDetailsFormat(Product $product)
    // {
    //     $defaultMain = $product->images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);
    //     $defaultImage = $defaultMain ? R2Helper::getFileUrl($defaultMain->image_path) : null;

    //     $imagesByColor = $product->images->groupBy('color_id');

    //     // Map colors in the same format your frontend expects
    //     $colors = $product->variants
    //         ->groupBy('color_id')
    //         ->map(function ($variants, $colorId) use ($imagesByColor) {
    //             $color = $variants->first()->color;
    //             $images = $imagesByColor[$colorId] ?? collect();

    //             $mainImage = $images->firstWhere('image_type', ProductImageType::VARIANT_MAIN)
    //                 ?? $images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

    //             $gallery = $images
    //                 ->whereIn('image_type', [ProductImageType::GALLERY, ProductImageType::VARIANT_MAIN])
    //                 ->map(fn($img) => [
    //                     'id' => $img->id,
    //                     'src' => R2Helper::getFileUrl($img->image_path),
    //                     'alt' => "image",
    //                     'dataValue' => $color->name,
    //                     'width' => 770,   // Optional: replace with real width if stored
    //                     'height' => 1075, // Optional: replace with real height if stored
    //                 ])
    //                 ->values();

    //             return [
    //                 'id' => $color->id,
    //                 'value' => $color->name, // Matches frontend currentColor.value
    //                 'className' => strtolower($color->name), // Matches frontend CSS class
    //                 'mainImage' => $mainImage ? R2Helper::getFileUrl($mainImage->image_path) : null,
    //                 'gallery' => $gallery,
    //             ];
    //         })
    //         ->values();

    //     // Map sizes
    //     $sizes = $product->variants
    //         ->pluck('size.name')
    //         ->unique()
    //         ->map(fn($size, $index) => [
    //             'id' => $index,
    //             'value' => $size, // Matches frontend currentSize.value
    //         ])
    //         ->values();

    //     return [
    //         'id' => $product->id,
    //         'slug' => $product->slug,
    //         'title' => $product->name,
    //         'price' => (float) $product->base_price,
    //         'imgSrc' => $defaultImage, // Matches Slider1ZoomOuter firstImage
    //         'colors' => $colors,
    //         'sizes' => $sizes,
    //         'isAvailable' => $product->variants->sum('stock') > 0,
    //     ];
    // }


    public function getProductSeoData($slug) {}







    // private function prepareProductDetailsFormat(Product $product)
    // {
    //     /* -------------------------------------------------
    //  | DEFAULT MAIN IMAGE
    //  -------------------------------------------------*/
    //     $defaultMain = $product->images
    //         ->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

    //     $defaultImage = $defaultMain
    //         ? R2Helper::getFileUrl($defaultMain->image_path)
    //         : null;

    //     /* -------------------------------------------------
    //  | GROUP IMAGES BY COLOR
    //  -------------------------------------------------*/
    //     $imagesByColor = $product->images
    //         ->groupBy('color_id');

    //     /* -------------------------------------------------
    //  | COLORS WITH MAIN + GALLERY
    //  -------------------------------------------------*/
    //     $colors = $product->variants
    //         ->groupBy('color_id')
    //         ->map(function ($variants, $colorId) use ($imagesByColor) {

    //             $color = $variants->first()->color;
    //             $images = $imagesByColor[$colorId] ?? collect();

    //             // Variant main image
    //             $mainImage = $images
    //                 ->firstWhere('image_type', ProductImageType::VARIANT_MAIN)
    //                 ?? $images->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

    //             // Gallery images
    //             $gallery = $images
    //                 ->whereIn('image_type', [
    //                     ProductImageType::GALLERY,
    //                     ProductImageType::VARIANT_MAIN,
    //                 ])
    //                 ->map(fn($img) => R2Helper::getFileUrl($img->image_path))
    //                 ->values();

    //             return [
    //                 'id'        => $color->id,
    //                 'name'      => $color->name,
    //                 'code'      => $color->code,
    //                 'mainImage' => $mainImage
    //                     ? R2Helper::getFileUrl($mainImage->image_path)
    //                     : null,
    //                 'gallery'   => $gallery,
    //             ];
    //         })
    //         ->values();

    //     /* -------------------------------------------------
    //  | SIZES
    //  -------------------------------------------------*/
    //     $sizes = $product->variants
    //         ->pluck('size.name')
    //         ->unique()
    //         ->values();

    //     /* -------------------------------------------------
    //  | FINAL RESPONSE
    //  -------------------------------------------------*/
    //     return [
    //         'id'           => $product->id,
    //         'slug'         => $product->slug,
    //         'title'        => $product->name,
    //         'price'        => (float) $product->base_price,
    //         'defaultImage' => $defaultImage,
    //         'colors'       => $colors,
    //         'sizes'        => $sizes,
    //         'isAvailable'  => $product->variants->sum('stock') > 0,
    //     ];
    // }




    // private function prepareProductFormat(Product $product)
    // {
    //     /* -------------------------------------------------
    //  | DEFAULT MAIN & HOVER IMAGES
    //  -------------------------------------------------*/
    //     $mainImageRecord = $product->images
    //         ->firstWhere('image_type', ProductImageType::DEFAULT_MAIN);

    //     $hoverImageRecord = $product->images
    //         ->firstWhere('image_type', ProductImageType::DEFAULT_HOVER);

    //     $mainImage = $mainImageRecord
    //         ? R2Helper::getFileUrl($mainImageRecord->image_path)
    //         : null;

    //     $hoverImage = $hoverImageRecord
    //         ? R2Helper::getFileUrl($hoverImageRecord->image_path)
    //         : null;

    //     /* -------------------------------------------------
    //  | DEFAULT MAIN COLOR DATA
    //  -------------------------------------------------*/


    //     // Get the DEFAULT_MAIN image record from product_images
    //     $mainColorDataRecord = ProductImage::where('product_id', $product->id)
    //         ->where('image_type', ProductImageType::DEFAULT_MAIN)
    //         ->first();

    //     $mainColorData = null;

    //     if ($mainColorDataRecord) {
    //         $color = null;

    //         // If color_id exists, get the color info from colors table
    //         if ($mainColorDataRecord->color_id) {
    //             $color = $mainColorDataRecord->color; // assuming ProductImage has color() relation
    //         }

    //         $mainColorData = [
    //             'name'   => $color?->name ?? 'Default', // fallback to 'Default'
    //             'code'   => $color?->code ?? null,
    //             'imgSrc' => R2Helper::getFileUrl($mainColorDataRecord->image_path),
    //         ];
    //     }

    //     /* -------------------------------------------------
    //  | VARIANT COLORS
    //  -------------------------------------------------*/
    //     $variantColors = $product->variants
    //         ->groupBy('color_id')
    //         ->map(function ($group) use ($product) {

    //             $color = $group->first()->color;

    //             $colorMainImage = ProductImage::where('product_id', $product->id)
    //                 ->where('color_id', $color->id)
    //                 ->where('image_type', ProductImageType::VARIANT_MAIN)
    //                 ->first();

    //             return [
    //                 'name'   => $color->name,
    //                 'code'   => $color->code,
    //                 'imgSrc' => $colorMainImage
    //                     ? R2Helper::getFileUrl($colorMainImage->image_path)
    //                     : null,
    //             ];
    //         })
    //         ->values();

    //     /* -------------------------------------------------
    //  | MERGE DEFAULT MAIN COLOR WITH VARIANTS
    //  -------------------------------------------------*/
    //     $colors = collect();
    //     if ($mainColorData) {
    //         $colors->push($mainColorData);
    //     }
    //     $colors = $colors->merge($variantColors)->values();

    //     /* -------------------------------------------------
    //  | UNIQUE SIZES
    //  -------------------------------------------------*/
    //     $sizes = $product->variants
    //         ->pluck('size.name')
    //         ->unique()
    //         ->values()
    //         ->toArray();

    //     /* -------------------------------------------------
    //  | CHECK AVAILABILITY
    //  -------------------------------------------------*/
    //     $isAvailable = $product->variants->sum('stock') > 0;

    //     /* -------------------------------------------------
    //  | FILTER CATEGORIES (show_area)
    //  -------------------------------------------------*/
    //     $filterCategories = [];
    //     if ($product->show_area) {
    //         $showAreas = is_array($product->show_area)
    //             ? $product->show_area
    //             : json_decode($product->show_area, true);

    //         if (in_array('new_arrival', $showAreas)) $filterCategories[] = 'New arrivals';
    //         if (in_array('trending', $showAreas)) $filterCategories[] = 'Trending';
    //         // Add more mappings if needed
    //     }

    //     /* -------------------------------------------------
    //  | FINAL PRODUCT DATA
    //  -------------------------------------------------*/
    //     return [
    //         'id'               => $product->id,
    //         'imgSrc'           => $mainImage,
    //         'imgHoverSrc'      => $hoverImage,
    //         'title'            => $product->name,
    //         'price'            => (float) $product->base_price,
    //         'colors'           => $colors,
    //         'sizes'            => $sizes,
    //         'filterCategories' => $filterCategories,
    //         'brand'            => 'YourBrand', // Change to dynamic if needed
    //         'isAvailable'      => $isAvailable,
    //         // 'countdown' => null, // Add later if needed
    //     ];
    // }

    //   public function getNewFashion(Request $request)
    // {
    //     $perPage = 20;

    //     $query = Product::query()
    //         ->with(['images', 'variants.color', 'variants.size'])
    //         ->where('status', 'active');

    //     // === FILTERS BY ID (Recommended & Fastest) ===
    //     if ($request->filled('color')) {
    //         $query->whereHas('variants.color', fn($q) => $q->whereIn('code', $request->color));
    //     }

    //     if ($request->filled('size')) {
    //         $query->whereHas('variants.size', fn($q) => $q->whereIn('id', $request->size)); // ← Use ID
    //     }

    //     if ($request->filled('collection')) {
    //         $query->whereHas('collections', fn($q) => $q->whereIn('id', $request->collection)); // ← ID
    //     }

    //     if ($request->filled('category')) {
    //         $query->whereIn('category_id', $request->category); // ← Direct ID column
    //     }

    //     if ($request->hasAny(['price_min', 'price_max'])) {
    //         $min = $request->input('price_min', 0);
    //         $max = $request->input('price_max', PHP_INT_MAX);
    //         $query->whereBetween('base_price', [$min, $max]);
    //     }

    //     $products = $query->orderByDesc('id')->paginate($perPage);

    //     $formatted = $products->getCollection()->map(fn($p) => $this->prepareProductFormat($p));

    //     return response()->json([
    //         'data'    => $formatted,
    //         'filters' => getShopFilters(), // Already includes id, name, slug
    //         'current_page' => $products->currentPage(),
    //         'last_page'    => $products->lastPage(),
    //         'total'       => $products->total(),
    //         'per_page'    => $products->perPage(),
    //     ]);
    // }


    public function getNewFashion(Request $request)
    {
        $perPage = 20;

        $query = Product::query()
            ->with(['images', 'variants.color', 'variants.size'])
            ->where('status', 'active')
            ->whereHas('showAreas', function ($q) {
                $q->where('key', 'new_arrival'); // ← Only new arrivals
            });

        // === ALL YOUR EXISTING FILTERS (unchanged) ===
        if ($request->filled('color')) {
            $query->whereHas('variants.color', fn($q) => $q->whereIn('code', $request->color));
        }

        if ($request->filled('size')) {
            $query->whereHas('variants.size', fn($q) => $q->whereIn('id', $request->size));
        }

        if ($request->filled('collection')) {
            $query->whereHas('collections', fn($q) => $q->whereIn('id', $request->collection));
        }

        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->category);
        }

        if ($request->hasAny(['price_min', 'price_max'])) {
            $min = $request->input('price_min', 0);
            $max = $request->input('price_max', PHP_INT_MAX);
            $query->whereBetween('base_price', [$min, $max]);
        }

        $products = $query->orderByDesc('id')->paginate($perPage);

        $formatted = $products->getCollection()->map(fn($p) => $this->prepareProductFormat($p));

        return response()->json([
            'data'         => $formatted,
            'filters'      => getShopFilters(), // Still include filters for frontend
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
            'total'        => $products->total(),
            'per_page'     => $products->perPage(),
        ]);
    }


    public function getCollectionProducts($slug, Request $request)
    {
        $perPage = 20;

        // Find collection by slug
        $collection = \App\Models\Collection::where('slug', $slug)->firstOrFail();

        $query = Product::query()
            ->with(['images', 'variants.color', 'variants.size'])
            ->where('status', 'active')
            ->whereHas('collections', function ($q) use ($collection) {
                $q->where('collections.id', $collection->id);
            });

        // === ALL YOUR EXISTING FILTERS (same as shop) ===
        if ($request->filled('color')) {
            $query->whereHas('variants.color', fn($q) => $q->whereIn('code', $request->color));
        }

        if ($request->filled('size')) {
            $query->whereHas('variants.size', fn($q) => $q->whereIn('id', $request->size));
        }

        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->category);
        }

        if ($request->hasAny(['price_min', 'price_max'])) {
            $min = $request->input('price_min', 0);
            $max = $request->input('price_max', PHP_INT_MAX);
            $query->whereBetween('base_price', [$min, $max]);
        }

        $products = $query->orderByDesc('id')->paginate($perPage);

        $formatted = $products->getCollection()->map(fn($p) => $this->prepareProductFormat($p));

        // === FIX: Add collection_name as array key (not object property) ===
        $formatted = $formatted->map(function ($product) use ($collection) {
            $product['collection_name'] = $collection->name; // ← Use array syntax
            return $product;
        });

        return response()->json([
            'data'         => $formatted,
            'filters'      => getShopFilters(),
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
            'total'        => $products->total(),
            'per_page'     => $products->perPage(),
        ]);
    }

    public function getCategoryProducts($slug, Request $request)
    {
        $perPage = 20;

        // Find category by slug
        $category = \App\Models\Category::where('slug', $slug)->firstOrFail();

        \Log::info($category);

        // $query = Product::query()
        //     ->with(['images', 'variants.color', 'variants.size'])
        //     ->where('status', 'active')
        //     ->where('category_id', $category->id);
        $query = Product::query()
            ->with(['images', 'variants.color', 'variants.size', 'categories'])
            ->where('status', 'active')
            // Only filter products that have this category in pivot
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id));

        // === ALL YOUR EXISTING FILTERS ===
        if ($request->filled('color')) {
            $query->whereHas('variants.color', fn($q) => $q->whereIn('code', $request->color));
        }

        if ($request->filled('size')) {
            $query->whereHas('variants.size', fn($q) => $q->whereIn('id', $request->size));
        }

        if ($request->filled('collection')) {
            $query->whereHas('collections', fn($q) => $q->whereIn('id', $request->collection));
        }

        if ($request->hasAny(['price_min', 'price_max'])) {
            $min = $request->input('price_min', 0);
            $max = $request->input('price_max', PHP_INT_MAX);
            $query->whereBetween('base_price', [$min, $max]);
        }

        $products = $query->orderByDesc('id')->paginate($perPage);

        $formatted = $products->getCollection()->map(fn($p) => $this->prepareProductFormat($p));

        // Add category name to products
        // $formatted = $formatted->map(function ($product) use ($category) {
        //     $product['category_name'] = $category->name;
        //     return $product;
        // });

        // $formatted = $formatted->map(function ($product) use ($category) {
        //     // Add all categories of this product as comma-separated string
        //     $product['category_names'] = $product['categories']->pluck('name')->implode(', ');
        //     unset($product['categories']); // optional: remove categories object
        //     return $product;
        // });

        \Log::info($formatted->toArray());

        return response()->json([
            'data'         => $formatted,
            'filters'      => getShopFilters(),
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
            'total'        => $products->total(),
            'per_page'     => $products->perPage(),
        ]);
    }


    public function getSectionProducts($slug, Request $request)
    {
        $perPage = 20;

        $section = \App\Models\NewSection::where('slug', $slug)->firstOrFail();

        $query = Product::query()
            ->with(['images', 'variants.color', 'variants.size'])
            ->where('status', 'active')
            ->whereHas('sections', function ($q) use ($section) {
                $q->where('section_product.section_id', $section->id); // ✅ FIX
            });

        // Filters
        if ($request->filled('color')) {
            $query->whereHas('variants.color', fn($q) => $q->whereIn('code', $request->color));
        }

        if ($request->filled('size')) {
            $query->whereHas('variants.size', fn($q) => $q->whereIn('id', $request->size));
        }

        if ($request->filled('category')) {
            $query->whereIn('category_id', $request->category);
        }

        if ($request->hasAny(['price_min', 'price_max'])) {
            $query->whereBetween('base_price', [
                $request->input('price_min', 0),
                $request->input('price_max', PHP_INT_MAX)
            ]);
        }

        $products = $query->latest()->paginate($perPage);

        $formatted = $products->getCollection()->map(fn($p) => $this->prepareProductFormat($p));

        $formatted = $formatted->map(function ($product) use ($section) {
            $product['section_name'] = $section->name;
            return $product;
        });

        return response()->json([
            'data'         => $formatted,
            'filters'      => getShopFilters(),
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
            'total'        => $products->total(),
            'per_page'     => $products->perPage(),
        ]);
    }


    public function getSizeChart(Request $request, string $slug)
    {
        $data = Cache::remember("size_chart_{$slug}", now()->addHours(24), function () use ($slug) {

            $product = Product::select('name', 'size_chart_image')
                ->where('slug', $slug)
                ->first();

            if (!$product || !$product->size_chart_image) {
                return null;
            }

            return [
                'url' => \App\Helpers\R2Helper::getFileUrl($product->size_chart_image),
                'alt' => $product->name . ' Size Chart',
            ];
        });

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Size chart not found',
                'url'     => null,
                'alt'     => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'url'     => $data['url'],
            'alt'     => $data['alt'],
        ]);
    }






    // for the search





    public function search(Request $request)
    {
        $q = trim($request->query('q', ''));
        $perPage = max(8, min(60, (int) $request->query('per_page', 24)));

        // STEP 0: empty query → latest products
        if ($q === '') {
            $products = Product::with(['images', 'variants.color', 'variants.size'])
                ->where('status', 'active')
                ->latest('created_at')
                ->paginate($perPage);

            return $this->searchResponse($products, $q);
        }

        // STEP 1: normalize search query
        $normalizedQuery = strtolower($q);
        $normalizedQuery = preg_replace('/[^a-z0-9 ]/', ' ', $normalizedQuery); // remove special chars
        $normalizedQuery = preg_replace('/\s+/', ' ', $normalizedQuery); // collapse spaces
        $words = array_filter(explode(' ', $normalizedQuery));

        // STEP 2: FULLTEXT search first
        $booleanSearch = collect($words)->map(fn($w) => '+' . trim($w) . '*')->implode(' ');

        $productIds = \DB::table('product_search_indexes')
            ->select('product_id')
            ->whereRaw("MATCH(search_text) AGAINST (? IN BOOLEAN MODE)", [$booleanSearch])
            ->pluck('product_id');

        // STEP 3: fallback LIKE search if FULLTEXT returns nothing
        if ($productIds->isEmpty()) {
            $productIds = \DB::table('product_search_indexes')
                ->where(function ($query) use ($words) {
                    foreach ($words as $word) {
                        $word = rtrim($word, 's'); // remove trailing 's' for plural match
                        $query->orWhere('search_text', 'LIKE', "%{$word}%");
                    }
                })
                ->pluck('product_id');
        }

        // STEP 4: if still empty → approximate matching for typos
        if ($productIds->isEmpty()) {
            $productIds = \DB::table('product_search_indexes')
                ->get(['product_id', 'search_text'])
                ->filter(function ($row) use ($words) {
                    $searchText = strtolower($row->search_text);
                    $searchText = preg_replace('/[^a-z0-9 ]/', ' ', $searchText);
                    $searchText = preg_replace('/\s+/', ' ', $searchText);

                    foreach ($words as $word) {
                        $word = rtrim($word, 's'); // remove plural s
                        if (str_contains($searchText, $word)) {
                            return true;
                        }
                    }
                    return false;
                })
                ->pluck('product_id');
        }

        // STEP 5: if still empty → random products
        if ($productIds->isEmpty()) {
            $products = Product::with(['images', 'variants.color', 'variants.size'])
                ->where('status', 'active')
                ->inRandomOrder()
                ->limit($perPage)
                ->get();

            return $this->searchResponse($products, $q);
        }

        // STEP 6: query products with filters
        $query = Product::with(['images', 'variants.color', 'variants.size'])
            ->where('status', 'active')
            ->whereIn('id', $productIds);

        $this->applyFilters($query, $request);

        $products = $query
            ->orderByRaw("FIELD(id, " . $productIds->implode(',') . ")")
            ->paginate($perPage);

        return $this->searchResponse($products, $q);
    }


    private function searchResponse($products, string $q)
    {
        return response()->json([
            'data' => $products->getCollection()
                ->map(fn($p) => $this->prepareProductFormat($p))
                ->values(),

            'filters'       => getShopFilters(),
            'current_page'  => $products->currentPage(),
            'last_page'     => $products->lastPage(),
            'total'         => $products->total(),
            'per_page'      => $products->perPage(),
            'query'         => $q,
            'found_matches' => $products->total() > 0,
        ]);
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('color')) {
            $query->whereHas(
                'variants.color',
                fn($q) => $q->whereIn('code', $request->color)
            );
        }

        if ($request->filled('size')) {
            $query->whereHas(
                'variants.size',
                fn($q) => $q->whereIn('id', $request->size)
            );
        }

        if ($request->filled('collection')) {
            $query->whereHas(
                'collections',
                fn($q) => $q->whereIn('id', $request->collection)
            );
        }

        if ($request->hasAny(['price_min', 'price_max'])) {
            $min = $request->input('price_min', 0);
            $max = $request->input('price_max', PHP_INT_MAX);
            $query->whereBetween('base_price', [$min, $max]);
        }
    }



    // public function search(Request $request)
    // {
    //     $q = trim($request->query('q', ''));
    //     $perPage = max(8, min(60, (int) $request->query('per_page', 24)));

    //     $baseQuery = Product::query()
    //         ->with(['images', 'variants.color', 'variants.size'])
    //         ->where('status', 'active');

    //     if ($q === '') {
    //         return response()->json(
    //             $baseQuery->latest('created_at')->paginate($perPage)
    //         );
    //     }

    //     $words = array_filter(explode(' ', $q));
    //     $booleanSearch = collect($words)
    //         ->map(fn($w) => '+' . trim($w) . '*')
    //         ->implode(' ');

    //     // 1️⃣ FULLTEXT search
    //     $products = $this->fullTextSearch(
    //         clone $baseQuery,
    //         $booleanSearch,
    //         $perPage
    //     );

    //     // 2️⃣ Fallback LIKE search if no results
    //     if ($products->total() === 0) {
    //         $products = $this->likeFallbackSearch(
    //             clone $baseQuery,
    //             $words,
    //             $perPage
    //         );
    //     }

    //     return response()->json([
    //         'data'          => $products->getCollection()
    //             ->map(fn($p) => $this->prepareProductFormat($p))
    //             ->values(),
    //         'filters'       => getShopFilters(),
    //         'current_page'  => $products->currentPage(),
    //         'last_page'     => $products->lastPage(),
    //         'total'         => $products->total(),
    //         'per_page'      => $products->perPage(),
    //         'query'         => $q,
    //         'found_matches' => $products->total() > 0,
    //     ]);
    // }


    // private function fullTextSearch($baseQuery, string $booleanSearch, int $perPage)
    // {
    //     return $baseQuery
    //         ->selectRaw("
    //         products.*,
    //         MATCH(products.name, products.keywords_text, products.description)
    //         AGAINST (? IN BOOLEAN MODE) AS relevance
    //     ", [$booleanSearch])
    //         ->whereRaw(
    //             "MATCH(products.name, products.keywords_text, products.description)
    //          AGAINST (? IN BOOLEAN MODE)",
    //             [$booleanSearch]
    //         )
    //         ->orderByDesc('relevance')
    //         ->paginate($perPage);
    // }


    // private function likeFallbackSearch($baseQuery, array $words, int $perPage)
    // {
    //     return $baseQuery
    //         ->where(function ($q) use ($words) {
    //             foreach ($words as $word) {
    //                 $q->orWhere('products.name', 'LIKE', "%{$word}%")
    //                     ->orWhere('products.description', 'LIKE', "%{$word}%");
    //             }
    //         })
    //         ->latest('created_at')
    //         ->paginate($perPage);
    // }



    public function getQuickLinks()
    {
        $links = Cache::remember('quick_links_api', now()->addHours(24), function () {

            // Collections FIRST
            $collections = Collection::query()
                ->select('name', 'slug')
                ->where('is_active', 1)
                ->orderBy('name')
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'collection',
                        'name' => $item->name,
                        'slug' => $item->slug,
                        'url'  => '/collection/' . $item->slug,
                    ];
                });

            // Categories SECOND
            $categories = Category::query()
                ->select('name', 'slug')
                ->orderBy('name')
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'category',
                        'name' => $item->name,
                        'slug' => $item->slug,
                        'url'  => '/shop/' . $item->slug,
                    ];
                });

            return [
                'collections' => $collections->values(),
                'categories'  => $categories->values(),
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $links
        ]);
    }
}
