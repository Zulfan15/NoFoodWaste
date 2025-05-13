<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Handles user profile management operations.
 */
class ProfileController extends Controller
{    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
      /**
     * Show the user profile page
     *
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        /** @var \App\Models\User $user */
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
    }    /**
     * Update the user profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
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
        $user->twitter_url = $request->twitter_url;        $user->instagram_url = $request->instagram_url;
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
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $request->validate([            'current_password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password saat ini tidak cocok.');
                }
            }],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }    /**
     * Show user settings page 
     *
     * @return \Illuminate\View\View
     */
    public function showSettings(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Get available time zones for dropdown
        $timezones = [
            'Asia/Jakarta' => 'Asia/Jakarta (GMT+7)',
            'Asia/Makassar' => 'Asia/Makassar (GMT+8)',
            'Asia/Jayapura' => 'Asia/Jayapura (GMT+9)'
        ];
        
        // Get available languages for dropdown
        $languages = [
            'id' => 'Bahasa Indonesia',
            'en' => 'English'
        ];
        
        // Calculate settings completion percentage
        $settingsCompletion = $this->calculateSettingsCompletion($user);
        
        return view('user.settings', compact('user', 'timezones', 'languages', 'settingsCompletion'));
    }
    
    /**
     * Calculate settings completion percentage for the user
     *
     * @param \App\Models\User $user
     * @return int
     */
    private function calculateSettingsCompletion($user): int
    {
        // Define all important settings that should be set
        $settingsChecklist = [
            // Account settings
            'password_updated' => !is_null($user->password_updated_at), // Check if password ever updated
            'profile_complete' => !empty($user->phone_number) && !empty($user->address),
            'two_factor_auth' => (bool) $user->two_factor_auth,
            
            // Notification settings
            'email_notifications' => (bool) $user->email_notifications,
            'donation_alerts' => (bool) $user->donation_alerts,
            'notification_preferences_set' => (bool) $user->in_app_notifications,
            
            // Privacy settings
            'privacy_preferences_set' => true, // Default settings are fine
            
            // Advanced settings
            'donation_radius_set' => !is_null($user->donation_radius)
        ];
        
        // Count completed settings
        $completedSettings = count(array_filter($settingsChecklist));
        $totalSettings = count($settingsChecklist);
        
        // Calculate percentage
        return round(($completedSettings / $totalSettings) * 100);
    }    /**
     * Update user notification settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $settingsType = $request->input('settings_type');
        
        // Validate the settings type first
        if (!in_array($settingsType, ['notifications', 'privacy', 'account', 'data'])) {
            return redirect()->route('settings')->with('error', 'Tipe pengaturan tidak valid.');
        }
        
        // Track which settings were changed for audit log
        $changedSettings = [];
        
        switch ($settingsType) {
            case 'notifications':
                // Validate notification settings
                $validated = $request->validate([
                    'notificationFrequency' => 'nullable|in:immediate,daily,weekly',
                    'donationRadius' => 'nullable|numeric|min:1|max:100',
                    'donationCategories' => 'nullable|array',
                    'donationCategories.*' => 'in:food,beverage,fruit,vegetable,staple,other',
                    'enableDonationMap' => 'nullable|boolean',
                ]);
                
                // Email notifications
                if ($user->email_notifications != $request->has('emailNotifications')) {
                    $changedSettings['email_notifications'] = [
                        'old' => $user->email_notifications,
                        'new' => $request->has('emailNotifications')
                    ];
                }
                $user->email_notifications = $request->has('emailNotifications');
                
                // Donation alerts
                if ($user->donation_alerts != $request->has('donationAlerts')) {
                    $changedSettings['donation_alerts'] = [
                        'old' => $user->donation_alerts,
                        'new' => $request->has('donationAlerts')
                    ];
                }
                $user->donation_alerts = $request->has('donationAlerts');
                
                // Claim updates
                if ($user->claim_updates != $request->has('claimUpdates')) {
                    $changedSettings['claim_updates'] = [
                        'old' => $user->claim_updates,
                        'new' => $request->has('claimUpdates')
                    ];
                }
                $user->claim_updates = $request->has('claimUpdates');
                
                // News updates
                if ($user->news_updates != $request->has('newsUpdates')) {
                    $changedSettings['news_updates'] = [
                        'old' => $user->news_updates,
                        'new' => $request->has('newsUpdates')
                    ];
                }
                $user->news_updates = $request->has('newsUpdates');
                
                // Handle new system notification settings if available
                $newSystemNotifications = $request->has('systemNotifications');
                if ($user->system_notifications != $newSystemNotifications) {
                    $changedSettings['system_notifications'] = [
                        'old' => $user->system_notifications,
                        'new' => $newSystemNotifications
                    ];
                }
                
                if ($newSystemNotifications) {
                    $user->system_notifications = true;
                    $newFrequency = $request->input('notificationFrequency', 'immediate');
                    
                    if ($user->notification_frequency != $newFrequency) {
                        $changedSettings['notification_frequency'] = [
                            'old' => $user->notification_frequency,
                            'new' => $newFrequency
                        ];
                    }
                    $user->notification_frequency = $newFrequency;
                } else {
                    $user->system_notifications = false;
                }
                
                // Preferensi komunikasi - In-app notifications
                if ($user->in_app_notifications != $request->has('inAppNotifications')) {
                    $changedSettings['in_app_notifications'] = [
                        'old' => $user->in_app_notifications,
                        'new' => $request->has('inAppNotifications')
                    ];
                }
                $user->in_app_notifications = $request->has('inAppNotifications');
                
                // Direct messages
                if ($user->direct_messages != $request->has('directMessages')) {
                    $changedSettings['direct_messages'] = [
                        'old' => $user->direct_messages,
                        'new' => $request->has('directMessages')
                    ];
                }
                $user->direct_messages = $request->has('directMessages');
                
                // Preferensi jarak donasi
                if ($request->has('donationRadius')) {
                    $newRadius = intval($request->input('donationRadius'));
                    if ($user->donation_radius != $newRadius) {
                        $changedSettings['donation_radius'] = [
                            'old' => $user->donation_radius,
                            'new' => $newRadius
                        ];
                    }
                    $user->donation_radius = $newRadius;
                }
                
                // Priority notifications
                if ($user->priority_notifications != $request->has('priorityNotifications')) {
                    $changedSettings['priority_notifications'] = [
                        'old' => $user->priority_notifications,
                        'new' => $request->has('priorityNotifications')
                    ];
                }
                $user->priority_notifications = $request->has('priorityNotifications');
                
                // Donation map
                if ($user->enable_donation_map != $request->has('enableDonationMap')) {
                    $changedSettings['enable_donation_map'] = [
                        'old' => $user->enable_donation_map,
                        'new' => $request->has('enableDonationMap')
                    ];
                }
                $user->enable_donation_map = $request->has('enableDonationMap');
                
                // Preferensi kategori donasi
                $oldCategories = json_encode($user->donation_categories);
                $newCategories = $request->has('donationCategories') ? $request->input('donationCategories') : [];
                if ($oldCategories != json_encode($newCategories)) {
                    $changedSettings['donation_categories'] = [
                        'old' => $user->donation_categories,
                        'new' => $newCategories
                    ];
                }
                $user->donation_categories = $newCategories;
                break;
                
            case 'privacy':
                // Validate privacy settings
                $validated = $request->validate([
                    'profileVisibility' => 'nullable|boolean',
                    'locationSharing' => 'nullable|boolean',
                    'activityTracking' => 'nullable|boolean',
                    'cookieConsent' => 'nullable|boolean',
                ]);
                
                // Profile visibility
                if ($user->profile_visibility != $request->has('profileVisibility')) {
                    $changedSettings['profile_visibility'] = [
                        'old' => $user->profile_visibility,
                        'new' => $request->has('profileVisibility')
                    ];
                }
                $user->profile_visibility = $request->has('profileVisibility');
                
                // Location sharing
                if ($user->location_sharing != $request->has('locationSharing')) {
                    $changedSettings['location_sharing'] = [
                        'old' => $user->location_sharing,
                        'new' => $request->has('locationSharing')
                    ];
                }
                $user->location_sharing = $request->has('locationSharing');
                
                // Activity tracking
                if ($user->activity_tracking != $request->has('activityTracking')) {
                    $changedSettings['activity_tracking'] = [
                        'old' => $user->activity_tracking,
                        'new' => $request->has('activityTracking')
                    ];
                }
                $user->activity_tracking = $request->has('activityTracking');
                
                // Cookie consent
                if ($user->cookie_consent != $request->has('cookieConsent')) {
                    $changedSettings['cookie_consent'] = [
                        'old' => $user->cookie_consent,
                        'new' => $request->has('cookieConsent')
                    ];
                }
                $user->cookie_consent = $request->has('cookieConsent');
                break;
                
            case 'account':
                // Validate account settings
                $validated = $request->validate([
                    'language' => 'required|in:id,en',
                    'timezone' => 'required|in:Asia/Jakarta,Asia/Makassar,Asia/Jayapura',
                    'twoFactorAuth' => 'nullable|boolean',
                    'loginAlerts' => 'nullable|boolean',
                ]);
                
                // Language
                if ($user->language != $request->input('language')) {
                    $changedSettings['language'] = [
                        'old' => $user->language,
                        'new' => $request->input('language')
                    ];
                }
                $user->language = $request->input('language');
                
                // Timezone
                if ($user->timezone != $request->input('timezone')) {
                    $changedSettings['timezone'] = [
                        'old' => $user->timezone,
                        'new' => $request->input('timezone')
                    ];
                }
                $user->timezone = $request->input('timezone');
                
                // Two-factor authentication
                if ($user->two_factor_auth != $request->has('twoFactorAuth')) {
                    $changedSettings['two_factor_auth'] = [
                        'old' => $user->two_factor_auth,
                        'new' => $request->has('twoFactorAuth')
                    ];
                }
                $user->two_factor_auth = $request->has('twoFactorAuth');
                
                // Login alerts
                if ($user->login_alerts != $request->has('loginAlerts')) {
                    $changedSettings['login_alerts'] = [
                        'old' => $user->login_alerts,
                        'new' => $request->has('loginAlerts')
                    ];
                }
                $user->login_alerts = $request->has('loginAlerts');
                break;
                
            default:
                return redirect()->route('settings')->with('error', 'Tipe pengaturan tidak valid.');
        }
        
        // Log settings changes if any were made
        if (!empty($changedSettings)) {
            \Illuminate\Support\Facades\Log::info('User updated settings', [
                'user_id' => $user->id,
                'settings_type' => $settingsType,
                'changes' => $changedSettings,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }
        
        $user->settings_updated_at = now();
        $user->save();
        
        return redirect()->route('settings', ['#'.$settingsType, 'success' => 'true'])->with('success', 'Pengaturan berhasil disimpan!');
    }/**
     * Show the user's activity page
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function activity(): View|RedirectResponse
    {        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        
        /** @var \App\Models\User $user */
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
     */
    public function updateProfilePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        /** @var \App\Models\User $user */
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
    public function deactivate(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
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
    public function deleteAccount(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
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
    
    /**
     * Export user data based on type
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function exportData(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $type = $request->input('type', 'profile');
        
        // Prepare data based on type
        switch ($type) {
            case 'profile':
                $data = [
                    'profile' => [
                        'user_id' => $user->user_id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'name' => $user->name,
                        'phone_number' => $user->phone_number,
                        'address' => $user->address,
                        'bio' => $user->bio,
                        'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                        'last_login' => $user->last_login ? $user->last_login->format('Y-m-d H:i:s') : null,
                    ],
                    'settings' => [
                        'language' => $user->language,
                        'timezone' => $user->timezone,
                        'email_notifications' => $user->email_notifications,
                        'donation_alerts' => $user->donation_alerts,
                        'claim_updates' => $user->claim_updates,
                        'news_updates' => $user->news_updates,
                        'profile_visibility' => $user->profile_visibility,
                        'location_sharing' => $user->location_sharing,
                        'activity_tracking' => $user->activity_tracking,
                        'cookie_consent' => $user->cookie_consent,
                        'two_factor_auth' => $user->two_factor_auth,
                        'login_alerts' => $user->login_alerts,
                    ]
                ];
                $filename = 'nofoodwaste_profile_data_' . date('Y-m-d') . '.json';
                break;
                
            case 'activity':
                // Get user's donations
                $donations = $user->donations()->orderBy('created_at', 'desc')->get();
                
                // Get user's claims
                $claims = $user->claims()->with('donation')->orderBy('created_at', 'desc')->get();
                
                $data = [
                    'donations' => $donations->map(function($donation) {
                        return [
                            'donation_id' => $donation->donation_id,
                            'name' => $donation->name,
                            'description' => $donation->description,
                            'category' => $donation->category,
                            'quantity' => $donation->quantity,
                            'expiry_date' => $donation->expiry_date,
                            'status' => $donation->status,
                            'created_at' => $donation->created_at->format('Y-m-d H:i:s'),
                            'updated_at' => $donation->updated_at->format('Y-m-d H:i:s'),
                        ];
                    })->toArray(),
                    'claims' => $claims->map(function($claim) {
                        return [
                            'claim_id' => $claim->claim_id,
                            'donation_name' => $claim->donation->name ?? 'Unknown Donation',
                            'status' => $claim->status,
                            'created_at' => $claim->created_at->format('Y-m-d H:i:s'),
                            'updated_at' => $claim->updated_at->format('Y-m-d H:i:s'),
                        ];
                    })->toArray()
                ];
                $filename = 'nofoodwaste_activity_data_' . date('Y-m-d') . '.json';
                break;
                
            default:
                return redirect()->route('settings', ['#data'])->with('error', 'Tipe data tidak valid.');
        }
        
        // Create JSON file in temp directory
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $tempFile = tempnam(sys_get_temp_dir(), 'export_');
        file_put_contents($tempFile, $json);
        
        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ])->deleteFileAfterSend(true);
    }
    
    /**
     * Process user data deletion request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processDataDeletionRequest(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'deletion_type' => 'required|in:activity,location,messages',
            'deletion_reason' => 'required|string|max:500',
            'deletion_confirm' => 'required'
        ]);
        
        // Log the deletion request
        \Illuminate\Support\Facades\Log::info('Data deletion request', [
            'user_id' => $user->user_id,
            'deletion_type' => $validated['deletion_type'],
            'reason' => $validated['deletion_reason']
        ]);
        
        // Process based on deletion type
        switch ($validated['deletion_type']) {
            case 'activity':
                // This would actually be implemented to delete activity data
                // For now, we'll just acknowledge the request
                break;
                
            case 'location':
                // Clear location data
                $user->latitude = null;
                $user->longitude = null;
                $user->last_location_update = null;
                $user->save();
                break;
                
            case 'messages':
                // This would actually delete messages
                // For now, we'll just acknowledge the request
                break;
        }
        
        // Send email notification to admin (would be implemented in a real system)
        // Mail::to('admin@nofoodwaste.com')->send(new DataDeletionRequestMail($user, $validated));
        
        return redirect()->route('settings', ['#data'])->with('success', 'Permintaan penghapusan data telah diterima. Kami akan memprosesnya dalam 7 hari kerja.');
    }
    
    /**
     * Export user data in requested format
     *
     * @param  string  $type   The type of data to export (profile, activity)
     * @param  string  $format The format to export data in (json, csv)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exportUserData(string $type, string $format)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Validate request parameters
        if (!in_array($type, ['profile', 'activity'])) {
            abort(400, 'Invalid export type');
        }
        
        if (!in_array($format, ['json', 'csv'])) {
            abort(400, 'Invalid export format');
        }
        
        $data = [];
        $filename = 'nofoodwaste_' . $type . '_' . date('Y-m-d');
        
        if ($type === 'profile') {
            // Prepare user profile data
            $data = [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'address' => $user->address,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'preferences' => [
                    'email_notifications' => (bool)$user->email_notifications,
                    'donation_alerts' => (bool)$user->donation_alerts,
                    'claim_updates' => (bool)$user->claim_updates,
                    'news_updates' => (bool)$user->news_updates,
                    'system_notifications' => (bool)$user->system_notifications,
                    'notification_frequency' => $user->notification_frequency,
                    'in_app_notifications' => (bool)$user->in_app_notifications,
                    'direct_messages' => (bool)$user->direct_messages,
                    'donation_radius' => $user->donation_radius,
                    'priority_notifications' => (bool)$user->priority_notifications,
                    'donation_categories' => $user->donation_categories,
                    'language' => $user->language,
                    'timezone' => $user->timezone,
                ],
                'privacy' => [
                    'profile_visibility' => (bool)$user->profile_visibility,
                    'location_sharing' => (bool)$user->location_sharing,
                    'activity_tracking' => (bool)$user->activity_tracking,
                    'cookie_consent' => (bool)$user->cookie_consent,
                ],
                'export_date' => now()->format('Y-m-d H:i:s')
            ];
        } else {
            // Prepare user activity data
            $donations = $user->donations()->orderBy('created_at', 'desc')->get();
            $claims = $user->claims()->with('donation.donor')->orderBy('created_at', 'desc')->get();
            
            $data = [
                'user_id' => $user->id,
                'export_date' => now()->format('Y-m-d H:i:s'),
                'donations' => $donations->map(function ($donation) {
                    return [
                        'id' => $donation->id,
                        'title' => $donation->title,
                        'description' => $donation->description,
                        'location' => $donation->location,
                        'status' => $donation->status,
                        'created_at' => $donation->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $donation->updated_at->format('Y-m-d H:i:s'),
                    ];
                }),
                'claims' => $claims->map(function ($claim) {
                    return [
                        'id' => $claim->id,
                        'donation_id' => $claim->donation_id,
                        'donation_title' => $claim->donation->title ?? 'Unknown',
                        'donor_name' => $claim->donation->donor->name ?? 'Unknown',
                        'status' => $claim->status,
                        'created_at' => $claim->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $claim->updated_at->format('Y-m-d H:i:s'),
                    ];
                }),
            ];
        }
        
        // Log the export activity
        \Illuminate\Support\Facades\Log::info('User exported data', [
            'user_id' => $user->id,
            'export_type' => $type,
            'export_format' => $format,
            'ip_address' => request()->ip(),
        ]);
        
        // Return data in requested format
        if ($format === 'json') {
            return response()->json($data)
                ->header('Content-Disposition', 'attachment; filename=' . $filename . '.json');
        } else {
            // For CSV, we need to flatten the data
            if ($type === 'profile') {
                $csv = "Property,Value\n";
                $csv .= "user_id," . $data['user_id'] . "\n";
                $csv .= "name," . $data['name'] . "\n";
                $csv .= "email," . $data['email'] . "\n";
                $csv .= "phone_number," . $data['phone_number'] . "\n";
                $csv .= "address," . $data['address'] . "\n";
                $csv .= "created_at," . $data['created_at'] . "\n";
                
                foreach ($data['preferences'] as $key => $value) {
                    if (is_array($value)) {
                        $value = implode(',', $value);
                    } elseif (is_bool($value)) {
                        $value = $value ? 'Yes' : 'No';
                    }
                    $csv .= "preference_" . $key . "," . $value . "\n";
                }
                
                foreach ($data['privacy'] as $key => $value) {
                    $value = $value ? 'Yes' : 'No';
                    $csv .= "privacy_" . $key . "," . $value . "\n";
                }
                
                $csv .= "export_date," . $data['export_date'] . "\n";
            } else {
                $csv = "Type,ID,Title,Description,Status,Created At\n";
                
                foreach ($data['donations'] as $donation) {
                    $csv .= "Donation,";
                    $csv .= $donation['id'] . ",";
                    $csv .= "\"" . str_replace("\"", "\"\"", $donation['title']) . "\",";
                    $csv .= "\"" . str_replace("\"", "\"\"", $donation['description']) . "\",";
                    $csv .= $donation['status'] . ",";
                    $csv .= $donation['created_at'] . "\n";
                }
                
                foreach ($data['claims'] as $claim) {
                    $csv .= "Claim,";
                    $csv .= $claim['id'] . ",";
                    $csv .= "\"" . str_replace("\"", "\"\"", $claim['donation_title']) . "\",";
                    $csv .= "\"From: " . str_replace("\"", "\"\"", $claim['donor_name']) . "\",";
                    $csv .= $claim['status'] . ",";
                    $csv .= $claim['created_at'] . "\n";
                }
            }
            
            return response($csv)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename=' . $filename . '.csv');
        }
    }
    
    /**
     * Show user's notifications
     *
     * @return \Illuminate\View\View
     */
    public function notifications(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Get user's notifications
        $notifications = $user->notifications()->paginate(10);
        
        // Mark notifications as read if requested
        if (request()->has('mark_as_read') && request()->mark_as_read === 'true') {
            $user->unreadNotifications->markAsRead();
        }
        
        return view('user.notifications', [
            'notifications' => $notifications,
            'unreadCount' => $user->unreadNotifications->count()
        ]);
    }
}
