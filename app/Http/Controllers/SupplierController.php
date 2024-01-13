<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class supplierController extends Controller
{
    public function index(Request $request)
    {
        $supplier = Supplier::all();
        if ($request->wantsJson()) {
            return response()->json($supplier);
        }
        return view('pages.supplier.index', compact('supplier'));
    }
    public function create()
    {
        return view('pages.supplier.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|max:100',
            'no_telpon' => 'required',
            'alamat' => 'required|String|max:255'
        ]);

        $supplier = Supplier::create($request->all());
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Supplier berhasil ditambah',
                'supplier' => $supplier
            ]);
        }
        return redirect()->route('Supplier.index')
            ->with('success', 'Supplier telah tersimpan.');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('pages.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|max:100',
            'no_telpon' => 'required',
            'alamat' => 'required|String|max:255'
        ]);

        $supplier = Supplier::find($id);
        $supplier->update($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Supplier berhasil diubah',
                'supplier' => $supplier
            ]);
        }
        return redirect()->route('Supplier.index')
            ->with('success', 'Supplier telah diperbaharui');
    }
    public function destroy(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Supplier berhasil dihapus',
            ]);
        }
        return redirect()->route('Supplier.index')
            ->with('success', 'Supplier telah dihapus');
    }
}
