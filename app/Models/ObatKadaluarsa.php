<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatKadaluarsa extends Model
{
    use HasFactory;
    protected $table = 'obat_kadaluarsa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_obat',
        'tanggal_kadaluarsa'
    ];
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
