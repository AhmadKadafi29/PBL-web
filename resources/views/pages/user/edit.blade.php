@extends('layouts.app')

@section('title', 'Edit Users')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Users</a></div>
                <div class="breadcrumb-item">Edit Users</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('user.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name')
                                is-invalid
                            @enderror" name="name" value="{{ $user->name }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email')
                                is-invalid
                            @enderror" name="email" value="{{ $user->email }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                        </div> --}}
                        <div class="form-group">
                            <label class="form-label">Roles</label>
                            <div class="selectgroup w-100">
                                {{-- <label class="selectgroup-item">
                                    <input type="radio" name="role" value="pemilik" class="selectgroup-input"
                                    @if ($user->role == 'pemilik')
                                    checked
                                    @endif>
                                    <span class="selectgroup-button">Pemilik</span>
                                </label> --}}
                                <label class="selectgroup-item">
                                    <input type="radio" name="role" value="karyawan" class="selectgroup-input"
                                    @if ($user->role == 'karyawan' )
                                    checked
                                    @endif>
                                    <span class="selectgroup-button">Karyawan</span>
                                </label>
                            </div>
                        </div>
                        {{-- <div class="form-group mb-0">
                            <label>Address</label>
                            <textarea class="form-control" data-height="150" name="address" value>
                                {{ $user->address }}
                            </textarea>
                        </div> --}}
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->

<!-- Page Specific JS File -->
@endpush
