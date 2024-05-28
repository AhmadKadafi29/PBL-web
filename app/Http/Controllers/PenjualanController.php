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

        foreach ($keranjang as $item) {
            $totalBayar += $item['harga_jual_obat'] * $item['jumlah'];
        }
        return view('pages.penjualan.index', compact('keranjang', 'totalBayar'));
    }

    public function cariObat(Request $request)
    {
        $nama = $request->input('nama_obat');
        $obat = DetailObat::whereHas('obat', function ($query) use ($nama) {
            $query->where('nama_obat', $nama);
        })
            ->where('stok_obat', '>', 0)
            ->where('tanggal_kadaluarsa', '>', now())
            ->orderBy('tanggal_kadaluarsa')
            ->first();

        if (!$obat) {
            return response()->json(['error' => 'Obat tidak ditemukan atau sudah habis/stok tidak mencukupi'], 404);
        }

        return response()->json([
            'nama_obat' => $obat->obat->nama_obat,
            'stok_obat' => $obat->stok_obat,
            'harga_obat' => $obat->obat->harga_obat,
        ]);
    }

    public function tambahKeKeranjang(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $namaObat = $request->nama_obat;
        $jumlah = $request->jumlah;

        $obat = DetailObat::whereHas('obat', function ($query) use ($namaObat) {
            $query->where('nama_obat', $namaObat);
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
            'kode_obat' => $obat->obat->kode_obat,
            'nama_obat' => $namaObat,
            'harga_obat' => $obat->obat->harga_obat,
            'jumlah' => $jumlah,
            'stok_obat' => $obat->stok_obat,
            'total_harga' => $obat->obat->harga_obat * $jumlah,
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
                'harga_jual_obat' => $item['harga_obat'],
                'harga_beli_obat' => $detailPembelian->harga_beli_satuan,
            ]);
        }
        // $penjualan = Penjualan::all();
        $totalBayar = 0;

        foreach ($keranjang as $item) {
            $totalBayar += $item['harga_obat'] * $item['jumlah'];
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
            $totalBayar += $item['harga_obat'] * $item['jumlah'];
        }

        return $totalBayar;

        $pdf = PDF::loadView('penjualan.nota', compact('keranjang', 'totalBayar'));
        return $pdf->download('nota_penjualan.pdf');
    }

    public function hapusItemKeranjang(Request $request, $index)
    {
        $keranjang = session('keranjang', []);

        if (isset($keranjang[$index])) {
            $item = $keranjang[$index];

            // Mulai transaksi database
            DB::beginTransaction();

            try {
                $obat = Obat::where('nama_obat', $item['nama_obat'])->first();
                $obat->stok_obat += $item['jumlah'];
                $obat->save();

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

        return redirect()->back()->with('error', 'Item keranjang tidak ditemukan.');
    }

    public function hapusKeranjang()
    {

        $keranjang = session('keranjang', []);

        foreach ($keranjang as $item) {
            $stokObat = $item['stok_obat'] + $item['jumlah'];
            DB::table('obat')->where('nama_obat', $item['nama_obat'])->update(['stok_obat' => $stokObat]);
        }

        // Hapus seluruh keranjang
        session()->forget('keranjang');

        return redirect()->back()->with('success', 'Seluruh keranjang berhasil dihapus.');
    }
}
