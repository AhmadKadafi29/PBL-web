@extends('layouts.app')

@section('title', 'Tambah Stok Opname')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Stok Opname</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Stok Opname</a></div>
                    <div class="breadcrumb-item">Tambah Stok Opname</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('Stok_opname.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <strong>Nama Obat</strong>
                                    <select class="form-control" name="id_obat">
                                        @foreach ($obat as $ob)
                                            <option value="{{ $ob->id_obat }}">{{ $ob->merek_obat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="stok_fisik">Stok Fisik</label>
                                    <input type="text" name="stok_fisik" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="status">status</label>
                                    <select class="form-control" name="status">
                                        <option value="belum kadaluarsa">Belum Kadaluarsa</option>
                                        <option value="kadaluarsa">Kadaluarsa</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_opname">Tanggal opname</label>
                                    <input type="date" name="tanggal_opname" class="form-control">
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
    @endsection
@endpush
