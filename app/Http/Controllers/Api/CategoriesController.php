<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return response()->json(['message' => 'Data Categories', 'data' => $categories], 200);
    }


    public function store(Request $request)
    {
        $category = Categories::create($request->all());
        return response()->json(['message' => 'data berhasil disimpan', 'data' => $category], 200);
    }

    public function update(Request $request, $id)
    {
        $category = Categories::find($id);
        $category->update($request->all());
        return response()->json(['message' => 'Data berhasil diupdate', 'data' => $category], 200);
    }

    public function destroy($id)
    {
        $category = Categories::find($id);
        $category->delete();
        return response()->json(['message' => 'Data berhasil dihapus', 'data' => $category], 200);
    }
}
