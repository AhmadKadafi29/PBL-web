@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                                            <option value="{{ $ob->id_obat }}">{{ $ob->merek_obat }}</option>
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
                                <div class="form-group">
                                    <strong>Harga Beli satuan</strong>
                                    <input type="text" name="harga_beli_satuan" class="form-control" onchange="updateTotal()" onchange=" updateHargaJual()">
                                </div>
                                <div class="form-group">
                                    <label for="no_batch">No Batch</label>
                                    <input type="text" name="no_batch" class="form-control" >
                                </div>
                            </div>
                            <div class="col-lg-6">
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
                                <div class="form-group">
                                    <label for="total_harga">Margin</label>
                                    <input type="number" name="margin" class="form-control" onchange="updateHargaJual()">
                                </div>
                                <div class="form-group">
                                    <label for="total_harga">Ongkir Pembelian</label>
                                    <input type="number" name="ongkir" class="form-control" onchange="updateHargaJual()">
                                </div>
                                <div class="form-group">
                                    <strong>Harga Jual satuan</strong>
                                    <input type="text" name="harga_jual_satuan" class="form-control" readonly>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary"
                                        style="width: 90px; height:40px; font-size:15px">Submit</button>
                                </div>

                            <hr style="margin-top: 20px; margin-bottom: 20px;">

                            <!-- Tabel Pembelian Obat -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Nama Obat</th>
                                            <th>Satuan</th>
                                            <th>Jumlah Obat</th>
                                            <th>Harga Beli Satuan</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Margin</th>
                                            <th>Ongkos Kirim</th>
                                            <th>No Batch</th>
                                            <th>Harga Jual Sataun</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="obat-list">
                                        <!-- Data obat yang dipilih dari modal akan ditambahkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus seluruh data obat<span id="deleteObjectName"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" data-dismiss="modal" onclick="resetDataObat()">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal Dialog Daftar Obat -->
    <div class="modal fade" id="obatModal" tabindex="-1" aria-labelledby="obatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-xxl-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="obatModalLabel">Pilih Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="obatForm">
                        <!-- Tabel Daftar Obat -->
                       <div >
                        <table class="table table-bordered table-striped">
                            <!-- Tabel Daftar Obat -->
                            <div class="float-right">
                                <form id="searchForm" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" id="searchObat" name="name">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="fetchDataObat()"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Merek Obat</th>
                                    <th>Dosis</th>
                                    <th>Satuan</th>
                                    <th>Kegunaan</th>
                                    <th>Efek Samping</th>
                                </tr>
                            </thead>
                            <tbody id="tableDataObat">
                                @foreach ($obat as $ob)
                                    <tr>
                                        <td><input type="checkbox" class="obat-checkbox" data-idobat ="{{ $ob->id_obat }}" data-nama="{{ $ob->merek_obat}}" data-kategori="{{  $ob->kategoriObat->nama_kategori }}" data-satuan="{{ $ob->kemasan }}"></td>
                                        <td>{{ $ob->merek_obat }}</td>
                                        <td>{{ $ob->dosis }}</td>
                                        <td>{{ $ob->kemasan }}</td>
                                        <td>{{ $ob->kegunaan }}</td>
                                        <td>{{ $ob->efek_samping }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       </div>
                        {{-- <div class="d-flex justify-content-center">

                                {{ $obat->withQueryString()->links() }}
                        </div> --}}

                    </form>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="tambahkanObat()">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @section('js')
        <script>

            function updateNoFaktur() {
                var idSupplier = document.getElementsByName('id_supplier')[0].value;
                var tanggalPembelian = document.getElementsByName('tanggal_pembelian')[0].value;

                // Buat noFaktur dari kombinasi id supplier dan tanggal pembelian
                if (idSupplier && tanggalPembelian) {
                    var noFaktur = idSupplier + tanggalPembelian.replace(/-/g, '');
                    document.getElementsByName('no_faktur')[0].value = noFaktur;
                }
            }

            function updateHargaJual(){
                    var hargaSatuan = Number(document.getElementsByName('harga_beli_satuan')[0].value);
                    var quantity = Number(document.getElementsByName('quantity')[0].value);
                    var margin = Number(document.getElementsByName('margin')[0].value);
                    var ongkir = Number(document.getElementsByName('ongkir')[0].value)
                    const ongkirsatuan= ongkir/quantity;
                    var hargajual = hargaSatuan +  margin+ ongkirsatuan;
                    document.getElementsByName('harga_jual_satuan')[0].value = hargajual;
                }
        </script>
    @endsection
@endpush
