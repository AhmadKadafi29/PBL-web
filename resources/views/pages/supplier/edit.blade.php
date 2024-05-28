@extends('layouts.app')

@section('title', 'Edit Supplier')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit supplier</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Supplier</a></div>
                    <div class="breadcrumb-item">Edit Supplier</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('Supplier.update', $supplier) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Supplier</label>
                                <input type="text"
                                    class="form-control @error('nama_supplier')
                                is-invalid
                            @enderror"
                                    name="nama_supplier" value="{{ $supplier->nama_supplier }}">
                                @error('nama_supplier')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>No Telpon</label>
                                <input type="text" class="form-control" name="no_telpon"
                                    value="{{ $supplier->no_telpon }}">
                            </div>
                            <div class="form-group mb-0">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="alamat" value="{{ $supplier->alamat }}">
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
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
