@extends('layouts.app')

@section('title', 'Nota Penjualan')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Nota Penjualan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Penjualan</div>
                <div class="breadcrumb-item active">Nota Penjualan</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Nota Penjualan</h2>
                                <div class="invoice-number">ID Transaksi: #{{ $penjualan->id }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Nama Kasir :</strong>
                                        {{ auth()->user()->name }}

                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Nama Barang</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penjualan->items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->obat->nama_obat }}</td>
                                                <td>Rp {{ number_format($item->harga_obat, 0, ',', '.') }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-8">
                            <div class="section-title">Pembayaran</div>
                            <p>Jumlah Dibayar: Rp {{ number_format($penjualan->jumlah_dibayar, 0, ',', '.') }}</p>
                            <p class="text-muted">Total Bayar: Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-lg-4 text-right">
                            <p>Kembalian: Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="text-md-right">
                                <div class="invoice-detail-item">Tanggal Transaksi:
                                    {{ $penjualan->ctanggal_penjualan->format('d F Y H:i:s') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <button onclick="window.print()" class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i>
                        Cetak Nota</button>
                </div>
            </div>
        </div>
    </section>
@endsection
