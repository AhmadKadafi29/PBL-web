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

        // Dapatkan tanggal 7 hari dari sekarang
        $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));

        // Query untuk mendapatkan detail obat dengan tanggal kadaluarsa lebih dari 7 hari dari tanggal sekarang
        $obat = DetailObat::whereDate('tanggal_kadaluarsa', '>', $sevenDaysLater)->get();

        // Mengembalikan view dengan data obat
        return view('pages.obat_hampir_kadaluarsa.index', compact('obat'));
    }

    /**
     * Show the form for creating a new resource.
     */

}
