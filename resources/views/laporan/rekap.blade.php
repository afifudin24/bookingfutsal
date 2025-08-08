@php
    use Carbon\Carbon;
    use Carbon\CarbonImmutable;
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Laporan</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            /* background-color:rgb(4, 41, 45); */

            font-weight: bold;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Footer Table */
        tfoot {
            /* background-color: #f4f4f4; */
            font-weight: bold;
        }

        tfoot th {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Rekap Laporan</h2>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Konfirmasi</th>
                    <th>Cara Bayar</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <!-- gunakan carbon -->
                        <td>{{ Carbon::parse($item->tanggal_konfirmasi)->translatedFormat('d F Y') }}</td>
                        <td>{{ $item->cara_bayar }}</td>
                        <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Keseluruhan:</th>
                    <th>Rp {{ number_format($laporan->sum('total_harga'), 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>