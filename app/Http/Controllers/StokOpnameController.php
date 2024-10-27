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
        $opname = StokOpname::with(['user', 'obat.detailobat'])->paginate(10);
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
            'tanggal_opname' => 'date',
        ]);
    
        try {
            // Cek jika ada detail obat yang kadaluarsa
            $kadaluarsaObat = DB::table('detail_obat')
                ->where('id_obat', $request->id_obat)
                ->where('tanggal_kadaluarsa', '<=', now())
                ->exists();
    
            if ($kadaluarsaObat) {
                return redirect()->route('Stok_opname.index')->with('error', ' obat yang sudah kadaluarsa.');
            }
    
            // Ambil total stok obat yang belum kadaluarsa
            $obatStok = DB::table('obat')
                ->join('detail_obat', 'obat.id_obat', '=', 'detail_obat.id_obat')
                ->where('obat.id_obat', $request->id_obat)
                ->where('detail_obat.tanggal_kadaluarsa', '>', now())
                ->sum('detail_obat.stok_obat');
    
            $selisihStok = $request->stok_fisik - $obatStok;
            StokOpname::create([
                'id_obat' => $request->id_obat,
                'stok_fisik' => $request->stok_fisik,
                'stok_sistem' => $obatStok,
                'harga_jual_satuan' => $selisihStok,
                'tanggal_opname' => $request->tanggal_opname,
                'id_user' => Auth::id(),
            ]);
    
            return redirect()->route('Stok_opname.index')->with('success', 'Stok opname berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->route('Stok_opname.index')->with('error', 'Terjadi kesalahan. Stok opname gagal disimpan.');
        }
    }
    
    // public function edit($id){
    //     $dataopname = StokOpname::find($id);
    //     $user = User::all();
    //     $obat = Obat::all();

    //     return view('pages.stok_opname.edit', compact('dataopname','user','obat'));
    // }

    // public function update(Request $request, $id){
    //     $request->validate([
    //     'stok_fisik' => 'required|integer',   
    //     'tanggal_opname' => 'date',
    //     'id_obat' => 'required|exists:obat,id_obat',
    //     ]);

    //     $obatStok = DB::table('obat')
    //     ->join('detail_obat', 'obat.id_obat', '=', 'detail_obat.id_obat')
    //     ->where('obat.id_obat', $request->id_obat)
    //     ->where('detail_obat.tanggal_kadaluarsa', '>',now())
    //     ->sum('detail_obat.stok_obat');

    //    $selisihStok =  $request->stok_fisik-$obatStok;
    //     $stokopname = StokOpname::find($id);
    //     $stokopname->update([
    //         'id_obat' => $request->id_obat,
    //         'stok_fisik' => $request->stok_fisik,
    //         'stok_sistem'=>$obatStok,
    //         'harga_jual_satuan' => $selisihStok,
    //         'tanggal_opname' => $request->tanggal_opname,
    //         'id_user' => Auth::id(),  
    //     ]);

    //     return redirect()->route('Stok_opname.index')
    //     ->with('success', 'Supplier telah diperbarui');



    // }
}


