@extends('layouts.main')
@section('title', 'Data Pengguna')
@section('content')
    <div class="mt-3">
        <h6>Data User</h6>
        <div class="row">
            <div class="col-12 col-md-6">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <a href="/users/create" class="btn btn-sm btn-primary mb-3"><i
                                class="fa-solid fa-plus me-2"></i>Tambah</a>
                        <table class="table" id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Username</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>
                                            <a href="/users/{{ $item->id }}/edit" class="btn btn-sm btn-warning"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="" data-bs-toggle="modal"
                                                data-bs-target="#delete-{{ $item->id }}" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- modal hapus --}}
                @foreach ($users as $item)
                    <div class="modal fade" id="delete-{{ $item->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="modal-title" id="exampleModalLabel">Hapus Data</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/users/{{ $item->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <p>Apakah anda ingin menghapus data ini?</p>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-sm btn-primary">Hapus</button>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
