<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obat>
 */
class ObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_obat' => $this->faker->unique()->word,
            'jenis_obat' => $this->faker->word,
            'kategori_obat_id' => '1',
            'stok_obat' => $this->faker->numberBetween(1, 100),
            'harga_obat' => $this->faker->numberBetween(1000, 50000),
            'tanggal_masuk' => $this->faker->date,
            'exp_date' => $this->faker->date,
            'status' => $this->faker->randomElement(['Tersedia', 'Kadaluarsa']),
        ];
    }
}
