<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $table = 'satuans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_obat',
        'satuan_terbesar',
        'satuan_terkecil_1',
        'jumlah_satuan_terkecil_1',
    ];

    public function obats()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id_obat');
    }

    public function detailSatuans()
    {
        return $this->hasMany(DetailSatuan::class, 'id_satuan', 'id');
    }
}
