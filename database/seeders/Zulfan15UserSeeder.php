<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Zulfan15UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */    public function run()
    {
        // Membuat user zulfan15 dengan role donatur
        User::create([
            'username' => 'zulfan15',
            'email' => 'zulfan15@example.com',
            'password' => Hash::make('password123'),
            'role' => 'donator', // Sesuai dengan enum di migrasi
            'phone_number' => '081234567890',
            'address' => 'Jl. Merdeka No. 15, Jakarta Selatan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
