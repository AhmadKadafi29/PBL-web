<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kategori_obat;
use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       

        Supplier::create([
            'nama_supplier' => 'PT. Sehat',
            'no_telpon' => '0897124145',
            'alamat' => 'Banyuwangi'
        ]);

        $this->call([
            UserSeeder::class,
            KategoriObatSeeder::class,
            SupplierSeeder::class
            
        ]);
    }
}
