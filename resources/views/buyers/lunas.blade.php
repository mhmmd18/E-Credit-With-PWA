@extends('layouts.main')
@section('title', 'Pembeli Lunas')
@section('content')
    <div class="mt-3">
        <h6>Pembeli {{ $type == 'Eceran' ? 'Eceran ' : 'Bungkusan' }} : <span class="badge bg-success text-white">Lunas</span></h6>
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
                        <a href="/buyers/list/{{ $type }}" class="btn btn-sm btn-secondary mb-3">Pembeli Belum Lunas</a>
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <table class="table table-secondary" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Hutang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buyers as $item)
                                    <tr>
                                        <td>{{ ($buyers->currentPage() - 1) * $buyers->perPage() + $loop->index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        @if ($type == 'Eceran')
                                        <td>{{ $item->qty * $item->smoke->unit_price }}</td>
                                        @else
                                        <td>{{ $item->qty * $item->smoke->price }}</td>
                                        @endif
                                        <td>
                                            <a href="/buyers/{{ $item->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#delete-{{ $item->id }}"
                                                    class="btn my-1 btn-sm btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
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
    {{-- modal hapus --}}
    @foreach ($buyers as $item)
        <div class="modal fade" id="delete-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Pop-Up Hapus</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/buyers/{{ $item->id }}" method="post">
                            @csrf
                            @method('delete')
                            <p>Apakah anda ingin menghapus pembeli ini?</p>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-primary">Hapus</button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
