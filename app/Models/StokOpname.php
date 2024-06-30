<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;
    protected $table = 'stok_opname';
    protected $primaryKey ='id_stok_opname';
    protected $fillable = [
        'id_obat',
        'id_user',
        'stok_fisik',
        'tanggal_opname',
        'harga_jual_satuan',
        'stok_sistem'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
