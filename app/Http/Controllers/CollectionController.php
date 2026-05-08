<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\helpers\R2Helper;
use Illuminate\Support\Facades\Cache;

class CollectionController extends Controller
{
    // public function list()
    // {
    //     return response()->json([
    //         'data' => Collection::select('id', 'name', 'slug')
    //             ->orderAsc('created_at')
    //             ->get()
    //     ]);
    // }


    public function list()
{
    return response()->json([
        'data' => Collection::select('id', 'name', 'slug')
            ->latest() // uses created_at DESC
            ->get()
    ]);
}



    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:collections,name', // Fixed: collections table
            'image' => 'nullable|string',
            'show_in_header' => 'nullable|boolean',

        ]);

        $collection = Collection::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'image' => $data['image'] ?? null,
            'show_in_header' => $data['show_in_header'] ?? false
        ]);

        Cache::forget('all_collections');
        Cache::forget('all_sections');
        Cache::forget('active_sections');

        return response()->json([
            'data' => $collection,
            'message' => 'Collection created successfully'
        ]);
    }

    // public function show($id)
    // {
    //     $collection = Collection::select('id', 'name', 'image')->findOrFail($id);

    //     if ($collection->image) {
    //         $collection->image = R2Helper::getFileUrl($collection->image);
    //     }

    //     return response()->json(['data' => $collection]);
    // }


    public function show($id)
    {
        $collection = Collection::select(
            'id',
            'name',
            'image',
            'show_in_header'
        )->findOrFail($id);

        if ($collection->image) {
            $collection->image = R2Helper::getFileUrl($collection->image);
        }

        return response()->json(['data' => $collection]);
    }


    public function update(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:collections,name,' . $collection->id, // Fixed
            'image' => 'nullable|string',
            'show_in_header' => 'nullable|boolean',
        ]);

        $collection->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'image' => $data['image'] ?? $collection->image,
            'show_in_header' => $data['show_in_header'] ?? $collection->show_in_header
        ]);

        Cache::forget('all_collections');
        Cache::forget('all_sections');
        Cache::forget('active_sections');

        return response()->json([
            'data' => $collection,
            'message' => 'Collection updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);

        // Optional: Only if your collections table has product_count or similar logic
        // Remove or adjust this if collections don't have associated products yet
        // if ($collection->product_count > 0) {
        //     return response()->json(['message' => 'Cannot delete collection with associated products'], 422);
        // }

        if ($collection->image) {
            R2Helper::deleteFile($collection->image);
        }

        $collection->delete();

        return response()->json(['message' => 'Collection deleted successfully']);
    }





    // for the frontednd code


    // public function getCollections(){





    // }


    public function getCollections(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = 9;

        $cacheKey = "collections_page_{$page}_per_{$perPage}";

        return Cache::remember($cacheKey, 60 * 30, function () use ($perPage) {
            $collections = Collection::orderByDesc('id')->paginate($perPage);

            $collections->getCollection()->transform(function ($collection) {
                return [
                    'imgSrc'  => $collection->image ? R2Helper::getFileUrl($collection->image) : 'https://via.placeholder.com/400x500',
                    'altText' => $collection->name . ' collection',
                    'title'   => $collection->name,
                    'slug'    => $collection->slug,
                ];
            });

            return $collections;
        });
    }
}
