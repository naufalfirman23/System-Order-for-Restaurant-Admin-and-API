@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2>Edit Produk</h2>
        @if(session('success'))
            <div id="alert" class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div id="alert" class="alert alert-error">{{ session('error') }}</div>
        @endif
        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Untuk update data -->
            
            <div class="mb-3">
                <div class="form-group mb-2">
                    <label for="nama">Nama Produk</label>
                    <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $produk->nama) }}" required>
                </div>

                <div class="form-group mb-2">
                    <label for="harga">Harga Produk</label>
                    <input type="text" id="harga" name="harga" class="form-control" value="Rp {{ number_format($produk->harga, 0, ',', '.') }}" required>
                </div>

                <div class="form-group mb-2">
                    <label for="kategori">Kategori Produk</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ $kategori->id == $produk->kategori_id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="deskripsi">Deskripsi (opsional)</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                <!-- Menampilkan gambar saat ini -->
                <div class="form-group mb-2">
                    <label for="gambar">Gambar Produk (opsional)</label>
                    @if($produk->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" class="img-fluid" width="200">
                        </div>
                    @endif
                    <input type="file" id="gambar" name="gambar" class="form-control">
                </div>
            </div>
        
            <button type="submit" class="btn btn-success">Update Produk</button>
        </form>
    </div>
</div>
@endsection
