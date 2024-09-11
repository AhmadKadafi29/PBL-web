<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notifikasi Penting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (!empty($notifications['lowStock']) && count($notifications['lowStock']) > 0)
                    <h6>Stok Obat Hampir Habis:</h6>
                    <ul>
                        @foreach ($notifications['lowStock'] as $obat)
                            <li>Stok obat {{ $obat['merek_obat'] }} hampir habis. Stok tersisa: {{ $obat['stok_obat'] }}
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if (!empty($notifications['expiredSoon']) && count($notifications['expiredSoon']) > 0)
                    <h6>Obat Hampir Kadaluarsa:</h6>
                    <ul>
                        @foreach ($notifications['expiredSoon'] as $obat)
                            <li>Obat {{ $obat['merek_obat'] }} akan segera kadaluarsa pada
                                {{ \Carbon\Carbon::parse($obat['tanggal_kadaluarsa'])->format('d-m-Y') }}.</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
            </li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle">
            <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
                <i class="far fa-bell"></i>
                @if ($unreadCount > 0)
                    <span class="badge badge-danger">{{ $unreadCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifikasi
                    <div class="float-right">
                        <a href="#">Tandai Semua Telah Dibaca</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @if (!empty($notifications['lowStock']) && count($notifications['lowStock']) > 0)
                        @foreach ($notifications['lowStock'] as $obat)
                            <a href="#" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-icon bg-danger text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    Stok obat {{ $obat['merek_obat'] }} hampir habis.
                                    <div class="time text-danger">Stok tersisa {{ $obat['stok_obat'] }}</div>
                                </div>
                            </a>
                        @endforeach
                    @endif
                    @if (!empty($notifications['expiredSoon']) && count($notifications['expiredSoon']) > 0)
                        @foreach ($notifications['expiredSoon'] as $obat)
                            <a href="#" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-icon bg-warning text-white">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                    Obat {{ $obat['merek_obat'] }} akan segera kadaluarsa.
                                    <div class="time text-warning">Kadaluarsa:
                                        {{ \Carbon\Carbon::parse($obat['tanggal_kadaluarsa'])->format('d-m-Y') }}</div>
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
<script type="text/javascript">
    $(document).ready(function() {
        @if (
            (!empty($notifications['lowStock']) && count($notifications['lowStock']) > 0) ||
                (!empty($notifications['expiredSoon']) && count($notifications['expiredSoon']) > 0))
            $('#notificationModal').modal('show');
        @endif
    });
</script>
