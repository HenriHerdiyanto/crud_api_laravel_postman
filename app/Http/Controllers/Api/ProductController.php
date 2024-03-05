<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(['message' => 'Data Product', 'data' => $products], 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // tambahkan validasi file gambar
            'category_id' => 'required', // perbaiki nama validasi
        ]);

        try {
            $gambar = $request->file('gambar');
            $nama_file = time() . "_" . $gambar->getClientOriginalName();
            $tujuan_upload = 'Produk';
            $gambar->move(public_path($tujuan_upload), $nama_file);

            $product = new Product();
            $product->nama_produk = $validatedData['nama_produk'];
            $product->deskripsi = $validatedData['deskripsi'];
            $product->harga = $validatedData['harga'];
            $product->stok = $validatedData['stok'];
            $product->gambar = $nama_file;
            $product->category_id = $validatedData['category_id']; // perbaiki nama kategori id
            $product->save();

            return response()->json(['message' => 'Data Product berhasil ditambah', 'data' => $product], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'gambar' => 'image|mimes:jpeg,png,JPG,gif,svg|max:2048',
            'category_id' => 'required',
        ]);

        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            // Update atribut produk
            $product->nama_produk = $validatedData["nama_produk"];
            $product->deskripsi = $validatedData["deskripsi"];
            $product->harga = $validatedData["harga"];
            $product->stok = $validatedData["stok"];
            $product->category_id = $validatedData["category_id"];

            // Jika ada file gambar yang diunggah
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $tujuan_upload = 'Produk';
                $file->move(public_path($tujuan_upload), $nama_file);

                // Hapus gambar lama jika ada
                if ($product->gambar && file_exists(public_path($tujuan_upload . '/' . $product->gambar))) {
                    unlink(public_path($tujuan_upload . '/' . $product->gambar));
                }

                // Set gambar baru
                $product->gambar = $nama_file;
            }

            $product->save();

            return response()->json(['message' => 'Product updated successfully', 'data' => $product], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Product::find($id);
        $produk->delete();
        return response()->json(['message' => 'Data Product berhasil dihapus', 'data' => $produk], 200);
    }
}
