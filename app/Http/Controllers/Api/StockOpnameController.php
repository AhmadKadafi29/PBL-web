<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StokOpname;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    public function index(){
        $data = StokOpname::with(['obat', 'user'])->get();
        return response()->json([
            'data' => $data->map(function($opname) {
                return [
                    'id_opname' => $opname->id,
                    'id_obat' => $opname->id_obat,
                    'id_user' => $opname->id_user,
                    'stok_fisik' => $opname->stok_fisik,
                    'status' => $opname->status,
                    'tanggal_kadaluarsa' => $opname->tanggal_kadaluarsa,
                    'nama_obat' => $opname->obat->nama_obat,
                    'nama_user' => $opname->user->name, // Mengganti 'id_user' dengan 'nama_user'
                ];
            })
        ], 200);
    }

}
