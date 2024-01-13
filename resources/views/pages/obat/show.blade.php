@extends('layouts.app')

@section('title', 'Detail Obat')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Confirm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">You can easily change the default browser confirmation box with a
                            bootstrap modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Detail Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Obat</a></div>
                    <div class="breadcrumb-item"><a href="#"> Detail Obat</a></div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail Obat {{ $obat->nama_obat }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <strong>Nama Obat</strong>
                                            <input type="text" name="nama_obat" class="form-control"
                                                value="{{ $obat->nama_obat }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <strong>Jenis Obat</strong>
                                            <input type="text" name="jenis_obat" class="form-control"
                                                value="{{ $obat->jenis_obat }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <strong>Kategori Obat</strong>
                                            <select class="form-control" id="position-option" name="kategori_obat_id"
                                                readonly>
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
                                                value="{{ $obat->stok_obat }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <strong>Harga Obat</strong>
                                            <input type="text" name="harga_obat" class="form-control"
                                                value="{{ $obat->harga_obat }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <strong>Tanggal Masuk</strong>
                                            <input type="text" class="form-control datepicker"
                                                value="{{ $obat->tanggal_masuk }}" readonly>
                                        </div>

                                        <div class="form-group">
                                            <strong>Expired Date</strong>
                                            <input type="text" class="form-control datepicker"
                                                value="{{ $obat->exp_date }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <strong>Status Obat</strong>
                                            <input type="text" name="harga_obat" class="form-control"
                                                value="{{ $obat->status }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
