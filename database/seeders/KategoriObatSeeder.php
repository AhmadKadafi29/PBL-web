<?php

namespace Database\Seeders;

use App\Models\Kategori_obat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori_obat::factory(20)->create();
    }
}
