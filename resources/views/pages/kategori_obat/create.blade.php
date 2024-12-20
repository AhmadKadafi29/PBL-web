@extends('layouts.app')

@section('title', 'Tambah Kategori Obat')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Kategori Obat </h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kategori Obat</a></div>
                    <div class="breadcrumb-item">Tambah Kategori Obat</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('Kategori.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Nama Kategori</strong>
                                    <input type="text" name="nama_kategori"
                                        class="form-control @error('nama_kategori') is-invalid @enderror">
                                    @error('nama_kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
