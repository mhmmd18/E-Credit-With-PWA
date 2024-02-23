@extends('layouts.main')
@section('title', 'Edit Catatan')
@section('content')

    <div class="mt-3">
        <h6>Catatan / Edit</h6>
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card py-3 px-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="text-success">{{ $log->customer->name }}</h6>
                        @if ($log->customer->status == 'Lunas')
                            <div class="badge badge-sm bg-success">Hutang Lunas</div>
                        @else
                            <h6 class="text-danger">Rp. {{ number_format($log->current_debt, 0) }}</h6>
                        @endif
                    </div>
                    <hr>
                    <form action="/logs/{{ $log->id }}" method="post">
                        @csrf
                        @method('put')
                        <div>
                            <input type="hidden" name="customer_id" id="customer_id" placeholder="Masukkan Jumlah Cicilan"
                                class="form-control @error('customer_id') is-invalid @enderror"
                                value="{{ old('customer_id', $log->customer_id) }}">
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="credit" class="form-label">Jumlah Cicilan</label>
                            <input type="number" name="credit" id="credit" placeholder="Masukkan Jumlah Cicilan"
                                class="form-control @error('credit') is-invalid @enderror"
                                value="{{ old('credit', $log->credit) }}">
                            @error('credit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            <a href="{{ URL::previous() }}" class="btn btn-sm btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
