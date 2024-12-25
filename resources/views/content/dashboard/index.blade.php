@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Selamat Datang {{ Auth::user()->name }}!</h5>
                            <p class="mb-4">Dashboard menampilkan berbagai informasi mengenai stok gudang, termasuk total
                                barang yang masuk dan keluar, jumlah barang yang terdaftar serta yang telah expired, dan
                                total pendapatan untuk setiap jenis barang.</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Total Barang Masuk</span>
                            <h3 class="card-title mb-2">{{ $totalBarangMasuk }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Total Barang Dibeli</span>
                            <h3 class="card-title mb-2 text-primary">{{ $totalBarangDibeli }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Total Barang</span>
                            <h3 class="card-title mb-2 text-info">{{ $totalBarang }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Total Barang Dengan Tanggal Expired</span>
                            <h3 class="card-title mb-2 text-danger">{{ $totalBarangExpired }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
            <div class="p-3 bg-white rounded shadow">
                {!! $totalPendapatanBarangChart->container() !!}
            </div>
        </div>
    </div>
    <script src="{{ $totalPendapatanBarangChart->cdn() }}"></script>

    {{ $totalPendapatanBarangChart->script() }}
@endsection
