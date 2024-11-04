@extends('layouts.app')

@section('title', 'Obat')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
@endpush

@section('main')
    <div class="main-content">

        <section class="section">
            <div class="section-header">
                <h1>Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Obat</a></div>
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
                                <h4>Daftar Obat</h4>
                                <div class="section-header-button">
                                    <a href="{{ route('Obat.create') }}" class="btn btn-primary">Obat Baru</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('Obat.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="merek_obat">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kategori Obat</th>
                                                <th>Merek Obat</th>
                                                <th>Dosis Obat</th>
                                                <th>Kegunaan</th>
                                                <th>Efek Samping</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obat as $index => $ob)
                                                <tr>
                                                    <td>{{ $index + $obat->firstItem() }}</td>
                                                    <td>{{ $ob->kategoriObat->nama_kategori }}</td>
                                                    <td>{{ $ob->merek_obat }}</td>
                                                    <td>{{ $ob->dosis }}</td>
                                                    <td>{{ $ob->kegunaan }}</td>
                                                    <td>{{ $ob->efek_samping }}</td>
                                                   
                                                    <td>
                                                        <div class="d-flex">
                                                            <a class="btn btn-sm btn-link btn-icon ml-2" href="{{ route('create-detailsatuan', $ob->id_obat) }}">
                                                                <i class="fas fa-cube"></i> satuan
                                                            </a>

                                                            <a href="{{ route('Obat.show', $ob->id_obat) }}" class="btn btn-sm btn-warning btn-icon  ml-2">
                                                                <i class="fas fa-eye"></i> Detail
                                                            </a>
                                                          
                                                            <a href="{{ route('Obat.edit', $ob->id_obat) }}" class="btn btn-sm btn-info btn-icon ml-2">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="float-right">
                                        {{ $obat->withQueryString()->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus obat <span id="deleteObjectName"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var modal = $(this);

            modal.find('.modal-body #deleteObjectName').text(name);
            modal.find('.modal-footer #deleteForm').attr('action', '{{ url('Obat') }}/' + id);
        });
    </script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script src="{{ asset('library/prismjs/prism.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>
@endpush
