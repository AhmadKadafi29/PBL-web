<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detail_pengembalian_obat extends Model
{
    use HasFactory;
    protected $primarykey='id';
    protected $fillable=[
        'id_detail_obat',
        'id_pengembalian_obat',
        'Quantity',
        'stok_awal'
    ];

    public function pembelian():BelongsTo
    {
        return $this->belongsTo(pengembalian_obat::class,'id_pengembalian_obat');
    }
    public function detail_obat():BelongsTo
    {
        return $this->belongsTo(DetailObat::class,'id_detail_obat');
    }
}
