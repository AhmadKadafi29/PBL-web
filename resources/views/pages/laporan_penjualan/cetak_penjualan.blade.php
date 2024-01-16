<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Cetak</title>
</head>

<body>
    <h1>Laporan Penjualan</h1>

    <h2>Laporan Penjualan Per Bulan</h2>
    <p>Bulan: {{ $bulan }}</p>
    <p>Tahun: {{ $tahun }}</p>

    <table border="1">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Obat</th>
                <th>Jumlah Penjualan</th>
                <!-- Tambahkan kolom lain sesuai kebutuhan -->
            </tr>
        </thead>
        <tbody>
            @foreach ($laporanPenjualan as $data)
                <tr>
                    <td>{{ $data->tanggal_penjualan }}</td>
                    <td>{{ $data->nama_obat }}</td>
                    <td>{{ $data->jumlah }}</td>
                    <!-- Tambahkan kolom lain sesuai kebutuhan -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Total Penjualan: {{ $total }}</p>
</body>

</html>
