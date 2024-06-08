@extends('layouts.app')

@section('title', 'Obat Kadaluarsa')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Confirm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">You can easily change the default browser confirmation box with a
                            bootstrap modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Obat Kadaluarsa</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Obat Kadaluarsa</a></div>
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
                                <h4>Obat Kadaluarsa</h4>
                                {{-- <form method="post" action="{{ route('Obatkadaluarsa.storekadaluarsa') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Pindahkan Obat Kadaluarsa</button>
                                </form> --}}

                            </div>
                            <div class="card-body">
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Merek Obat</th>
                                            <th>Nama Supplier</th>
                                            <th>Stok Obat</th>
                                            <th>Tanggal Kadaluarsa</th>

                                        </tr>
                                        @foreach ($obat as $kadaluarsa)
                                            <tr>

                                                <td>{{ $kadaluarsa->obat->merek_obat }}</td>
                                                <td>{{ $kadaluarsa->pembelian->supplier->nama_supplier}}</td>
                                                <td>{{ $kadaluarsa->stok_obat }}</td>
                                                <td>{{ $kadaluarsa->tanggal_kadaluarsa }}</td>


                                                <td>
                                                    {{-- <div class="d-flex">
                                                        <form
                                                            action="{{ route('Obatkadaluarsa.destroy', $kadaluarsa->id) }}"
                                                            class="ml-2" method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
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
