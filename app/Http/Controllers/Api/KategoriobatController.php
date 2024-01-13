<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori_obat;
use Illuminate\Http\Request;

class KategoriobatController extends Controller
{
    public function index()
    {
        $katobat = Kategori_obat::all();
        return response()->json([
            'obat' => $katobat
        ]);
    }
}
