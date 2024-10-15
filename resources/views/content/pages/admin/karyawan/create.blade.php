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
                    <form action="/karyawan" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nama_lengkap">Nama Lengkap <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_lengkap" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Nama Lengkap" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="jenis_kelamin">Jenis Kelamin <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="jenis_kelamin" aria-label="Default select example"
                                    required>
                                    <option value="" selected disabled>Tentukan Jenis Kelamin</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="umur">Umur <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" name="umur" value="0" min="0" class="form-control"
                                    id="basic-default-name" placeholder="Masukkan Umur" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nomor_telepon">Nomor Telepon <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nomor_telepon" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Nomor Telepon" required />
                            </div>
                        </div>
                        <h5 class="py-2 mb-3 text-primary">Akun Login Karyawan
                        </h5>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="email">Email <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Email" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="password">Password <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" id="basic-default-name"
                                    placeholder="*************" required />
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
