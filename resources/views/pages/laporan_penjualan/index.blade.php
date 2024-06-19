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
                    <div class="breadcrumb-item"><a href="#">Laporan Penjualan</a></div>
                </div>
            </div>
            <div class="section-body">
                <div class="container mt-4">
                    <h2>Generate Laporan Penjualan per Bulan</h2>
                    <form action="{{ route('laporan-penjualan.generate') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" class="form-control" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <select name="tahun" class="form-control" required>
                                        @php
                                            $currentYear = date('Y');
                                        @endphp
                                        @for ($year = $currentYear; $year >= $currentYear - 10; $year--)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 30px;">
                                <button type="submit" class="btn btn-primary">Generate Laporan</button>
                            </div>
                        </div>
                    </form>

                    @if (isset($laporanPenjualan))
                        <h3>Laporan Penjualan Bulan {{ date('F', mktime(0, 0, 0, $bulan, 1)) }} Tahun {{ $tahun }}
                        </h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Penjualan</th>
                                    <th>Nama Obat</th>
                                    <th>Jumlah Penjualan</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanPenjualan as $penjualan)
                                    <tr>
                                        <td>{{ $penjualan->id }}</td>
                                        <td>{{ $penjualan->nama_obat }}</td>
                                        <td>{{ $penjualan->jumlah }}</td>
                                        <td>Rp .{{ $penjualan->total_harga }}</td>
                                        <td>{{ $penjualan->tanggal_penjualan }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" align="right"><strong>Total :</strong></td>
                                    <td>Rp. {{ $total }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <form action="{{ route('laporan-penjualan.cetak') }}" method="get">
                            @csrf
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">
                            <button type="submit" align="right" class="btn btn-success">Cetak Laporan</button>
                        </form>
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
