<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoriobat extends Model
{
    use HasFactory;
    protected $table = 'kategori_obat';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];
    public function obat()
    {
        return $this->hasMany(Obat::class, 'kategori_obat_id', 'id_kategori');
    }
}
