<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Donation;
use App\Models\Leaderboard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{    /**
     * Get top donors for leaderboard
     *
     * @param string $period month, year, or all
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getTopDonors($period = 'month', $limit = 10)
    {
        // Use direct query to keep it simple and avoid model issues
        $query = DB::table('users')
            ->select(
                'users.user_id', 
                'users.username', 
                'users.email', 
                'users.role', 
                'users.phone_number', 
                'users.address',
                DB::raw('COALESCE(SUM(donations.quantity), 0) as total_donated')
            )
            ->leftJoin('donations', function($join) use ($period) {
                $join->on('users.user_id', '=', 'donations.user_id');
                
                if ($period === 'month') {
                    // Bulan ini
                    $join->whereMonth('donations.created_at', Carbon::now()->month)
                         ->whereYear('donations.created_at', Carbon::now()->year);
                } elseif ($period === 'year') {
                    // Tahun ini
                    $join->whereYear('donations.created_at', Carbon::now()->year);
                }
            })
            ->where('users.role', '=', 'donator')
            ->groupBy('users.user_id', 'users.username', 'users.email', 'users.role', 'users.phone_number', 'users.address')
            ->orderBy('total_donated', 'desc')
            ->limit($limit)
            ->get();

        return $query;
    }    /**
     * Get top communities (NGOs) for leaderboard
     *
     * @param string $period month, year, or all
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getTopCommunities($period = 'month', $limit = 10)
    {
        // Use direct query to keep it simple and avoid model issues
        $query = DB::table('users')
            ->select(
                'users.user_id', 
                'users.username', 
                'users.email', 
                'users.role',
                'users.phone_number', 
                'users.address', 
                DB::raw('COALESCE(COUNT(donation_claims.claim_id), 0) as total_claims')
            )            ->leftJoin('donation_claims', function($join) use ($period) {
                $join->on('users.user_id', '=', 'donation_claims.user_id');
                
                if ($period === 'month') {
                    // Bulan ini
                    $join->whereMonth('donation_claims.created_at', Carbon::now()->month)
                         ->whereYear('donation_claims.created_at', Carbon::now()->year);
                } elseif ($period === 'year') {
                    // Tahun ini
                    $join->whereYear('donation_claims.created_at', Carbon::now()->year);
                }
            })
            ->where('users.role', '=', 'penenrima')
            ->groupBy('users.user_id', 'users.username', 'users.email', 'users.role', 'users.phone_number', 'users.address')
            ->orderBy('total_claims', 'desc')
            ->limit($limit)
            ->get();

        return $query;
    }

    /**
     * Update leaderboard data (untuk dijalankan via cron job)
     */
    public function updateLeaderboard()
    {
        // Hapus data leaderboard lama untuk bulan ini
        $currentMonth = Carbon::now()->format('Y-m');
        Leaderboard::where('period', $currentMonth)->delete();

        // Dapatkan top donors bulan ini
        $topDonors = $this->getTopDonors('month');
        
        // Simpan ke database
        $rank = 1;
        foreach ($topDonors as $donor) {
            Leaderboard::create([
                'user_id' => $donor->user_id,
                'total_food_donated' => $donor->total_donated,
                'rank' => $rank,
                'period' => $currentMonth,
            ]);
            $rank++;
        }

        return response()->json(['message' => 'Leaderboard updated successfully']);
    }    /**
     * Get leaderboard data for the dashboard
     */
    public function getLeaderboardData(Request $request)
    {
        $period = $request->input('period', 'month'); // default: bulan ini
        $type = $request->input('type', 'donors'); // default: donatur
        
        if ($type === 'donors') {
            $data = $this->getTopDonors($period, 5);
        } else {
            $data = $this->getTopCommunities($period, 5);
        }
        
        return response()->json(['data' => $data]);
    }
      /**
     * Display leaderboard page
     */
    public function showLeaderboard(Request $request)
    {
        // Get period from request or default to month
        $period = $request->input('period', 'month');
        
        // Get leaderboard data based on period
        $topDonors = $this->getTopDonors($period, 10);
        $topCommunities = $this->getTopCommunities($period, 10);
        
        // Get global statistics
        $totalDonated = DB::table('donations')
                        ->when($period == 'month', function($query) {
                            return $query->whereMonth('created_at', Carbon::now()->month)
                                         ->whereYear('created_at', Carbon::now()->year);
                        })
                        ->when($period == 'year', function($query) {
                            return $query->whereYear('created_at', Carbon::now()->year);
                        })
                        ->sum('quantity');
        
        $activeDonors = DB::table('users')
                        ->where('role', 'donator')
                        ->whereExists(function($query) use ($period) {
                            $query->select(DB::raw(1))
                                  ->from('donations')
                                  ->whereRaw('users.user_id = donations.user_id')
                                  ->when($period == 'month', function($q) {
                                      return $q->whereMonth('created_at', Carbon::now()->month)
                                               ->whereYear('created_at', Carbon::now()->year);
                                  })
                                  ->when($period == 'year', function($q) {
                                      return $q->whereYear('created_at', Carbon::now()->year);
                                  });
                        })
                        ->count();
        
        $activeCommunities = DB::table('users')
                            ->where('role', 'penenrima')
                            ->whereExists(function($query) use ($period) {
                                $query->select(DB::raw(1))
                                      ->from('donation_claims')
                                      ->whereRaw('users.user_id = donation_claims.user_id')
                                      ->when($period == 'month', function($q) {
                                          return $q->whereMonth('created_at', Carbon::now()->month)
                                                   ->whereYear('created_at', Carbon::now()->year);
                                      })
                                      ->when($period == 'year', function($q) {
                                          return $q->whereYear('created_at', Carbon::now()->year);
                                      });
                            })
                            ->count();
        
        // Get previous ranks (from last month) for rank change indicators
        $prevPeriod = ($period == 'month') 
            ? Carbon::now()->subMonth()->format('Y-m') 
            : Carbon::now()->subYear()->format('Y');
            
        $previousRanks = DB::table('leaderboards')
                        ->where('period', $prevPeriod)
                        ->pluck('rank', 'user_id');

        // Format for period display
        $periodLabel = $this->getPeriodLabel($period);
        $lastUpdated = Carbon::now()->format('d M Y H:i');
        
        return view('leaderboard.index', compact(
            'topDonors', 
            'topCommunities', 
            'period', 
            'periodLabel',
            'totalDonated', 
            'activeDonors', 
            'activeCommunities',
            'previousRanks',
            'lastUpdated'
        ));
    }
    
    /**
     * Get the formatted label for a period
     */
    private function getPeriodLabel($period)
    {
        switch($period) {
            case 'week':
                return 'Minggu Ini';
            case 'month':
                return 'Bulan ' . Carbon::now()->locale('id')->monthName . ' ' . Carbon::now()->year;
            case 'year':
                return 'Tahun ' . Carbon::now()->year;
            case 'all':
                return 'Sepanjang Waktu';
            default:
                return 'Bulan Ini';
        }
    }
}
