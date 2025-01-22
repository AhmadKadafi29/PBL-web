<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Obat extends Model
{
    use HasFactory;
    protected $table = 'obat';
    protected $primaryKey = 'id_obat';
    protected $fillable = [
        'kategori_obat_id',
        'nama_obat',
        'merek_obat',
        'deskripsi_obat',
        'efek_samping',
    ];


    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class, 'id_obat');
    }

    public function detailObat()
    {
        return $this->hasMany(DetailObat::class, 'id_obat');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_obat');
    }

    public function kategoriObat()
    {
        return $this->belongsTo(Kategoriobat::class, 'kategori_obat_id', 'id_kategori');
    }

    public function stokopname()
    {
        return $this->hasMany(StokOpname::class, 'id_obat');
    }

    public function satuans()
    {
        return $this->hasMany(Satuan::class, 'id_obat', 'id_obat');
    }
    public function detailSatuans()
    {
        return $this->hasMany(DetailSatuan::class, 'id_obat', 'id');
    }
}
