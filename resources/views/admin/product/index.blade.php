@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2 class="mb-4 text-utama text-uppercase fw-bolder text-xl">Produk</h2>
        @if(session('success'))
            <div id="alert" class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div id="alert" class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <div class="row">
            <!-- Card 1 -->
            @foreach ($kategoris as $kategorinya)
                <div class="col-md-4 mb-4">
                    <div Zzclass="text-decoration-none">
                        <div class="card lawyer-card  shadow-sm border-0 h-100 hover-shadow">
                            <div class="position-relative">
                                <div class="position-absolute" style="width: 8px; height: 100%; background-color: rgba(var(--warna-second-rgb)); left: 0; top: 0;"></div>
                                <div class="card-body text-center">
                                    <h3 class="fw-bold text-dark">{{ $kategorinya->nama }}</h3>
                                    <p class="mb-0 text-muted">{{ $kategorinya->produk_count }} Produk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nomor, nama, atau kategori...">
            </div>
            <div class="col-md-8 d-flex justify-content-end">
                <a href="/produk/create" class="btn btn-success mb-4">Tambah Produk</a>
            </div>
        </div>
        <div class="card p-3 mb-4">
            <div class="card-header">
                <div class="row align-items-center">
                    <h1>Tabel Produk</h1> 
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered order-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kategori->nama }}</td>
                            <td>{{ 'Rp. ' . number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.produk.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" style="display:inline-block;">
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
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Mendengarkan input pencarian
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();  // Ambil nilai input dan ubah menjadi huruf kecil
        const rows = document.querySelectorAll('table tbody tr');  // Ambil semua baris dalam tabel

        rows.forEach(row => {
            const nama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const kategori = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const harga = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            // Cek apakah nama, kategori, atau harga cocok dengan nilai input pencarian
            if (nama.includes(searchValue) || kategori.includes(searchValue) || harga.includes(searchValue)) {
                row.style.display = '';  // Tampilkan baris jika cocok
            } else {
                row.style.display = 'none';  // Sembunyikan baris jika tidak cocok
            }
        });
    });
</script>

@endsection