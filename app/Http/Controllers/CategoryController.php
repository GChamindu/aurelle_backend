<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\helpers\R2Helper;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function list()
    {
        return response()->json([
            'data' => Category::select('id', 'name', 'slug', 'product_count')
                ->orderByDesc('id')
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'image' => $data['image'] ?? null,
        ]);

        Cache::forget('all_categories');
        return response()->json(['data' => $category, 'message' => 'Category created successfully']);
    }

    public function show($id)
    {
        $category = Category::select('id', 'name', 'image')->findOrFail($id);

        // Convert the stored path to full URL if image exists
        if ($category->image) {
            $category->image = R2Helper::getFileUrl($category->image);
        }

        return response()->json(['data' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|string',
        ]);

        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'image' => $data['image'] ?? $category->image,
        ]);

        return response()->json(['data' => $category, 'message' => 'Category updated successfully']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if ($category->product_count > 0) {
            return response()->json(['message' => 'Cannot delete category with associated products'], 422);
        }
        if ($category->image) {
            R2Helper::deleteFile($category->image);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }


    // for the frontend >>>>>>>>>>>>>>>>>>>>

    // public function getCategories()
    // {
    //     $categories = Category::select('name', 'image','slug')
    //         ->orderByDesc('id')
    //         ->get()
    //         ->map(function ($category) {
    //             return [
    //                 'imgSrc'  => $category->image
    //                     ? R2Helper::getFileUrl($category->image)
    //                     : 'https://via.placeholder.com/400x500',

    //                 'altText' => $category->name . ' collection',

    //                 'title'   => $category->name,
    //                 'slug'    => Str::slug($category->slug),
    //             ];
    //         });

    //     return response()->json($categories);
    // }



    // public function getCategories()
    // {
    //     $categories = getAllCategories()
    //         ->sortByDesc('id')
    //         ->map(function ($category) {
    //             return [
    //                 'imgSrc'  => $category->image
    //                     ? R2Helper::getFileUrl($category->image)
    //                     : 'https://via.placeholder.com/400x500',

    //                 'altText' => $category->name . ' collection',
    //                 'title'   => $category->name,
    //                 'slug'    => Str::slug($category->slug),
    //             ];
    //         })
    //         ->values(); // reset keys

    //     return response()->json($categories);
    // }


    public function getCategories()
    {
        $categories = getAllCategories()
            ->map(function ($category) {
                return [
                    'imgSrc'  => $category->image
                        ? R2Helper::getFileUrl($category->image)
                        : 'https://via.placeholder.com/400x500',

                    'altText' => $category->name . ' collection',
                    'title'   => $category->name,
                    'slug'    => Str::slug($category->slug),
                ];
            })
            ->values();

        return response()->json($categories);
    }
}
