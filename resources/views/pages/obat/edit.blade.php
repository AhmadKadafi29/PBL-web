@extends('layouts.app')

@section('title', 'Edit Obat')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
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
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <strong>Kode Obat</strong>
                                        <input type="text" name="kode_obat" class="form-control"
                                            value="{{ $obat->kode_obat }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_obat">Nama Obat</label>
                                        <input type="text" name="nama_obat" class="form-control"
                                            value="{{ $obat->nama_obat }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_obat">Jenis Obat</label>
                                        <input type="text" name="jenis_obat" class="form-control"
                                            value="{{ $obat->jenis_obat }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="satuan_obat">Satuan Obat</label>
                                        <input type="text" name="satuan_obat" class="form-control"
                                            value="{{ $obat->satuan_obat }}">
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="kategori_obat_id">Kategori Obat</label>
                                        <select class="form-control" id="position-option" name="kategori_obat_id">
                                            @foreach ($kategori as $kg)
                                                <option value="{{ $kg->id_kategori }}"
                                                    {{ $kg->id_kategori == $obat->kategori_obat_id ? 'selected' : '' }}>
                                                    {{ $kg->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="harga_jual_obat">Harga Obat</label>
                                        <input type="text" name="harga_jual_obat" class="form-control"
                                            value="{{ $obat->harga_jual_obat }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->

    <!-- Page Specific JS File -->
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
