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
use Illuminate\Support\Facades\Validator;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pembelian = Pembelian::paginate(10);
        $supplier = Supplier::paginate(10);
        return view('pages.pembelian.index', compact('pembelian', 'supplier'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $supplier = Supplier::all();
        $obat = Obat::with('satuans.detailSatuans')->get();

        return view('pages.pembelian.create', compact('obat', 'supplier'));
    }

    public function search(Request $request)

    {
        $name = $request->get('name');
        $obat = Obat::where('merek_obat', 'LIKE', '%' . $name . '%')->get();
        return response()->json($obat);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_supplier' => 'required|integer|exists:supplier,id_supplier',
            'no_faktur' => 'required|string|max:255|unique:pembelian,no_faktur',
            'tanggal_pembelian' => 'required|date',
            'total_harga' => 'required|numeric|min:0',
            'merek_obat' => 'required|array|min:1',
            'merek_obat.*' => 'required|integer|exists:obat,id_obat',
            'jumlah_obat' => 'required|array|min:1',
            'jumlah_obat.*' => 'required|integer|min:1',
            'harga_beli' => 'required|array|min:1',
            'harga_beli.*' => 'required|numeric|min:0',
            'tanggal_kadaluarsa' => 'required|array|min:1',
            'tanggal_kadaluarsa.*' => 'required|date',
            'no_batch' => 'required|array|min:1',
            'no_batch.*' => 'required|string|max:50',
            'harga_jual' => 'required|array|min:1',
            'harga_jual.*' => 'required|array|min:2',
            'harga_jual.*.*' => 'required|numeric|min:0',
        ]);

        // dd($request->all());

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator);
        // }

        // Simpan data pembelian
        $pembelian = Pembelian::create([
            'id_supplier' => $request->id_supplier,
            'no_faktur' => $request->no_faktur,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'total_harga' => $request->total_harga,
            'status_pembayaran' => 'lunas',
        ]);

        // Simpan detail pembelian dan stok
        $merek_obats = $request->input('merek_obat');
        $jumlah_obats = $request->input('jumlah_obat');
        $harga_belis = $request->input('harga_beli');
        $tanggal_kadaluarsas = $request->input('tanggal_kadaluarsa');
        $no_batchs = $request->input('no_batch');
        $harga_jual1 = $request->input('harga_jual1');
        $harga_jual2 = $request->input('harga_jual2');

        // dd($harga_jual1[0]);

        foreach ($merek_obats as $i => $id_obat) {
            $obat = Obat::with('satuans.detailSatuans')->find($id_obat);
            $detail_satuan = $obat->satuans->first();

            $satuan_terkecil_1 = $obat->satuan_terkecil_1;
            $jumlah_satuan_terkecil_1 = $obat->jumlah_satuan_terkecil_1;

            $detail_satuan_terkecil_2 = $detail_satuan->detailSatuans->first();
            $satuan_terkecil_2 = $detail_satuan_terkecil_2?->satuan_terkecil;
            $jumlah_satuan_terkecil_2 = $detail_satuan_terkecil_2?->jumlah ?? 0;

            $stok_terkecil_1 = $jumlah_obats[$i] * $jumlah_satuan_terkecil_1;
            $stok_terkecil_2 = $jumlah_obats[$i] * $jumlah_satuan_terkecil_1 * $jumlah_satuan_terkecil_2;



            DetailPembelian::create([
                'id_pembelian' => $pembelian->id_pembelian,
                'id_obat' => $id_obat,
                'harga_beli_satuan' => $harga_belis[$i],
                'quantity' => $jumlah_obats[$i],
                'no_batch' => $no_batchs[$i],
            ]);

            DetailObat::create([
                'id_pembelian' => $pembelian->id_pembelian,
                'id_obat' => $id_obat,
                'stok_obat_terkecil_1' => $stok_terkecil_1,
                'stok_obat_terkecil_2' => $stok_terkecil_2,
                'harga_jual_1' => $harga_jual1[0],
                'harga_jual_2' => $harga_jual2[0],
                'tanggal_kadaluarsa' => $tanggal_kadaluarsas[$i],
                'no_batch' => $no_batchs[$i],
            ]);
        }

        return redirect()->route('Pembelian.index')->with('success', 'Pembelian berhasil ditambahkan.');
    }



    private function generateNoFaktur($request)
    {
        return "{$request->id_supplier}" . date('Ymd', strtotime($request->tanggal_pembelian));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function show($id_pembelian)
    {
        $pembelian = Pembelian::findOrFail($id_pembelian);
        $supplier = Supplier::all();
        $obat = Obat::all();
        $detailpembelian = DetailPembelian::where('id_pembelian', $id_pembelian)->get();
        return view('pages.pembelian.show', compact('pembelian', 'supplier', 'obat', 'detailpembelian'));
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
