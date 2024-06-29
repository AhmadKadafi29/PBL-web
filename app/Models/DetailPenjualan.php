<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id_detail_penjualan';
    protected $fillable=[
        'id_obat',
        'id_penjualan',
        'id_penjualan_resep',
        'harga_jual_satuan',
        'harga_beli_satuan',
        'jumlah_jual'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    public function penjualan_resep()
    {
        return $this->belongsTo(PenjualanResep::class,'id_penjualan_resep');
    }
}
