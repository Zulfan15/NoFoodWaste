<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\LeaderboardController;

class DashboardController extends Controller
{
    protected $leaderboardController;
      public function __construct(LeaderboardController $leaderboardController)
    {
        $this->middleware('auth');
        $this->leaderboardController = $leaderboardController;
    }
      public function index()
    {
        try {
            // Data yang ingin ditampilkan pada dashboard, seperti statistik
            $saved_food = 5000; // contoh data makanan terselamatkan
            $active_donors = 150; // contoh data donatur aktif
            $helped_communities = 30; // contoh data komunitas yang terbantu
            
            // Get leaderboard data
            $topDonors = $this->leaderboardController->getTopDonors('month', 5);
            $topCommunities = $this->leaderboardController->getTopCommunities('month', 5);

            // Mengirim data ke view dashboard.index
            return view('dashboard.index', compact(
                'saved_food', 
                'active_donors', 
                'helped_communities',
                'topDonors',
                'topCommunities'
            ));
        } catch (\Exception $e) {
            // Log the error
            \Log::error("Leaderboard error: " . $e->getMessage());
            
            // Provide empty collections if there's an error
            $topDonors = collect();
            $topCommunities = collect();
            
            return view('dashboard.index', compact(
                'saved_food', 
                'active_donors', 
                'helped_communities',
                'topDonors',
                'topCommunities'
            ));
        }
    }
}

