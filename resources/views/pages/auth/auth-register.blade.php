@extends('layouts.auth')

@section('title', 'Register')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Register</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="form-group ">
                    <label for="name">Nama</label>
                    <input id="name" type="text"
                        class="form-control @error('name')
                    is-invalid
                @enderror"
                        name="name" autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email')
                    is-invalid
                @enderror"
                        name="email">
                    <div class="invalid-feedback">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" id="role" name="role">
                        <option>pemilik</option>
                        <option>karyawan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="alamat" class="d-block">Alamat</label>
                    <input id="alamat" type="alamat" class="form-control" name="alamat">

                </div>
                <div class="form-group">
                    <label for="no_telp" class="d-block">No Telpon</label>
                    <input id="no_telp" type="no_telp" class="form-control" name="no_telp">

                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label for="password" class="d-block">Password</label>
                        <input id="password" type="password"
                            class="form-control @error('password')
                        is-invalid
                    @enderror"
                            name="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <label for="password2" class="d-block">Password Confirmation</label>
                        <input id="password2" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
