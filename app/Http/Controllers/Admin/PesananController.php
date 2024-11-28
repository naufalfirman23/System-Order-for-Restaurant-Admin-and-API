<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $order = Order::with([
            'user',
            'product' => function ($query) {
                $query->select('id', 'nama', 'harga');
            },
            'kategoriPesanan' => function ($query) {
                $query->select('id', 'nama_kategori', 'deskripsi');
            }
        ])->get();
        return view('admin.pesanan.index', compact('order'));
    }
}
