<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'donation_claim_id',
        'beneficiaries',
        'people_served',
        'distribution_date',
        'notes',
        'photos',
    ];

    /**
     * Get the donation claim that this report belongs to.
     */
    public function donationClaim()
    {
        return $this->belongsTo(DonationClaim::class);
    }
}
