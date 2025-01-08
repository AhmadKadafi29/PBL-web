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
                    <form action="{{ route('Stok_opname.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="container-fluid">
                            <div class="row mt-3">
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <strong>Nama Obat</strong>
                                        <select class="form-control" name="id_obat">
                                            <option value="">--Pilih Obat--</option>
                                            @foreach ($obat as $ob)
                                                <option value="{{ $ob->id_obat }}">{{ $ob->merek_obat }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_obat')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="stok_fisik_1">Stok Fisik 1</label>
                                        <input type="text" name="stok_fisik_1" class="form-control">
                                        @error('stok_fisik_1')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="stok_fisik_2">Stok Fisik 2</label>
                                        <input type="text" name="stok_fisik_2" class="form-control">
                                        @error('stok_fisik_2')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal_opname">Tanggal opname</label>
                                        <input type="date" name="tanggal_opname" class="form-control">
                                        @error('tanggal_opname')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    @section('js')
    @endsection
@endpush