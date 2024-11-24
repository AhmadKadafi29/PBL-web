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
                                        <label for="merek_obat">Merek Obat</label>
                                        <input type="text" class="form-control @error('merek_obat') is-invalid @enderror"
                                            id="merek_obat" name="merek_obat" value="{{ old('merek_obat') }}">
                                        @error('merek_obat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_obat">Nama Obat</label>
                                        <input type="text" class="form-control @error('nama_obat') is-invalid @enderror"
                                            id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}">
                                        @error('nama_obat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Input Deskripsi Obat -->
                                    <div class="form-group">
                                        <label for="deskripsi_obat">Deskripsi Obat</label>
                                        <textarea class="form-control @error('deskripsi_obat') is-invalid @enderror" id="deskripsi_obat" name="deskripsi_obat">{{ old('deskripsi_obat') }}</textarea>
                                        @error('deskripsi_obat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="efek_samping">Efek Samping</label>
                                        <input type="text"
                                            class="form-control @error('efek_samping') is-invalid @enderror"
                                            id="efek_samping" name="efek_samping" value="{{ old('efek_samping') }}">
                                        @error('efek_samping')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <Strong for="kategori_obat_id">Kategori Obat</Strong>
                                        <select class="form-control @error('kategori_obat_id') is-invalid @enderror"
                                            id="kategori_obat_id" name="kategori_obat_id">

                                            <option value="">--pilih kategori obat--</option>
                                            @foreach ($kategori as $k)
                                                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori_obat_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="satuan_terbesar">Satuan Terbesar</label>
                                        <select class="form-control @error('satuan_terbesar') is-invalid @enderror"
                                            id="satuan_terbesar" name="satuan_terbesar">
                                            <option value="Box" {{ old('satuan_terbesar') == 'Box' ? 'selected' : '' }}>
                                                Box</option>
                                            <option value="Botol"
                                                {{ old('satuan_terbesar') == 'Botol' ? 'selected' : '' }}>Botol</option>
                                        </select>
                                        @error('satuan_terbesar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="satuan_terkecil_1">Satuan Terkecil 1</label>
                                        <select class="form-control @error('satuan_terkecil_1') is-invalid @enderror"
                                            id="satuan_terkecil_1" name="satuan_terkecil_1">
                                            <option value="Tablet"
                                                {{ old('satuan_terkecil_1') == 'Tablet' ? 'selected' : '' }}>Tablet
                                            </option>
                                            <option value="Kaplet"
                                                {{ old('satuan_terkecil_1') == 'Kaplet' ? 'selected' : '' }}>Kaplet
                                            </option>
                                        </select>
                                        @error('satuan_terkecil_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jumlah_satuan_terkecil_1">Jumlah Satuan Terkecil 1</label>
                                        <input type="number"
                                            class="form-control @error('jumlah_satuan_terkecil_1') is-invalid @enderror"
                                            id="jumlah_satuan_terkecil_1" name="jumlah_satuan_terkecil_1"
                                            value="{{ old('jumlah_satuan_terkecil_1') }}">
                                        @error('jumlah_satuan_terkecil_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Container untuk inputan dinamis -->
                                    <div id="satuan-terkecil-container"></div>

                                    <!-- Tombol untuk menambahkan inputan baru -->
                                    <div class="form-group mt-3">
                                        <button type="button" id="add-satuan-terkecil-btn" class="btn btn-primary">Tambah
                                            Satuan Terkecil</button>
                                    </div>

                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary"
                                            style="width: 90px; height:40px; font-size:15px">Simpan</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let satuanCount = 2; // Mulai dari Satuan Terkecil 2
            const satuanContainer = document.getElementById('satuan-terkecil-container');
            const addButton = document.getElementById('add-satuan-terkecil-btn');

            addButton.addEventListener('click', function() {
                if (satuanCount <= 3) {
                    const newField = `
                    <div class="form-group mt-3" id="satuan-terkecil-${satuanCount}">
                        <label for="satuan_terkecil_${satuanCount}">
                            <strong>Satuan Terkecil ${satuanCount}</strong>
                        </label>
                        <select class="form-control" name="satuan_terkecil_${satuanCount}">
                            <option value="Pil">Pil</option>
                            <option value="Dragee">Dragee</option>
                        </select>

                        <label for="jumlah_satuan_terkecil_${satuanCount}">
                            <strong>Jumlah Satuan Terkecil ${satuanCount}</strong>
                        </label>
                        <input type="number" class="form-control" name="jumlah_satuan_terkecil_${satuanCount}" placeholder="Jumlah">
                        <button type="button" class="btn btn-danger mt-2"
                                onclick="removeSatuan(${satuanCount})">Hapus</button>
                    </div>
                `;

                    satuanContainer.insertAdjacentHTML('beforeend', newField);
                    satuanCount++;
                } else {
                    alert('Maksimal 3 input tambahan!');
                }
            });
        });

        function removeSatuan(index) {
            const element = document.getElementById(`satuan-terkecil-${index}`);
            if (element) element.remove();
        }
    </script>

    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
