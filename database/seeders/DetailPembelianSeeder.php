<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_pembelian')->insert([
            ['id_pembelian' => 1, 'id_obat' => 1, 'no_batch' => 'BATCH001', 'harga_beli_satuan' => 10000, 'quantity' => 10],
            ['id_pembelian' => 2, 'id_obat' => 2, 'no_batch' => 'BATCH002', 'harga_beli_satuan' => 17000, 'quantity' => 20],
            ['id_pembelian' => 3, 'id_obat' => 3, 'no_batch' => 'BATCH003', 'harga_beli_satuan' => 13000, 'quantity' => 30],
            ['id_pembelian' => 4, 'id_obat' => 4, 'no_batch' => 'BATCH004', 'harga_beli_satuan' => 16000, 'quantity' => 40],
            ['id_pembelian' => 5, 'id_obat' => 5, 'no_batch' => 'BATCH005', 'harga_beli_satuan' => 20000, 'quantity' => 50],
            ['id_pembelian' => 6, 'id_obat' => 6, 'no_batch' => 'BATCH006', 'harga_beli_satuan' => 11000, 'quantity' => 60],
            ['id_pembelian' => 7, 'id_obat' => 7, 'no_batch' => 'BATCH007', 'harga_beli_satuan' => 18000, 'quantity' => 70],
            ['id_pembelian' => 8, 'id_obat' => 8, 'no_batch' => 'BATCH008', 'harga_beli_satuan' => 14000, 'quantity' => 80],
            ['id_pembelian' => 9, 'id_obat' => 9, 'no_batch' => 'BATCH009', 'harga_beli_satuan' => 11500, 'quantity' => 90],
            ['id_pembelian' => 10, 'id_obat' => 10, 'no_batch' => 'BATCH010', 'harga_beli_satuan' => 17500, 'quantity' => 100],
        ]);
    }
}
