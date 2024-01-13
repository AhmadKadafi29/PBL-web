@extends('layouts.app')

@section('title', 'Edit Obat')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('Obat.index') }}">Obat</a></div>
                    <div class="breadcrumb-item">Edit Obat</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('Obat.update', $obat) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <strong>Nama Obat</strong>
                                    <input type="text" name="nama_obat" class="form-control"
                                        value="{{ $obat->nama_obat }}">
                                </div>
                                <div class="form-group">
                                    <strong>Jenis Obat</strong>
                                    <input type="text" name="jenis_obat" class="form-control"
                                        value="{{ $obat->jenis_obat }}">
                                </div>
                                <div class="form-group">
                                    <strong>Kategori Obat</strong>
                                    <select class="form-control" id="position-option" name="kategori_obat_id">
                                        @foreach ($kategori as $kg)
                                            <option value="{{ $kg->id }}"
                                                {{ $kg->id == $obat->kategori_obat_id ? 'selected' : '' }}>
                                                {{ $kg->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <strong>Stok Obat</strong>
                                    <input type="text" name="stok_obat" class="form-control"
                                        value="{{ $obat->stok_obat }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <strong>Harga Obat</strong>
                                    <input type="text" name="harga_obat" class="form-control"
                                        value="{{ $obat->harga_obat }}">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="text" class="form-control datepicker"
                                        value="{{ $obat->tanggal_masuk }}">
                                </div>

                                <div class="form-group">
                                    <label>Expired Date</label>
                                    <input type="text" class="form-control datepicker" value="{{ $obat->exp_date }}">
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
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

    <!-- Page Specific JS File -->
@endpush
