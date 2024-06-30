<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
use Illuminate\Http\Request;

class ObatHampirKadaluarsa extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = date('Y-m-d');
        $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));
        $obat = DetailObat::whereDate('tanggal_kadaluarsa', '>', $today)
                          ->whereDate('tanggal_kadaluarsa', '<=', $sevenDaysLater)
                          ->orderBy('tanggal_kadaluarsa')
                          ->paginate(10);
        return view('pages.obat_hampir_kadaluarsa.index', compact('obat'));
    }
}
