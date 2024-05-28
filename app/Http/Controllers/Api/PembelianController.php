<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pembelian::with(['obat', 'supplier'])->get();
        return response()->json([
            "data" => $data->map(function ($pembelian) {
                return [
                    "id_pembelian" => $pembelian->id,
                    "id_obat" => $pembelian->id_obat,
                    "id_supplier" => $pembelian->id_supplier,
                    "nofaktur" => $pembelian->nofaktur,
                    "harga_satuan" => $pembelian->harga_satuan,
                    "quantity" => $pembelian->quantity,
                    "total_harga" => $pembelian->total_harga,
                    "tanggal_pembelian" => $pembelian->tanggal_pembelian,
                    "status_pembayaran" => $pembelian->status_pembayaran,
                    "nama_obat" => $pembelian->obat->nama_obat,
                     "nama_supplier" => $pembelian->supplier->nama_supplier,                ];
            }),
        ]);
    }


    public function getTotalPembelian(){
        $data = Pembelian::sum('total_harga');
        return response()->json([
            'data' => $data
        ]);
    }

    public function getLapPembelian($id, $tahun)
{
    $dataPembelian = Pembelian::with(['obat'])
        ->whereMonth('tanggal_pembelian', $id)
        ->whereYear('tanggal_pembelian', $tahun)
        ->get();
    return response()->json([
        'data' => $dataPembelian->map(function($pembelian){
            return[
                "id_pembelian" => $pembelian->id,
                "id_obat" => $pembelian->id_obat,
                "id_supplier" => $pembelian->id_supplier,
                "nofaktur" => $pembelian->nofaktur,
                "harga_satuan" => $pembelian->harga_satuan,
                "quantity" => $pembelian->quantity,
                "total_harga" => $pembelian->total_harga,
                "tanggal_pembelian" => $pembelian->tanggal_pembelian,
                "status_pembayaran" => $pembelian->status_pembayaran,
                "nama_obat" => $pembelian->obat->nama_obat,
                 "nama_supplier" => $pembelian->supplier->nama_supplier,

            ];
        })
    ]);
}
public function TotalPembelian($id, $tahun)
    {
        $totalpembelian = 0;
        $dataPenjualan = Pembelian::whereMonth('tanggal_pembelian', $id)
            ->whereYear('tanggal_pembelian', $tahun)
            ->get();

        foreach ($dataPenjualan as $item) {
            $totalpembelian += $item->total_harga;
        }

        return response()->json([
            'total_pembelian' => $totalpembelian,
        ]);
    }



}
