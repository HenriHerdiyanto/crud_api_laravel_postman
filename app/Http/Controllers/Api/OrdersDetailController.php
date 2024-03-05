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

        // Siapkan array untuk menyimpan data pengguna yang terkait dengan pesanan
        $users = [];

        // Siapkan array untuk menyimpan data produk yang terkait dengan pesanan
        $products = [];

        // Siapkan array untuk menyimpan data kategori yang terkait dengan produk
        $categories = [];

        // Siapkan array untuk menyimpan data detail pesanan
        $orderDetails = [];

        // Loop melalui setiap pesanan
        foreach ($orders as $order) {
            // Ambil pengguna yang terkait dengan pesanan
            $user = User::find($order->customer_id);
            // Tambahkan data pengguna ke dalam array
            $users[$order->id] = $user;

            // Ambil detail pesanan yang terkait dengan pesanan saat ini
            $currentOrderDetails = OrdersDetail::where('order_id', $order->id)->get();
            // Tambahkan data detail pesanan ke dalam array
            $orderDetails[$order->id] = $currentOrderDetails;

            // Loop melalui setiap detail pesanan
            foreach ($currentOrderDetails as $detail) {
                // Ambil produk yang terkait dengan detail pesanan
                $product = Product::find($detail->product_id);
                // Tambahkan data produk ke dalam array
                $products[$detail->id] = $product;

                // Ambil kategori yang terkait dengan produk
                $category = Categories::find($product->category_id);
                // Tambahkan data kategori ke dalam array
                $categories[$product->id] = $category;
            }
        }

        // Kembalikan respons JSON
        return response()->json([
            'message' => 'Data Pesanan Berhasil Diambil',
            'orders' => $orders,
            'users' => $users,
            'products' => $products,
            'categories' => $categories,
            'orderDetails' => $orderDetails
        ], 200);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    public function update(Request $request, OrdersDetail $ordersDetail)
    {
        //
    }

    public function destroy(OrdersDetail $ordersDetail)
    {
        //
    }
}
