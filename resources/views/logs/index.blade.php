@extends('layouts.main')
@section('title', 'Catatan Hari Ini')
@section('content')
    <div class="mt-3">
        <!-- <h6>Catatan / Index</h6> -->
        <div class="row">
            <div class="col-12 col-md-8">
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
