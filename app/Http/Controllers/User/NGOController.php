<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NGOController extends Controller
{
    /**
     * Display a listing of nearby NGOs.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
