@extends('layouts.app')

@section('title', 'Supplier')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Supplier</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Supplier</a></div>
                </div>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-12">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>x</span>
                                </button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>x</span>
                                </button>
                                <p>{{ $message }}</p>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Supplier</h4>
                                <div class="section-header-button">
                                    <a href="{{ route('Supplier.create') }}" class="btn btn-primary">Supplier baru</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="clearfix "></div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('Supplier.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Supplier</th>
                                            <th>No Telepon</th>
                                            <th>Alamat</th>
                                            <th>Action</th>
                                        </tr>


                                        @foreach ($supplier as $index => $sp)
                                            <tr>
                                                <td>{{ $index + $supplier->firstItem() }}</td>
                                                <td>{{ $sp->nama_supplier }} </td>
                                                <td> {{ $sp->no_telpon }} </td>
                                                <td> {{ $sp->alamat }} </td>
                                                <td>
                                                    <div class="d-flex ">
                                                        <a href="{{ route('Supplier.edit', $sp->id_supplier) }}"
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                            data-id="{{ $sp->id_supplier }}"
                                                            data-name="{{ $sp->nama_supplier }}" data-toggle="modal"
                                                            data-target="#deleteConfirmationModal">
                                                            <i class="fas fa-times"></i>
                                                            Delete
                                                        </button>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $supplier->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus supplier <span id="deleteObjectName"></span>?</p>
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
                modal.find('.modal-footer #deleteForm').attr('action', '{{ url('Supplier') }}/' + id);
            });
        </script>
        <!-- JS Libraies -->
        <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

        <!-- Page Specific JS File -->
        <script src="{{ asset('js/page/features-posts.js') }}"></script>
    @endpush
