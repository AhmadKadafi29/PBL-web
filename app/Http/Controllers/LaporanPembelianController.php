<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
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
        $totalharga=0;



        $laporanPembelian = DB::table('detail_pembelian')
        ->join('obat', 'detail_pembelian.id_obat', '=', 'obat.id_obat')
        ->join('pembelian', 'detail_pembelian.id_pembelian', '=', 'pembelian.id_pembelian')
        ->select(
            'detail_pembelian.*',
            'obat.merek_obat',
            'pembelian.tanggal_pembelian',
            'pembelian.id_supplier'
        )
        ->whereMonth('pembelian.tanggal_pembelian', $bulan)
        ->whereYear('pembelian.tanggal_pembelian', $tahun)
        ->get();
        $total = DB::table('detail_pembelian')
        ->join('pembelian', 'detail_pembelian.id_pembelian', '=', 'pembelian.id_pembelian')
        ->whereMonth('pembelian.tanggal_pembelian', $bulan)
        ->whereYear('pembelian.tanggal_pembelian', $tahun)
        ->get();
        foreach($total as $jumlah){
            $totalharga +=$jumlah->harga_beli_satuan *$jumlah->quantity;
        }
        return view('pages.laporan_pembelian.index', [
            'laporanPembelian' => $laporanPembelian,
            'total' => $totalharga,
            'data'=>$total,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function cetaklaporan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $totalharga=0;

        $laporanPembelian = DetailPembelian::with(['obat', 'pembelian'])
        ->whereHas('pembelian', function ($query) use ($bulan, $tahun) {
        $query->whereMonth('tanggal_pembelian', $bulan)
              ->whereYear('tanggal_pembelian', $tahun);
            })
         ->get();
        $total = DB::table('detail_pembelian')
        ->join('pembelian', 'detail_pembelian.id_pembelian', '=', 'pembelian.id_pembelian')
        ->whereMonth('pembelian.tanggal_pembelian', $bulan)
        ->whereYear('pembelian.tanggal_pembelian', $tahun)
        ->get();
        foreach($total as $jumlah){
            $totalharga +=$jumlah->harga_beli_satuan *$jumlah->quantity;
        }

        $pdf = PDF::loadView('pages.laporan_pembelian.cetak_pembelian', [
            'laporanPembelian' => $laporanPembelian,
            'total' => $totalharga,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);

        return $pdf->stream('laporan_pembelian_' . $bulan . '_' . $tahun . '.pdf');

         }
}
