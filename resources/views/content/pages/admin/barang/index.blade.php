@extends('layouts/contentNavbarLayout')

@section('title', 'Barang')

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
    <div class="text-end mb-3">
        <button id="klasifikasiButton" type="button" class="btn btn-primary">Klasifikasi Perhitungan</button>
    </div>
    <div class="card">
        <h5 class="card-header text-dark fw-bold">Daftar Barang</h5>
        <div class="card ps-3 pe-3 pb-3">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive text-nowrap p-0">
                    <table id="myTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">No</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Barang</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Harga Beli</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Harga Jual</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Stok</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Tanggal Expired</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Total Stok Keluar</th>
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
                                                <h6 class="mb-0 text-sm">{{ $item->nama }} (Ukuran {{ $item->ukuran }},
                                                    Warna {{ $item->warna }})</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Rp.
                                                    {{ number_format($item->harga_beli, 0, ',', '.') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Rp.
                                                    {{ number_format($item->harga_jual, 0, ',', '.') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->stok }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    {{ \Carbon\Carbon::parse($item->tanggal_expired)->locale('id')->translatedFormat('d F Y') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                @if ($item->total_stok_keluar)
                                                    <h6 class="mb-0 text-sm">{{ $item->total_stok_keluar }}</h6>
                                                @else
                                                    <h6 class="mb-0 text-sm">0</h6>
                                                @endif
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
        document.getElementById('klasifikasiButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Klasifikasi Perhitungan',
                html: `
            <p>Menentukan Kelas ABC untuk Rentang Nilai Presentase Kumulatif</p>
            <label for="classA">Kelas A (Persentase):</label>
            <input id="classA" class="swal2-input" type="number" min="0" max="100">
            
            <label for="classB">Kelas B (Persentase):</label>
            <input id="classB" class="swal2-input" type="number" min="0" max="100">
            
            <label for="classC">Kelas C (Persentase):</label>
            <input id="classC" class="swal2-input" type="number" min="0" max="100">
        `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const classA = document.getElementById('classA').value;
                    const classB = document.getElementById('classB').value;
                    const classC = document.getElementById('classC').value;

                    if (!classA || !classB || !classC) {
                        Swal.showValidationMessage('Semua nilai persentase harus diisi');
                    } else if (parseInt(classA) + parseInt(classB) + parseInt(classC) !== 100) {
                        Swal.showValidationMessage('Total persentase harus 100%');
                    }

                    return {
                        classA,
                        classB,
                        classC
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const {
                        classA,
                        classB,
                        classC
                    } = result.value;

                    axios.post('/barang/klasifikasi-perhitungan', {
                            kelasA: classA,
                            kelasB: classB,
                            kelasC: classC
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            // Redirect ke halaman hasil setelah klasifikasi berhasil
                            window.location.href = '/barang/hasil-klasifikasi-perhitungan';
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error',
                                'Terjadi kesalahan saat menyimpan data',
                                'error'
                            );
                        });
                } else if (result.isDismissed) {
                    Swal.fire(
                        'Dibatalkan',
                        'Proses klasifikasi dibatalkan.',
                        'error'
                    );
                }
            });
        });
    </script>
@endsection
