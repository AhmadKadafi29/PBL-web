@extends('layouts.app')

@section('title', 'Pembelian')

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
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="section-header">
                <h1>Pembelian</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Pembelian</a></div>
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
                                <h4>Pembelian</h4>
                                <div class="section-header-button">
                                    <a href="{{ route('Pembelian.create') }}" class="btn btn-primary">Tambah Pembelian</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="clearfix "></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Nama Supplier</th>
                                            <th>No faktur</th>
                                            <th>Total Harga</th>
                                            <th>Tanggal beli</th>
                                            <th>Status bayar</th>
                                            <th>Action</th>
                                        </tr>

                                        @foreach ($pembelian as $beli)
                                            <tr>
                                                <td>{{ $beli->obat->nama_obat }}</td>
                                                <td>{{ $beli->supplier->nama_supplier }} </td>
                                                <td> {{ $beli->noFaktur }} </td>
                                                <td> {{ $beli->total_harga }} </td>
                                                <td>{{ $beli->tanggal_pembelian }}</td>
                                                <td>
                                                    <span class="badge badge-success">{{ $beli->status_pembayaran }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex ">
                                                        <a href="{{ route('Pembelian.edit', $beli->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                            data-id="{{ $beli->id }}"
                                                            data-name="{{ $beli->obat->nama_obat }}">
                                                            <i class="fas fa-times"></i>
                                                            Delete
                                                        </button>
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
                {{-- <div class="modal fade" id="confirmDeleteModal-{{ $beli->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal Confirm
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-2">Do you want to delete {{ $beli->nama_obat }}?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('Pembelian.destroy', $beli->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>

                </div> --}}
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.confirm-delete').on('click', function() {
                var obatId = $(this).data('id');
                var obatName = $(this).data('name');

                $('#confirmDeleteModal .modal-body').html(
                    '<p class="mb-2">Apakah anda yakin ingin menghapus pembelian obat ' +
                    obatName + '?</p>');
                $('#confirmDeleteBtn').attr('data-id', obatId);
                $('#confirmDeleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function() {
                var obatId = $(this).data('id');
                $('#confirmDeleteModal').modal('hide');
            });
        });
    </script>
@endpush
