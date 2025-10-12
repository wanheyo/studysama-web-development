<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Comment;
use App\Models\ForumPost;
use App\Models\Attendance;
use App\Models\ForumReply;
use App\Models\Certificate;
use App\Models\UserProgression;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCourse extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    
    protected $table = 'user_courses';
    
    public $incrementing = true;
    
    protected $fillable = [
        'user_id',
        'course_id',
        'role_id',
        'rating',
        'comment',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function comments()
    { 
        return $this->hasMany(Comment::class);
    }

    public function userProgressions()
    {
        return $this->hasMany(UserProgression::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function forumReplies()
    {
        return $this->hasMany(ForumReply::class);
    }
}
