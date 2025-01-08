<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailsatuan extends Model
{
    use HasFactory;
    protected $table = 'detail_satuans';
    protected $primaryKey = 'id_detail_satuan';
    protected $fillable = [
        'id_satuan',
        'satuan_terkecil',
        'jumlah',

    ];


    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id');
    }
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id');
    }
}
