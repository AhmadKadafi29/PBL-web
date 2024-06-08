<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
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
        $opname = StokOpname::with(['user', 'obat.detailobat'])->get();
        return view('pages.stok_opname.index', compact('opname'));
    }

    public function create()
    {
        $user = User::all();
        $obat = Obat::all();

        return view('pages.stok_opname.create', compact('obat', 'user'));
    }

    public function store(Request $request){

        $request->validate([
        'id_obat' => 'required|exists:obat,id_obat',
        'stok_fisik' => 'required|integer',
       'status' => 'required|in:belum kadaluarsa,kadaluarsa',
        'tanggal_opname' => 'date',
    ]);

    try {
        $obatStok = DB::table('obat')
            ->join('detail_obat', 'obat.id_obat', '=', 'detail_obat.id_obat')
            ->where('obat.id_obat', $request->id_obat)
            ->where('detail_obat.tanggal_kadaluarsa', '>',now())
            ->sum('detail_obat.stok_obat');

        $selisihStok =  $request->stok_fisik-$obatStok;
        StokOpname::create([
            'id_obat' => $request->id_obat,
            'stok_fisik' => $request->stok_fisik,
            'status' => $request->status,
            'harga_jual_satuan' => $selisihStok,
            'tanggal_opname' => $request->tanggal_opname,
            'id_user' => Auth::id(),
        ]);

        return redirect()->route('Stok_opname.index')->with('success', 'Stok opname berhasil disimpan.');
    } catch (\Exception $e) {
        return redirect()->route('Stok_opname.index')->with('error', 'Terjadi kesalahan. Stok opname gagal disimpan.');
    }
    }
}
