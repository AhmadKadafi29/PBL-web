<?php

namespace App\Http\Controllers;

use App\Models\Kategoriobat;
use Illuminate\Http\Request;

class KategoriobatController extends Controller
{
    public function index(Request $request)
    {
        $kategoriobat = Kategoriobat::all();

        return view('pages.kategori_obat.index', compact('kategoriobat'));
    }
    public function create()
    {
        return view('pages.kategori_obat.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100',
        ]);

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
        $request->validate([
            'nama_kategori' => 'required|max:100',
        ]);

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
