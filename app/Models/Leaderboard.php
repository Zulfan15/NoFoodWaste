<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leaderboard extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leaderboards';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'leaderboard_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_food_donated',
        'rank',
        'period',
    ];

    /**
     * Get the user who is ranked on the leaderboard.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
