<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriPesanan;
use App\Models\KategoriProduk;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;

class ContentController extends Controller
{

    public function user(Request $request)
    {
        $userLogin = $request->user();
        return response()->json([
            'status' => 'success',
            'data' => $userLogin
        ], 200);
        
    }
    
    public function getAllCategories()
    {
        try {
            $categori = KategoriProduk::all();

            return response()->json([
                'status' => 'success',
                'data' => $categori
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil kategori.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getAllCategoriesPesanan()
    {
        try {
            $categoriPesanan = KategoriPesanan::all();

            return response()->json([
                'status' => 'success',
                'data' => $categoriPesanan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil kategori.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductsByCategory(Request $request)
    {
        try {
            if (!$request->has('category_id')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'category_id diperlukan.'
                ], 400);
            }
            $produk = Produk::select('id', 'nama', 'harga', 'gambar', 'kategori_id')
                            ->where('kategori_id', $request->category_id)
                            ->get();
    
            $produk->each(function ($produk) {
                $produk->gambar = url($produk->image_url);
            });
    
            if ($produk->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada produk ditemukan untuk kategori ini.'
                ], 404);
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $produk
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil produk.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getProductDetail($id)
    {
        try {
            $produk = Produk::where('id', $id)->first();

            if (!$produk) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Produk tidak ditemukan.'
                ], 404);
            }

            $produk->gambar = url($produk->image_url);

            return response()->json([
                'status' => 'success',
                'data' => $produk
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail produk.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function order(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:produk,id',
                'id_kategori_pesanan' => 'required|exists:kategori_pesanan,id',
                'quantity' => 'required|integer|min:1',
                'nama_pemesan' => 'required|string',
            ]);

            $produk = Produk::findOrFail($request->product_id);
            $total_price = $request->quantity * $produk->harga;
            $iSKategori = $produk->kategori_id; 

            $lastOrder = Order::latest('id')->value('nomor_pesanan');
            if ($lastOrder) {
                $lastNumber = (int) substr($lastOrder, strlen('ORD' . $iSKategori));
                $newNumber = 'ORD' . $iSKategori . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $newNumber = 'ORD' . $iSKategori . '00001';
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'nomor_pesanan' => $newNumber,
                'nama_pemesan' => $request->nama_pemesan,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $total_price,
                'status' => 'pending',
                'konfirmasi' => 'belum',
                'id_kategori_pesanan' => $request->id_kategori_pesanan
            ]);

            return response()->json([
                'status' => 'success',
                'data' => $order
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getShowMyOrder(Request $request)
    {
        try {
            $orders = Order::with([
                'product' => function ($query) {
                    $query->select('id', 'nama', 'deskripsi', 'harga', 'kategori_id', 'gambar', 'created_at', 'updated_at');
                },
                'kategoriPesanan' => function ($query) {
                    $query->select('id', 'nama_kategori');
                }
            ])->where('user_id', $request->user()->id)->get();
    
            $orders->transform(function ($order) {
                if ($order->product && $order->product->gambar) {
                    $order->product->gambar = url('storage/' . $order->product->gambar);
                }
    
                if ($order->kategoriPesanan) {
                    $order->nama_kategori = $order->kategoriPesanan->nama_kategori;
                }
                
                unset($order->kategoriPesanan);
    
                if (isset($order->total_price)) {
                    $order->total_price = 'Rp ' . number_format($order->total_price, 0, ',', '.');
                }
    
                return $order;
            });
    
            return response()->json([
                'status' => 'success',
                'data' => $orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil pesanan pengguna.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function terima(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,id',
            ]);
    
            $order = Order::find($validatedData['order_id']);
            $order->terima = true;
            $order->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Pesanan telah diterima.',
                'data' => $order,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui pesanan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function getShowDetailMyOrder($id)
    {
        try {
            $order = Order::with([
                'user',
                'product' => function ($query) {
                    $query->select('id', 'nama');
                },
                'kategoriPesanan' => function ($query) {
                    $query->select('id', 'nama_kategori', 'deskripsi');
                }
            ])->find($id);
            
            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil detail pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getOrderHistory(Request $request)
    {
        try {
            $orders = Order::with(['product' => function ($query) {
                $query->select('id', 'nama', 'harga', 'gambar', 'kategori_id');
            }])
            ->where('user_id', $request->user()->id) 
            ->where('status', 'completed') 
            ->where('terima', 1)
            ->get();
            $orders->each(function ($order) {
                if ($order->product && $order->product->gambar) {
                    $order->product->gambar = url('storage/' . $order->product->gambar);
                }
            });

            if ($orders->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tidak ada riwayat pesanan.',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Riwayat pesanan berhasil diambil.',
                'data' => $orders
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil riwayat pesanan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserOrders(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $orders = Order::where('user_id', $userId)->get();
            if ($orders->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada Pesanan.',
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $orders,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch orders.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function test()
    {
        try {
            $kategori = KategoriPesanan::find(1); // Kategori dengan ID 1
            $orders = $kategori->orders; // Semua order yang terkait

            return response()->json([
                'status' => 'success',
                'data' => $orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat melakukan pengujian.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
