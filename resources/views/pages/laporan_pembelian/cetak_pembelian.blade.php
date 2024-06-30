<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pembelian</title>
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
            margin-bottom: 40px;
        }

        .info {
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .toko-info {
            margin-top: 20px;
            margin-bottom: 20px
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .total span {
            font-weight: lighter;
            font-family: Verdana;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="toko-info">
            <p><strong>Nama Toko:</strong> Toko Apotek Sarkara</p>
            <p class="alamat"><strong>Alamat:</strong> Jl. JajangSurat</p>
        </div>

        <h2>Laporan Pembelian</h2>

        <div class="info">
            <p><strong>Bulan:</strong> {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</p>
            <p><strong>Tahun:</strong> {{ $tahun }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Merek Obat</th>
                    <th>Nama Supplier</th>
                    <th>Harga Beli Satuan</th>
                    <th>Quantity</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembelian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanPembelian as $pembelian)
                    <tr>
                        <td>{{ $pembelian->obat->merek_obat }}</td>
                        <td>{{ $pembelian->pembelian->supplier->nama_supplier }}</td>
                        <td>{{ number_format($pembelian->harga_beli_satuan, 0, ',', '.') }}</td>
                        <td>{{ $pembelian->quantity }}</td>
                        <td>{{ number_format($pembelian->harga_beli_satuan * $pembelian->quantity, 0, ',', '.') }}</td>
                        <td>{{ $pembelian->pembelian->tanggal_pembelian }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="total"><span>Total Harga: </span>{{ number_format($total, 0, ',', '.') }}</h4>

        <div class="tanggal">
            <p>Dokumen ini dibuat pada {{ date('d F Y H:i:s') }}</p>
        </div>
    </div>

</body>

</html>
