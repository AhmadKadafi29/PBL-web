<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
use App\Models\Obat;
use App\Models\StokOpname;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StokOpnameController extends Controller
{
    public function index()
    {
        $opname = StokOpname::with([
            'user',
            'obat.detailobat',
            'obat.satuans',
            'obat.satuans.detailSatuans'
        ])->paginate(10);
        return view('pages.stok_opname.index', compact('opname'));
    }

    public function create()
    {
        $user = User::all();
        $obat = Obat::all();

        return view('pages.stok_opname.create', compact('obat', 'user'));
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'id_obat' => 'required|exists:obat,id_obat',
                'stok_fisik_1' => 'required|integer|min:0',
                'stok_fisik_2' => 'required|integer|min:0',
                'tanggal_opname' => ['required', 'date', function ($attribute, $value, $fail) {
                    $now = Carbon::now()->setTimezone('Asia/Jakarta')->toDateString();
                    if (Carbon::parse($value)->toDateString() !== $now) {
                        $fail('Tanggal opname harus hari ini.');
                    }
                }],
            ],
            [
                'id_obat.required' => 'Nama Obat tidak boleh kosong.',
                'id_obat.exists' => 'Obat yang dipilih tidak valid.',
                'stok_fisik_1.required' => 'Stok fisik 1 tidak boleh kosong.',
                'stok_fisik_1.integer' => 'Stok fisik harus berupa angka.',
                'stok_fisik_1.min' => 'Stok fisik 1 tidak boleh kurang dari 0.',
                'stok_fisik_2.required' => 'Stok fisik 2 tidak boleh kosong.',
                'stok_fisik_2.integer' => 'Stok fisik harus berupa angka.',
                'stok_fisik_2.min' => 'Stok fisik 2 tidak boleh kurang dari 0.',
                'tanggal_opname.required' => 'Tanggal opname tidak boleh kosong.',
                'tanggal_opname.date' => 'Format tanggal opname tidak valid.',
            ]
        );

        try {
            // Cek jika ada detail obat yang kadaluarsa
            $kadaluarsaObat = DB::table('detail_obat')
                ->where('id_obat', $request->id_obat)
                ->where('tanggal_kadaluarsa', '<=', now())
                ->exists();

            if ($kadaluarsaObat) {
                return redirect()->route('Stok_opname.index')->with('error', ' Obat yang sudah kadaluarsa.');
            }

            // Ambil total stok obat yang belum kadaluarsa
            $stokSistem1 = DB::table('detail_obat')
                ->where('id_obat', $request->id_obat)
                ->where('tanggal_kadaluarsa', '>', now())
                ->sum('stok_satuan_terkecil_1');

            $stokSistem2 = DB::table('detail_obat')
                ->where('id_obat', $request->id_obat)
                ->where('tanggal_kadaluarsa', '>', now())
                ->sum('stok_satuan_terkecil_2');

            StokOpname::create([
                'id_obat' => $request->id_obat,
                'stok_fisik_1' => $request->stok_fisik_1,
                'stok_fisik_2' => $request->stok_fisik_2,
                'stok_sistem_1' => $stokSistem1,
                'stok_sistem_2' => $stokSistem2,
                'tanggal_opname' => $request->tanggal_opname,
                'id_user' => Auth::id(),
            ]);

            return redirect()->route('Stok_opname.index')->with('success', 'Stok opname berhasil disimpan.');
        } catch (\Exception $e) {
            print($e);
            // return redirect()->route('Stok_opname.index')->with('error', 'Terjadi kesalahan. Stok opname gagal disimpan.');
        }
    }
}
