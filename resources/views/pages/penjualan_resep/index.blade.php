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
                <h1>Penjualan Dengan Resep</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pejualan</a></div>

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
                                <h4>Penjualan Resep</h4>
                                <div class="section-header-button">
                                    <a href="{{ route('penjualanresep.create') }}" class="btn btn-primary">Tambah Resep</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <form action="{{ url('/penjualanresep/tambah-keranjang') }}" method="post"
                                            class="mb-3">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="merek_obat">Merek Obat</label>
                                                    <input type="text" name="merek_obat" id="merek_obat"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label for="stok_obat">Stok</label>
                                                    <input type="text" name="stok_obat" id="stok_obat"
                                                        class="form-control" readonly>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="harga_obat">Harga</label>
                                                    <input type="text" name="harga_obat" id="harga_obat"
                                                        class="form-control" readonly>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="jumlah">Jumlah Beli</label>
                                                    <input type="number" name="jumlah" value="1"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group col-md-2 mt-2">
                                                    <button type="submit" class="btn btn-primary mt-4">Tambah</button>
                                                </div>
                                            </div>
                                        </form>
                                        <form action="{{ route('penjualanresep.hapus-keranjang') }}" method="post">
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
                                             
                                                <th>Merek Obat</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                            {{-- @dd($keranjang) --}}
                                            @foreach ($keranjang as $index => $item)
                                                <tr>
                                                   
                                                    <td>{{ $item['nama_obat'] }}</td>
                                                    <td>{{ $item['harga_jual_obat'] }}</td>
                                                    <td>{{ $item['jumlah'] }}</td>
                                                    <td>{{ $item['Satuan'] }}</td>
                                                    <td>{{ $item['total_harga'] }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <form
                                                                action="{{ route('penjualanresep.hapusItemKeranjang', $index) }}"
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
                                    <form action="{{ route('penjualanresep.checkout') }}" method="post">
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
            $('#merek_obat').on('input', function() {
                // Ambil nilai ID obat dari input
                var nama = $(this).val();
                $.ajax({
                    url: "{{ url('/penjualan/cari-obat') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_obat: nama
                    },
                    success: function(response) {
                        $('#nama_obat').val(response.nama_obat);
                        $('#stok_obat').val(response.stok_obat);
                        $('#harga_obat').val(response.harga_obat);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('#jumlah_dibayar').on('input', function() {
                // Ambil nilai total bayar dan jumlah dibayar
                var totalBayar = parseFloat('{{ $totalBayar }}');
                var jumlahDibayar = parseFloat($(this).val());

                // Hitung kembalian
                var kembalian = jumlahDibayar - totalBayar;

                // Perbarui nilai input kembalian
                $('#kembalian').val(kembalian
                    .toFixed()); // Menampilkan kembalian dengan dua angka di belakang koma
            });
        });
    </script>
@endpush
