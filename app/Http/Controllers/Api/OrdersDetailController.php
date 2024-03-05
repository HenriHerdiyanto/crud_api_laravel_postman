<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Orders;
use App\Models\OrdersDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrdersDetailController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan
        $orders = Orders::all();

        // Siapkan array untuk menyimpan data pengguna, produk, kategori, dan detail pesanan
        $mergedData = [];

        // Loop melalui setiap pesanan
        foreach ($orders as $order) {
            // Ambil pengguna yang terkait dengan pesanan
            $user = User::find($order->customer_id);
            // Ambil detail pesanan yang terkait dengan pesanan saat ini
            $currentOrderDetails = OrdersDetail::where('order_id', $order->id)->get();
            // Siapkan array untuk menyimpan data produk, kategori, dan detail pesanan
            $orderData = [];

            // Loop melalui setiap detail pesanan
            foreach ($currentOrderDetails as $detail) {
                // Ambil produk yang terkait dengan detail pesanan
                $product = Product::find($detail->product_id);
                // Ambil kategori yang terkait dengan produk
                $category = Categories::find($product->category_id);

                // Tambahkan data produk, kategori, dan detail pesanan ke dalam array
                $orderData[] = [
                    'order_detail' => $detail,
                    'product' => $product,
                    'category' => $category
                ];
            }

            // Tambahkan data pesanan, pengguna, dan array produk, kategori, dan detail pesanan ke dalam array mergedData
            $mergedData[] = [
                'order' => $order,
                'user' => $user,
                'order_data' => $orderData
            ];
        }

        // Kembalikan respons JSON
        return response()->json([
            'message' => 'Data Pesanan Berhasil Diambil',
            'merged_data' => $mergedData
        ], 200);
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|integer',
                'product_id' => 'required|integer',
                'jumlah' => 'required|integer',
                'subtotal' => 'required|numeric',
            ]);

            $orderDetails = new OrdersDetail();
            $orderDetails->order_id = $validatedData['order_id'];
            $orderDetails->product_id = $validatedData['product_id'];
            $orderDetails->jumlah = $validatedData['jumlah'];
            $orderDetails->subtotal = $validatedData['subtotal'];
            $orderDetails->save();

            return response()->json(['message' => 'Data Berhasil Ditambahkan', 'data' => $orderDetails], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan data. ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $ordersDetail = OrdersDetail::findOrFail($id);
        $validatedData = $request->validate([
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'jumlah' => 'required|integer',
            'subtotal' => 'required|numeric',
        ]);
        $ordersDetail->order_id = $validatedData['order_id'];
        $ordersDetail->product_id = $validatedData['product_id'];
        $ordersDetail->jumlah = $validatedData['jumlah'];
        $ordersDetail->subtotal = $validatedData['subtotal'];
        $ordersDetail->save();
        return response()->json(['message' => 'Data Berhasil Diupdate', 'data' => $ordersDetail], 200);
    }

    public function destroy($id)
    {
        $orderDetail = OrdersDetail::findOrFail($id);
        $orderDetail->delete();
        return response()->json(['message' => 'Data Berhasil Diupdate', 'data' => $orderDetail], 200);
    }
}
