<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $data=Supplier::all();
        return response()->json([
            'data'=>$data
        ]);
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
        return response()->json([
            'message' => 'Supplier berhasil ditambah',
            'supplier' => $supplier
        ]);
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

        return response()->json([
            'message' => 'Supplier berhasil diubah',
            'supplier' => $supplier
        ]);
    }
    public function destroy(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return response()->json([
            'message' => 'Supplier berhasil dihapus',
        ]);
    }
}
