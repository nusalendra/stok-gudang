@extends('layouts/contentNavbarLayout')

@section('title', 'Daftar Pembelian')

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
    <div class="container mt-4">
        <div class="p-4 bg-white rounded shadow">
            <h2 class="mb-4 text-center">Daftar Pesanan Pembeli</h2>

            <div class="mb-4">
                <h4 class="mb-2">Informasi Pembeli</h4>
                <ul class="list-unstyled">
                    <li><strong>Nama Pembeli :</strong> {{ $pembeli->nama_pembeli }}</li>
                    <li><strong>Total Barang Dipesan :</strong> {{ $pembeli->pesanan->count() }} Barang</li>
                    <li><strong>Tanggal Pembelian :</strong> {{ $pembeli->created_at->format('d-m-Y / H:i:s') }}</li>
                </ul>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Rak</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalHarga = 0;
                            $allIds = [];
                        @endphp
                        @foreach ($pembeli->pesanan as $index => $pesanan)
                            @php
                                $subtotal = $pesanan->qty * $pesanan->harga;
                                $totalHarga += $subtotal;
                                $allIds[] = $pesanan->id;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pesanan->barang->rak?->nama }}</td>
                                <td>{{ $pesanan->barang->nama }}</td>
                                <td>{{ $pesanan->qty }}</td>
                                <td>Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total Keseluruhan</strong></td>
                            <td><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-center mt-4 d-flex justify-content-center">
                <a href="/keranjang-pesanan" class="btn btn-secondary me-1">Kembali ke Daftar Pembeli</a>
                <button id="checkoutButton" class="btn btn-warning" data-ids="{{ json_encode($allIds) }}"
                    pembeli-id={{ $pembeli->id }}>Checkout</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('checkoutButton').addEventListener('click', async function() {
            const button = this;
            const allIds = JSON.parse(button.dataset.ids);
            const pembeliId = button.getAttribute('pembeli-id');
            const selectedIds = allIds;

            if (selectedIds.length === 0) {
                Swal.fire('Peringatan', 'Tidak ada barang yang dipilih untuk diproses!', 'warning');
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
                Swal.fire('Sukses', 'Barang berhasil diproses!', 'success').then(() => {
                    window.location.href = `/beli-barang/checkout/${pembeliId}`;
                });
            }
        });
    </script>
@endsection
