@extends('layouts/contentNavbarLayout')

@section('title', 'Hasil Klasifikasi Perhitungan')

@section('content')
    <style>
        .kelas-a {
            background-color: #D1E7DD;
        }

        .kelas-b {
            background-color: #FFF3CD;
        }

        .kelas-c {
            background-color: #F8D7DA;
        }
    </style>
    <div class="card">
        <h5 class="card-header"
            style="background: linear-gradient(135deg, #5A9BD5, #BDC3C7); color: #ffffff; font-weight: bold">Hasil Data
            Barang Perhitungan Metode ABC</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th>Barang</th>
                        <th>Stok Terjual (Normal)</th>
                        <th>Harga (Normal)</th>
                        <th>Stok Terjual (Obral)</th>
                        <th>Harga (Obral)</th>
                        <th>Pendapatan</th>
                        <th>Persentase</th>
                        <th>Kumulatif</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php
                        $lastKelas = null;
                        $lastKelasStyle = '';
                    @endphp
                    @foreach ($dataBarang as $index => $item)
                        @php
                            if ($item['kumulatif'] <= 75) {
                                $kelas = 'A';
                                $kelasStyle = 'kelas-a';
                            } elseif ($item['kumulatif'] > 75 && $item['kumulatif'] <= 90) {
                                $kelas = 'B';
                                $kelasStyle = 'kelas-b';
                            } else {
                                $kelas = 'C';
                                $kelasStyle = 'kelas-c';
                            }
                        @endphp
                        <tr class="{{ $kelasStyle }}">
                            <td><i class="fas fa-box-open"></i> {{ $item['nama'] }}</td>
                            <td>{{ number_format($item['stok_terjual_normal'], 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item['harga_normal'], 0, ',', '.') }}</td>
                            <td>{{ number_format($item['stok_terjual_obral'], 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item['harga_obral'], 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item['pendapatan'], 0, ',', '.') }}</td>
                            <td>{{ $item['persentase'] }} %</td>
                            <td>{{ $item['kumulatif'] }} %</td>
                            <td>
                                @if ($lastKelas !== $kelas)
                                    {{ $kelas }}
                                    @php
                                        $lastKelas = $kelas;
                                    @endphp
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="5"></td>
                        <td><strong>Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
