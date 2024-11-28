<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPesanan;
use Illuminate\Http\Request;

class KategoriPesananControll extends Controller
{
    public function index()
    {
        $data = KategoriPesanan::all();
        return view('admin.kategori_pesanan.index', compact('data'));
    }
    public function destroy($id)
    {
        $category = KategoriPesanan::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.pesanan.kategori.index')->with('error', 'Kategori berhasil dihapus!');
    }
    public function create()
    {
        return view('admin.kategori_pesanan.create');  // Menampilkan view untuk form
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);

        KategoriPesanan::create([
            'nama_kategori' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        // Redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('admin.pesanan.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = KategoriPesanan::findOrFail($id);  
        return view('admin.kategori_pesanan.edit', compact('category'));  
    }

    // Mengupdate kategori
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);
        $category = KategoriPesanan::findOrFail($id);

        $category->update([
            'nama_kategori' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.pesanan.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }
}
