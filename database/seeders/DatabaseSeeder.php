<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            KategoriObatSeeder::class,
            SupplierSeeder::class,
            ObatSeeder::class,
            SatuanSeeder::class,
            // PembelianSeeder::class,
            // DetailPembelianSeeder::class,
            // DetailObatSeeder::class
        ]);
    }
}
