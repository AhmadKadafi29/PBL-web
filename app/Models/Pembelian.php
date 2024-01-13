<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_obat',
        'id_supplier',
        'noFaktur',
        'harga_satuan',
        'quantity',
        'total_harga',
        'tanggal_pembelian',
        'status_pembayaran'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
