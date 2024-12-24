@extends('layouts/contentNavbarLayout')

@section('title', 'Laporan')

@section('content')
    <style>
        .my-swal-popup {
            z-index: 1060 !important;
        }

        .swal2-backdrop-show {
            z-index: 1059 !important;
            background-color: rgba(0, 0, 0, 0.4) !important;
        }

        .navbar,
        .sidebar {
            z-index: 1000 !important;
        }
    </style>
    <div class="text-center mb-3">
        <a id="cetakPdfButton" href="/laporan/cetak-pdf" class="btn btn-dark" target="_blank">Cetak PDF</a>
        <button id="tanggalLaporanButton" type="button" class="btn btn-primary">Atur Tanggal Laporan Penjualan</button>
    </div>
    <div class="card">
        <div class="card-header bg-primary text-white py-3 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-white">Laporan Penjualan Harian</h5>
                <h6 class="mb-0 fw-bold text-white">
                    {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('d F Y') }}
                </h6>
            </div>
        </div>
        <div class="card ps-3 pe-3 pb-3">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive text-nowrap p-0">
                    <table id="myTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">No</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Nama Barang</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Harga Jual</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Terjual Hari Ini</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Total Harga</th>
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
                                                <h6 class="mb-0 text-sm">{{ $item->nama }} (Ukuran
                                                    {{ $item->ukuran }},
                                                    Warna {{ $item->warna }})</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Rp.
                                                    {{ number_format($item->harga, 0, ',', '.') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->total_qty }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Rp.
                                                    {{ number_format($item->total_qty * $item->harga, 0, ',', '.') }}
                                                </h6>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const cetakPdfButton = document.getElementById('cetakPdfButton');

        const currentUrlParams = new URLSearchParams(window.location.search);
        const filteredTanggal = currentUrlParams.get('tanggal');

        if (filteredTanggal) {
            cetakPdfButton.href = `/laporan/cetak-pdf?tanggal=${filteredTanggal}`;
        }

        tanggalLaporanButton.addEventListener('click', function() {
            Swal.fire({
                title: 'Tanggal Laporan Penjualan',
                html: `
            <p>Sesuaikan Tanggal Laporan Penjualan yang Ingin Diperiksa</p>
            <label for="tanggal">Input Tanggal :</label>
            <input id="tanggal" class="swal2-input" type="date" value="${filteredTanggal || ''}">
        `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const tanggal = document.getElementById('tanggal').value;
                    if (!tanggal) {
                        Swal.showValidationMessage('Tanggal tidak boleh kosong');
                        return false;
                    }
                    return {
                        tanggal
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const {
                        tanggal
                    } = result.value;

                    if (tanggal) {
                        cetakPdfButton.href = `/laporan/cetak-pdf?tanggal=${tanggal}`;

                        window.location.href = `/laporan?tanggal=${tanggal}`;
                    } else {
                        Swal.fire(
                            'Gagal',
                            'Tanggal tidak valid.',
                            'error'
                        );
                    }
                } else if (result.isDismissed) {
                    Swal.fire(
                        'Dibatalkan',
                        'Atur Tanggal Laporan Penjualan Dibatalkan',
                        'error'
                    );
                }
            });
        });
    </script>
@endsection
