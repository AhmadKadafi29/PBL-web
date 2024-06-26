@extends('layouts.app')

@section('title', 'Edit Obat')

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
                <h1>Edit Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Obat</a></div>
                    <div class="breadcrumb-item">Edit Obat</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('Obat.update', $obat->id_obat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <Strong for="merek_obat">Merek Obat</Strong>
                                        <input type="text" class="form-control @error('merek_obat') is-invalid @enderror"
                                            id="merek_obat" name="merek_obat" value="{{ $obat->merek_obat }}">
                                        @error('merek_obat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <Strong for="dosis">Dosis</Strong>
                                        <input type="text" class="form-control @error('dosis') is-invalid @enderror"
                                            id="dosis" name="dosis" value="{{ $obat->dosis }}">
                                        @error('dosis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <Strong for="kemasan">Kemasan</Strong>
                                        <input type="text" class="form-control @error('kemasan') is-invalid @enderror"
                                            id="kemasan" name="kemasan" value="{{ $obat->kemasan }}">
                                        @error('kemasan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <Strong for="kegunaan">Kegunaan</Strong>
                                        <input type="text" class="form-control @error('kegunaan') is-invalid @enderror"
                                            id="kegunaan" name="kegunaan" value="{{ $obat->kegunaan }}">
                                        @error('kegunaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <Strong for="efek_samping">Efek Samping</Strong>
                                        <input type="text"
                                            class="form-control @error('efek_samping') is-invalid @enderror"
                                            id="efek_samping" name="efek_samping" value="{{ $obat->efek_samping }}">
                                        @error('efek_samping')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <Strong for="kategori_obat_id">Kategori Obat</Strong>
                                        <select class="form-control @error('kategori_obat_id') is-invalid @enderror"
                                            id="kategori_obat_id" name="kategori_obat_id">
                                            @foreach ($kategori as $k)
                                                <option value="{{ $k->id_kategori }}"
                                                    {{ $obat->kategori_obat_id == $k->id_kategori ? 'selected' : '' }}>
                                                    {{ $k->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori_obat_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('Obat.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
