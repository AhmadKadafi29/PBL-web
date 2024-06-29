<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class supplierController extends Controller
{
    public function index(Request $request)
    {
        $supplier = Supplier::when($request->input('name'), function($query, $name){
            return $query->where('nama_supplier', 'like' ,'%'.$name.'%');
        })->paginate(10);
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

        Supplier::create($request->all());

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


        return redirect()->route('Supplier.index')
            ->with('success', 'Supplier telah diperbarui');
    }
    public function destroy(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return redirect()->route('Supplier.index')
            ->with('success', 'Supplier telah dihapus');
    }
}
