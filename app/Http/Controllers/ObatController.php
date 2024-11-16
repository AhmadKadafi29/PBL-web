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
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'kategori_obat_id' => 'required|integer|exists:kategori_obat,id_kategori',
            'merek_obat' => 'required|string|min:5|max:255',
            'dosis' => 'required|string|max:100',
            'kemasan' => 'required|string|max:100',
            'kegunaan' => 'required|string|min:10|max:255',
            'efek_samping' => 'required|string|min:10|max:255',
        ], [
            'kategori_obat_id.required' => 'Kategori obat wajib diisi.',
            'kategori_obat_id.integer' => 'Kategori obat harus berupa angka.',
            'kategori_obat_id.exists' => 'Kategori obat yang dipilih tidak valid.',
            'merek_obat.required' => 'Merek obat wajib diisi.',
            'merek_obat.string' => 'Merek obat harus berupa teks.',
            'merek_obat.min' => 'Merek obat minimal 5 karakter.',
            'merek_obat.max' => 'Merek obat maksimal 255 karakter.',
            'dosis.required' => 'Dosis obat wajib diisi.',
            'dosis.string' => 'Dosis harus berupa teks.',
            'dosis.max' => 'Dosis maksimal 100 karakter.',
            'kemasan.required' => 'Kemasan obat wajib diisi.',
            'kemasan.string' => 'Kemasan harus berupa teks.',
            'kemasan.max' => 'Kemasan maksimal 100 karakter.',
            'kegunaan.required' => 'Kegunaan obat wajib diisi.',
            'kegunaan.string' => 'Kegunaan harus berupa teks.',
            'kegunaan.max' => 'Kegunaan maksimal 500 karakter.',
            'efek_samping.required' => 'Efek samping obat wajib diisi.',
            'efek_samping.string' => 'Efek samping harus berupa teks.',
            'efek_samping.max' => 'Efek samping maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
        $validator = Validator::make($request->all(), [
            'kategori_obat_id' => 'required|integer|exists:kategori_obat,id_kategori',
            'merek_obat' => 'required|string|min:5|max:255',
            'dosis' => 'required|string|max:100',
            'kemasan' => 'required|string|max:100',
            'kegunaan' => 'required|string|min:10|max:255',
            'efek_samping' => 'required|string|min:10|max:255',
        ], [
            'kategori_obat_id.required' => 'Kategori obat wajib diisi.',
            'kategori_obat_id.integer' => 'Kategori obat harus berupa angka.',
            'kategori_obat_id.exists' => 'Kategori obat yang dipilih tidak valid.',
            'merek_obat.required' => 'Merek obat wajib diisi.',
            'merek_obat.string' => 'Merek obat harus berupa teks.',
            'merek_obat.min' => 'Merek obat minimal 5 karakter.',
            'merek_obat.max' => 'Merek obat maksimal 255 karakter.',
            'dosis.required' => 'Dosis obat wajib diisi.',
            'dosis.string' => 'Dosis harus berupa teks.',
            'dosis.max' => 'Dosis maksimal 100 karakter.',
            'kemasan.required' => 'Kemasan obat wajib diisi.',
            'kemasan.string' => 'Kemasan harus berupa teks.',
            'kemasan.max' => 'Kemasan maksimal 100 karakter.',
            'kegunaan.required' => 'Kegunaan obat wajib diisi.',
            'kegunaan.string' => 'Kegunaan harus berupa teks.',
            'kegunaan.max' => 'Kegunaan maksimal 500 karakter.',
            'efek_samping.required' => 'Efek samping obat wajib diisi.',
            'efek_samping.string' => 'Efek samping harus berupa teks.',
            'efek_samping.max' => 'Efek samping maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
