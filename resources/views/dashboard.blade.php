@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <div class="mt-3">
        @if (Auth::user()->role_id == 1)
        <h6 class="">Dashboard / Admin</h6>
        <div class="row mt-3">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-danger text-white">
                    <div class="mt-3 px-3">
                        <h6 class="pb-1">Data Pengguna</h6>
                        <div class="row">
                            <div class="col-12">
                                <p>Jumlah : {{ $user }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a class="text-white text-decoration-none" href="/users">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif (Auth::user()->role_id == 2 && Auth::user()->username == 'hamzia')
        <h6 class="">Dashboard / Owner</h6>
        <div class="row mt-3">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-primary text-white">
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
                            <a class="text-white text-decoration-none" href="/customers/list/Harian/lunas">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="text-white text-decoration-none" href="/customers/list/Harian">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-success text-white">
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
                            <a class="text-white text-decoration-none" href="/customers/list/Mingguan/lunas">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="text-white text-decoration-none" href="/customers/list/Mingguan">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
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
        @else 
        <h6 class="">Dashboard / Owner</h6> 
        <div class="row mt-3">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-primary text-white">
                    <div class="mt-3 px-3">
                        <h6 class="pb-1">Data Rokok</h6>
                        <div class="row">
                            <div class="col-12">
                                <p>{{ $rokok }} Macam</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a class="text-white text-decoration-none" href="/smokes">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-success text-white">
                    <div class="mt-3 px-3">
                        <h6 class="pb-1">Pelanggan Eceran</h6>
                        <div class="row">
                            <div class="col-6">
                                <p>Lunas : {{ $eceranLunas }}</p>
                            </div>
                            <div class="col-6">
                                <p class="ps-3">Belum : {{ $eceranBelumLunas }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a class="text-white text-decoration-none" href="/buyers/list/Eceran/lunas">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="text-white text-decoration-none" href="/buyers/list/Eceran">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card bg-warning text-black">
                    <div class="mt-3 px-3">
                        <h6 class="pb-1">Pembeli Bungkusan</h6>
                        <div class="row">
                            <div class="col-6">
                                <p>Lunas : {{ $bungkusanLunas }}</p>
                            </div>
                            <div class="col-6">
                                <p class="ps-3">Belum : {{ $bungkusanBelumLunas }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <a class="text-black text-decoration-none" href="/buyers/list/Bungkusan/lunas">
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <small>Details</small>
                                    <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="text-black text-decoration-none" href="/buyers/list/Bungkusan">
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
                        <h6 class="pb-1">Total Hutang</h6>
                        <div class="row">
                            <div class="col-12">
                                <p>Rp. {{ number_format($totalHutang, 0) }}</p>
                            </div>
                        </div>
                    </div>
                    <a class="text-black text-decoration-none" href="/reports">
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <small>Details</small>
                            <div class="small text-black"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
