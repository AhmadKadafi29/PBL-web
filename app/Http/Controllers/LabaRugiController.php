<?php

namespace App\Http\Controllers;
use App\Models\DetailPenjualan;
use App\Models\DetailPembelian;
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

        $pendapatan = DetailPenjualan::with(['penjualan', 'obat', 'penjualan_resep'])
        ->whereHas('penjualan_resep', function($query) use($bulan, $tahun) {
            $query->whereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun);
        })
        ->orwhereHas('penjualan', function($query) use($bulan, $tahun) {
            $query->whereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun);
        })->get();

        $totalpendapatan =0;
        foreach($pendapatan as$data){
            $totalpendapatan += $data->harga_jual_satuan * $data->jumlah_jual;
        }

        $totalpengeluaran=0;
        $pengeluaran = DB::table('detail_pembelian')
        ->join('pembelian', 'detail_pembelian.id_pembelian', '=', 'pembelian.id_pembelian')
        ->whereMonth('pembelian.tanggal_pembelian', $bulan)
        ->whereYear('pembelian.tanggal_pembelian', $tahun)
        ->get();
        foreach($pengeluaran as $jumlah){
            $totalpengeluaran +=$jumlah->harga_beli_satuan *$jumlah->quantity;
        }

        $labaRugi =$totalpengeluaran - $totalpendapatan;

        return view('pages.laporan_labarugi.index', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalPendapatan' => $totalpendapatan,
            'totalBiaya' => $totalpengeluaran,
            'labaRugi' => $labaRugi,
        ]);
    }

    public function printLabaRugi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $pendapatan = DetailPenjualan::with(['penjualan', 'obat', 'penjualan_resep'])
        ->whereHas('penjualan_resep', function($query) use($bulan, $tahun) {
            $query->whereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun);
        })
        ->orwhereHas('penjualan', function($query) use($bulan, $tahun) {
            $query->whereMonth('tanggal_penjualan', $bulan)
                ->whereYear('tanggal_penjualan', $tahun);
        })->get();

        $totalpendapatan =0;
        foreach($pendapatan as$data){
            $totalpendapatan += $data->harga_jual_satuan * $data->jumlah_jual;
        }

        $totalpengeluaran=0;
        $pengeluaran = DB::table('detail_pembelian')
        ->join('pembelian', 'detail_pembelian.id_pembelian', '=', 'pembelian.id_pembelian')
        ->whereMonth('pembelian.tanggal_pembelian', $bulan)
        ->whereYear('pembelian.tanggal_pembelian', $tahun)
        ->get();
        foreach($pengeluaran as $jumlah){
            $totalpengeluaran +=$jumlah->harga_beli_satuan *$jumlah->quantity;
        }

        $labaRugi =$totalpengeluaran - $totalpendapatan;

        $pdf = PDF::loadView('pages.laporan_labarugi.print', [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'totalPendapatan' => $totalpendapatan,
            'totalBiaya' => $totalpengeluaran,
            'labaRugi' => $labaRugi,
        ]);

        return $pdf->stream('laporan_labarugi_' . $bulan . '_' . $tahun . '.pdf');
    }
}
