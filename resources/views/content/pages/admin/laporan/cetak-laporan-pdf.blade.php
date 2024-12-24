<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f9f9f9;
            line-height: 1.6;
        }

        .container {
            margin: 20px auto;
            max-width: 900px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #2c3e50;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header button {
            background-color: #2c3e50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .header button:hover {
            background-color: #34495e;
        }

        .total-summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #ecf0f1;
            border-left: 4px solid #2c3e50;
            font-size: 16px;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Laporan Hari ini</h1>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Terjual</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <h6>{{ $item->nama }}</h6>
                            <small>Ukuran: {{ $item->ukuran }}, Warna: {{ $item->warna }}</small>
                        </td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->total_qty }}</td>
                        <td>Rp {{ number_format($item->total_qty * $item->harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-summary">
            <strong>Total Barang Terjual:</strong> {{ $pesanan->sum('total_qty') }} <br>
            <strong>Total Pendapatan:</strong> Rp
            {{ number_format($pesanan->sum(fn($item) => $item->total_qty * $item->harga), 0, ',', '.') }}
        </div>

        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        function printPage() {
            window.print();
        }
    </script>
</body>

</html>
