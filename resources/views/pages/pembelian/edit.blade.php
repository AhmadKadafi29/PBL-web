@extends('layouts.app')

@section('title', 'Edit Pembelian')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Pembelian</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="">Pembelian</a></div>
                    <div class="breadcrumb-item"><a href="#"> Edit Pembelian</a></div>
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
                            <form action="{{ route('Pembelian.update', $pembelian) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <strong>Nama Obat</strong>
                                                <select class="form-control" id="position-option" name="id_obat"
                                                    >
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
                                                <select class="form-control" id="position-option" name="id_supplier"
                                                    >
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
                                                    >
                                            </div>
                                            <div class="form-group">
                                                <label for="status_pembayaran">Status Pembayaran</label>
                                                <input type="text" name="status_pembayaran" class="form-control"
                                                    value="{{ $pembelian->status_pembayaran }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <strong>Harga satuan</strong>
                                                <input type="text" name="harga_satuan" class="form-control"
                                                    value="{{ $pembelian->harga_satuan }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="text" class="form-control " name="quantity"
                                                    value="{{ $pembelian->quantity }}" onchange="updateTotal()">
                                            </div>
                                            <div class="form-group">
                                                <label for="total_harga">Total Harga</label>
                                                <input type="number" name="total_harga" class="form-control"
                                                    value="{{ $pembelian->total_harga }}" onchange="updateTotal()">
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
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function updateTotal() {
            var hargaSatuan = document.getElementsByName('harga_satuan')[0].value;
            var quantity = document.getElementsByName('quantity')[0].value;
            var totalHarga = hargaSatuan * quantity;
            document.getElementsByName('total_harga')[0].value = totalHarga;
        }
    </script>
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
