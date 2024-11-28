<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPesanan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{

    public function index()
    {
        $kategori_pesanan = KategoriPesanan::all();

        $order_kategori = [];
        foreach ($kategori_pesanan as $key) {
            $count_orders = Order::where('id_kategori_pesanan', $key->id)->count();
            $order_kategori[$key->nama_kategori] = $count_orders;
        }
        $saldo_per_bulan = DB::table('orders')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total_saldo')
            )
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderByDesc(DB::raw('YEAR(created_at)'))
            ->orderByDesc(DB::raw('MONTH(created_at)'))
            ->get();

        $bulan = [];
        $saldo = [];
        foreach ($saldo_per_bulan as $item) {
            $bulan[] = $this->getBulanNama($item->month);
            $saldo[] = $item->total_saldo;
        }
        $pendapatan_per_minggu = Order::selectRaw('DAYNAME(created_at) as hari, SUM(total_price) as total_pendapatan')
        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]) 
        ->groupBy('hari')
        ->orderByRaw("FIELD(DAYNAME(created_at), 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
        ->get();

        $total_pendapatan = DB::table('orders')->sum('total_price');
        
        return view('admin.riwayat.index', compact('order_kategori','bulan', 'saldo', 'total_pendapatan', 'pendapatan_per_minggu'));
    }

    private function getBulanNama($month)
    {
        $bulan_arr = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return $bulan_arr[$month] ?? '';
    }


    
    
}
