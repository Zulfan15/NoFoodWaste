<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $primaryKey = 'user_id';    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'phone_number',
        'address',
        'bio',
        'profile_photo',
        // Social media links
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        // Notification settings
        'email_notifications',
        'donation_alerts',
        'claim_updates',
        'news_updates',
        // Privacy settings
        'profile_visibility',
        'location_sharing',
        'activity_tracking',
        // Account settings
        'language',
        'timezone',
        'two_factor_auth'
    ];
      protected $hidden = [
        'password',
    ];
      protected $casts = [
        // Notification settings
        'email_notifications' => 'boolean',
        'donation_alerts' => 'boolean',
        'claim_updates' => 'boolean',
        'news_updates' => 'boolean',
        // Privacy settings
        'profile_visibility' => 'boolean',
        'location_sharing' => 'boolean',
        'activity_tracking' => 'boolean',
        // Account settings
        'two_factor_auth' => 'boolean',
    ];
    
    /**
     * Get all donations made by the user.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class, 'user_id', 'user_id');
    }
    
    /**
     * Get all donation claims made by the user.
     */
    public function claims()
    {
        return $this->hasMany(DonationClaim::class, 'user_id', 'user_id');
    }

    /**
     * Get leaderboard entries for this user.
     */
    public function leaderboardEntries()
    {
        return $this->hasMany(Leaderboard::class, 'user_id', 'user_id');
    }
}
