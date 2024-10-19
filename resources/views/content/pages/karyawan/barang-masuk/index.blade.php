@extends('layouts/contentNavbarLayout')

@section('title', 'Karyawan')

@section('content')
    <div class="text-end mb-3">
        <a href="/barang-masuk/barang-tersedia">
            <button type="button" class="btn btn-primary">Input Barang Tersedia</button>
        </a>
        <a href="/barang-masuk/barang-baru">
            <button type="button" class="btn btn-primary">Input Barang Baru</button>
        </a>
    </div>
    <div class="card">
        <h5 class="card-header text-dark fw-bold">Daftar Barang Masuk</h5>
        <div class="card ps-3 pe-3 pb-3">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive text-nowrap p-0">
                    <table id="myTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">No</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Tanggal Barang Masuk</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Supplier Barang</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Nama Barang</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Jumlah</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Karyawan Penerima Barang
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $index + 1 }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $item->created_at->locale('id')->timezone('Asia/Jakarta')->translatedFormat('d F Y / H:i') }}
                                                    </h6>

                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->supplier->nama }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->barang->nama }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->jumlah }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->karyawan->nama_lengkap }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
                    <script src="//cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
                    <script>
                        let table = new DataTable('#myTable');
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
