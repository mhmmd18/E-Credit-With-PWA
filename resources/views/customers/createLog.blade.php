@extends('layouts.main')
@section('title', 'Create Catatan')
@section('content')

    <div class="mt-3">
        <h6>Catatan / Create</h6>
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="card py-3 px-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-success">{{ $customer->name }}</h6>
                        @if ($current != null)
                            <h6 class="text-danger">Rp. {{ number_format($current->current_debt, 0) }}</h6>
                        @else
                            <h6 class="text-danger">Rp. {{ number_format($customer->debt, 0) }}</h6>
                        @endif
                    </div>
                    <hr>
                    <form action="/customers/log" method="post">
                        @csrf
                        <input type="hidden" value="{{ $customer->id }}" name="customer_id">
                        <div>
                            <label for="credit" class="form-label">Jumlah Cicilan</label>
                            <input type="number" name="credit" id="credit" placeholder="Masukkan Jumlah Cicilan"
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
