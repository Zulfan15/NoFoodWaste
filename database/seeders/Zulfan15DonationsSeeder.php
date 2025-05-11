<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Donation;
use Carbon\Carbon;

class Zulfan15DonationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */    public function run()
    {
        // Cari user zulfan15
        $user = User::where('username', 'zulfan15')->first();
        
        if (!$user) {
            $this->command->error('User zulfan15 tidak ditemukan. Jalankan Zulfan15UserSeeder terlebih dahulu.');
            return;
        }

        $donations = [
            [
                'user_id' => $user->user_id,
                'food_name' => 'Makanan Catering Sisa Acara Seminar',
                'quantity' => 35,
                'pickup_location' => 'Kampus Universitas Indonesia, Depok',
                'expiration_date' => Carbon::now()->addDays(1),
                'status' => 'available',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => $user->user_id,
                'food_name' => 'Sayuran Segar dari Kebun Komunitas',
                'quantity' => 20,
                'pickup_location' => 'Kebun Komunitas Hijau, Duren Sawit, Jakarta Timur',
                'expiration_date' => Carbon::now()->addDays(3),
                'status' => 'available',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => $user->user_id,
                'food_name' => 'Roti dan Kue dari Toko Roti',
                'quantity' => 25,
                'pickup_location' => 'Bread House Bakery, Jl. Fatmawati No. 15, Jakarta Selatan',
                'expiration_date' => Carbon::now()->addDays(2),
                'status' => 'available',
                'created_at' => Carbon::now()->subHours(5),
                'updated_at' => Carbon::now()->subHours(5),
            ],
            [
                'user_id' => $user->user_id,
                'food_name' => 'Buah-buahan Segar Kelebihan Stok',
                'quantity' => 40,
                'pickup_location' => 'Toko Buah Segar, Pasar Modern BSD, Tangerang Selatan',
                'expiration_date' => Carbon::now()->addDays(5),
                'status' => 'available',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => $user->user_id,
                'food_name' => 'Bahan Makanan Pokok untuk Dapur Umum',
                'quantity' => 10,
                'pickup_location' => 'Jl. Merdeka No. 15, Jakarta Selatan',
                'expiration_date' => Carbon::now()->addMonths(3),
                'status' => 'available',
                'created_at' => Carbon::now()->subWeek(),
                'updated_at' => Carbon::now()->subWeek(),
            ],
        ];

        foreach ($donations as $donation) {
            Donation::create($donation);
        }
    }
}
