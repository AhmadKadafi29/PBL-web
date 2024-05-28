@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Pembelian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pembelian</a></div>
                    <div class="breadcrumb-item">Tambah Pembelian</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('Pembelian.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <strong>Nama Obat</strong>
                                    <select class="form-control" name="id_obat" onchange="updateNoFaktur()">
                                        @foreach ($obat as $ob)
                                            <option value="{{ $ob->id_obat }}">{{ $ob->nama_obat }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <strong>Nama Supplier</strong>
                                    <select class="form-control" name="id_supplier" onchange="updateNoFaktur()">
                                        @foreach ($supplier as $sp)
                                            <option value="{{ $sp->id_supplier }}">{{ $sp->nama_supplier }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                    <input type="date" class="form-control datepicker" id="tanggal_pembelian"
                                        name="tanggal_pembelian" onchange="updateNoFaktur()">
                                </div>
                                <div class="form-group">
                                    <label for="no_faktur">No Faktur</label>
                                    <input type="text" name="no_faktur" id="no_faktur" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="status_pembayaran">Status Pembayaran</label>
                                    <select class="form-control" id="status_pembayaran" name="status_pembayaran">
                                        <option value="Lunas">Lunas</option>
                                        <option value="Belum_lunas">Belum lunas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <strong>Harga satuan</strong>
                                    <input type="text" name="harga_beli_satuan" class="form-control"
                                        onchange="updateTotal()">
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control " name="quantity" onchange="updateTotal()">
                                </div>
                                <div class="form-group">
                                    <label for="total_harga">Total Harga</label>
                                    <input type="number" name="total_harga" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
                                    <input type="date" class="form-control datepicker" id="tanggal_kadaluarsa"
                                        name="tanggal_kadaluarsa" >
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary"
                                        style="width: 90px; height:40px; font-size:15px">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    @section('js')
        <script>
            function updateTotal() {
                var hargaSatuan = document.getElementsByName('harga_beli_satuan')[0].value;
                var quantity = document.getElementsByName('quantity')[0].value;
                var totalHarga = hargaSatuan * quantity;
                document.getElementsByName('total_harga')[0].value = totalHarga;
            }

            function updateNoFaktur() {
                var idObat = document.getElementsByName('id_obat')[0].value;
                var idSupplier = document.getElementsByName('id_supplier')[0].value;
                var tanggalPembelian = document.getElementsByName('tanggal_pembelian')[0].value;

                // Create noFaktur from the combination of id obat, supplier, and tanggal pembelian
                if (idObat && idSupplier && tanggalPembelian) {
                    // Buat noFaktur dari kombinasi id obat, supplier, dan tanggal pembelian
                    var noFaktur = idObat + idSupplier + tanggalPembelian.replace(/-/g, '');

                    // Set nilai no_faktur pada input field
                    document.getElementsByName('no_faktur')[0].value = noFaktur;
                }
            }
        </script>
    @endsection
@endpush
