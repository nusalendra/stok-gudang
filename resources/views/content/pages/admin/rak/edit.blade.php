@extends('layouts/contentNavbarLayout')

@section('title', ' Edit Rak')

@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="py-2 mb-3 text-primary"><span class="text-muted fw-semibold">Form /</span> Edit Rak
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/rak/{{ $rak->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nama">Nama Rak <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" value="{{ $rak->nama }}" class="form-control"
                                    id="basic-default-name" placeholder="Masukkan Nama Rak" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="lokasi">Lokasi Rak<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="lokasi" value="{{ $rak->lokasi }}" class="form-control"
                                    id="basic-default-name" placeholder="Masukkan Lokasi Rak" required />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="text-end">
                                <a href="/rak">
                                    <button type="button" class="btn btn-danger">Kembali</button>
                                </a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
