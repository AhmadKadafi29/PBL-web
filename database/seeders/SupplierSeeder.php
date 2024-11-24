<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('supplier')->insert([
            ['nama_supplier' => 'Supplier A', 'no_telpon' => '081234567890', 'alamat' => 'Jl. Mawar No. 1', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier B', 'no_telpon' => '081234567891', 'alamat' => 'Jl. Melati No. 2', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier C', 'no_telpon' => '081234567892', 'alamat' => 'Jl. Kamboja No. 3', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier D', 'no_telpon' => '081234567893', 'alamat' => 'Jl. Kenanga No. 4', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier E', 'no_telpon' => '081234567894', 'alamat' => 'Jl. Anggrek No. 5', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier F', 'no_telpon' => '081234567895', 'alamat' => 'Jl. Tulip No. 6', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier G', 'no_telpon' => '081234567896', 'alamat' => 'Jl. Dahlia No. 7', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier H', 'no_telpon' => '081234567897', 'alamat' => 'Jl. Teratai No. 8', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier I', 'no_telpon' => '081234567898', 'alamat' => 'Jl. Mawar No. 9', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Supplier J', 'no_telpon' => '081234567899', 'alamat' => 'Jl. Melati No. 10', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
