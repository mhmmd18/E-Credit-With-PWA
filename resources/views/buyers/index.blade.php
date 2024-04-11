@extends('layouts.main')
@section('title', 'Pembeli Belum Lunas')
@section('content')
    <div class="mt-3">
        <h6>Pembeli {{ $type == 'Eceran' ? 'Eceran ' : 'Bungkusan' }} : <span class="badge bg-danger text-white">Belum Lunas</span></h6>
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="card">
                    <form action="" class="mx-2">
                        <div class="row">
                            <div class="col-12 col-md-6 pt-2">
                                <div class="input-group">
                                    <input type="date" name="created_at" class="form-control" aria-label="Recipient's date" aria-describedby="button-addon2">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 pt-2">
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan Nama"
                                        aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary" type="submit"
                                        id="button-addon2">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <a href="/buyers/create" class="btn btn-sm btn-primary mb-3"><i
                                class="fa-solid fa-plus me-2"></i>Tambah</a>
                        <a href="/buyers/list/{{ $type }}/lunas" class="btn btn-sm btn-secondary mb-3">Pembeli Lunas</a>
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <table class="table table-secondary" style="font-size: 12px" id="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Hutang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buyers as $item)
                                    <tr>
                                        <td>{{ ($buyers->currentPage() - 1) * $buyers->perPage() + $loop->index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        @if ($item->type == 'Eceran')
                                            <td>Rp. {{ number_format($item->qty * $item->smoke->unit_price, 0, ',', '.') }}</td>
                                        @else
                                            <td>Rp. {{ number_format($item->qty * $item->smoke->price, 0, ',', '.') }}</td>
                                        @endif
                                        <td>
                                            <a href="/buyers/confirm/{{ $item->id }}" data-bs-toggle="modal"
                                                data-bs-target="#confirm-{{ $item->id }}" class="btn btn-sm btn-info">
                                                <i class="fa-solid fa-check-double"></i>
                                            </a>
                                            <a href="/buyers/{{ $item->id }}" data-bs-toggle="modal"
                                                data-bs-target="#detail-{{ $item->id }}" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="/buyers/{{ $item->id }}/edit" class="btn my-1 btn-sm btn-warning">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $buyers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal detail --}}
    @foreach ($buyers as $item)
        <div class="modal fade" id="detail-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Pop-Up Detail</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header bg-success text-white text-center mb-1">
                                    List Detail Pembeli
                                </div>
                                <table class="table table-secondary">
                                    <tr>
                                        <th>Nama</th>
                                        <td>:</td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rokok</th>
                                        <td>:</td>
                                        <td>
                                            {{ $item->smoke->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tipe</th>
                                        <td>:</td>
                                        <td>
                                            {{ $item->type }}
                                        </td>
                                    </tr>
                                    @if ($item->type == 'Eceran')
                                    <tr>
                                        <th>Harga Ecer</th>
                                        <td>:</td>
                                        <td>
                                        Rp. {{ str_replace(',', '.', number_format($item->smoke->unit_price, 0)) }}
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <th>Harga 1 Bungkus</th>
                                        <td>:</td>
                                        <td>
                                        Rp. {{ str_replace(',', '.', number_format($item->smoke->price, 0)) }}
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Jumlah</th>
                                        <td>:</td>
                                        <td>
                                            {{ $item->qty }}
                                        </td>
                                    </tr>
                                    @if ($item->type == 'Eceran')
                                    <tr>
                                        <th>Total</th>
                                        <td>:</td>
                                        <td>
                                            Rp. {{ number_format($item->qty * $item->smoke->unit_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <th>Total</th>
                                        <td>:</td>
                                        <td>
                                            Rp. {{ number_format($item->qty * $item->smoke->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- modal confirm --}}
    @foreach ($buyers as $item)
        <div class="modal fade" id="confirm-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Pop-Up Confirm</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/buyers/confirm/{{ $item->id }}" method="post">
                            @csrf
                            @method('put')
                            <p>Apakah anda ingin mengubah status pembeli ini?</p>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-primary">Confirm</button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
