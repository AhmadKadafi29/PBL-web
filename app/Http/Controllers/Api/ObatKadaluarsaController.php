<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ObatKadaluarsa;
use Illuminate\Http\Request;

class ObatKadaluarsaController extends Controller
{
    public function index(){
        $data = ObatKadaluarsa::with(['obat'])->get();
        return response()->json([
            "data" => $data->map(function($obat){
                return [
                    "id_obat_kadaluarsa" => $obat->id,
                    "id_obat"=>$obat->id_obat,
                    "nama_obat"=>$obat->obat->nama_obat,
                    "tanggal_kadaluarsa"=>$obat->tanggal_kadaluarsa
                ];

            })
        ]);
    }
}

// return response()->json([
//     "data" => $data->map(function ($pembelian) {
//         return [
//             "id_pembelian" => $pembelian->id_pembelian,
//             "id_obat" => $pembelian->id_obat,
//             "id_supplier" => $pembelian->id_supplier,
//             "nofaktur" => $pembelian->nofaktur,
//             "harga_satuan" => $pembelian->harga_satuan,
//             "quantity" => $pembelian->quantity,
//             "total_harga" => $pembelian->total_harga,
//             "tanggal_pembelian" => $pembelian->tanggal_pembelian,
//             "status_pembayaran" => $pembelian->status_pembayaran,
//             "nama_obat" => $pembelian->obat->nama_obat,
//              "nama_supplier" => $pembelian->supplier->nama_supplier,                ];
//     }),
// ]);
