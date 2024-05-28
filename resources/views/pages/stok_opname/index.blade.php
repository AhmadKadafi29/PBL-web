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
                                    <a href="{{ route('Stok_opname.create') }}" class="btn btn-primary">Tambah Stok
                                        Opname</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="clearfix "></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Nama User</th>
                                            <th>Stok Fisik</th>
                                            <th>Status</th>
                                            <th>Tanggal opname</th>
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($opname as $op)
                                            <tr>
                                                <td>{{ $op->obat->nama_obat }}</td>
                                                <td>{{ $op->user->name }} </td>
                                                <td> {{ $op->stok_fisik }} </td>
                                                <td>
                                                    <span class="badge badge-success">{{ $op->status }}</span>
                                                </td>
                                                <td>{{ $op->tanggal_opname }}</td>
                                                <td>
                                                    <div class="d-flex ">

                                                        <a href="{{ route('Stok_opname.edit', $op->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('Stok_opname.destroy', $op->id) }}"
                                                            class="ml-2" method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </table>
                                </div>
                                {{-- <div class="float-right">
                                    {{ $users->withQueryString()->links() }}
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
