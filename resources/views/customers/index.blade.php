@extends('layouts.main')
@section('title', 'Nasabah Belum Lunas')
@section('content')
    <div class="mt-3">
        <h6>Nasabah {{ $type == 'Harian' ? 'Harian ' : ($type == 'Mingguan' ? 'Mingguan ' : 'Bulanan ') }}/ Index </h6>
        <div class="row">
            <div class="col-12 col-md-10">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <form action="" class="mx-2">
                        <div class="row">
                            <div class="col-12 col-md-6 py-2">
                                <select name="address" class="form-control">
                                    <option value="" selected hidden>Pilih Alamat</option>
                                    <option value="Bakalan">Bakalan</option>
                                    <option value="Babatan">Babatan</option>
                                    <option value="Lojok">Lojok</option>
                                    <option value="Petung">Petung</option>
                                    <option value="Buaran">Buaran</option>
                                    <option value="Lajuk">Lajuk</option>
                                    <option value="Jajar">Jajar</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 py-2">
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan Nama"
                                        aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary" type="submit"
                                        id="button-addon2">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <a href="/customers/create" class="btn btn-sm btn-primary mb-3"><i
                                class="fa-solid fa-plus me-2"></i>Tambah</a>
                        <a href="/customers/list/{{ $type }}/lunas" class="btn btn-sm btn-secondary mb-3">Nasabah Lunas</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>
                                            <span
                                                class="badge badge-sm {{ $item->status == 'Lunas' ? 'bg-success' : 'bg-danger' }}">{{ $item->status }}</span>
                                        </td>
                                        <td>
                                                <a href="/customers/log/{{ $item->id }}"
                                                    class="btn my-1 btn-sm btn-primary"><i
                                                        class="fa-solid fa-money-bill"></i></a>
                                            <a href="/customers/{{ $item->id }}" class="btn my-1 btn-sm btn-success"><i
                                                    class="fa-solid fa-eye"></i></a>
                                            <a href="/customers/{{ $item->id }}/edit"
                                                class="btn my-1 btn-sm btn-warning"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
