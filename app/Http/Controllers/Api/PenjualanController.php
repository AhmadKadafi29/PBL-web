<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(){
        $data = Penjualan::with(['obat'])->get();
        return response()->json([
            "data" => $data->map(function ($penjualan) {
                return [
                    "id_penjualan"=>$penjualan->id,
                    "id_obat" => $penjualan->id_obat,
                    "harga_obat" => $penjualan->harga_obat,
                    "jumlah" => $penjualan->jumlah,
                    "total_harga" => $penjualan->total_harga,
                    "tanggal_penjualan" => $penjualan->tanggal_penjualan,
                    "nama_obat" => $penjualan->obat->nama_obat             ];
            }),
        ]);
    }

    public function getTotalPenjualan($id)
    {
        $totalPenjualan = 0;
        $dataPenjualan = Penjualan::whereMonth('tanggal_penjualan', $id)
            ->whereYear('tanggal_penjualan',now())
            ->get();

        foreach ($dataPenjualan as $item) {
            $totalPenjualan += $item->total_harga;
        }

        return response()->json([
            'total_penjualan' => $totalPenjualan,
        ]);
    }



    public function penjualanTeratas($id)
    {
    $penjualanTeratas = Penjualan::whereMonth('tanggal_penjualan', $id)
        ->whereYear('tanggal_penjualan', now())
        ->select('id_obat', DB::raw('SUM(jumlah) as total_terjual'),)
        ->groupBy('id_obat')
        ->orderByDesc('total_terjual')
        ->take(5)
        ->get();

    $details = [];
    foreach ($penjualanTeratas as $penjualan) {
        $details[] = [
            // 'id_obat' => $penjualan->id_obat,
            'nama_obat' => $penjualan->obat->nama_obat,
            'total_penjualan' => $penjualan->total_terjual,

        ];
    }
    return response()->json([
        'penjualan_teratas' => $details,
    ]);
}


public function statistik($id)
{
    $data = Penjualan::select(
            DB::raw('SUM(total_harga) as total_harga, DAY(tanggal_penjualan) as day, id_obat, SUM(jumlah) as total_jumlah')
        )
        ->whereMonth('tanggal_penjualan', $id)
        ->whereYear('tanggal_penjualan', now())
        ->groupBy(DB::raw('DAY(tanggal_penjualan), id_obat'))
        ->get();

    $datapembelian = Pembelian::get();

    foreach ($data as $penjualan) {
        $totalpenjualan = $penjualan->total_harga;

        $pembelianobatterkait = $datapembelian->where('id_obat', $penjualan->id_obat);

        if ($pembelianobatterkait->count() > 0) {
            $pembelian = $pembelianobatterkait->first();
            $totalpembelian = $pembelian->harga_satuan * $penjualan->total_jumlah;
            $keuntungan = $totalpenjualan - $totalpembelian;
            $penjualan->keuntungan = $keuntungan;
        } else {
            $penjualan->keuntungan = null;
        }
    }

    return response()->json([
        'data' => $data,
    ]);
}

public function getLapPenjualan($id, $tahun)
{
    $totalPenjualan = 0;
    $dataPenjualan = Penjualan::with(['obat'])
        ->whereMonth('tanggal_penjualan', $id)
        ->whereYear('tanggal_penjualan', $tahun)
        ->get();

    $formattedData = $dataPenjualan->map(function ($penjualan) use (&$totalPenjualan) {
        $totalPenjualan += $penjualan->total_harga;

        return [
            'id_penjualan' => $penjualan->id,
            'id_obat' => $penjualan->id_obat,
            'harga_obat' => $penjualan->harga_obat,
            'jumlah' => $penjualan->jumlah,
            'total_harga' => $penjualan->total_harga,
            'tanggal_penjualan' => $penjualan->tanggal_penjualan,
            'nama_obat' => $penjualan->obat->nama_obat, // Akses nama obat
        ];
    });

    return response()->json([
        'total_penjualan' => $totalPenjualan, // Pastikan total penjualan dimasukkan ke dalam respons
        'data' => $formattedData,
    ]);
}
public function TotalPenjualan($id, $tahun)
    {
        $totalPenjualan = 0;
        $dataPenjualan = Penjualan::whereMonth('tanggal_penjualan', $id)
            ->whereYear('tanggal_penjualan', $tahun)
            ->get();

        foreach ($dataPenjualan as $item) {
            $totalPenjualan += $item->total_harga;
        }

        return response()->json([
            'total_penjualan' => $totalPenjualan,
        ]);
    }
}
