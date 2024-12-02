@extends('layouts/contentNavbarLayout')
@php
    $container = 'container-fluid';
    $containerNav = 'container-fluid';
    $isMenu = false;
@endphp
@section('title', 'Daftar Rak')

@section('content')
    <style>
        .swal2-container {
            z-index: 10000 !important;
        }
    </style>
    <div class="d-flex justify-content-between mb-3">
        <a href="/rak">
            <button type="button" class="btn btn-dark">Kembali ke Halaman</button>
        </a>
        <div>
            <a href="/rak/{{ $data->id }}/cetak-pdf" class="btn btn-primary" target="_blank">Cetak PDF</a>
            <button id="openSweetAlert" type="button" class="btn btn-primary">Masukkan Barang</button>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header text-dark fw-bold">Daftar Barang di {{ $data->nama }}</h5>
        <div class="card ps-3 pe-3 pb-3">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive text-nowrap p-0">
                    <table id="myTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">No</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Nama Barang</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Stok
                                </th>
                                <th class="text-uppercase text-xs font-weight-bolder">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $index => $item)
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
                                                <h6 class="mb-0 text-sm">{{ $item->stok }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="ms-2 d-flex flex-column justify-content-center">
                                                <form action="/rak/{{ $data->id }}/hapus-barang/{{ $item->id }}"
                                                    method="POST" role="form text-left">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-trash3 me-1 mb-1" viewBox="0 0 16 16">
                                                            <path
                                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('openSweetAlert').addEventListener('click', async (event) => {
            const rakId = {{ $data->id }};

            // Mengambil barangList yang sudah diproses di Controller
            const barangList = @json($barangBelumDiRak);

            let checkboxList =
                '<div style="display: flex; flex-direction: column; gap: 10px;">'; // Mengubah flex direction menjadi column
            barangList.forEach(item => {
                checkboxList += `
                    <div>
                        <input type="checkbox" id="barang-${item.id}" name="barang" value="${item.id}">
                        <label for="barang-${item.id}">${item.nama}</label>
                    </div>`;
            });
            checkboxList += '</div>';

            const {
                value: selected
            } = await Swal.fire({
                title: "Barang Belum Di Rak",
                html: `
                    <form id="barangForm">
                        ${checkboxList}
                    </form>
                `,
                confirmButtonText: 'Submit',
                showCancelButton: true,
                preConfirm: () => {
                    const selectedItems = Array.from(document.querySelectorAll(
                            'input[name="barang"]:checked'))
                        .map(input => input.value);

                    if (selectedItems.length === 0) {
                        Swal.showValidationMessage("Pilih minimal satu barang!");
                    }

                    return selectedItems;
                }
            });

            if (selected && selected.length > 0) {
                fetch(`/rak/${rakId}/kirimbarang`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        barangIds: selected
                    })
                }).then(response => {
                    if (response.ok) {
                        Swal.fire("Sukses!", "Barang berhasil dikirim.", "success").then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire("Error!", "Terjadi kesalahan saat mengirim barang.", "error");
                    }
                }).catch(error => {
                    console.error(error);
                    Swal.fire("Error!", "Terjadi kesalahan koneksi.", "error");
                });
            }
        });
    </script>

@endsection
