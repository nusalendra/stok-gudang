@extends('layouts/contentNavbarLayout')

@section('title', ' Tambah Karyawan')

@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="py-2 mb-3 text-primary"><span class="text-muted fw-semibold">Form /</span> Tambah Karyawan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/karyawan/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nama_lengkap">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_lengkap" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Nama Lengkap" value="{{ $user->karyawan->nama_lengkap }}" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="jenis_kelamin" aria-label="Default select example"
                                    required>
                                    <option value="Laki-Laki"
                                        {{ $user->karyawan->jenis_kelamin === 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                                    </option>
                                    <option value="Perempuan"
                                        {{ $user->karyawan->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="umur">Umur</label>
                            <div class="col-sm-9">
                                <input type="number" name="umur" value="{{ $user->karyawan->umur }}" min="0"
                                    class="form-control" id="basic-default-name" placeholder="Masukkan Umur" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nomor_telepon">Nomor Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" name="nomor_telepon" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Nomor Telepon" value="{{ $user->karyawan->nomor_telepon }}" />
                            </div>
                        </div>
                        <h5 class="py-2 mb-3 text-primary">Akun Login Karyawan
                        </h5>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="email">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Email" value="{{ $user->email }}" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="password">Password Baru</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" id="basic-default-name"
                                    placeholder="*************" />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="text-end">
                                <a href="/karyawan">
                                    <button type="button" class="btn btn-danger">Kembali</button>
                                </a>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
