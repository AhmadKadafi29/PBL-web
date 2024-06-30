<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pembelian</title>
</head>

<body>
    <h1>Laporan Pembelian Bulan {{ $bulan }} Tahun {{ $tahun }}</h1> 
    <table border="1">
        <thead>
            <tr>
                <th>Merek Obat</th>
                <th>Jumlah Penjualan</th>
                <th>Total Harga</th>
                <th>Tanggal Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanPenjualan as $penjualan)
                <tr>
                    <td>{{ $penjualan->obat->merek_obat }}</td>
                    <td>{{ $penjualan->jumlah_jual }}</td>
                    <td>{{ $penjualan->jumlah_jual * $penjualan->harga_jual_satuan }}</td>
                    <td>
                        @if ($penjualan->penjualan_resep)
                            {{ $penjualan->penjualan_resep->tanggal_penjualan }}
                        @elseif ($penjualan->penjualan)
                            {{ $penjualan->penjualan->tanggal_penjualan }}
                        @endif
                    </td>      
                </tr>
            @endforeach
        </tbody>
    </table>
    <h2 style="text-align: right">Total Harga: {{ $total }}</h2>
</body>

</html>
