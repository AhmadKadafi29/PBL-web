<?php

namespace Database\Seeders;

use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembelian')->insert([
            ['id_supplier' => 1, 'no_faktur' => '123456', 'total_harga' => 100000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 2, 'no_faktur' => '123457', 'total_harga' => 150000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 3, 'no_faktur' => '123458', 'total_harga' => 200000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 4, 'no_faktur' => '123459', 'total_harga' => 250000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 5, 'no_faktur' => '123460', 'total_harga' => 300000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 6, 'no_faktur' => '123461', 'total_harga' => 350000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 7, 'no_faktur' => '123462', 'total_harga' => 400000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 8, 'no_faktur' => '123463', 'total_harga' => 450000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 9, 'no_faktur' => '123464', 'total_harga' => 500000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
            ['id_supplier' => 10, 'no_faktur' => '123465', 'total_harga' => 550000, 'tanggal_pembelian' => Carbon::now(), 'status_pembayaran' => 'lunas'],
        ]);

        
    }
}
