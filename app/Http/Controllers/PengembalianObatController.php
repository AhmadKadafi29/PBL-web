<?php

namespace App\Http\Controllers;

use App\Models\detail_pengembalian_obat;
use App\Models\DetailObat;
use App\Models\Pembelian;
use App\Models\pengembalian_obat;
use Illuminate\Http\Request;

class PengembalianObatController extends Controller
{
    public function index()
    {
        $datapengembalian = pengembalian_obat::paginate(10);
        return view('pages.pengembalian_obat.index', compact('datapengembalian'));
    }
    public function create()
    {
        return view(view: 'pages.pengembalian_obat.create');
    }

    public function searchFaktur(Request $request)

    {

        $noFaktur = $request->query('no_faktur');

        $pembelian = Pembelian::where('no_faktur', $noFaktur)
            ->with('supplier')
            ->with('detailPembelian.obat')
            ->with('detailobat')
            ->get();
        $stuan =
            $response = $pembelian->map(function ($item) {
                return [
                    'no_faktur' => $item->no_faktur,
                    'tanggal_pembelian' => $item->tanggal_pembelian,
                    'nama_supplier' => $item->supplier->nama_supplier,
                    'id_pembelian' => $item->id_pembelian,

                    'detail_pembelian' => $item->detailPembelian->map(function ($detail) {
                        return [
                            'id_obat' => $detail->id_obat,
                            'no_batch' => $detail->no_batch,
                            'merek_obat' => $detail->obat->merek_obat,
                            'harga_satuan' => $detail->harga_beli_satuan

                        ];
                    }),

                    'stok' => $item->detailobat->map(function ($stok) {
                        $satuan = $stok->obat->satuan; // Relasi dari model `Obat` ke model `Satuan`

                        // Default nilai konversi jika satuan tidak tersedia
                        $jumlahPerBox = 1;
                        if ($satuan) {
                            if ($satuan->jumlah_satuan_terkecil_1 > 0) {
                                $jumlahPerBox = $satuan->jumlah_satuan_terkecil_1;
                            }
                        }

                        $stokSatuanTerkecil = $stok->stok_satuan_terkecil_1;

                        // Hitung jumlah box dan sisa terkecil
                        $stokBox = 0;
                        $stokTerkecil = $stokSatuanTerkecil;
                        while ($stokTerkecil >= $jumlahPerBox) {
                            $stokBox++;
                            $stokTerkecil -= $jumlahPerBox;
                        }

                        return [
                            'stok_box' => $stokBox,
                            'stok_terkecil' => $stokTerkecil,
                            'tanggal_kadaluarsa' => $stok->tanggal_kadaluarsa,
                            'id_detail_obat' => $stok->id_detail_obat
                        ];
                    })
                ];
            });
        // dd($response);

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_obat' => 'required',
            'no_faktur' => 'required|string',
            'tanggal_pengembalian' => 'required|date',
            'total' => 'required|numeric|min:0',
            'merek_obat' => 'required|array',
            'no_batch' => 'required|array',
            'stok_tersedia' => 'required|array',
            'jumlah_retur' => 'required|array',
            'jumlah_retur.*' => 'numeric|min:0',
            'no_batch.*' => 'string',
        ]);

        $no_faktur = $request->no_faktur;
        $tanggal_pengembalian = $request->tanggal_pengembalian;
        $totalhargapengembalian = $request->total;

        $pembelian = Pembelian::where('no_faktur', $no_faktur)->first();
        $id_pembelian = $pembelian->id_pembelian;

        $idpengembalian = pengembalian_obat::create([
            'id_pembelian' => $id_pembelian,
            'tanggal_pengembalian' => $tanggal_pengembalian,
            'total_pengembalian' => $totalhargapengembalian
        ]);

        $id_pengembalian = $idpengembalian->id;

        $merek_obats = $request->input('merek_obat');
        $id = $request->input('id_obat');
        $no_batches = $request->input('no_batch');
        $jumlah_returs = $request->input('jumlah_retur');

        for ($i = 0; $i < count($merek_obats); $i++) {

            $detail_obat = DetailObat::where('id_obat', $id[$i]);

            // dd($detail_obat);

            if ($detail_obat) {
                $id_detail_obat = $detail_obat->id_detail_obat;
                $stokAwal = $detail_obat->stok_obat;
                $jumlah_retur = $jumlah_returs[$i];


                if ($stokAwal < $jumlah_retur) {

                    return redirect()->back()->with(['error' => 'Jumlah retur tidak boleh lebih dari stok tersedia untuk obat ' . $merek_obats[$i]]);
                }


                detail_pengembalian_obat::create([
                    'id_pengembalian_obat' => $id_pengembalian,
                    'Quantity' => $jumlah_returs[$i],
                    'id_detail_obat' => $id_detail_obat,
                    'stok_awal' => $stokAwal
                ]);

                $sisa_obat = $stokAwal - $jumlah_returs[$i];
                if ($sisa_obat == 0) {
                    $detail_obat->delete();
                } else {
                    $detail_obat->update([
                        'stok_obat' => $sisa_obat
                    ]);
                }
            } else {
                return redirect()->back()->with('error', 'Detail obat tidak ditemukan untuk no_batch: ' . $id[$i]);
            }
        }
        return redirect()->route('pengembalian-obat.index')->with('success', 'data pengembalian obat berhasil ditambahkan');
    }

    public function show($id)
    {

        $datadetailpengembalian = detail_pengembalian_obat::where('id_pengembalian_obat', $id)
            ->with('detail_obat')->get();

        return view('pages.pengembalian_obat.show', compact('datadetailpengembalian'));
        //dd($datadetailpengembalian);

    }
    public function undo($id)
    {
        $detailPengembalian = detail_pengembalian_obat::findOrFail($id);
        $detailObat = DetailObat::findOrFail($detailPengembalian->id_detail_obat);

        $id_pengembalian = $detailPengembalian->id_pengembalian_obat;

        $detailObat->update([
            'stok_obat' => $detailPengembalian->stok_awal
        ]);

        $detailPengembalian->delete();

        $remainingDetails = detail_pengembalian_obat::where('id_pengembalian_obat', $id_pengembalian)->count();

        if ($remainingDetails === 0) {
            pengembalian_obat::findOrFail($id_pengembalian)->delete();
        }

        return redirect()->route('pengembalian-obat.index')->with('success', 'Pengembalian berhasil dibatalkan');
    }
}
