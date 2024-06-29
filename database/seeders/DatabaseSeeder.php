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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'User',
        //     'email' => 'test@example.com',
        //     'role' => 'admin',
        //     'alamat' => 'banyuwangi',
        //     'no_telp' => '628141294238',
        //     'password' => Hash::make('12345678')
        // ]);


        // Kategori_obat::create([
        //     'nama_kategori' => 'obat bebas'
        // ]);

        // Obat::create([
        //     'kategori_obat_id' => 1,
        //     'kode_obat' => 'OB001',
        //     'nama_brand_obat' => 'komix',
        //     'jenis_obat' => 'sirup',
        //     'satuan_obat' => 'sachet',
        //     'status' => 'belum kadaluarsa'
        // ]);

        $this->call([
            UserSeeder::class,
            KategoriObatSeeder::class,
            SupplierSeeder::class,
            ObatSeeder::class,
            PembelianSeeder::class,
            DetailObatSeeder::class,
        ]);
    }
}
