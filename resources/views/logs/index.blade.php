@extends('layouts.main')
@section('title', 'Catatan Hari Ini')
@section('content')
    <div class="mt-3">
        <!-- <h6>Catatan / Index</h6> -->
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
                        <p class="fw-bold">Catatan Hari Ini</p>
                        <x-logs-table :catatan='$logs' :totalCicilan='$totalCicilan' />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
