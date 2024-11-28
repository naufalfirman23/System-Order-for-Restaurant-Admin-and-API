@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2 class="mb-4 text-utama text-uppercase fw-bolder text-xl">Pesanan</h2>

        <!-- Kolom Pencarian -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nomor, nama, atau kategori...">
            </div>
        </div>

        <!-- Tabel Daftar Pesanan -->
        <div class="table-responsive">
            <div class="card p-4">
                <div class="card-header mb-2 text-center">
                    <h2>Tabel Pesanan</h2>
                </div>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Nama Pemesan</th>
                            <th>Kategori</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Detail Item</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody"">
                        @foreach ($order as $item)
                        <tr>
                            <td>#{{ $item->nomor_pesanan }}</td>
                            <td>{{ $item->nama_pemesan }}</td>
                            <td>{{ $item->kategoriPesanan->nama_kategori }}</td>
                            <td>{{ 'Rp. ' . number_format($item->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($item->status == 'candeled')
                                    <span class="badge bg-danger">Canceled</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <span>{{ $item->product->nama }}</span> 
                                <span>{{ 'Rp. ' . number_format($item->product->harga, 0, ',', '.') }} x {{ $item->quantity }}</span>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Lihat</button>
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
    // Script pencarian untuk tabel
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#ordersTableBody tr');

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
