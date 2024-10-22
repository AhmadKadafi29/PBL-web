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
                                    <select class="form-control @error('id_obat') is-invalid @enderror" name="id_obat"
                                        onchange="updateNoFaktur()">
                                        @foreach ($obat as $ob)
                                            <option value="{{ $ob->id_obat }}">{{ $ob->merek_obat }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_obat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <strong>Nama Supplier</strong>
                                    <select class="form-control @error('id_supplier') is-invalid @enderror"
                                        name="id_supplier" onchange="updateNoFaktur()">
                                        @foreach ($supplier as $sp)
                                            <option value="{{ $sp->id_supplier }}">{{ $sp->nama_supplier }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                    <input type="date"
                                        class="form-control datepicker @error('tanggal_pembelian') is-invalid @enderror"
                                        id="tanggal_pembelian" name="tanggal_pembelian" onchange="updateNoFaktur()">
                                    @error('tanggal_pembelian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_faktur">No Faktur</label>
                                    <input type="text" name="no_faktur" id="no_faktur" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="status_pembayaran">Status Pembayaran</label>
                                    <select class="form-control @error('status_pembayaran') is-invalid @enderror"
                                        id="status_pembayaran" name="status_pembayaran">
                                        <option value="Lunas">Lunas</option>
                                        <option value="Belum_lunas">Belum lunas</option>
                                    </select>
                                    @error('status_pembayaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <strong>Harga Beli satuan</strong>
                                    <input type="text" name="harga_beli_satuan"
                                        class="form-control @error('harga_beli_satuan') is-invalid @enderror"
                                        onchange="updateTotal()" onchange=" updateHargaJual()">
                                    @error('harga_beli_satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_batch">No Batch</label>
                                    <input type="text" name="no_batch"
                                        class="form-control @error('no_batch') is-invalid @enderror">
                                    @error('no_batch')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                                        name="quantity" onchange="updateTotal()">
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="total_harga">Total Harga</label>
                                    <input type="number" name="total_harga" class="form-control" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
                                    <input type="date"
                                        class="form-control datepicker @error('tanggal_kadaluarsa') is-invalid @enderror"
                                        id="tanggal_kadaluarsa" name="tanggal_kadaluarsa">
                                    @error('tanggal_kadaluarsa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="total_harga">Margin</label>
                                    <input type="number" name="margin"
                                        class="form-control @error('margin') is-empty @enderror"
                                        onchange="updateHargaJual()">
                                    @error('margin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="total_harga">Ongkir Pembelian</label>
                                    <input type="number" name="ongkir"
                                        class="form-control @error('ongkir') is-empty @enderror"
                                        onchange="updateHargaJual()">
                                    @error('ongkir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <strong>Harga Jual satuan</strong>
                                    <input type="text" name="harga_jual_satuan" class="form-control" readonly>
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

            function updateHargaJual() {
                var hargaSatuan = Number(document.getElementsByName('harga_beli_satuan')[0].value);
                var quantity = Number(document.getElementsByName('quantity')[0].value);
                var margin = Number(document.getElementsByName('margin')[0].value);
                var ongkir = Number(document.getElementsByName('ongkir')[0].value)
                const ongkirsatuan = ongkir / quantity;
                var hargajual = hargaSatuan + margin + ongkirsatuan;
                document.getElementsByName('harga_jual_satuan')[0].value = hargajual;
            }
        </script>
    @endsection
@endpush
