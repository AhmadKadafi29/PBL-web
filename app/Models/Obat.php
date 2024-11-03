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
        'kode_obat',
        'merek_obat',
        'dosis',
        'kegunaan',
        'efek_samping',
        'kemasan',
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
        return $this->belongsTo(Kategoriobat::class, 'kategori_obat_id');
    }

    public function stokopname()
    {
        return $this->hasMany(StokOpname::class, 'id_obat');
    }

    public function detailsatuan(): HasMany
    {
        return $this->hasMany(detailsatuan::class,'id_obat');

    }
}
