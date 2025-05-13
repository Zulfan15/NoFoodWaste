<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }    /**
     * Show the user profile page
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        
        // Get user's donations
        $donations = $user->donations()->orderBy('created_at', 'desc')->get() ?? collect([]);
        
        // Get user's claims
        $claims = $user->claims()->with('donation.donor')->orderBy('created_at', 'desc')->get() ?? collect([]);
        
        // Calculate statistics
        $stats = [
            'total_donations' => $donations->count(),
            'claimed_donations' => $donations->where('status', 'claimed')->count(),
            'available_donations' => $donations->where('status', 'available')->count(),
            'expired_donations' => $donations->where('status', 'expired')->count(),
            'total_claims' => $claims->count(),
            'completed_claims' => $claims->where('status', 'completed')->count(),
            'pending_claims' => $claims->where('status', 'pending')->count()
        ];
        
        // Get recent activities (combine donations and claims)
        $recentDonations = $donations->take(5)->map(function($donation) {
            return [
                'id' => $donation->donation_id,
                'type' => 'donation',
                'title' => $donation->name,
                'status' => $donation->status,
                'date' => $donation->created_at,
                'url' => route('donations.show', $donation->donation_id)
            ];
        });
        
        $recentClaims = $claims->take(5)->map(function($claim) {
            return [
                'id' => $claim->claim_id,
                'type' => 'claim',
                'title' => $claim->donation->name ?? 'Unknown Donation',
                'status' => $claim->status,
                'date' => $claim->created_at,
                'url' => route('claims.show', $claim->claim_id)
            ];
        });
        
        // Combine and sort by date
        $recentActivities = $recentDonations->concat($recentClaims)
            ->sortByDesc('date')
            ->take(5);
        
        return view('user.profile', compact('user', 'stats', 'recentActivities'));
    }
    
    /**
     * Update the user profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->user_id, 'user_id')],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
        ]);
        
        $user->username = $request->username;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->bio = $request->bio;
        $user->facebook_url = $request->facebook_url;
        $user->twitter_url = $request->twitter_url;
        $user->instagram_url = $request->instagram_url;
        $user->linkedin_url = $request->linkedin_url;
        
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Update the user password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password saat ini tidak cocok.');
                }
            }],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
      /**
     * Show the user settings page
     *
     * @return \Illuminate\View\View
     */
    public function showSettings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }    /**
     * Update user notification settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $settingsType = $request->input('settings_type');
        
        switch ($settingsType) {
            case 'notifications':
                $user->email_notifications = $request->has('emailNotifications');
                $user->donation_alerts = $request->has('donationAlerts');
                $user->claim_updates = $request->has('claimUpdates');
                $user->news_updates = $request->has('newsUpdates');
                break;
                
            case 'privacy':
                $user->profile_visibility = $request->has('profileVisibility');
                $user->location_sharing = $request->has('locationSharing');
                $user->activity_tracking = $request->has('activityTracking');
                break;
                
            case 'account':
                $user->language = $request->input('language');
                $user->timezone = $request->input('timezone');
                $user->two_factor_auth = $request->has('twoFactorAuth');
                break;
                
            default:
                return redirect()->route('settings')->with('error', 'Tipe pengaturan tidak valid.');
        }
        
        $user->save();
        
        return redirect()->route('settings')->with('success', 'Pengaturan berhasil disimpan!');
    }    /**
     * Show the user's activity page
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function activity()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        
        $user = Auth::user();
          // Get user's donations
        $donations = $user->donations()->orderBy('created_at', 'desc')->get() ?? collect([]);
        
        // Get user's claims
        $claims = $user->claims()->with('donation.donor')->orderBy('created_at', 'desc')->get() ?? collect([]);
        
        // Calculate statistics
        $stats = [
            'total_donations' => $donations->count(),
            'claimed_donations' => $donations->where('status', 'claimed')->count(),
            'available_donations' => $donations->where('status', 'available')->count(),
            'my_claims' => $claims->count(),
        ];
        
        // Get recent donations and claims
        $recentDonations = $donations->take(5);
        $recentClaims = $claims->take(5);
        
        return view('user.activity', compact('stats', 'recentDonations', 'recentClaims'));
    }
    
    /**
     * Update the user's profile photo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                $oldPhotoPath = storage_path('app/public/profile_photos/' . $user->profile_photo);
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            
            // Store the new photo
            $photoName = time() . '_' . $user->user_id . '.' . $request->profile_photo->extension();
            
            // Use the proper Laravel storage system
            $request->file('profile_photo')->storeAs('public/profile_photos', $photoName);
            
            // Update user record
            $user->profile_photo = $photoName;
            $user->save();
            
            return redirect()->route('profile')->with('success', 'Foto profil berhasil diperbarui!');
        }
        
        return redirect()->route('profile')->with('error', 'Gagal mengupload foto profil.');
    }
    
    /**
     * Deactivate the user account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password yang dimasukkan tidak cocok.');
                }
            }],
        ]);
        
        // For now, we'll just log the user out and show a message
        // In a real implementation, you'd set a 'is_active' flag to false
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('info', 'Akun Anda telah dinonaktifkan.');
    }
    
    /**
     * Permanently delete the user account
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password yang dimasukkan tidak cocok.');
                }
            }],
            'confirm_delete' => ['required', 'accepted'],
        ]);
        
        // Logout first
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Delete the user
        $user->delete();
        
        return redirect()->route('login')->with('info', 'Akun Anda telah dihapus permanen.');
    }
}
