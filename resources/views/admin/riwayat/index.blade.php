@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2 class="mb-4 text-utama text-uppercase fw-bolder text-xl">Riwayat</h2>

        <!-- Info Boxes -->
        <div class="row text-center mb-4">
            @foreach ($order_kategori as $kategori => $jumlah_order)
                <div class="col-md-6">
                    <div class="card bg-white shadow-sm p-3">
                        <h4 class="text-utama">{{ $jumlah_order }}</h4>
                        <p>{{ $kategori }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Chart and Total -->
        <div class="row">
            <div class="col-12">
                <div class="card p-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-3">Pendapatan</h5>
                        <div class="text-end">
                            <h5 class="mb-1">TOTAL SEMUA</h5>
                            <h4 class="text-utama">{{ 'Rp. ' . number_format($total_pendapatan, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Profit and Line Chart -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <h5 class="mb-3 text-center">Total Laba Pendapatan %</h5>
                    <canvas id="pieChart" style="max-width: 200px; margin: 0 auto;"></canvas>
                    <p class="text-center mt-3"><span class="badge warna-utama">75%</span> Dine In</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-4 shadow-sm">
                    <h5 class="mb-3">Pendapatan Mingguan</h5>
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Pie Chart: Order Kategori
    let orderKategoriData = [];
    @foreach ($order_kategori as $kategori => $jumlah_order)
        orderKategoriData.push({
            kategori: "{{ $kategori }}", 
            jumlah_order: {{ $jumlah_order }}
        });
    @endforeach

    console.log(orderKategoriData);

    const labelsPie = orderKategoriData.map(item => item.kategori);
    const dataPie = orderKategoriData.map(item => item.jumlah_order);

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: labelsPie, 
            datasets: [{
                data: dataPie, 
                backgroundColor: ['rgba(231, 183, 21)', 'rgba(255, 99, 132)', 'rgba(54, 162, 235)', 'rgba(153, 102, 255)'], // Warna untuk masing-masing kategori
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true 
                }
            }
        }
    });

    // Bar Chart: Pendapatan per Bulan
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: @json($bulan), 
            datasets: [{
                label: 'Pendapatan',
                data: @json($saldo),
                backgroundColor: 'rgba(231, 183, 21, 0.7)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Line Chart: Pendapatan Mingguan
    let pendapatanPerMinggu = @json($pendapatan_per_minggu);
    
    // Pastikan data pendapatan per minggu ada dan valid
    if (pendapatanPerMinggu && pendapatanPerMinggu.length > 0) {
        const labelsLine = pendapatanPerMinggu.map(item => item.hari);  
        const dataLine = pendapatanPerMinggu.map(item => item.total_pendapatan); 

        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: labelsLine, 
                datasets: [{
                    label: 'Pendapatan Mingguan',
                    data: dataLine, 
                    fill: true,
                    backgroundColor: 'rgba(231, 183, 21, 0.2)', 
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    } else {
        console.error("Data pendapatan per minggu tidak ditemukan atau tidak valid.");
    }
</script>

@endsection
