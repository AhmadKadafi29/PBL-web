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
            ['id_obat' => 1, 'id_pembelian' => 1, 'stok_obat' => 100, 'no_batch' => 'BATCH001', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 10000],
            ['id_obat' => 2, 'id_pembelian' => 2, 'stok_obat' => 200, 'no_batch' => 'BATCH002', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 15000],
            ['id_obat' => 3, 'id_pembelian' => 3, 'stok_obat' => 300, 'no_batch' => 'BATCH003', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 20000],
            ['id_obat' => 4, 'id_pembelian' => 4, 'stok_obat' => 400, 'no_batch' => 'BATCH004', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 25000],
            ['id_obat' => 5, 'id_pembelian' => 5, 'stok_obat' => 500, 'no_batch' => 'BATCH005', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 30000],
            ['id_obat' => 6, 'id_pembelian' => 6, 'stok_obat' => 600, 'no_batch' => 'BATCH006', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 35000],
            ['id_obat' => 7, 'id_pembelian' => 7, 'stok_obat' => 700, 'no_batch' => 'BATCH007', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 40000],
            ['id_obat' => 8, 'id_pembelian' => 8, 'stok_obat' => 800, 'no_batch' => 'BATCH008', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 45000],
            ['id_obat' => 9, 'id_pembelian' => 9, 'stok_obat' => 900, 'no_batch' => 'BATCH009', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 50000],
            ['id_obat' => 10, 'id_pembelian' => 10, 'stok_obat' => 1000, 'no_batch' => 'BATCH010', 'tanggal_kadaluarsa' => Carbon::now()->addYear(), 'harga_jual' => 55000],
        ]);
    }
}
