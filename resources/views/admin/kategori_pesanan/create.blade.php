@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2 class="mb-4 text-utama text-uppercase fw-bolder text-xl">Tambah Kategori Pesanan</h2>
    
        @if(session('success'))
            <div id="alert" class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        <form action="{{ route('admin.pesanan.kategori.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nama">Nama Kategori</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="deskripsi">Deskripsi Kategori</label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="{{ old('deskripsi') }}" required>
                @error('deskripsi')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.pesanan.kategori.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection