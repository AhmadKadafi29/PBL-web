@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laporan Penjualan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Laporan</a></div>
                    <div class="breadcrumb-item">Laporan Penjualan</div>
                </div>
            </div>
            <div class="section-body">
                <div class="container mt-4">
                    <h2>Generate Laporan Penjualan Berdasarkan Rentang Tanggal</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('laporan-penjualan.generate') }}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        value="{{ old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai"
                                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        value="{{ old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 30px;">
                                <button type="submit" class="btn btn-primary">Generate Laporan</button>
                            </div>
                        </div>
                    </form>

                    @if (isset($laporanPenjualan))
                        <h3>Laporan Penjualan dari {{ $tanggal_mulai }} sampai {{ $tanggal_selesai }}</h3>

                        @if ($laporanPenjualan->isEmpty())
                            <div class="alert alert-warning">Tidak ada penjualan untuk periode ini.</div>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Jumlah Penjualan</th>
                                        <th>Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal Penjualan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanPenjualan as $penjualan)
                                        <tr>
                                            <td>{{ $penjualan->obat->merek_obat }}</td>
                                            <td>{{ $penjualan->jumlah_jual }}</td>
                                            <td>{{ $penjualan->obat->kemasan }}</td>
                                            <td>Rp
                                                {{ number_format($penjualan->harga_jual_satuan * $penjualan->jumlah_jual, 2) }}
                                            </td>
                                            <td>
                                                @if ($penjualan->penjualan_resep)
                                                    {{ $penjualan->penjualan_resep->tanggal_penjualan }}
                                                @elseif ($penjualan->penjualan)
                                                    {{ $penjualan->penjualan->tanggal_penjualan }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" align="right"><strong>Total :</strong></td>
                                        <td>Rp {{ number_format($total, 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <form action="{{ route('laporan-penjualan.cetak') }}" method="get">
                                @csrf
                                <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
                                <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
                                <button type="submit" class="btn btn-success">Cetak Laporan</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
