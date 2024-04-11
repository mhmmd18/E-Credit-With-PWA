@extends('layouts.main')
@section('title', 'Edit Pembeli')
@section('content')
<div class="mt-3">
    <div class="row">
        <div class="col-12 col-md-10">
            <div class="card py-3 px-3">
                <h6 class="py-3 bg-warning text-center text-dark">Form Edit Pembeli</h6>
                <form action="/buyers/{{ $buyer->id }}" method="post">
                    @csrf
                    @method('put')
                    <div>
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" placeholder="Masukkan Nama"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $buyer->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="smoke_id" class="form-label">Rokok</label>
                        <select name="smoke_id" id="smoke_id"
                            class="form-control @error('smoke_id') is-invalid @enderror" required>
                            <option value="" selected hidden>-- Pilih Rokok Yang Dibeli --</option>
                            @foreach ($smokes as $smoke)
                            <option style="font-size: 12px" value="{{ $smoke->id }}"
                                data-unit-price="{{ $smoke->unit_price }}"
                                data-package-price="{{ $smoke->price }}"
                                {{ old('smoke_id', $buyer->smoke_id) == $smoke->id ? 'selected' : ''}}>{{ $smoke->name }}</option>
                            @endforeach
                        </select>
                        @error('smoke_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label class="form-label d-block">Tipe Rokok</label>
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="eceran" value="Eceran"
                                {{ old('type', $buyer->type) == 'Eceran' ? 'checked' : '' }}>
                            <label class="form-check-label" for="eceran">
                                Eceran
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="bungkusan" value="Bungkusan"
                                {{ old('type', $buyer->type) == 'Bungkusan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="bungkusan">
                                Bungkusan
                            </label>
                        </div>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="qty" class="form-label">Jumlah</label>
                        <input type="text" name="qty" id="qty" placeholder="Masukkan Jumlah"
                            class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty', $buyer->qty) }}">
                        @error('qty')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" name="total" id="total"
                        class="form-control @error('total') is-invalid @enderror" value="{{ old('total') }}" readonly>
                    </div>
                    <div class="mt-4">
                        <!-- <button type="button" id="calculateTotal" class="btn btn-sm btn-primary">Hitung Total</button> -->
                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
