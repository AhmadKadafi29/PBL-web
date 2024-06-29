<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
use Illuminate\Http\Request;

class cobaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $namaObat = 'komik';
        //$jumlah = $request->jumlah;

        $obat = DetailObat::whereHas('obat', function ($query) use ($namaObat) {
            $query->where('merek_obat', $namaObat);
        })
            ->where('stok_obat', '>', 0)
            ->where('tanggal_kadaluarsa', '>', now())
            ->orderBy('tanggal_kadaluarsa')
            ->sum('stok_obat');
        return view('pages.penjualan.nota', compact('obat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
