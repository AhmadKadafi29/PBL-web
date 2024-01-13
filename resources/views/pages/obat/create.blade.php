@extends('layouts.app')

@section('title', 'Obat Baru')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Obat Baru</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Obat</a></div>
                    <div class="breadcrumb-item">Obat Baru</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('Obat.store') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <strong>Nama Obat</strong>
                                        <input type="text" name="nama_obat" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <strong>Jenis Obat</strong>
                                        <input type="text" name="jenis_obat" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <strong>Kategori Obat</strong>
                                        <select class="form-control" id="position-option" name="kategori_obat_id">
                                            @foreach ($kategori as $kg)
                                                <option value="{{ $kg->id }}">{{ $kg->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <strong>Stok Obat</strong>
                                        <input type="text" name="stok_obat" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <strong>Harga Obat</strong>
                                        <input type="text" name="harga_obat" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Masuk</label>
                                        <input type="text" name="tanggal_masuk" class="form-control datepicker">
                                    </div>

                                    <div class="form-group">
                                        <label>Expired Date</label>
                                        <input type="text" name="exp_date" class="form-control datepicker">
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary"
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
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
