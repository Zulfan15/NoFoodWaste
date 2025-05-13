<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\DonationClaim;
use App\Models\User;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    
    /**
     * Display a listing of statistics.
     *
     * @return \Illuminate\View\View
     */    
    public function index(): View
    {
        // Total users
        $totalUsers = User::count();

        // Total donations
        $totalDonations = Donation::count();
        
        // Available, claimed, and expired donations
        $availableDonations = Donation::where('status', 'available')->count();
        $claimedDonations = Donation::where('status', 'claimed')->count();
        $expiredDonations = Donation::where('status', 'expired')->count();
        
        // User counts by role
        $adminCount = User::where('role', 'admin')->count();
        $restaurantCount = User::where('role', 'restaurant')->count();
        $ngoCount = User::where('role', 'ngo')->count();
        $userCount = User::where('role', 'user')->count();
        
        // Monthly donations with claim counts
        $monthlyDonations = Donation::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, count(*) as count, SUM(CASE WHEN status = "claimed" THEN 1 ELSE 0 END) as claimed_count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        
        // Top donors with claimed donations count
        $topDonors = User::withCount(['donations', 'donations as claimed_donations_count' => function($query) {
                $query->where('status', 'claimed');
            }])
            ->where('role', 'restaurant')
            ->having('donations_count', '>', 0)
            ->orderBy('donations_count', 'desc')
            ->take(10)
            ->get();
          // Recent donations
        $recentDonations = Donation::with('donor')
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();
        
        return view('admin.statistics.index', compact(
            'totalUsers',
            'totalDonations',
            'availableDonations',
            'claimedDonations',
            'expiredDonations',
            'adminCount',
            'restaurantCount',
            'ngoCount',
            'userCount',
            'monthlyDonations',
            'topDonors',
            'recentDonations'
        ));
    }
}
