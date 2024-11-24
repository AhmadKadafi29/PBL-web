<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailsatuan extends Model
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
        return $this->belongsTo(Satuan::class, 'id_satuan');
    }
}
