<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\StokOpname;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokOpnameController extends Controller
{
    public function index()
    {
        $opname = StokOpname::with(['user', 'obat'])->get();
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
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'stok_fisik' => 'required|integer',
            'status' => 'required|in:belum kadaluarsa,kadaluarsa',
            'tanggal_opname' => 'date',
        ]);

        try {

            // Simpan data stok opname
            $stokOpnameData = $request->all();
            $stokOpnameData['id_user'] = Auth::id();
            StokOpname::create($stokOpnameData);

            $obat = Obat::findOrFail($request->id_obat);
            $obat->update([
                'stok_obat' => $request->stok_fisik,
                'status' => $request->status,
            ]);

            return redirect()->route('Stok_opname.index')->with('success', 'Stok opname berhasil disimpan.');
        } catch (\Exception $e) {


            return redirect()->route('Stok_opname.index')->with('error', 'Terjadi kesalahan. Stok opname gagal disimpan.');
        }
    }
}
