@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2>Tambah Produk</h2>
        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <!-- Input Nama Produk -->
                <div class="form-group mb-2">
                    <label for="nama">Nama Produk</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>
            
                <!-- Input Harga Produk -->
                <div class="form-group mb-2">
                    <label for="harga">Harga Produk</label>
                    <input type="number" id="harga" name="harga" class="form-control" required>
                </div>
        
                <!-- Input Kategori Produk -->
                <div class="form-group mb-2">
                    <label for="kategori">Kategori Produk</label>
                    <select name="kategori" id="kategori" class="form-control" style="height: 50px">
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($kategori as $kategoris)
                            <option value="{{ $kategoris->id }}">{{ $kategoris->nama }}</option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Input Gambar -->
                <div class="form-group mb-2">
                    <label for="gambar">Gambar Produk</label>
                    <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
                </div>
        
                <!-- Input Deskripsi Produk -->
                <div class="form-group mb-2">
                    <label for="deskripsi">Deskripsi (opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control"></textarea>
                </div>
            </div>
        
            <button type="submit" class="btn btn-success">Tambah</button>
        </form>
        
    </div>
</div>
@endsection
@section('scripts')
<script>
    function formatRupiah(input) {
        let value = input.value.replace(/[^\d]/g, ''); // Hapus semua karakter yang bukan angka
        if (value) {
            value = value.replace(/(\d)(\d{3})(?=\d)/g, '$1.$2'); // Format dengan titik sebagai pemisah ribuan
            input.value = 'Rp ' + value; // Tambahkan "Rp" di depan nilai
        } else {
            input.value = ''; // Kosongkan jika tidak ada input
        }
    }
</script>

@endsection