<?php

namespace Database\Seeders;

use App\Models\Kategoriobat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_obat')->insert([
            ['nama_kategori' => 'Analgesik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Antibiotik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Antiseptik' , 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Antihistamin' , 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Antipiretik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Antispasmodik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Antiinflamasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Vitamin', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Mineral', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Suplemen', 'created_at' => now(), 'updated_at' => now()],
        ]);


    }
}
