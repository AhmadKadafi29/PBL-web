<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;
    protected $table = 'stok_opname';
    protected $fillable = [
        'id_obat',
        'id_user',
        'stok_fisik',
        'status',
        'tanggal_opname'
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
