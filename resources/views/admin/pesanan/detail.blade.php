@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2 class="mb-4 text-utama text-uppercase fw-bolder text-xl">Detail Pesanan</h2>

        <!-- Kolom Pencarian -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nomor, nama, atau kategori...">
            </div>
        </div>

        <!-- Daftar Pesanan dalam Card -->
        <div class="row" id="ordersContainer">
            <!-- Pesanan 1 -->
            @foreach ($order as $item)
                <div class="col-md-4 mb-3 order-card">
                    <div class="card shadow-sm">
                        <div class="card-header warna-utama text-white">
                            <h5 class="card-title fw-bold">Pesanan #{{ $item->nomor_pesanan }}</h5>
                            <small>Nama: {{ $item->nama_pemesan }}</small>
                        </div>
                        <div class="card-body">
                            <p><strong>Kategori:</strong> {{ $item->kategoriPesanan->nama_kategori }}</p>
                            <p><strong>Total:</strong> {{ 'Rp. ' . number_format($item->total_price, 0, ',', '.') }}</p>
                            <p><strong>Status:</strong>
                                @if ($item->status  == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($item->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Cancel</span>
                                @endif
                            </p>
                            <hr>
                            <h6>Detail Item:</h6>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $item->product->nama }}</span> <span>{{ 'Rp. ' . number_format($item->product->harga, 0, ',', '.') }} x {{ $item->quantity }}</span>
                                </li>
                            </ul>
                            <div class="mt-3 d-flex justify-content-end">
                                <button class="btn btn-success btn-sm me-2"><i class="fas fa-edit"></i>Selesai</button>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Script pencarian
    document.getElementById('searchInput').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const orderCards = document.querySelectorAll('.order-card');

        orderCards.forEach(card => {
            const cardText = card.textContent.toLowerCase();
            if (cardText.includes(searchValue)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection
