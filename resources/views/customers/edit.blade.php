@extends('layouts.main')
@section('title', 'Edit Nasabah')
@section('content')
    <div class="mt-3">
        <h6>Nasabah / Edit</h6>
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="card py-3 px-3">
                    <p>Form Edit Nasabah</p>
                    <form action="/customers/{{ $customer->id }}" method="post">
                        @csrf
                        @method('put')
                        <div>
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" placeholder="Masukkan name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="password" class="form-label d-block">Jenis Kelamin</label>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="laki-laki" value="L" {{ old('gender', $customer->gender) == 'L' ? "checked" : "" }}>
                                <label class="form-check-label" for="laki-laki">
                                    Laki - Laki
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="perempuan" value="P" {{ old('gender', $customer->gender) == 'P' ? "checked" : ""}}>
                                <label class="form-check-label" for="perempuan">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="address" class="form-label">Alamat</label>
                            <select name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror" required>
                                <option value="" selected hidden>-- Pilih Alamat --</option>
                                <option value="Bakalan" {{ old('address', $customer->address) == 'Bakalan' ? "selected" : "" }}>Bakalan</option>
                                <option value="Babatan" {{ old('address', $customer->address) == 'Babatan' ? "selected" : "" }}>Babatan</option>
                                <option value="Lojok" {{ old('address', $customer->address) == 'Lojok' ? "selected" : "" }}>Lojok</option>
                                <option value="Petung" {{ old('address', $customer->address) == 'Petung' ? "selected" : "" }}>Petung</option>
                                <option value="Buaran" {{ old('address', $customer->address) == 'Buaran' ? "selected" : "" }}>Buaran</option>
                                <option value="Lajuk" {{ old('address', $customer->address) == 'Lajuk' ? "selected" : "" }}>Lajuk</option>
                                <option value="Jajar" {{ old('address', $customer->address) == 'Jajar' ? "selected" : "" }}>Jajar</option>
                                <option value="Lainnya" {{ old('address', $customer->address) == 'Lainnya' ? "selected" : "" }}>Lainnya</option>
                            </select>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="phone" class="form-label">No. HP</label>
                            <input type="number" name="phone" id="phone" placeholder="Masukkan No. Telp"
                                class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $customer->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="type" class="form-label">Tipe</label>
                            <select name="type" id="type"
                                class="form-control @error('type') is-invalid @enderror" required>
                                <option value="" selected hidden>-- Pilih Tipe --</option>
                                <option value="Harian" {{ old('type', $customer->type) == 'Harian' ? "selected" : "" }}>Harian</option>
                                <option value="Mingguan" {{ old('type', $customer->type) == 'Mingguan' ? "selected" : "" }}>Mingguan</option>
                                <option value="Bulanan" {{ old('type', $customer->type) == 'Bulanan' ? "selected" : "" }}>Bulanan</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="debt" class="form-label">Jumlah Hutang</label>
                            <input type="number" name="debt" id="debt" placeholder="Masukkan Jumlah Hutang"
                                class="form-control @error('debt') is-invalid @enderror" value="{{ old('debt', $customer->debt) }}" required>
                            @error('debt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            <a href="{{ URL::previous() }}" class="btn btn-sm btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
