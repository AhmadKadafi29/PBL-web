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
        $obat  = Obat::when($request->input('merek_obat'), function ($query, $merek_obat) {
            return $query->where('merek_obat', 'like', '%' . $merek_obat . '%');
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
            'kode_obat'=>'required',
            'kategori_obat_id' => 'integer',
            'merek_obat' => 'required',
            'dosis' => 'required',
            'kemasan' => 'required',
            'kegunaan' => 'required',
            'efek_samping' => 'required',

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
        $kategori=Kategori_obat::all();
        $obat = Obat::findOrFail($id);
        return view('pages.obat.edit', compact('obat', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_obat'=>'required',
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
