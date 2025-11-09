<?php

namespace App\Models;

use App\Models\Lesson;
use App\Models\Comment;
use App\Models\ForumPost;
use App\Models\ResourceFile;
use App\Models\UserProgression;
use App\Models\Report;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'lesson_id',
        'file_id', //nullable
        'name',
        'desc', //nullable
        'link', //nullable
        'category', 
        'total_visit',
        'status'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function resourceFile()
    {
        return $this->belongsTo(ResourceFile::class, 'file_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function userProgressions()
    {
        return $this->hasMany(UserProgression::class, 'resource_id');
    }

    // Custom relationship to get only student progressions
    public function studentProgressions()
    {
        return $this->hasMany(UserProgression::class)
            ->whereHas('userCourse', function ($query) {
                $query->where('status', 1)
                    ->where('role_id', 3); // student
            });
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reported');
    }
}
