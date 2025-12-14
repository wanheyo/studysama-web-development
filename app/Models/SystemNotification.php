<?php

namespace App\Models;

use App\Models\User;
use App\Models\SystemNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'content',
        'is_read',
        'noti_type', // e.g., 'report', 'message', 'course', 'system', etc.
        'report_id',
        'parent_type', // e.g., 'forum_post', 'forum_replies', 'course', etc.
        'read_at',
        'status',
        'parent_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'status' => 'integer',
    ];

    /**
     * Get the user who owns the system notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the parent notification, if any.
     */
    public function parent()
    {
        return $this->belongsTo(SystemNotification::class, 'parent_id');
    }

    /**
     * Get child notifications (if this is a parent).
     */
    public function children()
    {
        return $this->hasMany(SystemNotification::class, 'parent_id');
    }

    public function parentable()
    {
        return $this->morphTo(__FUNCTION__, 'parent_type', 'parent_id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}
