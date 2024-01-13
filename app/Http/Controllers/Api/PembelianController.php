<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $pembelian = Pembelian::all();
        return response()->json([
            'message' => 'data laporan pembelian',
            'data' => $pembelian
        ]);
    }
}
