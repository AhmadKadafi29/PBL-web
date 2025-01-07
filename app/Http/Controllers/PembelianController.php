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
use Log;

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
        $obat = Obat::where('merek_obat', 'LIKE', '%' . $name . '%')
        ->with('satuans.detailSatuans')->get();
        return response()->json($obat);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
     
    	Log::debug('Received data: ', $request->all());
        $data = $request->all(); 
        $nama_supplier = $data[0]['id_supplier']; 
        $no_faktur = $data[0]['no_faktur'];
        $tanggal_pembelian = $data[0]['tanggal_pembelian'];
        $total_harga = $data[0]['total_harga'];

        if (Pembelian::where('no_faktur', $no_faktur)->first()) {
            return response()->json([
                'success' => false,
                'message' => 'No faktur sudah ada dalam database. Silakan gunakan nomor faktur yang berbeda.'
            ], 400);
        }
        $idpembelian =Pembelian::create([
            'id_supplier' => $nama_supplier,
            'tanggal_pembelian'=>$tanggal_pembelian,
            'no_faktur'=>$no_faktur,
            'total_harga'=>$total_harga,
            'status_pembayaran'=>'lunas',
        ]);
       
        $id_pembelian = $idpembelian->id_pembelian;


        $dataobat = $data[0]['obat_list'];

        for($i = 0; $i < count($dataobat); $i++) {
            DetailPembelian::create([
               'id_pembelian' => $id_pembelian,
                'id_obat' => $dataobat[$i]['id_obat'],  
                'harga_beli_satuan' => $dataobat[$i]['harga_beli'],
                'quantity' => $dataobat[$i]['jumlah'],
                'no_batch' => $dataobat[$i]['no_batch'],
            ]);
            
            $obat = Obat::with('satuans.detailSatuans')->find($dataobat[$i]['id_obat']);
            $jumlah_satuan_terkecil1 = $obat->satuans[0]->jumlah_satuan_terkecil_1;
            $jumlah_satuan_terkecil = isset($obat->satuans[0]->detailSatuans[0]->jumlah) ? $obat->satuans[0]->detailSatuans[0]->jumlah : 0;
            DetailObat::create([
                'id_pembelian' => $id_pembelian, 
                'id_obat'=>$dataobat[$i]['id_obat'],
                'stok_satuan_terkecil_1'=> $dataobat[$i]['jumlah'] * $jumlah_satuan_terkecil1,
                'stok_satuan_terkecil_2'=> ( $dataobat[$i]['jumlah'] * $jumlah_satuan_terkecil1) * $jumlah_satuan_terkecil,
                'tanggal_kadaluarsa' =>$dataobat[$i]['tanggal_exp'],
                'harga_jual_1'=>$dataobat[$i]['harga_jual1'],
                'harga_jual_2'=>$dataobat[$i]['harga_jual2'],
                'no_batch' => $dataobat[$i]['no_batch'],
               
            ]);
        }
        session()->flash('success', 'Pembelian berhasil ditambahkan!');
        return response()->json(['success' => true, 'redirect_url' => route('Pembelian.index')]);

    
   
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
