<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><img src="{{ asset('img/sarkara.jpg') }}" alt="" width="120" height="60"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html"></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header mt-4">Apotek Sarkara</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('home') }}">General Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown ">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-pills"></i><span>Obat</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('Obat.index') }}">Obat list</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('Kategori.index') }}">Kategori obat</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('Obatkadaluarsa.index') }}">Obat Kadaluarsa list</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">

                <a class="nav-link" href="{{ route('Supplier.index') }}"><i
                        class="fas fa-boxes-packing"></i><span>Supplier</span></a>
            </li>
            <li class="nav-item">

                <a class="nav-link" href="{{ route('Pembelian.index') }}">
                    <i class="fa-solid fa-cart-shopping"></i><span>Pembelian</span></a>
            </li>

            <li class="nav-item">

                <a class="nav-link" href="{{ route('Stok_opname.index') }}">
                    <i class="fa-solid fa-tablets"></i><span>Stok Opname</span></a>
            </li>

            <li class="nav-item">

                <a class="nav-link" href="{{ route('penjualan.index') }}">
                    <i class="fa-solid fa-cart-shopping"></i><span>Penjualan</span></a>
            </li>
            <li class="nav-item dropdown ">
                <a href="" class="nav-link has-dropdown"><i class="fa fa-clipboard"
                        aria-hidden="true"></i><span>Laporan</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('laporan-penjualan.index') }}">Laporan Penjualan</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('laporan-pembelian.index') }}">Laporan Pembelian</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Laporan Laba & Rugi</a>
                    </li>
                </ul>
            </li>

        </ul>
    </aside>
</div>
