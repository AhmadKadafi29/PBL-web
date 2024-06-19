@extends('layouts.app')

@section('title', 'Tambah Stok Opname')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Nama Penebus Resep</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    {{-- <div class="breadcrumb-item"><a href="#">Sto</a></div>
                    <div class="breadcrumb-item">Tambah Stok Opname</div> --}}
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                   <div>
                    <form action="{{ route('penjualanresep.store') }}" method="POST">
                        @csrf
                   <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <strong>Nama Pasien</strong>
                               <input type="text" name="nama_pasien" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="stok_fisik">Alamat Pasien</label>
                                <input type="text" name="alamat_pasien" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="status">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelamin">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_dokter">Nama Dokter</label>
                                <input type="text" name="nama_dokter" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nomor_sip">Nomor SIP</label>
                                <input type="text" name="nomor_sip" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="tanggal_penjualan">Tanggal Penjualan</label>
                                <input type="date" name="tanggal_penjualan" class="form-control">
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary"
                                    style="width: 90px; height:40px; font-size:15px">Submit</button>
                            </div>
                        </div>
                    </div>
                   </div>
                    </form>
                   </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    @section('js')
    @endsection
@endpush
