<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPoint extends Model
{
    use HasFactory;

    protected $table = 'user_points';

    protected $fillable = [
        'user_id',
        'xp',
        'level',
        'total_points',
        'current_streak',
        'longest_streak',
        'last_streak_date',
        'status',
    ];

    protected $casts = [
        'last_streak_date' => 'datetime',
    ];

    // Relationship: Each point record belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
