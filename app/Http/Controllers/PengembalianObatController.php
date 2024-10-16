<?php

namespace App\Http\Controllers;

use App\Models\detail_pengembalian_obat;
use App\Models\DetailObat;
use App\Models\Pembelian;
use App\Models\pengembalian_obat;
use Illuminate\Http\Request;

class PengembalianObatController extends Controller
{
    public function index() {
        $datapengembalian = pengembalian_obat::paginate(10);
        return view('pages.pengembalian_obat.index', compact('datapengembalian'));
    }
    public function create()
    {
        return view('pages.pengembalian_obat.create');
    }

    public function searchFaktur(Request $request)
        
    {
       
            $noFaktur = $request->query('no_faktur');
            
            $pembelian = Pembelian::where('no_faktur', $noFaktur)
            ->with('supplier')
            ->with('detailPembelian.obat')
            ->with('detailobat') 
            ->get();

            $response = $pembelian->map(function ($item) {
                return [
                    'no_faktur' => $item->no_faktur,
                    'tanggal_pembelian' => $item->tanggal_pembelian,
                    'nama_supplier' => $item->supplier->nama_supplier,
                    'id_pembelian' => $item->id_pembelian,
            
                    'detail_pembelian' => $item->detailPembelian->map(function ($detail) {
                        return [
                            'no_batch' => $detail->no_batch,
                            'merek_obat' => $detail->obat->merek_obat,
                            'harga_satuan'=>$detail->harga_beli_satuan
                        ];
                    }),
            
                   
                    'stok' => $item->detailobat->map(function ($stok) {
                        return [
                            'stok_tersedia' => $stok->stok_obat,
                            'tanggal_kadaluarsa' => $stok->tanggal_kadaluarsa,
                            'id_detail_obat'=>$stok->id_detail_obat
                        ];
                    })
                ];
            });
            
            
        
            return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_faktur' => 'required|string',
            'tanggal_pengembalian' => 'required|date',
            'total' => 'required|numeric|min:0',
            'merek_obat' => 'required|array',
            'no_batch' => 'required|array',
            'stok_tersedia' => 'required|array',
            'jumlah_retur' => 'required|array',
            'jumlah_retur.*' => 'numeric|min:0',
            'no_batch.*' => 'string', 
        ]);
        
        $no_faktur = $request->no_faktur;
        $tanggal_pengembalian = $request->tanggal_pengembalian;
        $totalhargapengembalian= $request->total;

        $pembelian = Pembelian::where('no_faktur',$no_faktur)->first();
        $id_pembelian = $pembelian->id_pembelian;

        $idpengembalian = pengembalian_obat::create([
            'id_pembelian'=>$id_pembelian,
            'tanggal_pengembalian'=>$tanggal_pengembalian,
            'total_pengembalian'=>$totalhargapengembalian
        ]);

        $id_pengembalian = $idpengembalian->id;

        $merek_obats = $request->input('merek_obat');
        $no_batches = $request->input('no_batch');       
        $jumlah_returs = $request->input('jumlah_retur');

       for($i=0; $i<count($merek_obats) ; $i++){

        $detail_obat = DetailObat::where('no_batch', $no_batches[$i])->first();

        if ($detail_obat) {
            $id_detail_obat = $detail_obat->id_detail_obat;
            $quantity =$detail_obat->stok_obat;
            $jumlah_retur = $jumlah_returs[$i];

         
            if ($quantity < $jumlah_retur) {
              
                return redirect()->back()->with(['error' => 'Jumlah retur tidak boleh lebih dari stok tersedia untuk obat ' . $merek_obats[$i]]);
            }


        detail_pengembalian_obat::create([
            'id_pengembalian_obat'=>$id_pengembalian,
            'Quantity'=>$jumlah_returs[$i],
            'id_detail_obat'=>$id_detail_obat
        ]);

        $sisa_obat = $quantity-$jumlah_returs[$i];
        if($sisa_obat==0){
            $detail_obat->delete();

        }else{
            $detail_obat->update([
                'stok_obat' => $sisa_obat
            ]);
        }
        


        } else {
            return redirect()->back()->with('error', 'Detail obat tidak ditemukan untuk no_batch: ' . $no_batches[$i]);
             
        }

        
           
    }
    return redirect()->route('pengembalian-obat.index')->with('success', 'data pengembalian obat berhasil ditambahkan');
       


       
    }

    public function show($id){

        $datadetailpengembalian= detail_pengembalian_obat::where('id_pengembalian_obat', $id)
        ->with('detail_obat')->get();

        return view('pages.pengembalian_obat.show', compact('datadetailpengembalian'));
        //dd($datadetailpengembalian);

    }

    
}
