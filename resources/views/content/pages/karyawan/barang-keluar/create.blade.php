@extends('layouts/contentNavbarLayout')

@section('title', 'Input Barang Keluar')

@section('content')
    <style>
        .swal2-container {
            z-index: 9999;
        }
    </style>
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="py-2 mb-3 text-primary">Input Barang Keluar
                    </h5>
                </div>
                <div class="card-body">
                    <form action="/barang-keluar" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="barang_id">Barang <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="barang_id" aria-label="Default select example" required>
                                    <option value="" selected disabled>Tentukan Barang</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }} (Ukuran
                                            {{ $item->ukuran }}, Warna {{ $item->warna }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="status_penjualan">Status Penjualan <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" name="status_penjualan" aria-label="Default select example"
                                    required>
                                    <option value="" selected disabled>Tentukan Status Penjualan</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Obral">Obral</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="jumlah">Jumlah Barang <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" name="jumlah" min="0" value="0" class="form-control"
                                    id="basic-default-name" placeholder="Masukkan Jumlah Barang" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="nama_pembeli">Nama Pembeli <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_pembeli" class="form-control" id="basic-default-name"
                                    placeholder="Masukkan Nama Pembeli" required />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="text-end">
                                <a href="/barang-keluar">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Aksi Dihentikan',
                text: '{{ session('error') }}',
                backdrop: true
            });
        </script>
    @endif
@endsection
