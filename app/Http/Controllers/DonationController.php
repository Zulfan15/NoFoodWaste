<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index()
    {
        return view('donate.index'); // Menampilkan halaman donasi
    }

    public function findDonations()
    {
        // Menampilkan halaman untuk menemukan donasi
        return view('donate.find');
    }
      public function store(Request $request)
    {
        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after:today',
        ]);        $donation = new Donation([
            'food_name' => $request->food_name,
            'quantity' => $request->quantity,
            'expiry_date' => $request->expiry_date, // This maps to expiration_date through the fillable alias
            'user_id' => Auth::id(),
            'status' => 'available',
            'pickup_location' => Auth::user()->address ?? 'Location pending',
        ]);

        $donation->save();

        return redirect()->route('dashboard')->with('success', 'Donation added successfully!');
    }
    
    /**
     * Show all donations made by the authenticated user
     * 
     * @return \Illuminate\View\View
     */
    public function myDonations()
    {
        $donations = Auth::user()->donations()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('donate.my-donations', compact('donations'));
    }
    
    /**
     * Show all claims made by the authenticated user
     * 
     * @return \Illuminate\View\View
     */    public function myClaims()
    {
        $claims = Auth::user()->claims()->with('donation.user')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('donate.my-claims', compact('claims'));
    }
    
    /**
     * Show a specific donation
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $donation = Donation::findOrFail($id);
        
        // Check if user is allowed to view this donation
        if ($donation->user_id != Auth::id() && !$donation->is_claimed) {
            // If not the owner, they can only view claimed donations that they claimed
            $hasClaimed = false;
            
            if (Auth::user()->claims()->where('donation_id', $id)->exists()) {
                $hasClaimed = true;
            }
            
            if (!$hasClaimed) {
                return redirect()->route('find-donations')
                    ->with('error', 'Anda tidak memiliki akses untuk melihat donasi ini.');
            }
        }
        
        return view('donate.show', compact('donation'));
    }
    
    /**
     * Show edit form for a donation
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $donation = Donation::findOrFail($id);
        
        // Only the owner can edit
        if ($donation->user_id != Auth::id()) {
            return redirect()->route('donations.my')
                ->with('error', 'Anda tidak dapat mengedit donasi ini.');
        }
        
        // Cannot edit if already claimed
        if ($donation->is_claimed) {
            return redirect()->route('donations.my')
                ->with('error', 'Donasi yang sudah diklaim tidak dapat diedit.');
        }
        
        return view('donate.edit', compact('donation'));
    }
    
    /**
     * Update a donation
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        
        // Only the owner can update
        if ($donation->user_id != Auth::id()) {
            return redirect()->route('donations.my')
                ->with('error', 'Anda tidak dapat mengedit donasi ini.');
        }
        
        // Cannot update if already claimed
        if ($donation->is_claimed) {
            return redirect()->route('donations.my')
                ->with('error', 'Donasi yang sudah diklaim tidak dapat diedit.');
        }
        
        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after:today',
            'pickup_location' => 'required|string|max:255',
        ]);
        
        $donation->food_name = $request->food_name;
        $donation->quantity = $request->quantity;
        $donation->expiry_date = $request->expiry_date;
        $donation->pickup_location = $request->pickup_location;
        $donation->save();
        
        return redirect()->route('donations.my')
            ->with('success', 'Donasi berhasil diperbarui.');
    }
    
    /**
     * Delete a donation
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        
        // Only the owner can delete
        if ($donation->user_id != Auth::id()) {
            return redirect()->route('donations.my')
                ->with('error', 'Anda tidak dapat menghapus donasi ini.');
        }
        
        // Cannot delete if already claimed
        if ($donation->is_claimed) {
            return redirect()->route('donations.my')
                ->with('error', 'Donasi yang sudah diklaim tidak dapat dihapus.');
        }
        
        $donation->delete();
        
        return redirect()->route('donations.my')
            ->with('success', 'Donasi berhasil dihapus.');
    }
    
    /**
     * Claim a donation
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function claim(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        
        // Cannot claim own donation
        if ($donation->user_id == Auth::id()) {
            return redirect()->route('find-donations')
                ->with('error', 'Anda tidak dapat mengklaim donasi Anda sendiri.');
        }
        
        // Cannot claim if already claimed
        if ($donation->is_claimed) {
            return redirect()->route('find-donations')
                ->with('error', 'Donasi ini sudah diklaim oleh orang lain.');
        }
        
        // Create a new claim
        $claim = new \App\Models\DonationClaim([
            'donation_id' => $donation->donation_id,
            'user_id' => Auth::id(),
            'status' => 'pending',
            'notes' => $request->notes ?? null,
        ]);
        
        $claim->save();
        
        // Mark donation as claimed
        $donation->is_claimed = true;
        $donation->status = 'claimed';
        $donation->save();
        
        return redirect()->route('claims.my')
            ->with('success', 'Donasi berhasil diklaim.');
    }
    
    /**
     * Show a specific claim
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showClaim($id)
    {
        $claim = \App\Models\DonationClaim::with('donation.user')->findOrFail($id);
        
        // Check if user is allowed to view this claim
        if ($claim->user_id != Auth::id() && $claim->donation->user_id != Auth::id()) {
            return redirect()->route('claims.my')
                ->with('error', 'Anda tidak memiliki akses untuk melihat klaim ini.');
        }
        
        return view('donate.claim-details', compact('claim'));
    }
    
    /**
     * Cancel a claim
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelClaim($id)
    {
        $claim = \App\Models\DonationClaim::findOrFail($id);
        
        // Only the claimer can cancel
        if ($claim->user_id != Auth::id()) {
            return redirect()->route('claims.my')
                ->with('error', 'Anda tidak dapat membatalkan klaim ini.');
        }
        
        // Can only cancel pending claims
        if ($claim->status != 'pending') {
            return redirect()->route('claims.my')
                ->with('error', 'Hanya klaim dengan status menunggu yang dapat dibatalkan.');
        }
        
        // Update the donation status
        $donation = $claim->donation;
        $donation->is_claimed = false;
        $donation->status = 'available';
        $donation->save();
        
        // Delete the claim
        $claim->delete();
        
        return redirect()->route('claims.my')
            ->with('success', 'Klaim berhasil dibatalkan.');
    }
}

