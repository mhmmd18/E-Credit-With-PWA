@extends('layouts.main')
@section('title', 'Create Catatan')
@section('content')

    <div class="mt-3">
        <h6>Catatan / Create</h6>
        <div class="row">
            <div class="col-12 col-md-8">
                <form action="/logs" method="post">
                    @csrf
                    <div class="mt-2">
                        <label for="customer_id" class="form-label">Nama</label>
                        <select name="customer_id" id="customer_id" class="form-control select-multiple @error('customer_id') is-invalid @enderror" required>
                            <option value="" selected hidden>-- Pilih Nasabah --</option>
                            @foreach ($customers as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->type }} - {{ $item->address }}</option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="credit" class="form-label">Jumlah Cicilan</label>
                        <input type="number" name="credit" id="credit" placeholder="Masukkan Jumlah Cicilan"
                            class="form-control @error('credit') is-invalid @enderror" value="{{ old('credit') }}">
                        @error('credit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-sm btn-primary">Bayar</button>
                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
