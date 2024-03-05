<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Orders::all();
        return response()->json(['message' => 'Data Orders', 'data' => $orders], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "customer_id" => "required",
            "tanggal_pemesanan" => "required",
            "status_pembayaran" => "required",
            "status_pengiriman" => "required",
        ]);

        $orders = new Orders();
        $orders->customer_id = $validated["customer_id"];
        $orders->tanggal_pemesanan = $validated["tanggal_pemesanan"];
        $orders->status_pembayaran = $validated["status_pembayaran"];
        $orders->status_pengiriman = $validated["status_pengiriman"];
        $orders->save();

        return response()->json(['message' => 'Data Berhasil Diinput', 'data' => $validated], 200);
    }


    public function edit($id)
    {
        $orders = Orders::find($id);
        return response()->json(['message' => 'Data Edit Orders', 'data' => $orders], 200);
    }

    public function update(Request $request, $id)
    {
        $orders = Orders::find($id);
        if (!$orders) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            "customer_id" => "required",
            "tanggal_pemesanan" => "required",
            "status_pembayaran" => "required",
            "status_pengiriman" => "required",
        ]);

        $orders->customer_id = $validated["customer_id"];
        $orders->tanggal_pemesanan = $validated["tanggal_pemesanan"];
        $orders->status_pembayaran = $validated["status_pembayaran"];
        $orders->status_pengiriman = $validated["status_pengiriman"];
        $orders->save();

        return response()->json(['message' => 'Data Pesanan Berhasil Diupdate', 'data' => $orders], 200);
    }


    public function destroy($id)
    {
        $orders = Orders::find($id);
        $orders->delete();
        return response()->json(['message' => 'Data Pesanan Berhasil Dihapus', 'data' => $orders], 200);
    }
}
