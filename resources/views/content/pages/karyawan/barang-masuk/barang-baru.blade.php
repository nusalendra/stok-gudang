@extends('layouts/contentNavbarLayout')

@section('title', 'Input Barang Baru')

@section('content')
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="py-2 mb-3 text-primary">Input Barang Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/barang-masuk/barang-baru" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="supplier_id">Supplier <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="supplier_id" aria-label="Default select example" required>
                                    <option value="" selected disabled>Tentukan Supplier</option>
                                    @foreach ($supplier as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nama">Nama Barang <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Nama Barang" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="ukuran">Ukuran <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" name="ukuran" value="0" min="0" class="form-control"
                                    id="basic-default-name" placeholder="Masukkan Ukuran" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="warna">Warna <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="warna" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Warna" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="jumlah">Jumlah Barang <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" name="jumlah" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Jumlah Barang" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="harga_beli">Harga Beli <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" min="0" value="0" name="harga_beli" class="form-control"
                                    id="basic-default-name" placeholder="Masukkan Harga Beli" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="persentase_harga_jual">Harga Jual (Persentase) <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" min="0" value="0" name="persentase_harga_jual"
                                    class="form-control" id="basic-default-name" placeholder="Masukkan Harga Jual"
                                    required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="deskripsi">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="deskripsi" placeholder="Tambahkan Deskripsi (Opsional)" id="floatingTextarea"></textarea>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="text-end">
                                <a href="/barang-masuk">
                                    <button type="button" class="btn btn-danger">Kembali</button>
                                </a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
