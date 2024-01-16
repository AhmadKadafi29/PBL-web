<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Laporan Laba Rugi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2 {
            text-align: center;
        }

        .info {
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .total {
            margin-top: 20px;
            text-align: left;
        }

        .toko-info {
            margin-top: 20px;
        }

        .toko-info p {
            margin: 0;
        }

        .alamat {
            font-size: 14px;
            margin-top: 10px;
        }

        .tanggal {
            text-align: right;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="toko-info">
            <p><strong>Nama Toko:</strong> Toko Apotek Sarkara</p>
            <p class="alamat"><strong>Alamat:</strong> Jl. JajangSurat</p>
        </div>

        <h2 class="mb-4">Surat Laporan Laba Rugi</h2>

        <div class="info">
            <p><strong>Bulan:</strong> {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</p>
            <p><strong>Tahun:</strong> {{ $tahun }}</p>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Total Pendapatan</th>
                    <th>Total Biaya</th>
                    <th>Laba Rugi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rp. {{ $totalPendapatan }}</td>
                    <td>Rp. {{ $totalBiaya }}</td>
                    <td>Rp. {{ $labaRugi }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <p><strong>Total Pendapatan:</strong> Rp. {{ $totalPendapatan }}</p>
            <p><strong>Total Biaya:</strong> Rp. {{ $totalBiaya }}</p>
            <p><strong>Laba Rugi:</strong> Rp. {{ $labaRugi }}</p>
        </div>

        <div class="tanggal">
            <p>Dokumen ini dibuat pada {{ date('d F Y H:i:s') }}</p>
        </div>
    </div>
</body>

</html>
