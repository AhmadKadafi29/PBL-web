@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nama_supplier">Nama Supplier</label>
                                        <select class="form-control" name="id_supplier" onchange="updateNoFaktur()"
                                            id="nama_supplier">
                                            @foreach ($supplier as $sp)
                                                <option value="{{ $sp->id_supplier }}">{{ $sp->nama_supplier }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_faktur">No Faktur</label>
                                        <input type="text" name="no_faktur" id="no_faktur" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                        <input type="date" class="form-control datepicker" id="tanggal_pembelian"
                                            name="tanggal_pembelian" onchange="updateNoFaktur()">
                                    </div>
                                    <div class="form-group">
                                        <label for="ongkos_kirim">Ongkos Kirim</label>
                                        <input type="text" name="ongkos_kirim" id="ongkos_kirim" class="form-control">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Button untuk membuka modal daftar obat -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#obatModal" style="margin-right: 10px;">
                                        + Obat
                                    </button>
                                    <button type="reset" class="btn btn-secondary" style="margin-right: 10px;"
                                        data-toggle="modal" data-target="#deleteConfirmationModal">Reset</button>
                                    <button type="submit" class="btn btn-success"
                                        style="margin-right: 10px;">Simpan</button>
                                </div>

                                <div class="col-lg-6">
                                    <!-- Modal -->
                                    <div>
                                        <input type="text" name="total_harga" id="total_harga" class="form-control"
                                            readonly>
                                    </div>

                                </div>
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
                                            <th>Jumlah Beli</th>
                                            <th>Harga beli per satuan</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Margin</th>
                                            {{-- <th>Ongkos Kirim</th> --}}
                                            <th>No Batch</th>
                                            <th>Harga Jual Satuan</th>
                                            <th>Sub Total</th>
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
                    <button type="submit" class="btn btn-danger" data-dismiss="modal"
                        onclick="resetDataObat()">Hapus</button>
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
                        <div>
                            <table class="table table-bordered table-striped">
                                <!-- Tabel Daftar Obat -->
                                <div class="float-right">
                                    <form id="searchForm" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search"
                                                id="searchObat" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="fetchDataObat()"><i class="fas fa-search"></i></button>
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
                                            <td><input type="checkbox" class="obat-checkbox"
                                                    data-idobat ="{{ $ob->id_obat }}" data-nama="{{ $ob->merek_obat }}"
                                                    data-kategori="{{ $ob->kategoriObat->nama_kategori }}"
                                                    data-satuan='@json($ob->detailsatuan)'
                                                    data-konversi-satuan-terkecil='@json($ob->detailsatuan)'></td>
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
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            onclick="tambahkanObat()">Ok</button>
                    </div>
                </div>
            </div>
        </div>
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
            function updateNoFaktur() {
                var idSupplier = document.getElementsByName('id_supplier')[0].value;
                var tanggalPembelian = document.getElementsByName('tanggal_pembelian')[0].value;

                // Buat noFaktur dari kombinasi id supplier dan tanggal pembelian
                if (idSupplier && tanggalPembelian) {
                    var noFaktur = idSupplier + tanggalPembelian.replace(/-/g, '');
                    document.getElementsByName('no_faktur')[0].value = noFaktur;
                }
            }

            function tambahkanObat() {
                // Ambil data dari checkbox yang dicentang di modal
                const selectedObat = document.querySelectorAll('.obat-checkbox:checked');
                const obatList = document.getElementById('obat-list');
                let rowCount = obatList.rows.length;

                selectedObat.forEach((checkbox, index) => {
                    const namaObat = checkbox.getAttribute('data-nama');
                    const idobat = checkbox.getAttribute('data-idobat');
                    const hargaBeli = checkbox.getAttribute('data-harga');
                    const satuan = JSON.parse(checkbox.getAttribute('data-satuan'));

                    let satuanTerbesar = null;
                    let konversiTerbesar = 0;

                    satuan.forEach(satuanItem => {

                        if (satuanItem.satuan_konversi > konversiTerbesar) {
                            konversiTerbesar = satuanItem.satuan_konversi;
                            satuanTerbesar = satuanItem.satuan.nama_satuan;
                        }

                    });


                    console.log('Satuan Terbesar:', satuanTerbesar);
                    console.log('Satuan Terbesar:', konversiTerbesar);


                    const newRow = document.createElement('tr');
                    newRow.setAttribute('id', `obat.${rowCount + index + 1}`)
                    newRow.setAttribute('st', konversiTerbesar)
                    newRow.innerHTML = `
                        <td>${rowCount + index + 1}</td>
                        <td><button onclick="hapusItemObat(this)"  class="btn btn-link"><i class="fa-solid fa-trash""></i></button></td>
                        <td>${namaObat} <input type="hidden" name="merek_obat[]" value="${idobat}"></td>
                       <td>${satuanTerbesar} <input type="hidden" name="satuan[]" value="${satuanTerbesar}"></td>
                        <td><input type="number" name="jumlah_obat[]" class="jumlah-obat" onchange="updateHarga(this)"></td>
                        <td><input type="number" name="harga_beli[]" class="harga-beli" value="${hargaBeli}" onchange="updateHarga(this)"></td>
                        <td><input type="date"   name="tanggal_kadaluarsa[]" class="tanggal-kadaluarsa"></td>
                        <td><input type="number" name="margin[]" class="margin" onchange="updateHarga(this)"></td>
                        <td><input type="number" name="no_batch[]"  class="no_batch"></td>
                        <td><input type="number" name="harga_jual[]" readonly class="harga-jual"></td>
                        <td><input type="number" name="total[]" class="total" ></td>
                    `;
                    obatList.appendChild(newRow);
                });

                const allCheckboxes = document.querySelectorAll('.obat-checkbox');
                allCheckboxes.forEach((checkbox) => {
                    checkbox.checked = false;

                });

                $('#obatModal').modal('hide'); // Menutup modal
                $('.modal-backdrop').remove(); // Hapus overlay modal yang masih tertinggal

            }

            function hapusItemObat(element) {
                const row = element.closest('tr');
                row.remove();


            }

            function updateHarga(element) {
                const row = element.closest('tr');
                const konversiTerbesar = row.getAttribute('st');
                const jumlahObat = parseFloat(row.querySelector('.jumlah-obat').value) || 0;
                const hargaBeli = parseFloat(row.querySelector('.harga-beli').value) || 0;
                const margin = parseFloat(row.querySelector('.margin').value) || 0;
                // const ongkir = document.getElementById('ongkos_kirim').value || 0 ;
                // const ongkir_satuan = ongkir/konversiTerbesar;
                const hargaJual = (hargaBeli / konversiTerbesar) + margin;
                const total = hargaBeli * jumlahObat;
                row.querySelector('.harga-jual').value = hargaJual.toFixed(2);
                row.querySelector('.total').value = total.toFixed(2);


                totalHarga()
            }


            function totalHarga()

            {
                const totalElements = document.querySelectorAll('#obat-list .total');
                const totalHargaInput = document.getElementById('total_harga');

                let grandTotal = 0;
                totalElements.forEach((totalInput) => {
                    const totalValue = parseFloat(totalInput.value) || 0;
                    grandTotal += totalValue;
                });
                totalHargaInput.value = grandTotal.toFixed(2);
            }

            function resetDataObat() {
                const obatList = document.getElementById('obat-list');
                obatList.innerHTML = "";
                $('#deleteConfirmationModal').modal('hide')
                $('.modal-backdrop').remove();

            }

            async function fetchDataObat()

            {
                const searchQuery = document.getElementById('searchObat').value;
                const url = "{{ route('search-obat') }}";

                try {

                    const response = await fetch(`${url}?name=${encodeURIComponent(searchQuery)}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);

                    }

                    const data = await response.json();
                    const tableDataObat = document.getElementById('tableDataObat');
                    tableDataObat.innerHTML = "";
                    data.forEach(function(obat, index) {
                        const row = `<tr>
                                    <td><input type="checkbox" class="obat-checkbox" data-idobat="${obat.id_obat}" data-nama="${obat.merek_obat}" data-satuan="${obat.kemasan}"></td>
                                    <td>${obat.merek_obat}</td>
                                    <td>${obat.dosis}</td>
                                    <td>${obat.kemasan}</td>
                                    <td>${obat.kegunaan}</td>
                                    <td>${obat.efek_samping}</td>
                                </tr>`;
                        tableDataObat.insertAdjacentHTML('beforeend', row);

                    })

                } catch (error) {
                    console.error(error);

                }
            }
        </script>
    @endsection
@endpush

{{-- <td><input type="number" name="ongkir[]" class="ongkir" onchange="updateHarga(this)"></td> --}}
