@extends('layouts/contentNavbarLayout')

@section('title', ' Tambah Supplier')

@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="py-2 mb-3 text-primary"><span class="text-muted fw-semibold">Form /</span> Tambah Supplier
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/supplier" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nama">Nama Supplier <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Nama Supplier" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="alamat">Alamat <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="alamat" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Alamat" required />
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
                        <div class="row justify-content-end">
                            <div class="text-end">
                                <a href="/supplier">
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
