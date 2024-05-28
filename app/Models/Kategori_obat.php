<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_obat extends Model
{
    use HasFactory;
    protected $table = 'kategori_obat';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori'];
    public function Obat()
    {
        return $this->belongsTo(Obat::class, 'kategori_obat_id');
    }
}
