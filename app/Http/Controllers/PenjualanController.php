<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\Obat;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanController extends Controller
{
    public function index()
    {
        $keranjang = session('keranjang', []);
        $totalBayar = 0;
        // dd($keranjang);
        foreach ($keranjang as $item) {
            $totalBayar += $item['harga_jual'] * $item['jumlah'];
        }
        return view('pages.penjualan.index', compact('keranjang', 'totalBayar'));
    }

    public function cariObat(Request $request)
    {
        $nama = $request->input('merek_obat');

        // Use eager loading to get the related 'obat' data
        $obat = DetailObat::whereHas('obat', function ($query) use ($nama) {
            $query->where('merek_obat', $nama);
        })
            ->where('stok_obat', '>', 0)
            ->where('tanggal_kadaluarsa', '>', now())
            ->orderBy('tanggal_kadaluarsa')
            ->first();

        if (!$obat) {
            return response()->json(['error' => 'Obat tidak ditemukan atau sudah habis/stok tidak mencukupi'], 404);
        }

        return response()->json([
            'merek_obat' => $obat->obat->merek_obat,
            'stok_obat' => $obat->stok_obat,
            'harga_jual' => $obat->harga_jual,
        ]);
    }


    public function tambahKeKeranjang(Request $request)
    {
        $request->validate([
            'merek_obat' => 'required',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $namaObat = $request->merek_obat;
        $jumlah = $request->jumlah;

        $obat = DetailObat::whereHas('obat', function ($query) use ($namaObat) {
            $query->where('merek_obat', $namaObat);
        })
            ->where('stok_obat', '>', 0)
            ->where('tanggal_kadaluarsa', '>', now())
            ->orderBy('tanggal_kadaluarsa')
            ->first();

        if (!$obat) {
            return redirect()->back()->with('error', 'Obat tidak ditemukan atau sudah habis/stok tidak mencukupi.');
        }

        $stokObat = $obat->stok_obat;

        if ($stokObat < $jumlah) {
            return redirect()->back()->with('error', 'Stok obat tidak mencukupi.');
        }

        // Perbarui stok obat
        $obat->stok_obat -= $jumlah;
        $obat->save();

        $obatData = [
            'id_obat' => $obat->obat->id_obat,
            'merek_obat' => $namaObat,
            'harga_jual' => $obat->harga_jual,
            'jumlah' => $jumlah,
            'stok_obat' => $obat->stok_obat,
            'total_harga' => $obat->harga_jual * $jumlah,
        ];

        $keranjang = session('keranjang', []);
        $keranjang[] = $obatData;
        session(['keranjang' => $keranjang]);

        return redirect()->back()->with('success', 'Obat berhasil ditambahkan ke keranjang.');
    }



    public function checkout(Request $request)
    {
        // Validasi request sesuai kebutuhan
        $request->validate([
            'jumlah_dibayar' => 'required|numeric|min:0',
        ]);

        $keranjang = session('keranjang', []);

        $penjualan = Penjualan::create([
            'tanggal_penjualan' => now(),
        ]);


        foreach ($keranjang as $item) {
            $detailPembelian = DetailPembelian::where('id_obat', $item['id_obat'])->latest()->first();

            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id,
                'id_obat' => $item['id_obat'],
                'jumlah' => $item['jumlah'],
                'harga_jual' => $item['harga_jual'],
                'harga_beli_obat' => $detailPembelian->harga_beli_satuan,
            ]);
        }
        // $penjualan = Penjualan::all();
        $totalBayar = 0;

        foreach ($keranjang as $item) {
            $totalBayar += $item['harga_jual'] * $item['jumlah'];
        }

        $totalBayar;
        // $pdf = PDF::loadView('pages.penjualan.nota', compact('keranjang', 'totalBayar'));
        // $pdf->download('nota_penjualan.pdf');

        session()->forget('keranjang');


        return redirect()->back()->with('success', 'Transaksi berhasil.');
    }

    public function cetakNota(Request $request, $keranjang)
    {
        $keranjang = session('keranjang', []);
        $totalBayar = 0;

        foreach ($keranjang as $item) {
            $totalBayar += $item['harga_jual'] * $item['jumlah'];
        }

        return $totalBayar;

        $pdf = PDF::loadView('penjualan.nota', compact('keranjang', 'totalBayar'));
        return $pdf->download('nota_penjualan.pdf');
    }

    public function hapusItemKeranjang(Request $request, $index)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$index])) {
            $item = $keranjang[$index];
            $nama = $item['merek_obat'];
            $obat = DetailObat::whereHas('obat', function ($query) use ($nama) {
                $query->where('merek_obat', $nama);
            })->first();
            $obat->stok_obat += $item['jumlah'];
            $obat->save();
            unset($keranjang[$index]);
            session()->put('keranjang', $keranjang);
        }

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function hapusKeranjang()
    {

        $keranjang = session('keranjang', []);

        foreach ($keranjang as $item) {
            $stokObat = $item['stok_obat'] + $item['jumlah'];
            DB::table('obat')->where('merek_obat', $item['merek_obat'])->update(['stok_obat' => $stokObat]);
        }

        // Hapus seluruh keranjang
        session()->forget('keranjang');

        return redirect()->back()->with('success', 'Seluruh keranjang berhasil dihapus.');
    }
}
