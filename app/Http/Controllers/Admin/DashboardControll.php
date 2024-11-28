<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardControll extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'user',
            'product' => function ($query) {
                $query->select('id', 'nama', 'harga');
            },
            'kategoriPesanan' => function ($query) {
                $query->select('id', 'nama_kategori', 'deskripsi');
            }
        ])->get();

        $countConfirmed = Order::where('konfirmasi', 'sudah')->count();
        $countNotConfirmed = Order::where('konfirmasi', 'belum')->count();
        return view('admin.dashboard', compact('orders', 'countConfirmed', 'countNotConfirmed'));
    }

    public function confirm($id)
    {
        try {
            $order = Order::findOrFail($id);

            Log::debug('Pesanan ditemukan: ', $order->toArray());
            $order->konfirmasi = 'sudah';
            $order->save();
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil dikonfirmasi.']);
        } catch (\Exception $e) {
            Log::error('Kesalahan pada konfirmasi pesanan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function updateStatus($id)
    {
        try {
            $order = Order::findOrFail($id);

            Log::debug('Pesanan ditemukan: ', $order->toArray());
            $order->status = 'completed';
            $order->save();
            return redirect()->route('admin.dashboard');
        } catch (\Exception $e) {
            Log::error('Kesalahan pada konfirmasi pesanan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function getNewOrders()
    {
        $orders = Order::with([
            'user',
            'product' => function ($query) {
                $query->select('id', 'nama', 'harga');
            },
            'kategoriPesanan' => function ($query) {
                $query->select('id', 'nama_kategori', 'deskripsi');
            }
        ])->where('konfirmasi', 'belum')->get();

        return response()->json($orders);
    }
}
