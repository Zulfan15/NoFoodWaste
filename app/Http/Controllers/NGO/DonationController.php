<?php

namespace App\Http\Controllers\NGO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\DonationClaim;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
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
     * Display a listing of available donations.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function availableDonations()
    {
        $donations = Donation::where('status', 'available')
            ->where('expiry_date', '>', now())
            ->with('donor')
            ->orderBy('expiry_date')
            ->get();
            
        return view('ngo.donations.available', compact('donations'));
    }
    
    /**
     * Display history of claimed donations.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function claimHistory()
    {
        $claims = DonationClaim::where('user_id', Auth::id())
            ->with('donation.donor')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('ngo.donations.claim-history', compact('claims'));
    }
    
    /**
     * Claim a donation.
     *
     * @param  int  $donationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function claim($donationId)
    {
        $donation = Donation::where('status', 'available')
            ->where('expiry_date', '>', now())
            ->findOrFail($donationId);
            
        // Create claim
        $claim = new DonationClaim([
            'user_id' => Auth::id(),
            'donation_id' => $donation->id,
            'claimed_at' => now(),
            'status' => 'pending',
        ]);
        
        $claim->save();
        
        // Update donation status
        $donation->status = 'claimed';
        $donation->save();
        
        return redirect()->route('ngo.claim-history')
            ->with('success', 'Donation claimed successfully. Please pick up the donation within 24 hours.');
    }
    
    /**
     * Show details of a claimed donation.
     *
     * @param  int  $claimId
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showClaim($claimId)
    {
        $claim = DonationClaim::where('user_id', Auth::id())
            ->with('donation.donor')
            ->findOrFail($claimId);
            
        return view('ngo.donations.show-claim', compact('claim'));
    }
    
    /**
     * Mark a claim as completed.
     *
     * @param  int  $claimId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeClaim($claimId)
    {
        $claim = DonationClaim::where('user_id', Auth::id())
            ->findOrFail($claimId);
            
        $claim->status = 'completed';
        $claim->completed_at = now();
        $claim->save();
        
        return redirect()->route('ngo.claim-history')
            ->with('success', 'Claim marked as completed successfully.');
    }
}
