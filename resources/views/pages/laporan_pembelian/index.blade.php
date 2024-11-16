@extends('layouts.app')

@section('title', 'Laporan Pembelian')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laporan Pembelian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Laporan</a></div>
                    <div class="breadcrumb-item"><a href="#">Laporan Pembelian</a></div>
                </div>
            </div>
            <div class="section-body">
                <div class="container mt-4">
                    <h2>Generate Laporan Pembelian Berdasarkan Rentang Tanggal</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('laporan-pembelian.generate') }}" method="post">
                        @csrf
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                           value="{{ old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
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

                    @if (isset($laporanPembelian))
                        <h3>Laporan Pembelian dari {{ $tanggal_mulai }} sampai {{ $tanggal_selesai }}</h3>

                        @if($laporanPembelian->isEmpty())
                            <div class="alert alert-warning">Tidak ada pembelian untuk periode ini.</div>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Pembelian</th>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Harga Beli Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal Pembelian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($laporanPembelian as $pembelian)
                                        <tr>
                                            <td>{{ $pembelian->id_pembelian }}</td>
                                            <td>{{ $pembelian->merek_obat }}</td>
                                            <td>{{ $pembelian->quantity }}</td>
                                            <td>Rp {{ number_format($pembelian->harga_beli_satuan, 2) }}</td>
                                            <td>Rp {{ number_format($pembelian->harga_beli_satuan * $pembelian->quantity, 2) }}</td>
                                            <td>{{ $pembelian->tanggal_pembelian }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" align="right"><strong>Total :</strong></td>
                                        <td>Rp. {{ number_format($total, 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <form action="{{ route('laporan-pembelian.cetak') }}" method="get">
                                @csrf
                                <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
                                <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
                                <button type="submit" align="right" class="btn btn-success">Cetak Laporan</button>
                            </form>
                        @endif
                    @endif
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