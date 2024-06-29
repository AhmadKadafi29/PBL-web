<?php

namespace App\Http\Controllers;

use App\Models\DetailObat;
use App\Models\DetailPembelian;
use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pembelian = Pembelian::all();
        $supplier = Supplier::all();
        return view('pages.pembelian.index', compact('pembelian','supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = Supplier::all();
        $obat = Obat::all();

        return view('pages.pembelian.create', compact('obat', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $noFaktur = "{$request->id_obat}{$request->id_supplier}" . date('Ymd', strtotime($request->tanggal_pembelian));
        $harga_beli_satuan = $request->input('harga_beli_satuan');
        $harga_jual_satuan = $request->input('harga_jual_satuan');
        $quantity = $request->input('quantity');

        $pembelian = new Pembelian;
        $pembelian->id_supplier = $request->input('id_supplier');
        $pembelian->no_faktur = $noFaktur;
        $pembelian->total_harga = $harga_beli_satuan * $quantity;
        $pembelian->tanggal_pembelian = $request->input('tanggal_pembelian');
        $pembelian->status_pembayaran = $request->input('status_pembayaran');
        $pembelian->save();

        $id_obat = $request->id_obat;

        $detailPembelian = [
            'id_pembelian' => $pembelian->id_pembelian,
            'id_obat' => $id_obat,
            'harga_beli_satuan' => $harga_beli_satuan,
            'quantity' => $quantity,
        ];


        DetailPembelian::create($detailPembelian);
        DetailObat::create([
            'id_pembelian' => $pembelian->id_pembelian,
            'id_obat' => $id_obat,
            'stok_obat' => $quantity,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
            'harga_jual' =>$harga_jual_satuan,
            'no_batch'=>$request->no_batch
        ]);

        return redirect()->route('Pembelian.index')->with('success', 'Pembelian berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function show($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $supplier = Supplier::all();
        $obat = Obat::all();
        return view('pages.pembelian.show', compact('pembelian', 'supplier', 'obat'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $pembelian->delete();
        return redirect()->route('Pembelian.index')->with('success', 'Pembelian Deleted');
    }
}
