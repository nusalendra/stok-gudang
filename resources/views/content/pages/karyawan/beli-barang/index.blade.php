@extends('layouts/contentNavbarLayout')

@section('title', 'Beli Barang')

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
        <button id="masukkanKeranjang" type="button" class="btn btn-dark">Masukkan Keranjang</button>
        <button id="submitSelection" type="button" class="btn btn-primary">Checkout Barang</button>
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
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Rak</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Barang</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Harga</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Sisa Stok</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Tanggal Expired</th>
                                <th class="text-uppercase text-xs font-weight-bolder text-start">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                @php
                                    $today = \Carbon\Carbon::now();
                                    $tanggalExpired = \Carbon\Carbon::parse($item->tanggal_expired);
                                    $hargaFinal = $today->greaterThanOrEqualTo($tanggalExpired)
                                        ? $item->harga_jual / 2
                                        : $item->harga_jual;
                                @endphp
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
                                                <h6 class="mb-0 text-sm">{{ $item->rak?->nama }}</h6>
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
                                                <h6 class="mb-0 text-sm">
                                                    @if ($today->greaterThanOrEqualTo($tanggalExpired))
                                                        <s class="text-danger">Rp.
                                                            {{ number_format($item->harga_jual, 0, ',', '.') }}</s>
                                                        Rp. {{ number_format($hargaFinal, 0, ',', '.') }}
                                                    @else
                                                        Rp. {{ number_format($item->harga_jual, 0, ',', '.') }}
                                                    @endif
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
                                                    {{ $tanggalExpired->locale('id')->translatedFormat('d F Y') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <input type="checkbox" class="item-checkbox" data-id="{{ $item->id }}"
                                                    data-nama="{{ $item->nama }}" data-stok="{{ $item->stok }}"
                                                    data-harga="{{ $hargaFinal }}">
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
        document.getElementById('submitSelection').addEventListener('click', async function() {
            const selectedIds = [];
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');

            for (const checkbox of checkboxes) {
                const id = checkbox.dataset.id;
                const stok = checkbox.dataset.stok;
                const nama = checkbox.dataset.nama;

                if (stok === "0") {
                    await Swal.fire('Peringatan', `Stok untuk barang ${nama} habis!`, 'warning');
                    return;
                }

                selectedIds.push(id);
            }

            if (selectedIds.length === 0) {
                Swal.fire('Peringatan', 'Pilih setidaknya satu barang untuk melanjutkan!', 'warning');
                return;
            }

            const {
                isConfirmed
            } = await Swal.fire({
                title: 'Konfirmasi',
                text: `Anda akan membeli ${selectedIds.length} barang. Lanjutkan?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
            });

            if (isConfirmed) {
                axios.post('/beli-barang/checkout-items', {
                    ids: selectedIds
                }).then(response => {
                    Swal.fire('Sukses', 'Barang berhasil diproses!', 'success').then(() => {
                        window.location.href = '/beli-barang/checkout';
                    });
                }).catch(error => {
                    Swal.fire('Error', 'Terjadi kesalahan saat memproses data!', 'error');
                });
            }
        });

        document.getElementById('masukkanKeranjang').addEventListener('click', async function() {
            const selectedItems = [];
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');

            for (const checkbox of checkboxes) {
                const id = checkbox.dataset.id;
                const stok = parseInt(checkbox.dataset.stok, 10);
                const nama = checkbox.dataset.nama;
                const harga = parseFloat(checkbox.dataset.harga);

                if (stok === 0) {
                    await Swal.fire('Peringatan', `Stok untuk barang ${nama} habis!`, 'warning');
                    return;
                }

                const {
                    value: jumlah
                } = await Swal.fire({
                    title: `Masukkan jumlah untuk ${nama}`,
                    input: 'number',
                    inputAttributes: {
                        min: 1,
                        max: stok,
                        step: 1
                    },
                    inputPlaceholder: 'Jumlah barang',
                    showCancelButton: true,
                    confirmButtonText: 'Masukkan',
                    cancelButtonText: 'Batal',
                });

                if (jumlah) {
                    if (jumlah > stok) {
                        await Swal.fire('Peringatan',
                            `Jumlah melebihi stok tersedia (${stok}) untuk barang ${nama}!`, 'warning');
                        return;
                    }
                    selectedItems.push({
                        id,
                        nama,
                        harga,
                        jumlah
                    });
                }
            }

            if (selectedItems.length === 0) {
                Swal.fire('Peringatan', 'Pilih setidaknya satu barang untuk melanjutkan!', 'warning');
                return;
            }

            const {
                value: namaPembeli
            } = await Swal.fire({
                title: 'Masukkan Nama Pembeli',
                input: 'text',
                inputPlaceholder: 'Nama pembeli',
                showCancelButton: true,
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal',
            });

            if (!namaPembeli) {
                Swal.fire('Peringatan', 'Nama pembeli wajib diisi!', 'warning');
                return;
            }

            const {
                isConfirmed
            } = await Swal.fire({
                title: 'Konfirmasi',
                text: `Anda akan menambahkan ${selectedItems.length} barang ke keranjang. Lanjutkan?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
            });

            if (isConfirmed) {
                axios.post('/beli-barang/masukkan-keranjang', {
                    nama_pembeli: namaPembeli,
                    items: selectedItems
                }).then(response => {
                    Swal.fire('Sukses', 'Barang berhasil diproses!', 'success').then(() => {
                        window.location.href = '/beli-barang';
                    });
                }).catch(error => {
                    Swal.fire('Error', 'Terjadi kesalahan saat memproses data!', 'error');
                });
            }
        });
    </script>
@endsection
