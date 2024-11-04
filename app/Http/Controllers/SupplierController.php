<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
            'nama_supplier' => 'required|string|min:5|max:30|regex:/^[a-zA-Z\s]*$/',
            'no_telpon' => 'required|digits:12|regex:/^08[0-9]*$/',
            'alamat' => 'required|string|min:5|max:255'
        ], [
            'nama_supplier.required' => 'Nama supplier harus diisi.',
            'nama_supplier.string' => 'Nama supplier harus berupa teks.',
            'nama_supplier.min' => 'Nama supplier minimal 5 karakter.',
            'nama_supplier.max' => 'Nama supplier maksimal 30 karakter.',
            'nama_supplier.regex' => 'Nama supplier hanya boleh mengandung huruf dan spasi.',
            'no_telpon.required' => 'Nomor telepon harus diisi.',
            'no_telpon.digits' => 'Nomor telepon harus terdiri dari 12 digit.',
            'no_telpon.regex' => 'Nomor telepon harus diawali dengan 08.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.min' => 'Alamat minimal 5 karakter.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
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
