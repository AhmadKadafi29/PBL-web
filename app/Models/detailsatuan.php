<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detailsatuan extends Model
{
    use HasFactory;
    protected $table = 'detail_satuans';
    protected $primaryKey ='id_detail_satuan';
    protected $fillable = [
        'id_obat',
        'id_satuan',
        'satuan_konversi',
      
    ];

    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class,'id_obat');
    }

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(satuan::class,'id_satuan');
    }
}
