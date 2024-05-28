<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObatResource;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{

    public function index()
    {
        $data = Obat::with(['kategoriobat'])->get();
        return response()->json([
            "data" => $data
        ]);
    }

    public function hampir_kadaluarsa()
    {
        $obatHampirKadaluarsa = Obat::whereDate('exp_date', '>', now())
        ->with(['kategoriobat'])
            ->whereDate('exp_date', '<=', now()->addDays(7))
            ->get();

            return response()->json([
                "data" => $obatHampirKadaluarsa->map(function ($obat) {
                    return [
                        "id_obat" => $obat->id,
                        "nama_obat" => $obat->nama_obat,
                        "jenis_obat" => $obat->jenis_obat,
                        "kategori_obat_id" => $obat->kategori_obat_id,
                        "kategori_obat" => $obat->kategoriobat->nama_kategori,
                        "stok_obat" => $obat->stok_obat,
                        "harga_obat" => $obat->harga_obat,
                        "tanggal_masuk" => $obat->tanggal_masuk,
                        "exp_date" => $obat->exp_date,
                        "status" => $obat->status,
                    ];
                }),
            ]);
    }
}
