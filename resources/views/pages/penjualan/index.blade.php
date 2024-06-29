@extends('layouts.app')

@section('title', 'Penjualan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Penjualan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Penjualan</a></div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Penjualan</h4>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <form action="{{ url('/penjualan/tambah-keranjang') }}" method="post"
                                            class="mb-3">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="nama_obat">Nama Obat</label>
                                                    <input type="text" name="nama_obat" id="nama_obat"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label for="stok_obat">Stok</label>
                                                    <input type="text" name="stok_obat" id="stok_obat"
                                                        class="form-control" readonly>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="harga_jual">Harga</label>
                                                    <input type="text" name="harga_jual" id="harga_jual"
                                                        class="form-control" readonly>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="jumlah">Jumlah Beli</label>
                                                    <input type="number" name="jumlah"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group col-md-2 mt-2">
                                                    <button type="submit" class="btn btn-primary mt-4">Tambah</button>
                                                </div>
                                            </div>
                                        </form>
                                        <form action="{{ route('penjualan.hapus-keranjang') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2">
                                                <i class="fas fa-trash"></i> Hapus Keranjang
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Kode Obat</th>
                                                <th>Merek Obat</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                            @foreach ($keranjang as $index => $item)
                                                <tr>
                                                    <td>{{ $item['kode_obat'] }}</td>
                                                    <td>{{ $item['nama_obat'] }}</td>
                                                    <td>{{ $item['harga_obat'] }}</td>
                                                    <td>{{ $item['jumlah'] }}</td>
                                                    <td>{{ $item['harga_obat'] * $item['jumlah'] }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <form
                                                                action="{{ route('penjualan.hapusItemKeranjang', $index) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button
                                                                    class="btn btn-sm btn-danger btn-icon confirm-delete ml-2">
                                                                    <i class="fas fa-times"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" align="right"><strong>Total Bayar :</strong></td>
                                                <td>Rp. {{ $totalBayar }}</td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <form action="{{ route('penjualan.checkout') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jumlah_dibayar">Jumlah Dibayar :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                            <input type="number" name="jumlah_dibayar" id="jumlah_dibayar"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="kembalian">Kembalian :</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp</span>
                                                        </div>
                                                        <input type="number" name="kembalian" id="kembalian"
                                                            class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-primary">Checkout</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#nama_obat').on('input', function() {
                // Ambil nilai ID obat dari input
                var nama = $(this).val();
                $.ajax({
                    url: "{{ url('/penjualan/cari-obat') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        merek_obat: nama
                    },
                    success: function(response) {

                        $('#merek_obat').val(response.merek_obat);
                        $('#stok_obat').val(response.stok_obat);
                        $('#harga_jual').val(response.harga_jual);

                    },

                });
            });

            $('#jumlah_dibayar').on('input', function() {
                var totalBayar = parseFloat('{{ $totalBayar }}');
                var jumlahDibayar = parseFloat($(this).val());
                var kembalian = jumlahDibayar - totalBayar;
                $('#kembalian').val(kembalian.toFixed(2));
            });
        });
    </script>
@endpush
