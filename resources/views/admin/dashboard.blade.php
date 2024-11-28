@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-5">
        <h2 class="mb-4">Halaman Dashboard</h2>

        <!-- Cards -->
        <div class="row justify-content-center">
            <!-- Card Pesanan Terkonfirmasi -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm position-relative">
                    <div class="position-absolute" style="width: 8px; height: 100%; background-color: #f7db8c; left: 0; top: 0;"></div>
                    <div class="card-body text-center">
                        <h3 class="fw-bold" id="count-confirmed">{{ $countConfirmed }}</h3>
                        <p class="mb-0">Pesanan Terkonfirmasi</p>
                    </div>
                </div>
            </div>

            <!-- Card Pesanan Belum Terkonfirmasi -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm position-relative">
                    <div class="position-absolute" style="width: 8px; height: 100%; background-color: #f7db8c; left: 0; top: 0;"></div>
                    <div class="card-body text-center">
                        <h3 class="fw-bold" id="count-not-confirmed">{{ $countNotConfirmed }}</h3>
                        <p class="mb-0">Belum Terkonfirmasi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Sections -->
        <div class="row">
            <!-- Terkonfirmasi -->
            <div class="col-md-6 text-sm">
                <div class="card shadow-sm">
                    <div class="card-header warna-utama text-white fw-bold">Terkonfirmasi</div>
                    <div class="card-body">
                        <!-- Tabel Pesanan Terkonfirmasi -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nomor Pesanan</th>
                                    <th>Nama Pemesan</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="confirmed-orders">
                                @foreach ($orders as $item)
                                @if ($item->konfirmasi == 'sudah' && $item->status !== 'completed')
                                <tr>
                                    <td>{{ $item->nomor_pesanan }}</td>
                                    <td>{{ $item->nama_pemesan }}</td>
                                    <td>{{ $item->product->nama ?? 'Produk tidak ditemukan' }}</td>
                                    <td>{{ $item->kategoriPesanan->nama_kategori ?? 'Kategori tidak ditemukan' }}</td>
                                    <td>
                                        <form action="{{ route('admin.updateStatus.order', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm">
                                                Selesai
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Belum Terkonfirmasi -->
            <div class="col-md-6 text-sm">
                <div class="card shadow-sm">
                    <div class="card-header warna-utama text-white fw-bold">Belum Terkonfirmasi</div>
                    <div class="card-body">
                        <!-- Tabel Pesanan Belum Terkonfirmasi -->
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nomor Pesanan</th>
                                    <th>Nama Pemesan</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="not-confirmed-orders">
                                @foreach ($orders as $item)
                                @if ($item->konfirmasi == 'belum' && $item->status !== 'completed' )
                                <tr>
                                    <td>{{ $item->nomor_pesanan }}</td>
                                    <td>{{ $item->nama_pemesan }}</td>
                                    <td>{{ $item->product->nama }}</td>
                                    <td>{{ $item->kategoriPesanan->nama_kategori }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm btn-confirm" data-id="{{ $item->id }}">Confirm</button>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notConfirmedOrdersList = document.querySelector('#not-confirmed-orders');
        const confirmedOrdersList = document.querySelector('#confirmed-orders');
        const notConfirmedCount = document.querySelector('#count-not-confirmed');
        const confirmedCount = document.querySelector('#count-confirmed');

        // Fetch new orders
        function fetchNewOrders() {
            fetch('{{ route('admin.orders.new') }}')
                .then(response => response.json())
                .then(data => {
                    notConfirmedOrdersList.innerHTML = ''; // Clear the list
                    let newOrdersCount = 0;

                    data.forEach(order => {
                        const listItem = createOrderListItem(order);
                        notConfirmedOrdersList.appendChild(listItem);
                        newOrdersCount++;
                    });

                    notConfirmedCount.textContent = newOrdersCount; // Update the counter
                })
                .catch(error => console.error('Error fetching new orders:', error));
        }

        // Confirm order
        function confirmOrder(orderId, listItem) {
            if (confirm('Apakah Anda yakin ingin mengkonfirmasi pesanan ini?')) {
                fetch(`/admin/orders/confirm/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        confirmedOrdersList.appendChild(listItem);
                        listItem.querySelector('.btn-confirm').remove();
                        updateCounters(-1, 1);
                        alert(data.message);
                    } else {
                        alert('Gagal mengkonfirmasi pesanan.');
                    }
                })
                .catch(error => {
                    console.error('Error confirming order:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            }
        }

        // Create list item for orders
        function createOrderListItem(order) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${order.nomor_pesanan || 'Tidak Diketahui'}</td>
                <td>${order.nama_pemesan || 'Tidak Diketahui'}</td>
                <td>${order.product ? order.product.nama : 'Produk Tidak Diketahui'}</td>
                <td>${order.kategori_pesanan ? order.kategori_pesanan.nama_kategori : 'Kategori Tidak Diketahui'}</td>
                <td>
                    <button class="btn btn-success btn-sm btn-confirm" data-id="${order.id}">Confirm</button>
                </td>
            `;
            row.querySelector('.btn-confirm').addEventListener('click', function () {
                confirmOrder(order.id, row);
                location.reload(); 
            });
            return row;
        }

        function updateCounters(notConfirmedDelta, confirmedDelta) {
            notConfirmedCount.textContent = parseInt(notConfirmedCount.textContent) + notConfirmedDelta;
            confirmedCount.textContent = parseInt(confirmedCount.textContent) + confirmedDelta;
        }

        setInterval(fetchNewOrders, 10000);
    });
</script>
@endsection
