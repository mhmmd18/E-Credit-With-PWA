@extends('layouts.main')
@section('title', 'Detail Nasabah')
@section('content')
    <div class="mt-3">
        <!-- <h6>Nasabah / Show</h6> -->
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header bg-success text-white mb-1">
                            Detail Nasabah : <span class="badge bg-light text-dark">{{ $customer->name }}</span>
                        </div>
                        <table class="table table-secondary">
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>
                                    {{ $customer->name }}
                                </td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>:</td>
                                <td>
                                    @if ($customer->gender == 'L')
                                        Laki - Laki
                                    @else
                                        Perempuan
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>:</td>
                                <td>
                                    {{ $customer->address }}
                                </td>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <td>:</td>
                                <td>
                                    @if ($customer->phone != null)
                                        {{ $customer->phone }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Tipe</th>
                                <td>:</td>
                                <td>
                                    {{ $customer->type }}
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Hutang</th>
                                <td>:</td>
                                <td>
                                    Rp. {{ str_replace(',', '.', number_format($customer->debt, 0)) }}
                                </td>
                            </tr>
                            <tr>
                                <th>Sisa Hutang</th>
                                <td>:</td>
                                <td>
                                    Rp. {{ str_replace(',', '.', number_format($customer->debt - $totalCicilan, 0)) }}
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>:</td>
                                <td>
                                    <span
                                        class="badge badge-sm {{ $customer->status == 'Lunas' ? 'bg-success' : 'bg-danger' }}">{{ $customer->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Barang</th>
                                <td>:</td>
                                <td>
                                @if ($customer->items != null)
                                        {{ $customer->items }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-md-10">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="card-header bg-info text-black">
                            Detail Catatan : <span class="badge bg-light text-dark">{{ $customer->name }}</span>
                        </div>
                        <form action="" class="col-12 col-md-6 py-2">
                            <div class="input-group">
                                <input type="date" name="date" class="form-control" aria-label="Recipient's date" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </form>   
                        <x-logs-table :catatan='$logs' :totalCicilan='$totalCicilan' />
                        <a href="{{ $customer->type == 'Harian' && $customer->status == 'Belum Lunas' ? '/customers/list/Harian' : ($customer->type == 'Harian' && $customer->status == 'Lunas' ? '/customers/list/Harian/lunas' : ($customer->type == 'Mingguan' && $customer->status == 'Belum Lunas' ? '/customers/list/Mingguan' : ($customer->type == 'Mingguan' && $customer->status == 'Lunas' ? '/customers/list/Mingguan/lunas' : ($customer->type == 'Bulanan' && $customer->status == 'Belum Lunas' ? '/customers/list/Bulanan' : '/customers/list/Bulanan/lunas')))) }}" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
