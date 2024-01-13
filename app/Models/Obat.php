<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;
    protected $table = 'obat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_obat',
        'jenis_obat',
        'kategori_obat_id',
        'stok_obat',
        'harga_obat',
        'tanggal_masuk',
        'exp_date',
        'status'
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'id_obat', 'id_obat');
    }

    public function Kategoriobat()
    {
        return $this->belongsTo(Kategori_obat::class, 'kategori_obat_id');
    }

    public function kadaluarsas()
    {
        return $this->hasMany(ObatKadaluarsa::class, 'id_obat');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_obat');
    }

    public function stokopname()
    {
        return $this->hasMany(StokOpname::class, 'id_obat');
    }
}
