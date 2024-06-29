<?php

namespace Database\Factories;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker= FakerFactory::create('id_ID');
        return [
            'nama_supplier'=>$faker->company(),
            'no_telpon'=>$faker->phoneNumber(),
            'alamat'=>$faker->address()
        ];
    }
}
