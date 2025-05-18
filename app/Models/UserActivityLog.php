<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivityLog extends Model
{
    use HasFactory;

    protected $table = 'user_activity_logs';

    protected $fillable = [
        'user_id',
        'activity_type',      // e.g., mcq, flashcard, wsp
        'xp_earned',
        'max_xp',
        'points_earned',
        'token_used',
        'topic',
        'file_name',
        'completed_at',
        'status',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    // Relationship: each activity log belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
