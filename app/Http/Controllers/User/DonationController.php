<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
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
    public function index()
    {
        $donations = Donation::where('status', 'available')
            ->where('expiry_date', '>', now())
            ->with('donor')
            ->orderBy('expiry_date')
            ->get();
            
        return view('user.donations.index', compact('donations'));
    }
    
    /**
     * Display donation history from NGOs and restaurants.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    public function history()
    {
        $donations = Donation::with(['donor', 'claim.user'])
            ->where('status', 'claimed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('user.donations.history', compact('donations'));
    }
    
    /**
     * Display details of a specific donation.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    public function show($id)
    {
        $donation = Donation::with(['donor', 'claim.user'])
            ->findOrFail($id);
            
        return view('user.donations.show', compact('donation'));
    }
}
