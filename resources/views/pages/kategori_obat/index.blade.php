@extends('layouts.app')

@section('title', 'Kategori obat')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kategori obat</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kategori obat</a></div>
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
                                <h4>Kategori</h4>
                                <div class="section-header-button">
                                    <a href="{{ route('Kategori.create') }}" class="btn btn-primary">Kategori baru</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="clearfix"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            @can('isPemilik')

                                            <th>Action</th>
                                            @endcan
                                        </tr>


                                        @foreach ($kategoriobat as $kategori)
                                            <tr>
                                                <td>{{ $kategori->id_kategori }} </td>
                                                <td> {{ $kategori->nama_kategori }} </td>
                                                @can('isPemilik')


                                                <td>
                                                    <div class="d-flex ">
                                                        <a href="{{ route('Kategori.edit', $kategori->id_kategori) }}"
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('Kategori.destroy', $kategori->id_kategori) }}"
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
                                                @endcan
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
