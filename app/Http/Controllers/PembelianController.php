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
      
        $nama_supplier = $request->input("id_supplier");
        $no_faktur = $request->input('no_faktur');
        $tanggal_pembelian = $request->input('tanggal_pembelian');
        $total_harga = $request->input('total_harga');
        $idpembelian =Pembelian::create([
            'id_supplier' => $nama_supplier,
            'tanggal_pembelian'=>$tanggal_pembelian,
            'no_faktur'=>$no_faktur,
            'total_harga'=>$total_harga,
            'status_pembayaran'=>'lunas',

        ]);
        $id_pembelian = $idpembelian->id_pembelian;

        $merek_obats = $request->input('merek_obat');
        $satuans = $request->input('satuan');
        $jumlah_obats = $request->input('jumlah_obat');
        $harga_belis = $request->input('harga_beli');
        $tanggal_kadaluarsas = $request->input('tanggal_kadaluarsa');
        $jumlah_obats = $request->input('jumlah_obat');
        $no_batchs = $request->input('no_batch');
        $harga_juals = $request->input('harga_jual');
        $jumlah_obats = $request->input('jumlah_obat');
        for($i=0; $i<count($merek_obats) ; $i++){
           
            DetailPembelian::create([
                'id_pembelian'=>  $id_pembelian,
                'id_obat'=>$merek_obats[$i],
                'harga_beli_satuan' => $harga_belis[$i],
                'quantity'=>$jumlah_obats[$i],
                'no_batch' => $no_batchs[$i]
            ]);
               
        }

        for($i=0; $i<count($merek_obats) ; $i++){
            $obat = Obat::with('detailsatuan')->find($merek_obats[$i]);
            $konversi_ke_satuan_terkecil = $obat->detailsatuan->max('satuan_konversi');

            DetailObat::create([
                'id_pembelian' => $idpembelian->id_pembelian, 
                'id_obat'=>$merek_obats[$i],
                'stok_obat' => $jumlah_obats[$i] * $konversi_ke_satuan_terkecil,
                'tanggal_kadaluarsa' => $tanggal_kadaluarsas[$i],
                'harga_jual'=>$harga_juals[$i],
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
