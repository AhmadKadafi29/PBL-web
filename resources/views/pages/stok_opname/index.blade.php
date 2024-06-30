@extends('layouts.app')

@section('title', 'Stok Opname')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Stok Opname</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Stok Opname</a></div>
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
                                <h4>Stok Opname</h4>
                                <div class="section-header-button">
                                    <a href="{{ route('Stok_opname.create') }}" class="btn btn-primary">Tambah Stok Opname</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Nama User</th>
                                            <th>Stok Sistem</th>
                                            <th>Stok Fisik</th>
                                            <th>Hasil Selisih Opname</th>
                                            <th>Tanggal opname</th>
                                            {{-- <th> Action</th> --}}

                                        </tr>

                                        @foreach ($opname as $op)
                                            <tr>
                                                <td>{{ $op->obat->merek_obat }}</td>
                                                <td>{{ $op->user->name }} </td>
                                                <td>
                                                    {{ $op->stok_sistem }}
                                                </td>
                                                <td>{{ $op->stok_fisik }}</td>
                                                <td>{{ $op->harga_jual_satuan }}</td>     
                                                <td>{{ $op->tanggal_opname }}</td>
                                                {{-- <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('Stok_opname.edit', $op->id_stok_opname) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                    </div>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                {{-- Uncomment the following line if you want to enable pagination --}}
                                {{-- <div class="float-right">{{ $users->withQueryString()->links() }}</div> --}}
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
