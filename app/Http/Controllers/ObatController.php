<?php

namespace App\Http\Controllers;

use App\Http\Resources\ObatResource;
use App\Models\DetailObat;
use App\Models\Kategoriobat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $obat  = Obat::when($request->input('merek_obat'), function ($query, $merek_obat) {
            return $query->where('merek_obat', 'like', '%' . $merek_obat . '%');
        })
            ->select('*')
            ->paginate(10);
        return view('pages.obat.index', compact('obat'));
    }

    public function create()

    {
        $kategori = Kategoriobat::all();
        return view('pages.Obat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_obat_id' => 'integer',
            'merek_obat' => 'required',
            'dosis' => 'required',
            'kemasan' => 'required',
            'kegunaan' => 'required',
            'efek_samping' => 'required',

        ]);

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
        $kategori = Kategoriobat::all();
        $obat = Obat::findOrFail($id);
        $kategori = Kategoriobat::all();
        return view('pages.obat.edit', compact('obat', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_obat_id' => 'integer',
            'merek_obat' => 'required',
            'dosis' => 'required',
            'kemasan' => 'required',
            'kegunaan' => 'required',
            'efek_samping' => 'required',

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
