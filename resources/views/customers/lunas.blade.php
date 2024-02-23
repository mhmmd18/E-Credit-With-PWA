@extends('layouts.main')
@section('title', 'Nasabah Lunas')
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
                                    <option value="Bakalan" {{ old('address') == 'Bakalan' ? 'selected' : '' }}>Bakalan
                                    </option>
                                    <option value="Babatan" {{ old('address') == 'Babatan' ? 'selected' : '' }}>Babatan
                                    </option>
                                    <option value="Lojok" {{ old('address') == 'Lojok' ? 'selected' : '' }}>Lojok</option>
                                    <option value="Petung" {{ old('address') == 'Petung' ? 'selected' : '' }}>Petung
                                    </option>
                                    <option value="Buaran" {{ old('address') == 'Buaran' ? 'selected' : '' }}>Buaran
                                    </option>
                                    <option value="Lajuk" {{ old('address') == 'Lajuk' ? 'selected' : '' }}>Lajuk</option>
                                    <option value="Jajar" {{ old('address') == 'Jajar' ? 'selected' : '' }}>Jajar</option>
                                    <option value="Lainnya" {{ old('address') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
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
                        <a href="/customers/list/{{ $type }}" class="btn btn-sm btn-secondary mb-3">Nasabah Belum Lunas</a>
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
                                            <a href="/customers/{{ $item->id }}" class="btn my-1 btn-sm btn-success"><i
                                                    class="fa-solid fa-eye"></i></a>
                                            <a href="/customers/{{ $item->id }}/edit"
                                                class="btn my-1 btn-sm btn-warning"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="/customers/{{ $item->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#delete-{{ $item->id }}"
                                                    class="btn my-1 btn-sm btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $customers->links() }}
                    </div>
                </div>
                {{-- modal hapus --}}
                @foreach ($customers as $item)
                    <div class="modal fade" id="delete-{{ $item->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="modal-title" id="exampleModalLabel">Hapus Nasabah</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/customers/{{ $item->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <p>Apakah anda ingin menghapus nasabah ini?</p>
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
