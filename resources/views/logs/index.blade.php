@extends('layouts.main')
@section('title', 'Catatan')
@section('content')
    <div class="mt-3">
        <h6>Catatan / Index</h6>
        <div class="row">
            <div class="col-12 col-md-8">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('failed'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        {{-- <a href="/logs/create" class="btn btn-sm btn-primary mb-3"><i
                                class="fa-solid fa-plus me-2"></i>Tambah</a> --}}
                        <p>Catatan Hari ini</p>
                        <x-logs-table :catatan='$logs' />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
