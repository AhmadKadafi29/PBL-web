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
                    <form  method="POST">
                        @csrf
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="no_faktur">No Faktur</label>
                                        <div class="input-group">
                                            <input type="text" name="no_faktur" id="no_faktur" class="form-control" placeholder="Masukkan No Faktur">
                                            <div class="input-group-append">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" onclick="fetchDataFaktur()"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="tanggal_pembelian">Tanggal Pengembalian</label>
                                        <input type="date" class="form-control datepicker" id="tanggal_pembelian"
                                            name="tanggal_pembelian" onchange="updateNoFaktur()">
                                    </div>
                                   
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="no_faktur">Supplier</label>
                                        <input type="text" name="no_faktur" id="no_faktur" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label for="total_harga">Total Pengembalian</label>
                                        <input type="text" name="total_harga" id="total_harga" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-left">
                                    <!-- Button untuk membuka modal daftar obat -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#obatModal" style="margin-right: 10px;">
                                        + Obat
                                    </button>
                                    <button type="reset" class="btn btn-secondary" style="margin-right: 10px;" data-toggle="modal" data-target="#deleteConfirmationModal" >Reset</button>
                                    <button type="submit" class="btn btn-success" style="margin-right: 10px;">Simpan</button>
                                </div>

                                <!-- Modal -->
                            
                            </div>

                            <hr style="margin-top: 20px; margin-bottom: 20px;">
                            
                            <!-- Tabel Pembelian Obat -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No Faktur</th>
                                            <th>Nama Supplier</th>
                                            <th>Nama Obat</th>
                                            <th>No Batch</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Kuantitas Obat</th>
                                            <th>Jumlah Dikembalikan</th>
                                            <th>Subtotal</th>
                                            <th>Potongan</th>
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
                const row = ``;
                tableDataFaktur.insertAdjacentHTML('beforeend', row);
            });
        } else {
            console.error('tableDataFaktur element not found');
        }

    } catch (error) {
        console.error('Error fetching faktur data:', error);
    }
}


        </script>
    @endsection
@endpush
