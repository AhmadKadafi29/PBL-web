@extends('layouts.app')

@section('title', 'New Supplier')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>New Supplier</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Supplier</a></div>
                    <div class="breadcrumb-item">New Supplier</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('Supplier.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Nama Supplier</strong>
                                    <input type="text" name="nama_supplier" class="form-control">
                                </div>
                                <div class="form-group">
                                    <strong>No Telepon</strong>
                                    <input type="text" name="no_telpon" class="form-control">
                                </div>
                                <div class="form-group">
                                    <strong>Alamat</strong>
                                    <input type="text" name="alamat" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                                <button type="submit" class="btn btn-primary">Simpan</button>
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
