@extends('layouts.app')

@section('title', 'Tambah Pengembalian Obat')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Pengembalian Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pengembalian</a></div>
                    <div class="breadcrumb-item">Tambah Pengembalian</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form method="POST" action="{{ route('pengembalian-obat.store') }}">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Form Input Faktur -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="no_faktur">No Faktur</label>
                                        <div class="input-group">
                                            <input type="text" name="no_faktur" id="no_faktur" class="form-control"
                                                placeholder="Masukkan No Faktur">
                                            <button class="btn btn-primary input-group-append" type="button"
                                                onclick="fetchDataFaktur()"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                        <input type="date" class="form-control" id="tanggal_pembelian"
                                            name="tanggal_pembelian" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="supplier">Supplier</label>
                                        <input type="text" name="supplier" id="supplier" class="form-control" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                                        <input type="date" class="form-control" id="tanggal_pengembalian"
                                            name="tanggal_pengembalian">
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="reset" class="btn btn-secondary"
                                        onclick="resetDataObat()">Reset</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                                <div class="col-lg-6">
                                    <input type="number" name="total" id="totalpengembalian" class="form-control"
                                        readonly>
                                </div>
                            </div>

                            <!-- Tabel Pengembalian Obat -->
                            <div class="table-responsive mt-3">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Aksi</th>
                                            <th>Nama Obat</th>
                                            <th>No Batch</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Stok Obat (Box)</th>
                                            <th>Stok Obat Terkecil</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah Dikembalikan (Box)</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableDataFaktur">
                                        <!-- Data akan diisi oleh JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @section('js')
        <script>
            async function fetchDataFaktur() {
                const searchQuery = document.getElementById('no_faktur').value;
                const supplier = document.getElementById('supplier');
                const tanggal_pembelian = document.getElementById('tanggal_pembelian');
                const url = `{{ route('search-faktur') }}`;

                try {
                    const response = await fetch(`${url}?no_faktur=${encodeURIComponent(searchQuery)}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }

                    const data = await response.json();
                    console.log(data)
                    const tableDataFaktur = document.getElementById('tableDataFaktur');

                    if (tableDataFaktur) {

                        tableDataFaktur.innerHTML = "";

                        data.forEach(function(faktur) {

                            supplier.value = `${faktur.nama_supplier}`;
                            tanggal_pembelian.value = `${faktur.tanggal_pembelian}`;
                            stok = faktur.stok;

                            faktur.detail_pembelian.forEach((detail, index) => {
                                const newRow = document.createElement('tr');
                                newRow.setAttribute('id', `obat.${detail.no_batch}`)
                                newRow.innerHTML = `
                                        <tr>
                                                <td><button onclick ="hapusItemPembelianObat(this)" class="btn btn-link"><i class="fa-solid fa-trash""></i></button></td>
                                                <input type="hidden" name="id_obat[]" class="total" value="${detail.id_obat}"readonly>
                                                <td><input type="text" name="merek_obat[]" class="total" value="${detail.merek_obat}" readonly></td>
                                                <td><input type="text" name="no_batch[]" class="total" value="${detail.no_batch}"readonly></td>
                                                <td><input type="date" name="tanggal_kadaluarsa[]" class="total" value="${stok[index].tanggal_kadaluarsa}"readonly></td>
                                                <td><input type="number" name="stok_box[]" class="stok_box" value="${stok[index].stok_box}"readonly ></td>
                                                <td><input type="number" name="stok_terkecil[]" class="stok_terkecil" value="${stok[index].stok_terkecil}"readonly ></td>
                                                <td>${detail.harga_satuan}<input type="hidden" class="harga_satuan" value="${detail.harga_satuan}"></td>
                                                <td><input type="number" name="jumlah_retur[]" class="jumlah-retur" onchange="updatesubtotal(this)" ></td>
                                                <td><input type="number" name="subtotal[]" class="subtotal" readonly></td>
                                                
                                        </tr>
                                    `;
                                tableDataFaktur.appendChild(newRow);

                            })

                        });
                    } else {
                        console.error('tableDataFaktur element not found');
                    }

                } catch (error) {
                    console.error('Error fetching faktur data:', error);
                }
            }


            function hapusItemPembelianObat(element) {
                const item = element.closest('tr');
                item.remove();
                TotalPengembalian();
            }

            function updatesubtotal(element) {
                const row = element.closest('tr');
                const jumlahRetur = parseInt(row.querySelector('.jumlah-retur').value || 0);
                const stok1 = parseInt(row.querySelector('.stok_1').value || 0);
                const hargaSatuan = parseFloat(row.querySelector('.harga_satuan').value || 0);
                const subtotal = row.querySelector('.subtotal');

                if (jumlahRetur > stok1) {
                    alert("Jumlah retur tidak boleh lebih besar dari stok!");
                    row.querySelector('.jumlah-retur').value = 0;
                    subtotal.value = 0;
                } else {
                    subtotal.value = jumlahRetur * hargaSatuan;
                }
                TotalPengembalian();
            }

            function TotalPengembalian() {
                const totalElement = document.getElementById('totalpengembalian');
                const subtotals = document.querySelectorAll('.subtotal');
                let total = 0;
                subtotals.forEach(sub => {
                    total += parseFloat(sub.value || 0);
                });
                totalElement.value = total;
            }

            function resetDataObat() {
                document.getElementById('tableDataFaktur').innerHTML = '';
                document.getElementById('totalpengembalian').value = 0;
            }
        </script>
    @endsection
@endpush
