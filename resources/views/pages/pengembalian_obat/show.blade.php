@extends('layouts.app')

@section('title', 'Detail Pembelian')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Pengembalian Obat</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href=""> Pengembalian Obat</a></div>
                   <div class="breadcrumb-item"><a href="#"> Detail Pengembalian Obat</a></div>
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
                            {{-- <div class="card-header">
                                <h4>Detail Pengembalian Obat</h4>
                            </div> --}}
                            <div class="card-body">
                                <div class="clearfix "></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Obat</th>
                                                <th>No Batch</th>
                                                <th>Jumlah Dikembalikan</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            ?>
                                            @foreach ($datadetailpengembalian as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->detail_obat->obat->merek_obat }}</td>
                                                    <td>{{  $item->detail_obat->no_batch}}</td>
                                                    <td>{{ $item->Quantity }}</td>
                                                  
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <a href="{{ route('pengembalian-obat.index') }}" class="btn btn-primary">Kembali</a>
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script src="{{ asset('library/prismjs/prism.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>
@endpush
