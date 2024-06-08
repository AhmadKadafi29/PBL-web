<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $table = 'detail_pembelian';
    protected $primaryKey = 'id_detail_pembelian';
    protected $fillable = [
        'id_pembelian',
        'id_obat',
        'harga_beli_satuan',
        'quantity',
        // 'harga_jual_satuan'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
