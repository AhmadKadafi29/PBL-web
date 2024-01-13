<?php

namespace App\Http\Controllers;

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

        foreach ($keranjang as $item) {
            $totalBayar += $item['harga_obat'] * $item['jumlah'];
        }
        return view('pages.penjualan.index', compact('keranjang', 'totalBayar'));
    }

    public function cariObat(Request $request)
    {
        $idObat = $request->input('id_obat');
        $obat = Obat::find($idObat);

        if (!$obat) {
            return response()->json(['error' => 'Obat tidak ditemukan'], 404);
        }

        return response()->json([
            'nama_obat' => $obat->nama_obat,
            'stok_obat' => $obat->stok_obat,
            'harga_obat' => $obat->harga_obat,
        ]);
    }

    public function tambahKeKeranjang(Request $request)
    {
        $request->validate([
            'id_obat' => 'required',
            'stok_obat' => 'required|numeric|min:0',
            'harga_obat' => 'required|numeric|min:0',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $stokObat = $request->stok_obat;
        $jumlah = $request->jumlah;

        if ($stokObat - $jumlah < 0) {
            return redirect()->back()->with('error', 'Stok obat tidak mencukupi.');
        }

        $stokObat -= $jumlah;

        $obat = [
            'id_obat' => $request->id_obat,
            'nama_obat' => $request->nama_obat,
            'harga_obat' => $request->harga_obat,
            'jumlah' => $jumlah,
            'total_harga' => $request->harga_obat * $jumlah,
        ];

        $keranjang = session('keranjang', []);
        $keranjang[] = $obat;
        session(['keranjang' => $keranjang]);

        DB::table('obat')->where('id', $request->id_obat)->update(['stok_obat' => $stokObat]);
        return redirect()->back()->with('success', 'Obat berhasil ditambahkan ke keranjang.');
    }

    public function checkout(Request $request)
    {
        // Validasi request sesuai kebutuhan
        $request->validate([
            'jumlah_dibayar' => 'required|numeric|min:0',
        ]);

        $keranjang = session('keranjang', []);

        foreach ($keranjang as $item) {
            Penjualan::create([
                'id_obat' => $item['id_obat'],
                'harga_obat' => $item['harga_obat'],
                'jumlah' => $item['jumlah'],
                'total_harga' => $item['total_harga'],
                'tanggal_penjualan' => now(),
            ]);
        }

        session()->forget('keranjang');
        $this->cetakNota($request, $keranjang);

        return redirect()->back()->with('success', 'Transaksi berhasil.');
    }

    public function cetakNota(Request $request, $keranjang)
    {
        $keranjang = session('keranjang', []);
        $totalBayar = 0;

        foreach ($keranjang as $item) {
            $totalBayar += $item['harga_obat'] * $item['jumlah'];
        }

        return $totalBayar;

        $pdf = PDF::loadView('penjualan.nota', compact('keranjang', 'totalBayar'));
        return $pdf->download('nota_penjualan.pdf');
    }

    public function hapusItemKeranjang(Request $request, $index)
    {
        $keranjang = session('keranjang', []);
        $idObat = $request->input('id_obat');
        try {
            // Mulai transaksi database
            DB::beginTransaction();

            $obat = Obat::find($idObat);
            $obat->stok_obat += $keranjang[$index]['jumlah'];
            DB::table('obat')->where('id', $idObat)->update(['stok_obat' => $obat->stok_obat]);

            unset($keranjang[$index]);
            session()->put('keranjang', $keranjang);

            // Commit transaksi
            DB::commit();

            return redirect()->back()->with('success', 'Obat berhasil dihapus dari keranjang.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan. Obat gagal dihapus dari keranjang.');
        }
    }

    public function hapusKeranjang()
    {

        $keranjang = session('keranjang', []);

        foreach ($keranjang as $item) {
            $stokObat = $item['stok_obat'] + $item['jumlah'];
            DB::table('obat')->where('id', $item['id_obat'])->update(['stok_obat' => $stokObat]);
        }

        // Hapus seluruh keranjang
        session()->forget('keranjang');

        return redirect()->back()->with('success', 'Seluruh keranjang berhasil dihapus.');
    }
}
