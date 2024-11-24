@extends('layouts.app')

@section('title', 'Detail Satuan')

@push('style')
    <!-- Tambahkan CSS tambahan jika perlu -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Satuan Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Detail Satuan</a></div>
                    <div class="breadcrumb-item">Detail Satuan</div>
                </div>
            </div>

            <div class="section-body">
                <div class="container">

                    <div class="card">
                        @foreach ($satuans as $satuan)
                            <div class="form-group">
                                <label for="satuan_terbesar">{{ $satuan->satuan_terbesar }}</label>
                                <input type="text" class="form-control" id="satuan_terbesar"
                                    value="{{ $satuan->satuan_terbesar }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="satuan_terkecil_1">Satuan Terkecil ke 1</label>
                                <input type="text" class="form-control" id="satuan_terkecil_1"
                                    value="{{ $satuan->satuan_terkecil_1 }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="jumlah_satuan_terkecil_1">Jumlah Satuan Terkecil ke 1</label>
                                <input type="number" class="form-control" id="jumlah_satuan_terkecil_1"
                                    value="{{ $satuan->jumlah_satuan_terkecil_1 }}" disabled>
                            </div>

                            @foreach ($satuan->detailSatuans as $detail)
                                <div class="form-group">
                                    <label for="satuan_terkecil_{{ $loop->iteration }}">satuan terkecil ke
                                        {{ $loop->iteration + 1 }}</label>
                                    <input type="text" class="form-control" id="satuan_terkecil_{{ $loop->iteration }}"
                                        value="{{ $detail->satuan_terkecil }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="jumlah_satuan_terkecil_{{ $loop->iteration }}">Jumlah Satuan Terkecil ke
                                        {{ $loop->iteration + 1 }}</label>
                                    <input type="number" class="form-control"
                                        id="jumlah_satuan_terkecil_{{ $loop->iteration }}" value="{{ $detail->jumlah }}"
                                        disabled>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- Tambahkan JS tambahan jika perlu -->
    @section('js')
    @endsection
@endpush
