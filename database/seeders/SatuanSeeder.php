<?php

namespace Database\Seeders;

use App\Models\detailsatuan;
use App\Models\satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data obat dan satuannya
        $obatSatuanData = [
            // Data obat dengan 2 satuan terkecil
            ['id_obat' => 1, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10, 'satuan_terkecil_2' => 'pil', 'jumlah_satuan_terkecil_2' => 5],
            ['id_obat' => 2, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10, 'satuan_terkecil_2' => 'pil', 'jumlah_satuan_terkecil_2' => 5],
            // Data obat dengan hanya 1 satuan terkecil
            ['id_obat' => 3, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10],
            ['id_obat' => 4, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10],
            ['id_obat' => 5, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10],
            ['id_obat' => 6, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10],
            ['id_obat' => 7, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10],
            ['id_obat' => 8, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10],
            // Data obat dengan 2 satuan terkecil
            ['id_obat' => 9, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10, 'satuan_terkecil_2' => 'pil', 'jumlah_satuan_terkecil_2' => 5],
            ['id_obat' => 10, 'satuan_terbesar' => 'Box', 'satuan_terkecil_1' => 'Tablet', 'jumlah_satuan_terkecil_1' => 10],
        ];

        // Loop untuk membuat satuan dan detail satuan
        foreach ($obatSatuanData as $data) {
            // Membuat satuan utama untuk setiap obat
            $satuan = Satuan::create([
                'id_obat' => $data['id_obat'],
                'satuan_terbesar' => $data['satuan_terbesar'],
                'satuan_terkecil_1' => $data['satuan_terkecil_1'],
                'jumlah_satuan_terkecil_1' => $data['jumlah_satuan_terkecil_1'],
            ]);

            // Menambahkan satuan terkecil 2 jika ada
            if (isset($data['satuan_terkecil_2']) && isset($data['jumlah_satuan_terkecil_2'])) {
                DetailSatuan::create([
                    'id_satuan' => $satuan->id,
                    'satuan_terkecil' => $data['satuan_terkecil_2'],
                    'jumlah' => $data['jumlah_satuan_terkecil_2'],
                ]);
            }
        }
    }
}
