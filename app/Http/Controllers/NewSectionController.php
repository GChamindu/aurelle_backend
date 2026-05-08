<?php

namespace App\Http\Controllers;

use App\Models\NewSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewSectionController extends Controller
{
    public function list()
    {
        return response()->json([
            'data' => NewSection::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|boolean'
        ]);

        NewSection::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        return response()->json([
            'data' => NewSection::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $section = NewSection::findOrFail($id);

        $section->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        NewSection::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    // for the api


    public function getAllSections()
    {
        $sections = getAllSections();
        return response()->json([
            'data' => $sections
        ]);
    }


 public function getSections()
{
    $sections = getActiveSections();

    return response()->json([
        'data' => $sections
    ]);
}




    // frontend api

    public function getSectionsForHeader()
    {
        $sections = getAllSections();
        return response()->json([
            'data' => $sections
        ]);
    }
}
