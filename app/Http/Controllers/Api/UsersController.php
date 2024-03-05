<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['message' => 'Data User', 'data' => $users], 200);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_pelanggan' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'password' => 'required',
        ]);
        $user = new User();
        $user->nama_pelanggan = $validate['nama_pelanggan'];
        $user->email = $validate['email'];
        $user->alamat = $validate['alamat'];
        $user->nomor_telepon = $validate['nomor_telepon'];
        $user->password = bcrypt($validate['password']);
        $user->save();
        return response()->json(['message' => 'data berhasil disimpan', 'data' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validate = $request->validate([
            'nama_pelanggan' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'password' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->nama_pelanggan = $validate['nama_pelanggan'];
        $user->email = $validate['email'];
        $user->alamat = $validate['alamat'];
        $user->nomor_telepon = $validate['nomor_telepon'];
        $user->password = bcrypt($validate['password']);
        $user->save();

        return response()->json(['message' => 'Data berhasil diupdate'], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'Data berhasil diupdate'], 200);
    }
}
