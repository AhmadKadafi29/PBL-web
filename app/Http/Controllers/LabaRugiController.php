<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class LabaRugiController extends Controller
{
    public function index()
    {
        return view('pages.laporan_labarugi.index');
    }

    public function generateLabaRugi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $totalPendapatan = DB::table('penjualan')
            ->whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->sum('total_harga');

        $totalBiaya = DB::table('pembelian')
            ->whereMonth('tanggal_pembelian', $bulan)
            ->whereYear('tanggal_pembelian', $tahun)
            ->sum('total_harga');

        $labaRugi = $totalPendapatan - $totalBiaya;

        return view('pages.laporan_labarugi.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalPendapatan' => $totalPendapatan,
            'totalBiaya' => $totalBiaya,
            'labaRugi' => $labaRugi,
        ]);
    }

    public function printLabaRugi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $totalPendapatan = DB::table('penjualan')
            ->whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', $tahun)
            ->sum('total_harga');

        $totalBiaya = DB::table('pembelian')
            ->whereMonth('tanggal_pembelian', $bulan)
            ->whereYear('tanggal_pembelian', $tahun)
            ->sum('total_harga');

        $labaRugi = $totalPendapatan - $totalBiaya;

        $pdf = PDF::loadView('pages.laporan_labarugi.print', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalPendapatan' => $totalPendapatan,
            'totalBiaya' => $totalBiaya,
            'labaRugi' => $labaRugi,
        ]);

        return $pdf->stream('laporan_labarugi_' . $bulan . '_' . $tahun . '.pdf');
    }
}
