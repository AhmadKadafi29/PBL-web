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
use Illuminate\Support\Facades\Validator;

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
            'merek_obat.required' => 'Merek obat harus diisi.',
        ]);

        $merek = $request->input('merek_obat');

        // Cari detail obat berdasarkan merek
        $obat = DetailObat::whereHas('obat', function ($query) use ($merek) {
            $query->where('merek_obat', 'like', '%' . $merek . '%');
        })
            ->where('stok_satuan_terkecil_1', '>', 0)
            ->where('tanggal_kadaluarsa', '>', now())
            ->orderBy('tanggal_kadaluarsa')
            ->first();
            

        if (!$obat) {
            return back()->with('error', 'Obat tidak ditemukan atau stok tidak mencukupi.');
        }


        // Kirim data obat ke view
        return back()->with([
            'merek_obat' => $merek,
            'stok_satuan_1' => $obat->stok_satuan_terkecil_1,
            'stok_satuan_2' => $obat->stok_satuan_terkecil_2,
            'harga_jual_1' => $obat->harga_jual_1,
            'harga_jual_2' => $obat->harga_jual_2,
        ]);
    }


    public function tambahKeKeranjang(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'merek_obat' => 'required',
                'jumlah' => 'required|integer|min:1',
                'jenis_satuan' => 'required|in:1,2',
            ],
            [
                'jumlah.required' => 'Jumlah beli harus diisi.',
                'jumlah.integer' => 'Jumlah beli harus berupa angka.',
                'jumlah.min' => 'Jumlah beli minimal adalah 1.',
                'jenis_satuan.required' => 'Jenis satuan harus dipilih.',
            ]
        );

        // dd($validator);

        $namaObat = $request->merek_obat;
        $jumlah = $request->jumlah;
        $jenisSatuan = $request->satuan; // Mengambil jenis satuan

        // dd($jenisSatuan);

        // Cari obat berdasarkan merek
        $obat = DetailObat::whereHas('obat', function ($query) use ($namaObat) {
            $query->where('merek_obat', $namaObat);
        })
            ->where('stok_satuan_terkecil_' . $jenisSatuan, '>', 0)
            ->where('tanggal_kadaluarsa', '>', now())
            ->with('obat.satuans')
            ->first();

        if (!$obat) {
            return redirect()->back()->with('error', 'Obat tidak ditemukan atau stok tidak mencukupi.');
        }

        // Cek stok sesuai dengan jenis satuan
        $stokObat = $obat->{'stok_satuan_terkecil_' . $jenisSatuan};
        $hargaJual = $obat->{'harga_jual_' . $jenisSatuan}; // Sesuaikan dengan jenis satuan

        if ($stokObat < $jumlah) {
            return redirect()->back()->with('error', 'Stok obat tidak mencukupi.');
        }


        if ($jenisSatuan == 1) {
            $satuan = $obat->obat->satuans[0]->satuan_terkecil_1; // Relasi ke tabel satuans
        } else {
            $satuan = $obat->obat->satuans->first()->detailSatuans->first()->satuan_terkecil ?? 'Tidak ditemukan';
        }

        // Perbarui stok obat
        $obat->{'stok_satuan_terkecil_' . $jenisSatuan} -= $jumlah;
        $obat->save();

        $obatData = [
            'nama_obat' => $namaObat,
            'harga_jual_obat' => $hargaJual,
            'jumlah' => $jumlah,
            'stok_obat' => $obat->{'stok_satuan_terkecil_' . $jenisSatuan},
            'total_harga' => $hargaJual * $jumlah,
            'tanggal_kadaluarsa' => $obat->tanggal_kadaluarsa,
            'Satuan' => $satuan,
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
        $totalBayar = 0;

        $penjualan = Penjualan::create([
            'tanggal_penjualan' => now(),
        ]);
        $idPenjualan = $penjualan->id_penjualan;

        foreach ($keranjang as $item) {
            $detailPembelian = DetailPembelian::where('id_obat', $item['id_obat'])->latest()->first();

            // Menyesuaikan harga jual dan jumlah berdasarkan keranjang
            $hargaJual = $item['harga_jual_obat'];
            $jumlahJual = $item['jumlah'];

            DetailPenjualan::create([
                'id_penjualan' => $idPenjualan,
                'id_obat' => $item['id_obat'],
                'jumlah_jual' => $jumlahJual,
                'harga_jual_satuan' => $hargaJual,
                'harga_beli_satuan' => $detailPembelian->harga_beli_satuan,
            ]);

            $totalBayar += $hargaJual * $jumlahJual;
        }

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

            DB::beginTransaction();

            try {
                $obat = DetailObat::where('id_obat', $item['id_obat'])
                    ->where('tanggal_kadaluarsa', $item['tanggal_kadaluarsa'])
                    ->first();

                if (!$obat) {
                    throw new \Exception('Obat tidak ditemukan.');
                }

                // Perbarui stok berdasarkan satuan
                if ($item['Satuan'] === $obat->obat->satuans[0]->satuan_terkecil_1) {
                    $obat->stok_satuan_terkecil_1 += $item['jumlah'];
                } else {
                    $obat->stok_satuan_terkecil_2 += $item['jumlah'];
                }

                $obat->save();

                // Hapus item dari keranjang
                unset($keranjang[$index]);
                session()->put('keranjang', $keranjang);

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

        DB::beginTransaction();

        try {
            foreach ($keranjang as $item) {
                $obat = DetailObat::where('id_obat', $item['id_obat'])
                    ->where('tanggal_kadaluarsa', $item['tanggal_kadaluarsa'])
                    ->first();

                if (!$obat) {
                    throw new \Exception('Obat tidak ditemukan.');
                }

                // Perbarui stok berdasarkan satuan
                if ($item['Satuan'] === $obat->obat->satuans[0]->satuan_terkecil_1) {
                    $obat->stok_satuan_terkecil_1 += $item['jumlah'];
                } else {
                    $obat->stok_satuan_terkecil_2 += $item['jumlah'];
                }

                $obat->save();
            }

            // Hapus semua item dari keranjang
            session()->forget('keranjang');

            DB::commit();

            return redirect()->back()->with('success', 'Seluruh keranjang berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan. Keranjang gagal dihapus.');
        }
    }
}
