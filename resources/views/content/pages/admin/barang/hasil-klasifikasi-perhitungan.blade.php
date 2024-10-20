@extends('layouts/contentNavbarLayout')

@section('title', 'Hasil Klasifikasi Perhitungan')

@section('content')

    <div class="card mb-4">
        <h5 class="card-header"
            style="background: linear-gradient(135deg, #5A9BD5, #BDC3C7); color: #ffffff; font-weight: bold">Persentase
            Kelas
            ABC</h5>
        <div class="card-body" style="padding: 20px;">
            <ul class="list-unstyled">
                <li style="margin-bottom: 20px;"><strong>Kelas A:</strong>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ $kelasA }}%; background-color: #6CB2EB; font-size: 16px;"
                            aria-valuenow="{{ $kelasA }}" aria-valuemin="0" aria-valuemax="100">{{ $kelasA }} %
                        </div>
                    </div>
                </li>
                <li style="margin-bottom: 20px;"><strong>Kelas B:</strong>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ $kelasB }}%; background-color: #6ECF68; font-size: 16px;"
                            aria-valuenow="{{ $kelasB }}" aria-valuemin="0" aria-valuemax="100">{{ $kelasB }} %
                        </div>
                    </div>
                </li>
                <li><strong>Kelas C:</strong>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ $kelasC }}%; background-color: #FFC107; font-size: 16px;"
                            aria-valuenow="{{ $kelasC }}" aria-valuemin="0" aria-valuemax="100">{{ $kelasC }} %
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header"
            style="background: linear-gradient(135deg, #5A9BD5, #BDC3C7); color: #ffffff; font-weight: bold">Hasil Perolehan
            Persentase</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead>
                    <tr class="bg-light">
                        <th>No</th>
                        <th>Barang</th>
                        <th>Stok Terjual</th>
                        <th>Harga</th>
                        <th>Pendapatan (Stok Terjual x Harga)</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php
                        $totalPendapatan = 0;
                    @endphp
                    @foreach ($dataHitungPersentase as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><i class="fas fa-box-open"></i> {{ $item['nama'] }}</td>
                            <td>{{ number_format($item['stok_terjual'], 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>Rp. {{ number_format($item['pendapatan'], 0, ',', '.') }}</td>
                            <td>{{ $item['persentase'] }} %</td>
                        </tr>
                        @php
                            $totalPendapatan += $item['pendapatan'];
                        @endphp
                    @endforeach
                </tbody>
                <tfoot class="bg-light">
                    <tr>
                        <td colspan="4"></td>
                        <td><strong>Total: Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card mt-4">
        <h5 class="card-header"
            style="background: linear-gradient(135deg, #5A9BD5, #BDC3C7); color: #ffffff; font-weight: bold">Hasil Perolehan
            Nilai Kumulatif & Pembagian Kelas</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th>No</th>
                        <th>Barang</th>
                        <th>Persentase</th>
                        <th>Kumulatif</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @php
                        $index = 1;
                    @endphp

                    @foreach ($kelasAData as $item)
                        <tr class="table-primary">
                            <td>{{ $index++ }}</td>
                            <td><i class="fas fa-star"></i> {{ $item['nama'] }}</td>
                            <td>{{ $item['persentase'] }} %</td>
                            <td>{{ $item['kumulatif'] }} %</td>
                            <td>A</td>
                        </tr>
                    @endforeach

                    @foreach ($kelasBData as $item)
                        <tr class="table-success">
                            <td>{{ $index++ }}</td>
                            <td><i class="fas fa-star-half-alt"></i> {{ $item['nama'] }}</td>
                            <td>{{ $item['persentase'] }} %</td>
                            <td>{{ $item['kumulatif'] }} %</td>
                            <td>B</td>
                        </tr>
                    @endforeach

                    @foreach ($kelasCData as $item)
                        <tr class="table-warning">
                            <td>{{ $index++ }}</td>
                            <td><i class="fas fa-star-half-alt"></i> {{ $item['nama'] }}</td>
                            <td>{{ $item['persentase'] }} %</td>
                            <td>{{ $item['kumulatif'] }} %</td>
                            <td>C</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
