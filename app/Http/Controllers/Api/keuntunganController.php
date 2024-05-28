<?php

namespace App\Http\Controllers\Api;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuntunganController extends Controller
{
    public function keuntungan($bulan)
    {
        $penjualanObat = Penjualan::whereMonth('tanggal_penjualan', $bulan)
            ->whereYear('tanggal_penjualan', now())
            ->get();

        $pembelianObat = Pembelian::get();
        $keuntunganPerObat = [];
        $totalKeuntungan = 0;

        foreach ($penjualanObat as $penjualan) {
            $totalPenjualan = $penjualan->total_harga;

            $pembelianObatTerkait = $pembelianObat->where('id_obat', $penjualan->id_obat);

            if ($pembelianObatTerkait->count() > 0) {
                $pembelian = $pembelianObatTerkait->first();
                $totalPembelian = $pembelian->harga_satuan * $penjualan->jumlah;
                $keuntungan = $totalPenjualan - $totalPembelian;
                $keuntunganPerObat[] = [
                    'id_obat' => $penjualan->id_obat,
                    'nama_obat' => $penjualan->obat->nama_obat,
                    'total_penjualan' => $totalPenjualan,
                    'total_pembelian' => $totalPembelian,
                    'keuntungan' => $keuntungan,
                ];
            }
        }

        foreach ($keuntunganPerObat as $keuntunganObat) {
            $totalKeuntungan += $keuntunganObat['keuntungan'];
        }

        return response()->json([
            'obat'=>$keuntunganPerObat,

            'total_keuntungan' => $totalKeuntungan,
        ]);
    }



}

