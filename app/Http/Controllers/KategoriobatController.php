<?php

namespace App\Http\Controllers;

use App\Models\Kategori_obat;
use Illuminate\Http\Request;

class KategoriobatController extends Controller
{
    public function index(Request $request)
    {
        $kategoriobat = Kategori_obat::all();
        if ($request->wantsJson()) {
            return response()->json($kategoriobat);
        }
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

        $kategoriobat = Kategori_obat::create($request->all());
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'kategori berhasil ditambah',
                'kategori_obat' => $kategoriobat
            ]);
        }
        return redirect()->route('Kategori.index')
            ->with('success', 'Kategori Obat telah tersimpan.');
    }

    public function edit($id)
    {
        $ko = Kategori_obat::find($id);
        return view('pages.kategori_obat.edit', compact('ko'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100',
        ]);

        $ko = Kategori_obat::find($id);
        $ko->update($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'kategori obat berhasil diubah',
                'kategori_obat' => $ko
            ]);
        }
        return redirect()->route('Kategori.index')
            ->with('success', 'Kategori Bibliografi telah diperbaharui');
    }
    public function destroy(Request $request, $id)
    {
        $ko = Kategori_obat::find($id);
        $ko->delete();
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'kategori obat berhasil dihapus',
                'kategori_obat' => $ko
            ]);
        }
        return redirect()->route('Kategori.index')
            ->with('success', 'Kategori obat telah dihapus');
    }
}
