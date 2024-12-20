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
        $request->validate([
            'merek_obat' => 'required|string',
        ], [
            'merek_obat.required' => 'merek obat harus diisi.',
        ]);

        $merek = $request->input('merek_obat');
        $obat = DetailObat::whereHas('obat', function ($query) use ($merek) {
            $query->where('merek_obat', $merek);
        })
            ->where('stok_obat', '>', 0)
            ->where('tanggal_kadaluarsa', '>', now())
            ->orderBy('tanggal_kadaluarsa')
            ->first();

        if (!$obat) {
            return response()->json(['error' => 'Obat tidak ditemukan.'], 404);
        } else if ($obat->stok_obat == 0) {
            return response()->json(['error' => 'stok tidak mencukupi.'], 404);
        } else if ($obat->tanggal_kadaluarsa < now()) {
            return response()->json(['error' => 'obat telah kadaluarsa.'], 404);
        }


        return response()->json([
            'merek_obat' => $obat->merek_obat,
            'stok_obat' => $obat->stok_obat,
            'harga_obat' => $obat->harga_jual,
        ]);
    }

    public function tambahKeKeranjang(Request $request)
    {
        $request->validate([
            'merek_obat' => 'required',
            'jumlah' => 'required|integer|min:1',
        ], [
            'jumlah.required' => 'Jumlah beli harus diisi.',
            'jumlah.integer' => 'Jumlah beli harus berupa angka.',
            'jumlah.min' => 'Jumlah beli minimal adalah 1.',
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
            'kode_obat' => $obat->obat->kode_obat,
            'nama_obat' => $namaObat,
            'harga_jual_obat' => $obat->harga_jual,
            'jumlah' => $jumlah,
            'stok_obat' => $obat->stok_obat,
            'total_harga' => $obat->harga_jual * $jumlah,
            'tanggal_kadaluarsa' => $obat->tanggal_kadaluarsa,
            'Satuan' => $obat->obat->kemasan,
            'id_obat' => $obat->id_obat
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
        $idPenjualan = $penjualan->id_penjualan;


        foreach ($keranjang as $item) {
            $detailPembelian = DetailPembelian::where('id_obat', $item['id_obat'])->latest()->first();

            DetailPenjualan::create([
                'id_penjualan' => $idPenjualan,
                'id_obat' => $item['id_obat'],
                'jumlah_jual' => $item['jumlah'],
                'harga_jual_satuan' => $item['harga_jual_obat'],
                'harga_beli_satuan' => $detailPembelian->harga_beli_satuan,
            ]);
        }

        // $penjualan = Penjualan::all();
        $totalBayar = 0;

        foreach ($keranjang as $item) {
            $totalBayar += $item['harga_jual_obat'] * $item['jumlah'];
        }
        $totalBayar;
        // $pdf = PDF::loadView('pages.penjualan.nota', compact('keranjang', 'totalBayar', 'penjualan'));
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
            $namaObat = $item['nama_obat'];

            try {
                $obat = DetailObat::whereHas('obat', function ($query) use ($namaObat) {
                    $query->where('merek_obat', $namaObat);
                })
                    ->where('tanggal_kadaluarsa', $item['tanggal_kadaluarsa'])
                    ->first();
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
            $namaObat = $item['nama_obat'];
            $obat = DetailObat::whereHas('obat', function ($query) use ($namaObat) {
                $query->where('merek_obat', $namaObat);
            })
                ->where('tanggal_kadaluarsa', $item['tanggal_kadaluarsa'])
                ->first()
                ->update(['stok_obat' => $stokObat]);
        }
        session()->forget('keranjang');

        return redirect()->back()->with('success', 'Seluruh keranjang berhasil dihapus.');
    }
}
