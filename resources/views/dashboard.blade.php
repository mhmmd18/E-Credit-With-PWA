@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="mt-3">
        @if (Auth::user()->role_id == 1)
        <h6 class="">Dashboard / Admin</h6>
        @else
        <h6 class="">Dashboard / Owner</h6>
        @endif
        <div class="row mt-3">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-primary text-black">
                    <div class="mt-3 px-3">
                        <h6 class="pb-1">Nasabah Harian</h6>
                        <div class="row">
                            <div class="col-6">
                                <p>Lunas : {{ $harianLunas }}</p>
                            </div>
                            <div class="col-6">
                                <p class="ps-3">Belum : {{ $harianBelumLunas }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a class="text-black text-decoration-none" href="/customers/list/Harian/lunas">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="text-black text-decoration-none" href="/customers/list/Harian">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-success text-black">
                    <div class="mt-3 px-3">
                        <h6 class="pb-1">Nasabah Mingguan</h6>
                        <div class="row">
                            <div class="col-6">
                                <p>Lunas : {{ $mingguanLunas }}</p>
                            </div>
                            <div class="col-6">
                                <p class="ps-3">Belum : {{ $mingguanBelumLunas }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a class="text-black text-decoration-none" href="/customers/list/Mingguan/lunas">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="text-black text-decoration-none" href="/customers/list/Mingguan">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-warning text-black">
                    <div class="mt-3 px-3">
                        <h6 class="pb-1">Nasabah Bulanan</h6>
                        <div class="row">
                            <div class="col-6">
                                <p>Lunas : {{ $bulananLunas }}</p>
                            </div>
                            <div class="col-6">
                                <p class="ps-3">Belum : {{ $bulananBelumLunas }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a class="text-black text-decoration-none" href="/customers/list/Bulanan/lunas">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="text-black text-decoration-none" href="/customers/list/Bulanan">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-info text-black">
                    <div class="mt-3 px-3">
                        <h6 class="pb-1">Penghasilan</h6>
                        <div class="row">
                            <div class="col-12">
                                <p>Rp. {{ number_format($penghasilan, 0) }}</p>
                            </div>
                        </div>
                    </div>
                    <a class="text-black text-decoration-none" href="/logs">
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <small>Details</small>
                            <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
