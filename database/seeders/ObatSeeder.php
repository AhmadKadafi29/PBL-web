<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('obat')->insert([
            [
                'kategori_obat_id' => 1,
                'nama_obat' => 'Paracetamol',
                'merek_obat' => 'Panadol',
                'deskripsi_obat' => 'Obat pereda demam dan nyeri.',
                'efek_samping' => 'Mual, pusing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 1,
                'nama_obat' => 'Ibuprofen',
                'merek_obat' => 'Brufen',
                'deskripsi_obat' => 'Obat antiinflamasi nonsteroid.',
                'efek_samping' => 'Sakit perut, ruam kulit.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 2,
                'nama_obat' => 'Amoxicillin',
                'merek_obat' => 'Amoxil',
                'deskripsi_obat' => 'Antibiotik untuk infeksi bakteri.',
                'efek_samping' => 'Diare, reaksi alergi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 3,
                'nama_obat' => 'Cetirizine',
                'merek_obat' => 'Zyrtec',
                'deskripsi_obat' => 'Antihistamin untuk alergi.',
                'efek_samping' => 'Mengantuk, mulut kering.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 3,
                'nama_obat' => 'Loratadine',
                'merek_obat' => 'Claritin',
                'deskripsi_obat' => 'Obat alergi tanpa efek kantuk.',
                'efek_samping' => 'Sakit kepala, mulut kering.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 4,
                'nama_obat' => 'Salbutamol',
                'merek_obat' => 'Ventolin',
                'deskripsi_obat' => 'Inhaler untuk asma.',
                'efek_samping' => 'Tremor, palpitasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 4,
                'nama_obat' => 'Budesonide',
                'merek_obat' => 'Pulmicort',
                'deskripsi_obat' => 'Steroid untuk inhalasi.',
                'efek_samping' => 'Iritasi tenggorokan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 5,
                'nama_obat' => 'Omeprazole',
                'merek_obat' => 'Losec',
                'deskripsi_obat' => 'Obat untuk asam lambung.',
                'efek_samping' => 'Sakit kepala, perut kembung.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 5,
                'nama_obat' => 'Ranitidine',
                'merek_obat' => 'Zantac',
                'deskripsi_obat' => 'Obat antasida untuk maag.',
                'efek_samping' => 'Diare, pusing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_obat_id' => 6,
                'nama_obat' => 'Metformin',
                'merek_obat' => 'Glucophage',
                'deskripsi_obat' => 'Obat untuk diabetes tipe 2.',
                'efek_samping' => 'Mual, sakit perut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
