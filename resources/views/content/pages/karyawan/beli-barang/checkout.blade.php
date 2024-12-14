@extends('layouts/contentNavbarLayout')

@section('title', 'Beli Barang')

@section('content')
    <style>
        .swal2-container {
            z-index: 9999;
        }
    </style>
    <div class="container mt-4">
        <h2 class="mb-4">Checkout Barang</h2>
        <div class="container mt-4">
            <form id="checkoutForm" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">Informasi Barang</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $index => $item)
                                            @php
                                                $today = \Carbon\Carbon::now();
                                                $tanggalExpired = \Carbon\Carbon::parse($item->tanggal_expired);
                                                $harga = $today->greaterThanOrEqualTo($tanggalExpired)
                                                    ? $item->harga_jual / 2
                                                    : $item->harga_jual;
                                            @endphp
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>
                                                    <input type="number" name="qty[{{ $item->id }}]"
                                                        class="jumlah-input text-center w-25"
                                                        data-harga="{{ $harga }}" min="1" value="1"
                                                        onchange="updateSubtotal(this)" required>
                                                </td>
                                                <td>Rp. {{ number_format($harga, 0, ',', '.') }}</td>
                                                <td class="subtotal"></td>
                                                <td>
                                                    <form action="{{ route('beli-barang.remove-items', $index) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </td>
                                                <input type="hidden" name="barang_id[{{ $item->id }}]"
                                                    value="{{ $item->id }}">
                                                <input type="hidden" name="harga[{{ $item->id }}]"
                                                    value="{{ $harga }}">
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">Informasi Pengiriman</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                                    <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                    <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                        <option value="" selected disabled>Pilih metode pembayaran</option>
                                        <option value="QRIS">QRIS</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Proses Checkout</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">Ringkasan Pesanan</div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <p>Total Barang</p>
                                    <strong id="totalBarang"></strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <h5>Total Pembayaran</h5>
                                    <strong id="total"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function updateSubtotal(input) {
            const harga = parseFloat(input.dataset.harga);
            const jumlah = parseInt(input.value);
            const subtotal = harga * jumlah;

            const formatRupiah = (angka) => {
                return 'Rp. ' + angka.toLocaleString('id-ID', {
                    minimumFractionDigits: 0
                });
            };

            const tdSubtotal = input.closest('tr').querySelector('.subtotal');
            tdSubtotal.textContent = formatRupiah(subtotal);

            let total = 0;
            let totalBarang = 0;

            document.querySelectorAll('.jumlah-input').forEach((input) => {
                const jumlah = parseInt(input.value);
                const harga = parseFloat(input.dataset.harga);
                const subtotal = harga * jumlah;
                total += subtotal;
                totalBarang += jumlah;
            });

            document.getElementById('total').textContent = formatRupiah(total);

            document.getElementById('totalBarang').textContent = totalBarang;
        }

        document.querySelectorAll('.jumlah-input').forEach((input) => updateSubtotal(input));
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const form = this;
            const formData = new FormData(form);

            fetch('/beli-barang/checkout', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaksi Berhasil',
                            text: data.message,
                            confirmButtonText: 'OK',
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = '/beli-barang';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Terjadi kesalahan saat memproses transaksi.',
                    });
                });
        });
    </script>
@endsection
