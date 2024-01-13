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
        $obat = Obat::all();
        return response()->json([
            'obat' => $obat
        ]);
    }

    public function kadaluarsa()
    {
        $obatsKadaluarsa = Obat::where('tanggal_kadaluarsa', '<', now())->get();

        foreach ($obatsKadaluarsa as $obatKadaluarsa) {
            $obatKadaluarsa->kadaluarsas()->create([
                'tanggal_kadaluarsa' => $obatKadaluarsa->tanggal_kadaluarsa,
            ]);
        }

        return response()->json(['message' => 'Obat kadaluarsa dipindahkan.']);
    }
}
