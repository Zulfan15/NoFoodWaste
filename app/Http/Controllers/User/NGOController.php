<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DonationClaim;
use Illuminate\Support\Facades\Auth;

class NGOController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of nearby NGOs.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function nearby()
    {
        // In a real app, this would use geolocation
        // For now, we'll just show all NGOs
        $ngos = User::where('role', 'ngo')
            ->get();
            
        return view('user.ngos.nearby', compact('ngos'));
    }
    
    /**
     * Display details of a specific NGO.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show($id)
    {
        $ngo = User::where('role', 'ngo')
            ->findOrFail($id);
            
        // Get recent claims by this NGO
        $recentClaims = DonationClaim::where('user_id', $id)
            ->with('donation.donor')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('user.ngos.show', compact('ngo', 'recentClaims'));
    }
}
