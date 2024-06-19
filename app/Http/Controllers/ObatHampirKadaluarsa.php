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
        // Dapatkan tanggal sekarang
        $today = date('Y-m-d');

        // Dapatkan tanggal 7 hari ke depan
        $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));

        // Query untuk mendapatkan detail obat dengan tanggal kadaluarsa dalam rentang 7 hari ke depan
        $obat = DetailObat::whereDate('tanggal_kadaluarsa', '>', $today)
                          ->whereDate('tanggal_kadaluarsa', '<=', $sevenDaysLater)
                          ->orderBy('tanggal_kadaluarsa')
                          ->get();

        // Mengembalikan view dengan data obat
        return view('pages.obat_hampir_kadaluarsa.index', compact('obat'));
    }


    /**
     * Show the form for creating a new resource.
     */

}
