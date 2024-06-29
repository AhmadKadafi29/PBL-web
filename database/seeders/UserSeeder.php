<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(50)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'pemilik',
            'alamat' => 'banyuwangi',
            'no_telp'=>'0875312562'
        ]);
        User::create([
            'name' => 'karyawan',
            'email' => 'karyawan@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'karyawan',
            'alamat' => 'banyuwangi',
            'no_telp'=>'0875312562'

        ]);
    }
}
