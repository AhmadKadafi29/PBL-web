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
    <div class="toko-info">
        <p><strong>Nama Toko:</strong> Toko Apotek Sarkara</p>
        <p class="alamat"><strong>Alamat:</strong> Jl. JajangSurat</p>
    </div>

    <h2 class="mb-4">Surat Laporan  Pembelian</h2>

    <div class="info">
        <p><strong>Bulan:</strong> {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}</p>
        <p><strong>Tahun:</strong> {{ $tahun }}</p>
    </div>
    <table border="1">
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
            @foreach($laporanPembelian as $pembelian)
                <tr>
                    <td>{{ $pembelian->obat->merek_obat }}</td>
                    <td>{{ $pembelian->pembelian->supplier->nama_supplier }}</td>
                    <td>{{ $pembelian->harga_beli_satuan }}</td>
                    <td>{{ $pembelian->quantity }}</td>
                    <td>{{ $pembelian->harga_beli_satuan * $pembelian->quantity }}</td>
                    <td>{{ $pembelian->pembelian->tanggal_pembelian }}</td>        
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2 style="text-align: right">Total Harga: {{ $total }}</h2>
</body>
</html>
