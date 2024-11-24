<?php

namespace Database\Seeders;

use App\Models\DetailObat;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_obat')->insert([
            [
                'id_obat' => 1,
                'id_pembelian' => 1,
                'no_batch' => 'BATCH001',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 10000,
                'harga_jual_2' => 5000, // Contoh harga jual untuk satuan terkecil 2
                'stok_satuan_terkecil_1' => 10,
                'stok_satuan_terkecil_2' => 50,
            ],
            [
                'id_obat' => 2,
                'id_pembelian' => 2,
                'no_batch' => 'BATCH002',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 15000,
                'harga_jual_2' => 7500,
                'stok_satuan_terkecil_1' => 20,
                'stok_satuan_terkecil_2' => 100,
            ],
            [
                'id_obat' => 3,
                'id_pembelian' => 3,
                'no_batch' => 'BATCH003',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 20000,
                'harga_jual_2' => 0, // Harga jual 2 menjadi 0 karena stok terkecil 2 adalah 0
                'stok_satuan_terkecil_1' => 30,
                'stok_satuan_terkecil_2' => 0,
            ],
            [
                'id_obat' => 4,
                'id_pembelian' => 4,
                'no_batch' => 'BATCH004',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 25000,
                'harga_jual_2' => 0,
                'stok_satuan_terkecil_1' => 40,
                'stok_satuan_terkecil_2' => 0,
            ],
            [
                'id_obat' => 5,
                'id_pembelian' => 5,
                'no_batch' => 'BATCH005',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 30000,
                'harga_jual_2' => 0,
                'stok_satuan_terkecil_1' => 50,
                'stok_satuan_terkecil_2' => 0,
            ],
            [
                'id_obat' => 6,
                'id_pembelian' => 6,
                'no_batch' => 'BATCH006',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 35000,
                'harga_jual_2' => 0,
                'stok_satuan_terkecil_1' => 60,
                'stok_satuan_terkecil_2' => 0,
            ],
            [
                'id_obat' => 7,
                'id_pembelian' => 7,
                'no_batch' => 'BATCH007',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 40000,
                'harga_jual_2' => 0,
                'stok_satuan_terkecil_1' => 70,
                'stok_satuan_terkecil_2' => 0,
            ],
            [
                'id_obat' => 8,
                'id_pembelian' => 8,
                'no_batch' => 'BATCH008',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 45000,
                'harga_jual_2' => 0,
                'stok_satuan_terkecil_1' => 80,
                'stok_satuan_terkecil_2' => 0,
            ],
            [
                'id_obat' => 9,
                'id_pembelian' => 9,
                'no_batch' => 'BATCH009',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 50000,
                'harga_jual_2' => 25000,
                'stok_satuan_terkecil_1' => 90,
                'stok_satuan_terkecil_2' => 980,
            ],
            [
                'id_obat' => 10,
                'id_pembelian' => 10,
                'no_batch' => 'BATCH010',
                'tanggal_kadaluarsa' => Carbon::now()->addYear(),
                'harga_jual_1' => 55000,
                'harga_jual_2' => 0,
                'stok_satuan_terkecil_1' => 100,
                'stok_satuan_terkecil_2' => 0,
            ],
        ]);
        
    }
}
