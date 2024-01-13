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
                                <form method="post" action="{{ route('Obatkadaluarsa.storekadaluarsa') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Pindahkan Obat Kadaluarsa</button>
                                </form>

                            </div>
                            <div class="card-body">
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Tanggal Kadaluarsa</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($obatkadaluarsa as $kadaluarsa)
                                            <tr>

                                                <td>{{ $kadaluarsa->obat->nama_obat }}</td>
                                                <td>{{ $kadaluarsa->tanggal_kadaluarsa }}</td>

                                                <td>
                                                    <div class="d-flex">
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                            data-id="{{ $kadaluarsa->id }} "
                                                            data-name="{{ $kadaluarsa->obat->nama_obat }}">
                                                            <i class="fas fa-times"></i>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="confirmDeleteModal-{{ $kadaluarsa->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal Confirm
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="mb-2">Do you want to delete
                                                                {{ $kadaluarsa->obat->nama_obat }}?
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form
                                                                action="{{ route('Obatkadaluarsa.destroy', $kadaluarsa->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
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
    <script>
        $(document).ready(function() {
            $('.confirm-delete').on('click', function() {
                var obatId = $(this).data('id');
                var obatName = $(this).data('name');

                $('#confirmDeleteModal .modal-body').html(
                    '<p class="mb-2">Apakah anda yakin ingin menghapus obat kadaluarsa ' +
                    obatName + '?</p>');
                $('#confirmDeleteBtn').attr('data-id', obatId);
                $('#confirmDeleteModal').modal('show');
            });

            $('#confirmDeleteBtn').on('click', function() {
                var obatId = $(this).data('id');
                // Perform delete operation here using obatId
                // ...

                // Close the modal
                $('#confirmDeleteModal').modal('hide');
            });
        });
    </script>
@endpush
