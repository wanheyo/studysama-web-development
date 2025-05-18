<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Challenge extends Model
{
    use HasFactory;

    protected $table = 'challenges';

    protected $fillable = [
        'title',
        'desc',
        'activity_type',     // mcq, flashcard, wsp
        'period_type',       // daily, weekly, monthly
        'target_count',
        'start_date',
        'end_date',
        'reward_xp',
        'reward_points',
        'badge_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Optional: A challenge may reward a badge
    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    public function userChallenges()
    {
        return $this->hasMany(UserChallenge::class);
    }

}
