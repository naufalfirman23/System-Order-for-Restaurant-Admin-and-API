@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2 class="mb-4 text-utama text-uppercase fw-bolder text-xl">Kategori Pesanan</h2>
        @if(session('success'))
            <div id="alert" class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div id="alert" class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <a href="/pesanan/kategori/create" class="btn btn-success mb-4">Tambah Kategori</a>
        
        <div class="card p-3 mb-4">
            <div class="card-header">
                <div class="row align-items-center">
                    <h1>Tabel Kategori</h1> 
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered order-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>Kategori {{ $item->nama_kategori }}</td>
                            <td>
                                <a href="{{ route('admin.pesanan.kategori.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.pesanan.kategori.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection