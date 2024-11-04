<?php

namespace App\Http\Controllers;

use App\Http\Resources\ObatResource;
use App\Models\DetailObat;
use App\Models\detailsatuan;
use App\Models\Kategoriobat;
use App\Models\Obat;
use App\Models\satuan;
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
        $kategori = Kategoriobat::all();
        return view('pages.obat.create', compact('kategori', 'kodeobat'));
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
        $itemObat = DetailObat::with('obat.detailsatuan')->where('id_obat', $id_obat)->get();


        return view('pages.obat.show', compact('itemObat'));
    }


    public function edit($id_obat)

    {
        $obat = Obat::findOrFail($id_obat);
        $kategori = Kategoriobat::all();
        return view('pages.obat.edit', compact('obat', 'kategori'));
    }

    public function update(Request $request, $id_obat)
    {
        $request->validate([
            'kategori_obat_id' => 'integer',
            'merek_obat' => 'required',
            'dosis' => 'required',
            'kemasan' => 'required',
            'kegunaan' => 'required',
            'efek_samping' => 'required',

        ]);
        $obat = Obat::findOrFail($id_obat);
        $obat->update($request->all());

        return redirect()->route('Obat.index')->with('success', 'Obat berhasil diubah');
    }


    public function create_detailsatuan($id)
    {
        $id_obat = $id;
        $satuan = satuan::get();
        return view('pages.obat.create_detailsatuan', compact('id_obat', 'satuan'));
    }

    public function store_detailsatuan(Request $request, $id)
    {
        //dd($request);
        $id_obat = $id;
        $nama_obat = Obat::find($id_obat);
        $satuan_terkecil = $request->input('satuan_terkecil');
        $satuan_konversi_terkecil = 1;

        detailsatuan::create([
            'id_obat' => $id_obat,
            'id_satuan' => $satuan_terkecil,
            'satuan_konversi' => 1
        ]);

        $satuan_ke1 = $request->input('nama_satuan');
        $konversi = $request->input('konversi');
        if ($satuan_ke1) {
            for ($i = 0; $i < count($satuan_ke1); $i++) {
                detailsatuan::create([
                    'id_obat' => $id_obat,
                    'id_satuan' => $satuan_ke1[$i],
                    'satuan_konversi' => $konversi[$i]
                ]);
            }
        }

        return redirect()->route('Obat.index')->with('success', 'Detail detail satuan ' . $nama_obat->merek_obat . ' berhasil diubah.');
    }
}
