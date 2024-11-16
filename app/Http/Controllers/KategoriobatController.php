<?php

namespace App\Http\Controllers;

use App\Models\Kategoriobat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriobatController extends Controller
{
    public function index(Request $request)
    {
        $kategoriobat = Kategoriobat::when($request->input('nama_kategori'), function ($query, $nama_kategori) {
            return $query->where('nama_kategori', 'like', '%' . $nama_kategori . '%');
        })
            ->orderBy('id_kategori', 'asc')
            ->paginate(10);
        return view('pages.kategori_obat.index', compact('kategoriobat'));
    }
    public function create()
    {
        return view('pages.kategori_obat.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kategori' => 'required|string|min:5|max:20|regex:/^[a-zA-Z\s]+$/|unique:kategori_obat,nama_kategori'
            ],
            [
                'nama_kategori.required' => 'nama kategori wajib diisi',
                'nama_kategori.min' => 'nama kategori tidak boleh kurang 5 karakter',
                'nama_kategori.unique' => 'nama kategori sudah ada',
                'nama_kategori.regex' => 'nama kategori tidak boleh mengandung angka',
                'nama_kategori.string' => 'nama kategori harus huruf',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Kategoriobat::create($request->all());
        return redirect()->route('Kategori.index')
            ->with('success', 'Kategori Obat telah tersimpan.');
    }

    public function edit($id_kategori)
    {
        $ko = Kategoriobat::find($id_kategori);
        return view('pages.kategori_obat.edit', compact('ko'));
    }

    public function update(Request $request, $id_kategori)
    {
        $validator = Validator::make($request->all(),[
                'nama_kategori' => 'required|string|min:5|max:20|regex:/^[a-zA-Z\s]+$/|unique:kategori_obat,nama_kategori'
        ],[
                'nama_kategori.required' => 'nama kategori wajib diisi',
                'nama_kategori.min' => 'nama kategori tidak boleh kurang 5 karakter',
                'nama_kategori.unique' => 'nama kategori sudah ada',
                'nama_kategori.regex' => 'nama kategori tidak boleh mengandung angka',
                'nama_kategori.string' => 'nama kategori harus huruf',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ko = Kategoriobat::find($id_kategori);
        $ko->update($request->all());

        return redirect()->route('Kategori.index')
            ->with('success', 'Kategori Bibliografi telah diperbaharui');
    }
    public function destroy(Request $request, $id_kategori)
    {
        $ko = Kategoriobat::find($id_kategori);
        $ko->delete();
        return redirect()->route('Kategori.index')
            ->with('success', 'Kategori obat telah dihapus');
    }
}
