<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply auth middleware to methods that need authentication
        // Only allow guest access to index and findDonations
        $this->middleware('auth', ['except' => ['index', 'findDonations', 'getNearbyDonations']]);
    }

    public function index()
    {
        return view('donate.index'); // Menampilkan halaman donasi
    }    public function findDonations(Request $request)
    {
        // Get current authenticated user (could be null for guest users)
        $user = auth()->user();
        
        // Query for available donations
        $query = Donation::with('donor')
            ->where('status', 'available')
            ->where('expiration_date', '>', now());
            
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('food_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Category filter
        if ($request->has('category') && !empty($request->category) && $request->category != 'all') {
            $query->where('category', $request->category);
        }
        
        // Quantity filter
        if ($request->has('quantity_min') && is_numeric($request->quantity_min)) {
            $query->where('quantity', '>=', $request->quantity_min);
        }
          // Date filter
        if ($request->has('pickup_date') && !empty($request->pickup_date)) {
            $date = date('Y-m-d', strtotime($request->pickup_date));
            $query->whereDate('expiration_date', '>=', $date);
        }
        
        // Sort functionality
        if ($request->has('sort')) {
            switch($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'expiry':
                    $query->orderBy('expiration_date', 'asc');
                    break;
                case 'quantity-high':
                    $query->orderBy('quantity', 'desc');
                    break;
                case 'quantity-low':
                    $query->orderBy('quantity', 'asc');
                    break;
                default:
                    // Default sort is by nearest (we'll implement distance calculation later)
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            // Default sort
            $query->orderBy('created_at', 'desc');
        }
        
        // Paginate the results
        $donations = $query->paginate(8);

        // Get categories for filter options
        $categories = Donation::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        // Jika request AJAX (untuk update marker peta & grid donasi tanpa reload)
        if ($request->ajax() || $request->get('ajax') == 1) {
            // Data marker untuk JS
            $donationMarkers = [];
            foreach ($donations as $donation) {
                if ($donation->latitude && $donation->longitude) {
                    $donationMarkers[] = [
                        'latitude' => $donation->latitude,
                        'longitude' => $donation->longitude,
                        'popupContent' => view('donate._map_popup', compact('donation'))->render(),
                    ];
                }
            }
            // Render ulang grid donasi (opsional, jika ingin update grid juga)
            $html = view('donate._donation_grid', compact('donations'))->render();
            return response()->json([
                'donations' => $donationMarkers,
                'html' => $html,
            ]);
        }

        return view('donate.find', compact('donations', 'categories'));
    }
        public function store(Request $request)
    {        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after:today',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'pickup_location' => 'required|string',
        ]);        
        
        $donation = new Donation([
            'food_name' => $request->food_name,
            'quantity' => $request->quantity,            'category' => $request->category,
            'description' => $request->description,
            'expiration_date' => $request->expiry_date,
            'user_id' => Auth::id(),
            'status' => 'available',
            'pickup_location' => $request->pickup_location ?? (Auth::check() ? Auth::user()->address : null) ?? 'Location pending',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('donations', 'public');
            $donation->image = $imagePath;
        }
        
        // Get coordinates from the address
        if (!empty($donation->pickup_location)) {
            $coordinates = $this->getCoordinatesFromAddress($donation->pickup_location);
            if ($coordinates) {
                $donation->latitude = $coordinates['lat'];
                $donation->longitude = $coordinates['lng'];
            }
        }

        $donation->save();

        return redirect()->route('dashboard')->with('success', 'Donasi berhasil ditambahkan!');
    }
      /**
     * Show all donations made by the authenticated user
     */
    public function myDonations()
    {
        // Mendapatkan user saat ini
        $user = Auth::user();
        $donations = $user->donations()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('donate.my-donations', compact('donations'));
    }    /**
     * Show all claims made by the authenticated user
     * 
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */    
    public function myClaims()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Tetap kembalikan view dengan notifikasi error agar return type konsisten
            return view('donate.my-claims', [
                'claims' => collect([]),
                'error' => 'Silakan login terlebih dahulu untuk melihat klaim donasi Anda.'
            ]);
        }
        // Mendapatkan user saat ini
        $user = Auth::user();
        $claims = $user->claims()->with(['donation.donor'])->orderBy('created_at', 'desc')->paginate(10);
        return view('donate.my-claims', compact('claims'));
    }
      /**
     * Show a specific donation
     * 
     * @param int $id
     */    
    public function show($id)
    {
        $donation = Donation::with(['donor', 'claim.user'])->findOrFail($id);
        
        // Check if user is allowed to view this donation
        if ($donation->user_id != Auth::id() && $donation->status != 'claimed') {            // If not the owner, they can only view claimed donations that they claimed
            $hasClaimed = false;
            
            if (Auth::check() && Auth::user()->claims()->where('donation_id', $donation->donation_id)->exists()) {
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
        if ($donation->status == 'claimed') {
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
     */    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        
        // Only the owner can update
        if ($donation->user_id != Auth::id()) {
            return redirect()->route('donations.my')
                ->with('error', 'Anda tidak dapat mengedit donasi ini.');
        }
        
        // Cannot update if already claimed
        if ($donation->status == 'claimed') {
            return redirect()->route('donations.my')
                ->with('error', 'Donasi yang sudah diklaim tidak dapat diedit.');
        }
          $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'expiry_date' => 'required|date|after:today',
            'pickup_location' => 'required|string|max:255',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        
        $donation->food_name = $request->food_name;
        $donation->quantity = $request->quantity;
        $donation->expiration_date = $request->expiry_date;
        $donation->pickup_location = $request->pickup_location;
        $donation->category = $request->category;
        $donation->description = $request->description;
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('donations', 'public');
            $donation->image = $imagePath;
        }
        
        // Update coordinates if location changed
        if ($donation->isDirty('pickup_location')) {
            $coordinates = $this->getCoordinatesFromAddress($request->pickup_location);
            if ($coordinates) {
                $donation->latitude = $coordinates['lat'];
                $donation->longitude = $coordinates['lng'];
            }
        }
        
        $donation->save();
        
        return redirect()->route('donations.my')
            ->with('success', 'Donasi berhasil diperbarui.');
    }
      
    /**
     * Delete a donation
     * 
     * @param int $id
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
        if ($donation->status == 'claimed') {
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
        if ($donation->status == 'claimed') {
            return redirect()->route('find-donations')
                ->with('error', 'Donasi ini sudah diklaim oleh orang lain.');
        }        // Create a new claim
        $claim = new \App\Models\DonationClaim([
            'donation_id' => $donation->donation_id, // Menggunakan donation_id sesuai model
            'user_id' => Auth::id(),
            'status' => 'pending',
            'notes' => $request->notes ?? null,
        ]);
        
        $claim->save();
        
        // Mark donation as claimed
        $donation->status = 'claimed';
        $donation->save();
        
        return redirect()->route('claims.my')
            ->with('success', 'Donasi berhasil diklaim.');
    }
      
    /**
     * Show a specific claim
     * 
     * @param int $id
     */
    public function showClaim($id)
    {        
        $claim = \App\Models\DonationClaim::with(['donation.donor', 'user'])->findOrFail($id);
        
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
        $donation->status = 'available';
        $donation->save();
        
        // Delete the claim
        $claim->delete();
        
        return redirect()->route('claims.my')
            ->with('success', 'Klaim berhasil dibatalkan.');
    }

    /**
     * Get nearby donations based on user's location
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */    public function getNearbyDonations(Request $request)
    {
        // Validate the input
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        
        $lat = $request->lat;
        $lng = $request->lng;
        
        // Query for available donations
        $query = Donation::with('donor')
            ->where('status', 'available')
            ->where('expiration_date', '>', now());
            
        // Apply any additional filters from the request
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }
        
        if ($request->has('quantity_min') && is_numeric($request->quantity_min)) {
            $query->where('quantity', '>=', $request->quantity_min);
        }
          if ($request->has('pickup_date')) {
            $date = date('Y-m-d', strtotime($request->pickup_date));
            $query->whereDate('expiration_date', '>=', $date);
        }
        
        // Get donations
        $donations = $query->get();
        
        // Calculate distance for each donation and add it as a calculated attribute
        foreach ($donations as $donation) {
            // If the donation has lat/lng, calculate distance
            if ($donation->latitude && $donation->longitude) {
                $distance = $this->calculateDistance(
                    $lat, 
                    $lng, 
                    $donation->latitude, 
                    $donation->longitude
                );
                $donation->setAttribute('distance', $distance);
            } else {
                $donation->setAttribute('distance', null);
            }
        }
        
        // Sort by distance if needed
        if ($request->has('sort') && $request->sort === 'nearest') {
            $donations = $donations->sortBy('distance');
        }
        
        return response()->json([
            'success' => true,
            'donations' => $donations
        ]);
    }
    
    /**
     * Calculate the distance between two coordinates using the Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // radius in kilometers
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earthRadius * $c;
        
        return $distance;
    }
    
    /**
     * Show the form for claiming a donation
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function claimForm($id)
    {
        $donation = Donation::with('donor')->findOrFail($id);
        
        // Check if the donation is available
        if ($donation->status !== 'available') {
            return redirect()->route('find-donations')
                ->with('error', 'Donasi ini tidak tersedia untuk diklaim.');
        }
        
        // Check if the user is trying to claim their own donation
        if ($donation->user_id === Auth::id()) {
            return redirect()->route('find-donations')
                ->with('error', 'Anda tidak dapat mengklaim donasi Anda sendiri.');
        }
        
        return view('donate.claim-form', compact('donation'));
    }

    /**
     * Get coordinates (latitude/longitude) from an address using a geocoding service
     * 
     * @param string $address
     * @return array|null
     */
    private function getCoordinatesFromAddress($address)
    {
        // This is a simplified implementation - in a real project you would 
        // use a geocoding API like Google Maps, MapBox, or OpenStreetMap Nominatim
        
        // For testing purposes, we'll return random coordinates around Jakarta
        // In a production app, replace this with actual geocoding API calls
        $baseLatitude = -6.200000; // Jakarta base coordinates
        $baseLongitude = 106.816666;
        
        // Generate a small random offset (-0.05 to 0.05 degrees)
        $latOffset = (mt_rand(-500, 500) / 10000);
        $lngOffset = (mt_rand(-500, 500) / 10000);
        
        return [
            'lat' => $baseLatitude + $latOffset,
            'lng' => $baseLongitude + $lngOffset
        ];
        
        // Example implementation with Google Maps API:
        /*
        $apiKey = config('services.google_maps.api_key');
        $address = urlencode($address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$apiKey}";
        
        $response = Http::get($url);
        $data = $response->json();
        
        if ($response->successful() && isset($data['results'][0]['geometry']['location'])) {
            return $data['results'][0]['geometry']['location'];
        }
        
        return null;
        */
    }

    /**
     * Find donations by category
     *
     * @param string $category
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */    public function findByCategory($category)
    {
        $query = Donation::with('donor')
            ->where('status', 'available')
            ->where('expiration_date', '>', now());
            
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        
        $donations = $query->orderBy('created_at', 'desc')->paginate(8);
        $categories = Donation::select('category')->distinct()->whereNotNull('category')->pluck('category');
        
        return view('donate.find', compact('donations', 'categories'));
    }
}

