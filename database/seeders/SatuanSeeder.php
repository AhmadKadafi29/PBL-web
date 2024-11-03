<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('satuans')->insert([
            [
                'nama_satuan' => 'pil',
               
            ],
            [
                'nama_satuan' => 'blister',
               
            ],
            [
                'nama_satuan' => 'botol',
               
            ],
            [
                'nama_satuan' => 'box',
               
            ],
           
        ]);

        DB::table('detail_satuans')->insert([
            [
                'id_satuan' => 1,
                'id_obat' => 1,
                'satuan_konversi' => 1,
               
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id_satuan' => 2,
                'id_obat' => 1,
                'satuan_konversi' => 5,
               
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_satuan' => 4,
                'id_obat' => 1,
                'satuan_konversi' => 20,
                
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        ]);

    }
}
