<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;



/**
 * User Model
 *
 * @property int $user_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $phone_number
 * @property string|null $address
 * @property string|null $bio
 * @property string|null $profile_photo
 * @property string|null $facebook_url
 * @property string|null $twitter_url
 * @property string|null $instagram_url
 * @property string|null $linkedin_url
 * @property bool $email_notifications
 * @property bool $donation_alerts
 * @property bool $claim_updates
 * @property bool $news_updates
 * @property bool $profile_visibility
 * @property bool $location_sharing
 * @property bool $activity_tracking
 * @property string|null $language
 * @property string|null $timezone
 * @property bool $two_factor_auth
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method void save()
 * @method void delete()
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Donation[] $donations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DonationClaim[] $claims
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Leaderboard[] $leaderboardEntries
 */
use App\Models\Donation;
use App\Models\DonationClaim;
use App\Models\Leaderboard;

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
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donations()
    {
        return $this->hasMany(\App\Models\Donation::class, 'user_id', 'user_id');
    }
    
    /**
     * Get all donation claims made by the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claims()
    {
        return $this->hasMany(\App\Models\DonationClaim::class, 'user_id', 'user_id');
    }

    /**
     * Get leaderboard entries for this user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leaderboardEntries()
    {
        return $this->hasMany(\App\Models\Leaderboard::class, 'user_id', 'user_id');
    }
}
