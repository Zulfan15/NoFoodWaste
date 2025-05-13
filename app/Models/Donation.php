<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Donation Model
 *
 * @property int $donation_id
 * @property int $user_id
 * @property string $food_name
 * @property string $category
 * @property int $quantity
 * @property string $description
 * @property string|null $image
 * @property string $pickup_location
 * @property float|null $latitude
 * @property float|null $longitude
 * @property \Illuminate\Support\Carbon $expiration_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\User $donor
 * @property-read \App\Models\DonationClaim|null $claim
 * @property-read string $title
 */
class Donation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'donations';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'donation_id';    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'user_id',
        'food_name',
        'category',
        'quantity',
        'description',
        'image',
        'pickup_location',
        'latitude',
        'longitude',
        'expiration_date',
        'status',
        // Aliases to maintain compatibility with controllers
        'title',
        'expiry_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiration_date' => 'datetime',
    ];

    /**
     * Get the user who donated the food.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the claim for this donation.
     */
    public function claim(): HasOne
    {
        return $this->hasOne(DonationClaim::class, 'donation_id', 'donation_id');
    }

    /**
     * Scope a query to only include available donations.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include claimed donations.
     */
    public function scopeClaimed($query)
    {
        return $query->where('status', 'claimed');
    }

    /**
     * Scope a query to only include expired donations.
     */    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Get the food name attribute (alias for title).
     *
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->food_name;
    }

    /**
     * Set the food name via the title attribute.
     *
     * @param string $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['food_name'] = $value;
    }

    /**
     * Get the description attribute (alias for food_name).
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return $this->food_name; // Using food_name as description for compatibility
    }

    /**
     * Get expiry_date attribute (alias for expiration_date).
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getExpiryDateAttribute()
    {
        return $this->expiration_date;
    }

    /**
     * Set the expiration date via the expiry_date attribute.
     *
     * @param string $value
     * @return void
     */
    public function setExpiryDateAttribute($value)
    {
        $this->attributes['expiration_date'] = $value;
    }
}
