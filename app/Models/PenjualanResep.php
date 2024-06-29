<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanResep extends Model
{
    use HasFactory;
    protected $table = 'penjualan_resep';
    protected $primarykey = 'id';

    protected $fillable =[
        'nama_pasien',
        'alamat_pasien',
        'jenis_kelamin',
        'nama_dokter',
        'nomor_sip',
        'tanggal_penjualan',
        'tanggal_penulisan_resep'
    ];

    public function detail_penjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan_resep');
    }
}
