<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.laporan_penjualan.index');
    }


    public function generate(Request $request)
    {
        // Validasi form input sesuai kebutuhan
        $request->validate([
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric|min:2000',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $laporanPenjualan = DB::table('penjualan')
            ->join('obat', 'penjualan.id_obat', '=', 'obat.id')
            ->select('penjualan.*', 'obat.nama_obat')
            ->whereMonth('penjualan.tanggal_penjualan', $bulan)
            ->whereYear('penjualan.tanggal_penjualan', $tahun)
            ->get();
        $total = DB::table('penjualan')
            ->whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->sum('total_harga');
        return view('pages.laporan_penjualan.index', [
            'laporanPenjualan' => $laporanPenjualan,
            'total' => $total,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }
}
