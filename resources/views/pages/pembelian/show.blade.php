@extends('layouts.app')

@section('title', 'Detail Pembelian')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Pembelian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="">Pembelian</a></div>
                    <div class="breadcrumb-item"><a href="#"> Detail Pembelian</a></div>
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
                                <h4>Detail Pembelian</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <strong>Nama Obat</strong>
                                            <select class="form-control" id="position-option" name="id_obat" readonly>
                                                @foreach ($obat as $ob)
                                                    <option value="{{ $ob->id }}"
                                                        {{ $ob->id == $pembelian->id_obat ? 'selected' : '' }}>
                                                        {{ $ob->nama_obat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <strong>Nama Supplier</strong>
                                            <select class="form-control" id="position-option" name="id_supplier" readonly>
                                                @foreach ($supplier as $sp)
                                                    <option value="{{ $sp->id }}"
                                                        {{ $sp->id == $pembelian->id_supplier ? 'selected' : '' }}>
                                                        {{ $sp->nama_supplier }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                            <input type="date" class="form-control datepicker" id="tanggal_pembelian"
                                                name="tanggal_pembelian" value="{{ $pembelian->tanggal_pembelian }}"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="status_pembayaran">Status Pembayaran</label>
                                            <input type="text" name="status_pembayaran" class="form-control"
                                                value="{{ $pembelian->status_pembayaran }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <strong>Harga satuan</strong>
                                            <input type="text" name="harga_satuan" class="form-control"
                                                value="{{ $pembelian->harga_satuan }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="text" class="form-control " name="quantity"
                                                value="{{ $pembelian->quantity }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="total_harga">Total Harga</label>
                                            <input type="number" name="total_harga" class="form-control"
                                                value="{{ $pembelian->total_harga }}" readonly>
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script src="{{ asset('library/prismjs/prism.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>
@endpush
