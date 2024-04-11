@extends('layouts.main')
@section('title', 'Edit Rokok')
@section('content')
    <div class="mt-3">
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="card py-3 px-3">
                    <h6 class="py-3 bg-warning text-center text-dark">Form Edit Rokok</h6>
                    <form action="/smokes/{{ $smoke->id }}" method="post">
                        @csrf
                        @method('put')
                        <div>
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" placeholder="Masukkan Nama"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $smoke->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="unit_price" class="form-label">Harga Ecer</label>
                            <input type="text" name="unit_price" id="unit_price" placeholder="Masukkan Harga Ecer"
                                class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price', $smoke->unit_price) }}" required>
                            @error('unit_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="price" class="form-label">Harga 1 Bungkus</label>
                            <input type="text" name="price" id="price" placeholder="Masukkan Harga 1 Bungkus"
                                class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $smoke->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            <a href="/smokes" class="btn btn-sm btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
