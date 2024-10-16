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
                <h1>Tambah Data Pengembalian Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pembelian</a></div>
                    <div class="breadcrumb-item">Tambah Pembelian</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="card">
                    <form method="POST" action="{{ route('pengembalian-obat.store') }}">

                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="no_faktur">No Faktur</label>
                                        <div class="input-group">
                                            <input type="text" name="no_faktur" id="no_faktur" class="form-control" placeholder="Masukkan No Faktur" >
                                            <div class="input-group-append">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" onclick="fetchDataFaktur()"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                        <input type="date" class="form-control datepicker" id="tanggal_pembelian"
                                            name="tanggal_pembelian" onchange="updateNoFaktur()">
                                    </div>
                                   
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="supplier">Supplier</label>
                                        <input type="text" name="supplier" id="supplier" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                                        <input type="date" class="form-control datepicker" id="tanggal_pengembalian"
                                            name="tanggal_pengembalian" onchange="updateNoFaktur()">
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 text-left">
                                    <button type="reset" class="btn btn-secondary" style="margin-right: 10px;" data-toggle="modal" data-target="#deleteConfirmationModal" >Reset</button>
                                    <button type="submit" class="btn btn-success" style="margin-right: 10px;">Simpan</button>
                                    
                                </div>
                                <div class="col-lg-6 ">
                                    <div class="form-group">                                    
                                        <input type="number" name="total" id="totalpengembalian" class="form-control " readonly>
                                    </div>

                                    
                                </div>

                                <!-- Modal -->
                            
                            </div>

                            <hr style="margin-top: 20px; margin-bottom: 20px;">
                            
                            <!-- Tabel Pembelian Obat -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        
                                            <th>Aksi</th>
                                            <th>Nama Obat</th>
                                            <th>No Batch</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Kuantitas Obat</th>
                                            <th>Harga Satuan</th> 
                                            <th>Jumlah Dikembalikan</th>
                                            <th>Subtotal</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody id="tableDataFaktur">
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
  
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

                                    supplier.value=`${faktur.nama_supplier}`;
                                    tanggal_pembelian.value= `${faktur.tanggal_pembelian}`;
                                    stok=faktur.stok;    
                                                            
                                    faktur.detail_pembelian.forEach((detail, index) => {
                                        const newRow = document.createElement('tr');
                                        newRow.setAttribute('id', `obat.${detail.no_batch}`)
                                         newRow.innerHTML = `
                                         <tr>
                                                <td><button onclick ="hapusItemPembelianObat(this)" class="btn btn-link"><i class="fa-solid fa-trash""></i></button></td>
                                                <td><input type="text" name="merek_obat[]" class="total" value="${detail.merek_obat}" readonly></td>
                                                <td><input type="text" name="no_batch[]" class="total" value="${detail.no_batch}"readonly></td>
                                                <td><input type="date" name="tanggal_kadaluarsa[]" class="total" value="${stok[index].tanggal_kadaluarsa}"readonly></td>
                                                <td><input type="number" name="stok_tersedia[]" class="stok_tersedia" value="${stok[index].stok_tersedia}"readonly ></td>
                                                <td>${detail.harga_satuan}<input type="hidden" class="harga_satuan" value="${detail.harga_satuan}"></td>
                                                <td><input type="number" name="jumlah_retur[]" class="jumlah-retur" onchange="updatesubtotal(this)" ></td>
                                                <td><input type="number" name="subtotal[]" class="subtotal"></td>
                                                
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


                    function hapusItemPembelianObat(element)
                    {
                        const item = element.closest('tr');
                        item.remove()
                    }

                    function updatesubtotal(element)
                    {
                        const row = element.closest('tr');
                        const jumlahretur = row.querySelector('.jumlah-retur').value;
                        const harga_satuan = row.querySelector('.harga_satuan').value;
                        const subtotal = row.querySelector('.subtotal');
                        const kuantitas = row.querySelector('.stok_tersedia').value; 
                            subtotal.value=jumlahretur* harga_satuan;   
                            TotalPengembalian()
                        
                    }

                    function TotalPengembalian() {
                        const elementTotal = document.getElementById('totalpengembalian');
                        const subtotals = document.querySelectorAll('.subtotal');
                        let totalHarga = 0;

                        // Loop melalui semua elemen subtotal dan tambahkan nilainya ke totalHarga
                        subtotals.forEach((subtotal) => {
                            totalHarga += parseFloat(subtotal.value || 0); // Pastikan nilainya diubah menjadi float
                        });

                        // Tampilkan hasil total pada input totalpengembalian
                        elementTotal.value = totalHarga;
                    }



        </script>
    @endsection
@endpush
