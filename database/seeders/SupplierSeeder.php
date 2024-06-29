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
        DB::table('obat')->insert([
            ['kategori_obat_id' => 1, 'merek_obat' => 'Panadol', 'dosis' => '500mg', 'kemasan' => 'Tablet', 'kegunaan' => 'Analgesik', 'efek_samping' => 'Mual'],
            ['kategori_obat_id' => 2, 'merek_obat' => 'Amoxicillin', 'dosis' => '500mg', 'kemasan' => 'Kapsul', 'kegunaan' => 'Antibiotik', 'efek_samping' => 'Alergi'],
            ['kategori_obat_id' => 3, 'merek_obat' => 'Betadine', 'dosis' => '10%', 'kemasan' => 'Cairan', 'kegunaan' => 'Antiseptik', 'efek_samping' => 'Iritasi'],
            ['kategori_obat_id' => 4, 'merek_obat' => 'Cetirizine', 'dosis' => '10mg', 'kemasan' => 'Tablet', 'kegunaan' => 'Antihistamin', 'efek_samping' => 'Ngantuk'],
            ['kategori_obat_id' => 5, 'merek_obat' => 'Paracetamol', 'dosis' => '500mg', 'kemasan' => 'Tablet', 'kegunaan' => 'Antipiretik', 'efek_samping' => 'Pusing'],
            ['kategori_obat_id' => 6, 'merek_obat' => 'Buscopan', 'dosis' => '10mg', 'kemasan' => 'Tablet', 'kegunaan' => 'Antispasmodik', 'efek_samping' => 'Mulut kering'],
            ['kategori_obat_id' => 7, 'merek_obat' => 'Ibuprofen', 'dosis' => '400mg', 'kemasan' => 'Tablet', 'kegunaan' => 'Antiinflamasi', 'efek_samping' => 'Sakit perut'],
            ['kategori_obat_id' => 8, 'merek_obat' => 'Vitamin C', 'dosis' => '500mg', 'kemasan' => 'Tablet', 'kegunaan' => 'Vitamin', 'efek_samping' => 'Diare'],
            ['kategori_obat_id' => 9, 'merek_obat' => 'Calcium', 'dosis' => '600mg', 'kemasan' => 'Tablet', 'kegunaan' => 'Mineral', 'efek_samping' => 'Sembelit'],
            ['kategori_obat_id' => 10, 'merek_obat' => 'Fish Oil', 'dosis' => '1000mg', 'kemasan' => 'Kapsul', 'kegunaan' => 'Suplemen', 'efek_samping' => 'Bau mulut'],
        ]);
    }
}
