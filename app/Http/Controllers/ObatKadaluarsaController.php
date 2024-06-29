<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
use App\Models\Obat;
use App\Models\ObatKadaluarsa;
use Illuminate\Http\Request;

class ObatKadaluarsaController extends Controller
{
    public function index()
    {
        $obatkadaluarsa = DetailObat::whereDate('detail_obat.tanggal_kadaluarsa', '<', now()->toDateString())
        ->get();

        return view('pages.obat_kadaluarsa.index', compact('obatkadaluarsa'));
    }

    // public function storekadaluarsa(Request $request)
    // {
    //     $obat = Obat::whereDate('exp_date', '<', now())->get();
    //     foreach ($obat as $ob) {
    //         $existingRecord = ObatKadaluarsa::where('id_obat', $ob->id)->first();
    //         if (!$existingRecord) {
    //             ObatKadaluarsa::create([
    //                 'id_obat' => $ob->id,
    //                 'tanggal_kadaluarsa' => $ob->exp_date,
    //             ]);
    //         }
    //     }
    //     return redirect()->route('Obatkadaluarsa.index')->with('success', 'Obat-obat kadaluarsa telah dipindahkan ke tabel kadaluarsa.');
    // }


    // public function destroy($id)
    // {
    //     $obatkadaluarsa = ObatKadaluarsa::find($id);
    //     $obatkadaluarsa->delete();
    //     return redirect()->route('Obatkadaluarsa.index')->with('success', 'Obat Kadaluarsa berhasil dihapus');
    // }
}
