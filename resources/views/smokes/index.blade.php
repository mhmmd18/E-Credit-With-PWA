@extends('layouts.main')
@section('title', 'Data Rokok')
@section('content')
    <div class="mt-3">
        <h6>Data Rokok</h6>
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="card">
                    <form action="" class="mx-3">
                        <div class="row">
                            <div class="col-4 col-md-6 pt-2">
                                <a href="/smokes/create" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-plus me-2"></i>Tambah</a>
                            </div>
                            <div class="col-8 col-md-6 pt-2">
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($smokes as $item)
                                    <tr>
                                        <td>{{ $startNumber++ }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="/smokes/{{ $item->id }}" data-bs-toggle="modal"
                                                data-bs-target="#detail-{{ $item->id }}" class="btn btn-sm btn-success">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="/smokes/{{ $item->id }}/edit" class="btn my-1 btn-sm btn-warning">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="/smokes/{{ $item->id }}" data-bs-toggle="modal"
                                                data-bs-target="#delete-{{ $item->id }}" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $smokes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal detail --}}
    @foreach ($smokes as $item)
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
                                    List Detail Rokok
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
                                        <th>Harga Ecer</th>
                                        <td>:</td>
                                        <td>
                                        Rp. {{ str_replace(',', '.', number_format($item->unit_price, 0)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Harga 1 Bungkus</th>
                                        <td>:</td>
                                        <td>
                                        Rp. {{ str_replace(',', '.', number_format($item->price, 0)) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- modal hapus --}}
    @foreach ($smokes as $item)
        <div class="modal fade" id="delete-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">Pop-Up Hapus</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/smokes/{{ $item->id }}" method="post">
                            @csrf
                            @method('delete')
                            <p>Apakah anda ingin menghapus rokok ini?</p>
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
