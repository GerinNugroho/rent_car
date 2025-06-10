<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Category::all());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $category = Category::create($validated);
        return response()->json([
            'status' => true,
            'message' => 'kategori berhasil disimpan',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'kategori tidak ditemukan',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'kategori ditemukan',
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'kategori tidak ditemukan'
            ], 404);
        }
        $category->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'kategori berhasil diupdate',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $error) {
            return response()->json([
                'status' => false,
                'message' => 'kategori tidak ditemukan'
            ], 404);
        }
        Category::findOrFail($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'kategori berhasil dihapus'
        ]);
    }
}
