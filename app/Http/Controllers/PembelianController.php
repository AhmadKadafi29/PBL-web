<?php

namespace App\Http\Controllers;

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
        return view('pages.pembelian.index', compact('pembelian'));
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

        $request->validate([
            'id_supplier' => 'required',
            'id_obat' => 'required',
            'harga_satuan' => 'required|integer',
            'quantity' => 'required|integer',
            'tanggal_pembelian' => 'required',
            'status_pembayaran' => 'required|string'
        ]);


        $noFaktur = "{$request->id_obat}{$request->id_supplier}" . date('Ymd', strtotime($request->tanggal_pembelian));
        $totalHarga = $request->quantity * $request->harga_satuan;

        // Simpan data pembelian ke database
        Pembelian::create([
            'id_obat' => $request->id_obat,
            'id_supplier' => $request->id_supplier,
            'noFaktur' => $noFaktur,
            'harga_satuan' => $request->harga_satuan,
            'quantity' => $request->quantity,
            'total_harga' => $totalHarga,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        return redirect()->route('Pembelian.index')->with('success', 'Data pembelian berhasil');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pembelian = Pembelian::find($id);
        $supplier = Supplier::all();
        $obat = Obat::all();
        return view('pages.pembelian.edit', compact('pembelian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_supplier' => 'required',
            'id_obat' => 'required',
            'harga_satuan' => 'required|integer',
            'quantity' => 'required|integer',
            'tanggal_pembelian' => 'required',
            'status_pembayaran' => 'required|string'
        ]);


        $pembelian = Pembelian::find($id);
        $totalHarga = $request->quantity * $request->harga_satuan;
        $noFaktur = "{$request->id_obat}{$request->id_supplier}" . date('Ymd', strtotime($request->tanggal_pembelian));
        $pembelian->update([
            'id_obat' => $request->id_obat,
            'id_supplier' => $request->id_supplier,
            'noFaktur' => $noFaktur,
            'quantity' => $request->quantity,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $totalHarga,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'status_pembayaran' => $request->status_pembayaran,
        ]);
        return redirect()->route('Pembelian.index')->with('success', 'Data Pembelian berhasil diupdate');
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
