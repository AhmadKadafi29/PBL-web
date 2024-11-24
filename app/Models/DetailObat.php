<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailObat extends Model
{
    use HasFactory;
    protected $table = 'detail_obat';
    protected $primaryKey = 'id_detail_obat';
    protected $fillable = [
        'id_obat',
        'id_pembelian',
        'stok_satuan_terkecil_1',
        'stok_satuan_terkecil_2',
        'harga_jual_1',
        'harga_jual_2',
        'tanggal_kadaluarsa',
        'no_batch'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    public function detail_pengembalian(): HasMany
    {
        return $this->hasMany(detail_pengembalian_obat::class, 'id_detail_obat');
    }
}
