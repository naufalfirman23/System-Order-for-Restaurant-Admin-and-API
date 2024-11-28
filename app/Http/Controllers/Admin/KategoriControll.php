<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriControll extends Controller
{
    public function index()
    {
        $data = KategoriProduk::all();
        return view('admin.kategori.index', compact('data'));
    }

    public function create()
    {
        return view('admin.kategori.create');  // Menampilkan view untuk form
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        KategoriProduk::create([
            'nama' => $request->nama,
        ]);

        // Redirect ke halaman kategori dengan pesan sukses
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $category = KategoriProduk::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.kategori.index')->with('error', 'Kategori berhasil dihapus!');
    }

    public function edit($id)
    {
        $category = KategoriProduk::findOrFail($id);  
        return view('admin.kategori.edit', compact('category'));  
    }

    // Mengupdate kategori
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $category = KategoriProduk::findOrFail($id);

        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }
}
