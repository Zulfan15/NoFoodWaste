<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */    public function index(): View
    {
        $donations = Donation::where('user_id', Auth::id())
            ->with('claim.user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('restaurant.donations.index', compact('donations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('restaurant.donations.create');
    }    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'pickup_location' => 'required|string',
            'expiration_date' => 'required|date|after:now',
            'image' => 'nullable|image|max:2048',
        ]);

        $donation = new Donation([
            'food_name' => $request->food_name,
            'quantity' => $request->quantity,
            'pickup_location' => $request->pickup_location,
            'expiration_date' => $request->expiration_date,
            'user_id' => Auth::id(),
            'status' => 'available',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('donations', 'public');
            $donation->image = $imagePath;
        }

        $donation->save();

        return redirect()->route('restaurant.donations.index')
            ->with('success', 'Donation added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */    public function show($id): View
    {
        $donation = Donation::where('user_id', Auth::id())
            ->with('claim.user')
            ->findOrFail($id);
            
        return view('restaurant.donations.show', compact('donation'));
    }/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $donation = Donation::where('user_id', Auth::id())->findOrFail($id);
        
        // Don't allow editing if donation is already claimed
        if ($donation->status !== 'available') {
            return redirect()->route('restaurant.donations.index')
                ->with('error', 'Cannot edit a donation that has already been claimed or expired');
        }
        
        return view('restaurant.donations.edit', compact('donation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $donation = Donation::where('user_id', Auth::id())->findOrFail($id);
        
        // Don't allow editing if donation is already claimed
        if ($donation->status !== 'available') {
            return redirect()->route('restaurant.donations.index')
                ->with('error', 'Cannot edit a donation that has already been claimed or expired');
        }
        
        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'pickup_location' => 'required|string',
            'expiration_date' => 'required|date|after:now',
            'image' => 'nullable|image|max:2048',
        ]);

        $donation->food_name = $request->food_name;
        $donation->quantity = $request->quantity;
        $donation->pickup_location = $request->pickup_location;
        $donation->expiration_date = $request->expiration_date;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($donation->image) {
                Storage::disk('public')->delete($donation->image);
            }
            
            $imagePath = $request->file('image')->store('donations', 'public');
            $donation->image = $imagePath;
        }        $donation->save();

        return redirect()->route('restaurant.donations.index')
            ->with('success', 'Donation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $donation = Donation::where('user_id', Auth::id())->findOrFail($id);
        
        // Don't allow deletion if donation is already claimed
        if ($donation->status === 'claimed') {
            return redirect()->route('restaurant.donations.index')
                ->with('error', 'Cannot delete a donation that has already been claimed');
        }
        
        // Delete image if exists
        if ($donation->image) {
            Storage::disk('public')->delete($donation->image);
        }
        
        $donation->delete();

        return redirect()->route('restaurant.donations.index')
            ->with('success', 'Donation deleted successfully');
    }
    
    /**
     * Show statistics of restaurant donations
     * 
     * @return \Illuminate\View\View
     */
    public function statistics(): View
    {
        $totalDonations = Donation::where('user_id', Auth::id())->count();
        $claimedDonations = Donation::where('user_id', Auth::id())->where('status', 'claimed')->count();
        $availableDonations = Donation::where('user_id', Auth::id())->where('status', 'available')->count();
        $expiredDonations = Donation::where('user_id', Auth::id())->where('status', 'expired')->count();
        
        $monthlyDonations = Donation::where('user_id', Auth::id())
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, count(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        return view('restaurant.donations.statistics', compact(
            'totalDonations',
            'claimedDonations',
            'availableDonations',
            'expiredDonations',
            'monthlyDonations'
        ));
    }
}
