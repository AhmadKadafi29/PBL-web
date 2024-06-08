<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailObat extends Model
{
    use HasFactory;
    protected $table = 'detail_obat';
    protected $primaryKey = 'id_detail_obat';
    protected $fillable = [
        'id_detail_obat',
        'id_obat',
        'id_pembelian',
        'stok_obat',
        'tanggal_kadaluarsa',
        'harga_jual'
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
