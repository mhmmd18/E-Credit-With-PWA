@extends('layouts.main')
@section('title', 'Create Catatan')
@section('content')

    <div class="mt-3">
        <!-- <h6>Catatan / Create</h6> -->
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="card py-3 px-3">
                    <div class="d-flex justify-content-center flex-column">
                        <h6 class="py-2 bg-primary text-center text-white">Form Tambah Catatan</h6>
                        <h6 class="py-2 bg-warning text-center text-dark">Nasabah {{ $customer->type }}</h6>
                    </div>
                    <hr>
                    @if (session()->has('failed'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('failed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between">
                        <h6 class="text-white bg-success px-2 py-1 rounded rounded-md">{{ $customer->name }}</h6>
                        @if ($current != null)
                        <h6 class="text-white bg-danger px-2 py-1 rounded rounded-md">Rp. {{ str_replace(',', '.', number_format($customer->debt - $totalCicilan, 0)) }}</h6>
                        @else
                        <h6 class="text-white bg-success px-2 py-1 rounded rounded-md">Rp. {{ str_replace(',', '.', number_format($customer->debt, 0)) }}</h6>
                        @endif
                    </div>
                    <form action="/customers/log" method="post">
                        @csrf
                        <input type="hidden" value="{{ $customer->id }}" name="customer_id">
                        <div>
                            <label for="credit" class="form-label">Jumlah Cicilan</label>
                            <input type="text" name="credit" id="credit" placeholder="Masukkan Jumlah Cicilan"
                                class="form-control @error('credit') is-invalid @enderror" value="{{ old('credit') }}">
                            @error('credit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Bayar</button>
                            <a href="{{ URL::previous() }}"
                                class="btn btn-sm btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
