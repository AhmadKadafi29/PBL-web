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
            'tanggal_mulai' => 'required|date|before_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai|before_or_equal:today',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_mulai.before_or_equal' => 'Tanggal mulai tidak boleh lebih dari hari ini.',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
            'tanggal_selesai.before_or_equal' => 'Tanggal selesai tidak boleh lebih dari hari ini.',
        ]);

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $totalharga = 0;

        $laporanPembelian = DB::table('detail_pembelian')
            ->join('obat', 'detail_pembelian.id_obat', '=', 'obat.id_obat')
            ->join('pembelian', 'detail_pembelian.id_pembelian', '=', 'pembelian.id_pembelian')
            ->select(
                'detail_pembelian.*',
                'obat.merek_obat',
                'pembelian.tanggal_pembelian',
                'pembelian.id_supplier'
            )
            ->whereBetween('pembelian.tanggal_pembelian', [$tanggalMulai, $tanggalSelesai])
            ->get();

        foreach ($laporanPembelian as $item) {
            $totalharga += $item->harga_beli_satuan * $item->quantity;
        }

        $message = $laporanPembelian->isEmpty() ? "Tidak ada pembelian untuk periode ini." : null;

        return view('pages.laporan_pembelian.index', [
            'laporanPembelian' => $laporanPembelian,
            'total' => $totalharga,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'message' => $message,
        ]);
    }

    public function cetaklaporan(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date|before_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai|before_or_equal:today',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_mulai.before_or_equal' => 'Tanggal mulai tidak boleh lebih dari hari ini.',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.',
            'tanggal_selesai.before_or_equal' => 'Tanggal selesai tidak boleh lebih dari hari ini.',
        ]);

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        $totalharga = 0;

        $laporanPembelian = DetailPembelian::with(['obat', 'pembelian'])
            ->whereHas('pembelian', function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereBetween('tanggal_pembelian', [$tanggalMulai, $tanggalSelesai]);
            })
            ->get();

        foreach ($laporanPembelian as $item) {
            $totalharga += $item->harga_beli_satuan * $item->quantity;
        }

        if ($laporanPembelian->isEmpty()) {
            return redirect()->back()->with('message', 'Tidak ada pembelian untuk periode ini.');
        }

        $pdf = PDF::loadView('pages.laporan_pembelian.cetak_pembelian', [
            'laporanPembelian' => $laporanPembelian,
            'total' => $totalharga,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
        ]);

        return $pdf->stream('laporan_pembelian_' . $tanggalMulai . 'to' . $tanggalSelesai . '.pdf');
    }
}
