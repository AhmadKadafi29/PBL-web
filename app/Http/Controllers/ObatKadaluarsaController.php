<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatKadaluarsa;
use Illuminate\Http\Request;

class ObatKadaluarsaController extends Controller
{
    public function index()
    {
        $obatkadaluarsa = ObatKadaluarsa::with('obat')->get();
        return view('pages.obat_kadaluarsa.index', compact('obatkadaluarsa'));
    }

    public function storekadaluarsa(Request $request)
    {
        $obat = Obat::whereDate('exp_date', '<', now())->get();
        foreach ($obat as $ob) {
            $existingRecord = ObatKadaluarsa::where('id_obat', $ob->id)->first();
            if (!$existingRecord) {
                ObatKadaluarsa::create([
                    'id_obat' => $ob->id,
                    'tanggal_kadaluarsa' => $obat->exp_date,
                ]);
                return redirect()->route('Obatkadaluarsa.index')
                    ->with('success', 'Obat-obat kadaluarsa telah dipindahkan ke tabel kadaluarsa.');
            } else {
                return redirect()->route('Obatkadaluarsa.index')
                    ->with('danger', 'Obat sudah ada');
            }
        }
    }

    public function destroy($id)
    {
        $obatkadaluarsa = ObatKadaluarsa::find($id);
        $obatkadaluarsa->delete();
        return redirect()->route('Obatkadaluarsa.index')->with('success', 'Obat Kadaluarsa berhasil dihapus');
    }
}
