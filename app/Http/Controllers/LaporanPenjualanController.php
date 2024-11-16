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
        // Validasi tanggal mulai dan tanggal selesai
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
        $total = 0;

        // Query untuk laporan penjualan berdasarkan tanggal penjualan
        $laporanPenjualan = DetailPenjualan::with(['penjualan', 'obat', 'penjualan_resep'])
            ->whereHas('penjualan', function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereBetween('tanggal_penjualan', [$tanggalMulai, $tanggalSelesai]);
            })
            ->orWhereHas('penjualan_resep', function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereBetween('tanggal_penjualan', [$tanggalMulai, $tanggalSelesai]);
            })
            ->get();

        // Menghitung total harga
        foreach ($laporanPenjualan as $data) {
            $total += $data->harga_jual_satuan * $data->jumlah_jual;
        }

        $message = $laporanPenjualan->isEmpty() ? "Tidak ada penjualan untuk periode ini." : null;

        return view('pages.laporan_penjualan.index', [
            'laporanPenjualan' => $laporanPenjualan,
            'total' => $total,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'message' => $message,
        ]);
    }

    public function cetaklaporan(Request $request)
    {
        // Validasi tanggal mulai dan tanggal selesai
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
        $total = 0;

        // Query untuk laporan penjualan berdasarkan tanggal penjualan
        $laporanPenjualan = DetailPenjualan::with(['penjualan', 'obat', 'penjualan_resep'])
            ->whereHas('penjualan', function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereBetween('tanggal_penjualan', [$tanggalMulai, $tanggalSelesai]);
            })
            ->orWhereHas('penjualan_resep', function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereBetween('tanggal_penjualan', [$tanggalMulai, $tanggalSelesai]);
            })
            ->get();

        // Menghitung total harga
        foreach ($laporanPenjualan as $data) {
            $total += $data->harga_jual_satuan * $data->jumlah_jual;
        }

        if ($laporanPenjualan->isEmpty()) {
            return redirect()->back()->with('message', 'Tidak ada penjualan untuk periode ini.');
        }

        // Membuat PDF laporan penjualan
        $pdf = PDF::loadView('pages.laporan_penjualan.cetak_penjualan', [
            'laporanPenjualan' => $laporanPenjualan,
            'total' => $total,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
        ]);

        return $pdf->stream('laporan_penjualan_' . $tanggalMulai . '_to_' . $tanggalSelesai . '.pdf');
    }
}
