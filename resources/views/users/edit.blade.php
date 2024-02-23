@extends('layouts.main')
@section('title', 'Edit User')
@section('content')
    <div class="mt-3">
        <h6>Users / Edit</h6>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card py-3 px-3">
                    <p>Form Edit User</p>
                    <form action="/users/{{ $user->id }}" method="post">
                        @csrf
                        @method('put')
                        <div>
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username"
                                class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" value="{{ old('password', $user->password) }}" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            <a href="/users" class="btn btn-sm btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
