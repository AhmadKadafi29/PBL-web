<?php

namespace App\Http\Controllers;

use App\Http\Resources\ObatResource;
use App\Models\DetailObat;
use App\Models\Detailsatuan;
use App\Models\Kategoriobat;
use App\Models\Obat;
use App\Models\Satuan;
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
        // Validasi data
        $validator = Validator::make($request->all(), [
            'kategori_obat_id' => 'required|integer|exists:kategori_obat,id_kategori',
            'nama_obat' => 'required|string|max:255',
            'merek_obat' => 'required|string|min:5|max:255',
            'deskripsi_obat' => 'nullable|string',
            'efek_samping' => 'nullable|string|min:10|max:255',
            'satuan_terbesar' => 'required|string',
            'satuan_terkecil_1' => 'required|string',
            'jumlah_satuan_terkecil_1' => 'required|integer|min:1',
        ]);

        // dd($validator);

        // Validasi untuk input dinamis (satuan terkecil 2 hingga 5)
        for ($i = 2; $i <= 5; $i++) {
            $validator->after(function ($validator) use ($request, $i) {
                if ($request->has("satuan_terkecil_{$i}") && $request->has("jumlah_satuan_terkecil_{$i}")) {
                    $validator->sometimes("satuan_terkecil_{$i}", 'nullable|string', function ($input) use ($i) {
                        return !empty($input->{"satuan_terkecil_{$i}"});
                    });
                    $validator->sometimes("jumlah_satuan_terkecil_{$i}", 'nullable|integer|min:1', function ($input) use ($i) {
                        return !empty($input->{"jumlah_satuan_terkecil_{$i}"});
                    });
                }
            });
        }

        // dd($request->all());

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data obat
        $obat = Obat::create([
            'kategori_obat_id' => $request->kategori_obat_id,
            'merek_obat' => $request->merek_obat,
            'nama_obat' => $request->nama_obat,
            'deskripsi_obat' => $request->deskripsi_obat,
            'efek_samping' => $request->efek_samping,
        ]);

        // Simpan data satuan
        $satuan = Satuan::create([
            'id_obat' => $obat->id_obat,
            'satuan_terbesar' => $request->satuan_terbesar,
            'satuan_terkecil_1' => $request->satuan_terkecil_1,
            'jumlah_satuan_terkecil_1' => $request->jumlah_satuan_terkecil_1,
        ]);

        foreach (range(2, 5) as $i) {
            if ($request->has("satuan_terkecil_{$i}") && $request->has("jumlah_satuan_terkecil_{$i}")) {
                Detailsatuan::create([
                    'id_satuan' => $satuan->id,
                    'satuan_terkecil' => $request->input("satuan_terkecil_{$i}"),
                    'jumlah' => $request->input("jumlah_satuan_terkecil_{$i}"),
                ]);
            }
        }

        return redirect()->route('Obat.index')->with('success', 'Obat berhasil ditambahkan!');
    }


    public function show($id_obat)
    {
        $itemObat = DetailObat::with('pembelian.supplier', 'obat.satuans.detailSatuans')->where('id_obat', $id_obat)->get();
       
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

    // Controller
    public function showDetailSatuan($id_obat)
    {
        $satuans = Satuan::where('id_obat', $id_obat)->with('detailSatuans')->get();
        return view('pages.Obat.detailsatuan', compact('satuans'));
    }
}
