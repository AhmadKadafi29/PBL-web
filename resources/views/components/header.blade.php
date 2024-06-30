<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi
                    <div class="float-right">
                        <a href="#">Tandai Semua Telah Dibaca</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @if (isset($notifications['lowStock']) && $notifications['lowStock']->count() > 0)
                        @foreach ($notifications['lowStock'] as $obat)
                            <a href="#" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-icon bg-danger text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    Stok obat {{ $obat->obat->merek_obat }} hampir habis.
                                    <div class="time text-danger">Stok tersisa {{ $obat->stok_obat }}</div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    @if (isset($notifications['expiredSoon']) && $notifications['expiredSoon']->count() > 0)
                        @foreach ($notifications['expiredSoon'] as $obat)
                            <a href="#" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-icon bg-warning text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    Obat {{ $obat->obat->merek_obat }} akan segera kadaluarsa.
                                    <div class="time text-warning">Kadaluarsa:
                                        {{ $obat->tanggal_kadaluarsa->format('d-m-Y') }}</div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">Lihat Semua <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                {{-- <a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a> --}}
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit()">

                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
