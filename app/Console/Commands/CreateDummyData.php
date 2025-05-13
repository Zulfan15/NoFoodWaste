<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Donation;
use App\Models\DonationClaim;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateDummyData extends Command
{
    protected $signature = 'dummy:create';
    protected $description = 'Create dummy data for donations and claims';

    public function handle()
    {
        $this->info('Creating dummy data...');

        // Get users
        $donators = User::where('role', 'donator')->get();
        $recipients = User::where('role', 'penenrima')->get();

        if ($donators->isEmpty()) {
            $this->error('No donator users found. Creating donator users...');
            // Create donator users
            for ($i = 1; $i <= 5; $i++) {
                User::create([
                    'username' => 'donator' . $i,
                    'email' => 'donator' . $i . '@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'donator',
                    'phone_number' => '08123456789' . $i,
                    'address' => 'Jalan Donator ' . $i,
                ]);
            }
            $donators = User::where('role', 'donator')->get();
        }

        if ($recipients->isEmpty()) {
            $this->error('No recipient users found. Creating recipient users...');
            // Create recipient users
            for ($i = 1; $i <= 5; $i++) {
                User::create([
                    'username' => 'recipient' . $i,
                    'email' => 'recipient' . $i . '@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'penenrima',
                    'phone_number' => '08987654321' . $i,
                    'address' => 'Jalan Penerima ' . $i,
                ]);
            }
            $recipients = User::where('role', 'penenrima')->get();
        }

        // Create donations
        $foods = [
            'Nasi Padang', 'Pizza', 'Ayam Goreng', 'Mie Ayam', 'Bakso',
            'Sate', 'Gado-gado', 'Soto', 'Rendang', 'Nasi Goreng'
        ];
        
        // Clear existing donations and claims
        DonationClaim::query()->delete();
        Donation::query()->delete();

        $this->info('Creating donations...');
        foreach ($donators as $donator) {
            // Each donator creates 1-5 donations
            $donationCount = rand(1, 5);
            for ($i = 0; $i < $donationCount; $i++) {
                $food = $foods[array_rand($foods)];
                $quantity = rand(1, 10);
                $status = 'available';
                
                // Create donation
                $donation = Donation::create([
                    'user_id' => $donator->user_id,
                    'food_name' => $food,
                    'quantity' => $quantity,
                    'pickup_location' => 'Jalan ' . $food . ' No. ' . rand(1, 100),
                    'expiration_date' => Carbon::now()->addDays(rand(1, 5)),
                    'status' => $status,
                    'created_at' => Carbon::now()->subDays(rand(0, 30)), // Some donations from past month
                ]);
                
                // 70% chance of donation being claimed
                if (rand(1, 10) <= 7) {
                    $recipient = $recipients->random();
                      // Create claim
                    DonationClaim::create([
                        'donation_id' => $donation->donation_id,
                        'user_id' => $recipient->user_id,
                        'status' => 'completed',
                        'notes' => 'Klaim otomatis oleh ' . $recipient->username,
                        'created_at' => Carbon::now()->subDays(rand(0, 28)),
                    ]);
                    
                    // Update donation status
                    $donation->update(['status' => 'claimed']);
                }
            }
        }

        $this->info('Dummy data created successfully!');
        
        // Update the leaderboard
        $this->call('leaderboard:update');
        
        return 0;
    }
}
