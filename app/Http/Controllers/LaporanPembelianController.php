<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPembelianController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.laporan_pembelian.index');
    }


    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric|min:2000',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $laporanPembelian = DB::table('detail_pembelian')
            ->join('obat', 'detail_pembelian.id_obat', '=', 'obat.id_obat')
            ->select('pembelian.*', 'obat.merek_obat')
            ->whereMonth('pembelian.tanggal_pembelian', $bulan)
            ->whereYear('pembelian.tanggal_pembelian', $tahun)
            ->get();
        $total = DB::table('pembelian')
            ->whereMonth('tanggal_pembelian', $bulan)
            ->whereYear('tanggal_pembelian', $tahun)
            ->sum('total_harga');
        return view('pages.laporan_pembelian.index', [
            'laporanPembelian' => $laporanPembelian,
            'total' => $total,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function cetaklaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $laporanPembelian = DB::table('pembelian')
            ->join('obat', 'pembelian.id_obat', '=', 'obat.id')
            ->select('pembelian.*', 'obat.nama_obat')
            ->whereMonth('pembelian.tanggal_pembelian', $bulan)
            ->whereYear('pembelian.tanggal_pembelian', $tahun)
            ->get();
        $total = DB::table('pembelian')
            ->whereMonth('tanggal_pembelian', $bulan)
            ->whereYear('tanggal_pembelian', $tahun)
            ->sum('total_harga');

        $pdf = PDF::loadView('pages.laporan_pembelian.cetak_pembelian', [
            'laporanPembelian' => $laporanPembelian,
            'total' => $total,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return $pdf->stream('laporan_pembelian_' . $bulan . '_' . $tahun . '.pdf');
    }
}
