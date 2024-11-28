@if(Auth::check() && Auth::user()->role === 'admin')
<div id="layoutSidenav_nav">
    <nav class="sidenav warna-utama shadow-right sidenav-light text-white">
        <div class="sidenav-menu">
            <!-- Logo -->
            <a href="/dashboard" class="d-flex justify-content-center align-items-center pt-10" style="display: flex; justify-content: center; align-items: center; height: 70px;">
                <img src="{{ asset('assets/img/logo-hanachik.png') }}" alt="gambar logo" style="max-width: 80%; height: auto; object-fit: contain;">
            </a>
            
            <!-- List Menu -->
            <div class="fw-bold pt-10">
                <a href="/dashboard" 
                   class="nav-link mb-2 py-3 d-flex align-items-center {{ Request::is('dashboard') ? 'active text-lg text-utama' : '' }}" >
                    <i class="fa-solid fa-house-chimney me-2"></i>
                    Beranda
                </a>

                <a href="/pesanan" 
                   class="nav-link mb-2 py-3 d-flex align-items-center {{ Request::is('pesanan') ? 'active text-lg text-utama' : '' }}">
                    <i class="fas fa-folder me-2"></i>
                    Pesanan
                </a>

                <a href="/riwayat" 
                   class="nav-link mb-2 py-3 d-flex align-items-center {{ Request::is('riwayat') ? 'active text-lg text-utama' : '' }}">
                    <i class="fas fa-clock-rotate-left me-2"></i>
                    Riwayat
                </a>
                <a href="/produk" 
                   class="nav-link  mb-2 py-3 d-flex align-items-center {{ Request::is('produk') ? 'active text-lg text-utama' : '' }}">
                   <i class="fa-solid fa-database me-2"></i>
                    Kelola Produk
                </a>
                <a href="/produks/kategori" 
                   class="nav-link  mb-2 py-3 d-flex align-items-center {{ Request::is('produks/kategori') ? 'active text-lg text-utama' : '' }}">
                   <i class="fa-solid fa-database me-2"></i>
                    Kategori Produk
                </a>
                <a href="/pesanan/kategori" 
                   class="nav-link  mb-10 py-3 d-flex align-items-center {{ Request::is('pesanan/kategori') ? 'active text-lg text-utama' : '' }}">
                   <i class="fa-solid fa-database me-2"></i>
                    Kategori Pesanan
                </a>
            </div>
        </div>
    </nav>
</div>
@endif
