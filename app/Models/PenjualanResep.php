<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanResep extends Model
{
    use HasFactory;
    protected $table = 'penjualan_resep';
    protected $primarykey = 'id_penjualan_resep';

    protected $fillable =[
        'nama_pasien',
        'alamat_pasien',
        'jenis_kelamin',
        'nama_dokter',
        'nomor_sip',
        'tanggal_penjualan'
    ];

    public function detail_penjualan(){
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan_resep');
    }
}
