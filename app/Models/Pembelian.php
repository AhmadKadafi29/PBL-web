<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $fillable = [
        'id_supplier',
        'tanggal_pembelian',
        'no_faktur',
        'total_harga',
        'status_pembayaran',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian');
    }

    public function pengembalian(): HasMany
    {
        return $this->hasMany(pengembalian_obat::class, 'id_pembelian');
    }

    public function detailobat(): HasMany
    {
        return $this->hasMany(DetailObat::class,'id_pembelian');
    }
}
