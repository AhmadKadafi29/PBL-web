<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;

class PengembalianObatController extends Controller
{
    public function index() {
        $pembelian = Pembelian::all();
        return view('pages.pengembalian_obat.index', compact('pembelian'));
    }
    public function create()
    {
        return view('pages.pengembalian_obat.create');
    }

    public function searchFaktur(Request $request)
{
    $noFaktur = $request->query('no_faktur');
    // Cari data pembelian berdasarkan no faktur
    $pembelian = Pembelian::where('no_faktur', $noFaktur)
    ->with('supplier')
    ->with('detailPembelian')
    ->with('detailobat.obat') // pastikan Anda memiliki relasi 'supplier'
    ->get();

    $result = $pembelian->map(function ($p) {
        return [
            'no_faktur' => $p->no_faktur,
            'tanggal_pembelian' => $p->tanggal_pembelian,
            'status_pembayaran' => $p->status_pembayaran,
            'total_harga' => $p->total_harga,
            'supplier' => $p->supplier->nama_supplier,
            'detail_pembelian' => $p->detailPembelian->map(function ($detail) {
                return [
                    'nama_obat' => $detail->detailobat->obat->merek_obat ?? '',
                    'no_batch' => $detail->no_batch,
                    'kuantitas' => $detail->quantity,
                    'harga_beli_satuan' => $detail->harga_beli_satuan,
                    'tanggal_kadaluarsa' => $detail->detailobat->tanggal_kadaluarsa ?? '',
                    'subtotal' => $detail->quantity * $detail->harga_beli_satuan,
                ];
            }),
        ];
    });
    
    // Return hasil sebagai JSON
    return response()->json($result);
}

    
}
