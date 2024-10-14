<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class pengembalian_obat extends Model
{
    use HasFactory;
    protected $primarykey = "id";

    protected $fillable =[
        "id_pembelian",
        "tanggal_pengembalian",
        "Total"
    ];

    public function pembelian():BelongsTo
    {
        return $this->belongsTo(Pembelian::class,'id_pembelian');
    }

    public function detail_pengembalian(): HasMany
    {
        return $this->hasMany(detail_pengembalian_obat::class,'id_pengembalian_obat');
    }

}
