<?php

namespace App\Http\Controllers;

use App\Http\Resources\ObatResource;
use App\Models\Kategori_obat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $obat = Obat::all();
        return view('pages.obat.index', compact('obat'));
    }

    public function create()
    {
        $kategori = Kategori_obat::all();
        return view('pages.Obat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required',
            'jenis_obat' => 'required',
            'kategori_obat_id' => 'integer',
            'stok_obat' => 'required',
            'harga_obat' => 'required',
            'tanggal_masuk' => 'required|date',
            'exp_date' => 'required|date',
            'status' => 'string'
        ]);

        Obat::create($request->all());
        return redirect()->route('Obat.index')->with('success', 'New Obat successfully');
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        $kategori = Kategori_obat::all();
        return view('pages.obat.show', compact('obat', 'kategori'));
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        $kategori = Kategori_obat::all();
        return view('pages.obat.edit', compact('obat', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat' => 'required',
            'jenis_obat' => 'required',
            'kategori_obat_id' => 'integer',
            'stok_obat' => 'required',
            'harga_obat' => 'required',
            'status_obat' => 'integer'

        ]);
        $obat = Obat::find($id);
        $obat->update($request->all());

        return redirect()->route('Obat.index')->with('success', 'Obat berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $obat = Obat::find($id);
        $obat->delete();
        return redirect()->route('Obat.index')->with('success', 'Obat berhasil dihapus');
    }
}
