<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $data = Produk::with('kategori')->get();
        $kategoris = KategoriProduk::withCount('produk')->get();
        return view('admin.product.index', compact('data', 'kategoris'));
    }

    public function create()
    {
        $kategori = KategoriProduk::all();
        return view('admin.product.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'kategori' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Menyimpan gambar
        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('images/produk', 'public'); // Menyimpan gambar ke storage/app/public/images
        }

        // Menyimpan produk ke database
        Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori_id' => $request->kategori,
            'gambar' => $gambar,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id); 
        $kategoris = KategoriProduk::all();
        return view('admin.product.edit', compact('produk', 'kategoris')); // Mengirimkan data produk ke view
    }

    public function update(Request $request, $id)
    {
    
        $produk = Produk::findOrFail($id);
    
        // Menangani gambar yang diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
                unlink(public_path('storage/' . $produk->gambar));
            }
            $gambarPath = $request->file('gambar')->store('images/produk', 'public');
        } else {
            $gambarPath = $produk->gambar; // Tetap menggunakan gambar lama jika tidak ada gambar baru
        }
    
        // Update produk
        $produk->update([
            'nama' => $request->nama,
            'harga' => str_replace(['Rp', '.'], '', $request->harga), // Menangani format harga
            'deskripsi' => $request->deskripsi,
            'kategori_id' => $request->kategori,
            'gambar' => $gambarPath, // Menyimpan path gambar
        ]);
    
        return redirect()->route('admin.produk.edit', $produk->id)->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
            unlink(public_path('storage/' . $produk->gambar)); // Hapus gambar
        }
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('error', 'Produk berhasil dihapus');
    }

    
}
