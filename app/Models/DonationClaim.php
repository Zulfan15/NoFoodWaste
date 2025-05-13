<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DonationClaim Model
 *
 * @property int $claim_id
 * @property int $donation_id
 * @property int $user_id
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Donation $donation
 * @property-read \App\Models\User $user
 */
class DonationClaim extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'donation_claims';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'claim_id';    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'donation_id',
        'user_id',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];    /**
     * The model's boot method.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // We no longer need to set claim_time as it has been removed
    }

    /**
     * Get the donation associated with this claim.
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class, 'donation_id', 'donation_id');
    }    /**
     * Get the user who claimed the donation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Scope a query to only include pending claims.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved claims.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected claims.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope a query to only include completed claims.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
