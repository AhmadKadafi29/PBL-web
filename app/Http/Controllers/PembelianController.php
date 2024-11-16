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
        $obat = Obat::with('detailsatuan.satuan')->get();

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
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'id_supplier' => 'required|integer|exists:supplier,id_supplier',
            'no_faktur' => 'required|string|max:255|unique:pembelian,no_faktur',
            'tanggal_pembelian' => 'required|date',
            'total_harga' => 'required|numeric|min:0',
            'merek_obat' => 'required|array|min:1',
            'merek_obat.*' => 'required|integer|exists:obats,id_obat',
            'satuan' => 'required|array|min:1',  
            'satuan.*' => 'required|string|max:50',  
            'jumlah_obat' => 'required|array|min:1', 
            'jumlah_obat.*' => 'required|integer|min:1',  
            'harga_beli' => 'required|array|min:1',  
            'harga_beli.*' => 'required|numeric|min:0',  
            'tanggal_kadaluarsa' => 'required|array|min:1',  
            'tanggal_kadaluarsa.*' => 'required|date',  
            'no_batch' => 'required|array|min:1',  
            'no_batch.*' => 'required|string|max:50',  
            'harga_jual' => 'required|array|min:1',  
            'harga_jual.*' => 'required|numeric|min:0',  
        ], [
            'id_supplier.required' => 'Supplier wajib diisi.',
            'id_supplier.integer' => 'ID Supplier harus berupa angka.',
            'id_supplier.exists' => 'Supplier yang dipilih tidak valid.',
            'no_faktur.required' => 'Nomor faktur wajib diisi.',
            'no_faktur.string' => 'Nomor faktur harus berupa teks.',
            'no_faktur.max' => 'Nomor faktur maksimal 255 karakter.',
            'no_faktur.unique' => 'Nomor faktur sudah digunakan.',
            'tanggal_pembelian.required' => 'Tanggal pembelian wajib diisi.',
            'tanggal_pembelian.date' => 'Tanggal pembelian harus dalam format tanggal yang valid.',
            'total_harga.required' => 'Total harga wajib diisi.',
            'total_harga.numeric' => 'Total harga harus berupa angka.',
            'total_harga.min' => 'Total harga tidak boleh kurang dari 0.',
            'merek_obat.required' => 'Merek obat wajib diisi.',
            'merek_obat.array' => 'Merek obat harus berupa array.',
            'merek_obat.*.required' => 'Merek obat wajib diisi.',
            'merek_obat.*.integer' => 'Merek obat harus berupa angka.',
            'merek_obat.*.exists' => 'Merek obat yang dipilih tidak valid.',
            'satuan.required' => 'Satuan obat wajib diisi.',
            'satuan.array' => 'Satuan harus berupa array.',
            'satuan.*.required' => 'Satuan obat wajib diisi.',
            'satuan.*.string' => 'Satuan harus berupa teks.',
            'satuan.*.max' => 'Satuan maksimal 50 karakter.',
            'jumlah_obat.required' => 'Jumlah obat wajib diisi.',
            'jumlah_obat.array' => 'Jumlah obat harus berupa array.',
            'jumlah_obat.*.required' => 'Jumlah obat wajib diisi.',
            'jumlah_obat.*.integer' => 'Jumlah obat harus berupa angka positif.',
            'harga_beli.required' => 'Harga beli obat wajib diisi.',
            'harga_beli.array' => 'Harga beli harus berupa array.',
            'harga_beli.*.required' => 'Harga beli obat wajib diisi.',
            'harga_beli.*.numeric' => 'Harga beli harus berupa angka.',
            'harga_beli.*.min' => 'Harga beli tidak boleh kurang dari 0.',
            'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa obat wajib diisi.',
            'tanggal_kadaluarsa.array' => 'Tanggal kadaluarsa harus berupa array.',
            'tanggal_kadaluarsa.*.required' => 'Tanggal kadaluarsa wajib diisi.',
            'tanggal_kadaluarsa.*.date' => 'Tanggal kadaluarsa harus dalam format tanggal yang valid.',
            'no_batch.required' => 'Nomor batch obat wajib diisi.',
            'no_batch.array' => 'Nomor batch harus berupa array.',
            'no_batch.*.required' => 'Nomor batch wajib diisi.',
            'no_batch.*.string' => 'Nomor batch harus berupa teks.',
            'no_batch.*.max' => 'Nomor batch maksimal 50 karakter.',
            'harga_jual.required' => 'Harga jual obat wajib diisi.',
            'harga_jual.array' => 'Harga jual harus berupa array.',
            'harga_jual.*.required' => 'Harga jual obat wajib diisi.',
            'harga_jual.*.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.*.min' => 'Harga jual tidak boleh kurang dari 0.',
        ]);

        // Mengecek jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Melakukan proses penyimpanan pembelian
        $nama_supplier = $request->input("id_supplier");
        $no_faktur = $request->input('no_faktur');
        $tanggal_pembelian = $request->input('tanggal_pembelian');
        $total_harga = $request->input('total_harga');

        $idpembelian = Pembelian::create([
            'id_supplier' => $nama_supplier,
            'tanggal_pembelian' => $tanggal_pembelian,
            'no_faktur' => $no_faktur,
            'total_harga' => $total_harga,
            'status_pembayaran' => 'lunas',
        ]);

        $id_pembelian = $idpembelian->id_pembelian;

        $merek_obats = $request->input('merek_obat');
        $satuans = $request->input('satuan');
        $jumlah_obats = $request->input('jumlah_obat');
        $harga_belis = $request->input('harga_beli');
        $tanggal_kadaluarsas = $request->input('tanggal_kadaluarsa');
        $no_batchs = $request->input('no_batch');
        $harga_juals = $request->input('harga_jual');

        // Menyimpan detail pembelian
        for ($i = 0; $i < count($merek_obats); $i++) {
            DetailPembelian::create([
                'id_pembelian' => $id_pembelian,
                'id_obat' => $merek_obats[$i],
                'harga_beli_satuan' => $harga_belis[$i],
                'quantity' => $jumlah_obats[$i],
                'no_batch' => $no_batchs[$i]
            ]);
        }

        // Menyimpan detail obat
        for ($i = 0; $i < count($merek_obats); $i++) {
            $obat = Obat::with('detailsatuan')->find($merek_obats[$i]);
            $konversi_ke_satuan_terkecil = $obat->detailsatuan->max('satuan_konversi');

            DetailObat::create([
                'id_pembelian' => $idpembelian->id_pembelian,
                'id_obat' => $merek_obats[$i],
                'stok_obat' => $jumlah_obats[$i] * $konversi_ke_satuan_terkecil,
                'tanggal_kadaluarsa' => $tanggal_kadaluarsas[$i],
                'harga_jual' => $harga_juals[$i],
                'no_batch' => $no_batchs[$i]
            ]);
        }

        return redirect()->route('Pembelian.index')->with('success', 'Pembelian berhasil ditambahkan');
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
