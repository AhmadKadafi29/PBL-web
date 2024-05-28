<?php

namespace App\Http\Controllers;

use App\Http\Resources\ObatResource;
use App\Models\DetailObat;
use App\Models\Kategori_obat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $obat  = Obat::when($request->input('nama_obat'), function ($query, $nama_obat) {
            return $query->where('nama_obat', 'like', '%' . $nama_obat . '%');
        })
            ->select('*')
            ->paginate(10);
        return view('pages.obat.index', compact('obat'));
    }

    public function create()

    {
        $lastObat = Obat::orderBy('id_obat', 'desc')->first();
        $nextCodeNumber = $lastObat ? (int)substr($lastObat->kode_obat, 2) + 1 : 1;
        $formattedCodeNumber = str_pad($nextCodeNumber, 3, '0', STR_PAD_LEFT);
        $kodeobat = 'OB' . $formattedCodeNumber;
        $kategori = Kategori_obat::all();
        return view('pages.Obat.create', compact('kategori', 'kodeobat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_obat_id' => 'integer',
            'nama_brand_obat' => 'required',
            'jenis_obat' => 'required',
            'satuan_obat' => 'required',
            'harga_jual_obat' => 'required',
            'status' => 'string'
        ]);
        $lastObat = DB::table('obat')->orderBy('id_obat', 'desc')->first();
        $nextCodeNumber = $lastObat ? substr($lastObat->kode_obat, 2) + 1 : 1;
        $formattedCodeNumber = str_pad($nextCodeNumber, 3, '0', STR_PAD_LEFT);
        $newObatCode = 'OB' . $formattedCodeNumber;
        $request->merge(['kode_obat' => $newObatCode]);

        Obat::create($request->all());
        return redirect()->route('Obat.index')->with('success', 'Obat Baru berhasil ditambah');
    }

    public function show($id_obat)
    {
        $obat = Obat::findOrFail($id_obat);
        $itemObat = DetailObat::where('id_obat', $id_obat)->get();

        return view('pages.obat.show', compact('obat', 'itemObat'));
    }


    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('pages.obat.edit', compact('obat', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_obat_id' => 'integer',
            'nama_obat' => 'required',
            'jenis_obat' => 'required',
            'satuan_obat' => 'required',
            'harga_jual_obat' => 'required',
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
