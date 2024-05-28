@extends('layouts.app')

@section('title', 'Edit Kategori Obat')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>New Kategori Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kategori Obat</a></div>
                    <div class="breadcrumb-item">Edit Kategori Obat</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">

                    <form action="{{ route('Kategori.update', $ko) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Nama Kategori</strong>
                                    <input type="text" name="nama_kategori" class="form-control"
                                        value="{{ $ko->nama_kategori }}">
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
