<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    protected $fillable = [
        'nama_supplier',
        'no_telpon',
        'alamat'
    ];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_supplier');
    }
}
