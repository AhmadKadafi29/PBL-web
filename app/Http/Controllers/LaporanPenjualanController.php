<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanController extends Controller
{
    public function index()
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
        $laporanPenjualan = DetailPenjualan::with(['penjualan', 'obat', 'penjualan_resep'])
        ->whereHas('penjualan_resep', function($query) use($bulan, $tahun) {
            $query->whereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun);
        })
        ->orwhereHas('penjualan', function($query) use($bulan, $tahun) {
            $query->whereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun);
        })->get();

        $total =0;
        foreach($laporanPenjualan as$data){
            $total += $data->harga_jual_satuan * $data->jumlah_jual;
        }  
        return view('pages.laporan_penjualan.index', [
            'laporanPenjualan' => $laporanPenjualan,
            'total' => $total,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function cetaklaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $laporanPenjualan = DetailPenjualan::with(['penjualan', 'obat', 'penjualan_resep'])
        ->whereHas('penjualan_resep', function($query) use($bulan, $tahun) {
            $query->whereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun);
        })
        ->orwhereHas('penjualan', function($query) use($bulan, $tahun) {
            $query->whereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun);
        })->get();

        $total =0;
        foreach($laporanPenjualan as$data){
            $total += $data->harga_jual_satuan * $data->jumlah_jual;
        }
        $pdf = PDF::loadView('pages.laporan_penjualan.cetak_penjualan', [
            'laporanPenjualan' => $laporanPenjualan,
            'total' => $total,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return $pdf->stream('laporan_penjualan_' . $bulan . '_' . $tahun . '.pdf');
    }
}
