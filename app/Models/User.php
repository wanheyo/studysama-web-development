<?php

namespace App\Models;

use App\Models\User;
use App\Models\Badge;
use App\Models\Course;
use App\Models\SocialLink;
use App\Models\UserCourse;
use App\Models\UserActivityLog;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone_num',
        'bio',
        'total_follower',
        'average_rating',
        'social_link',
        'image',
        'last_changed_at',
        'verification_status',
        'status',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // A user can follow many users
    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follower_id', 'following_id')
                    ->withTimestamps();
    }

    // A user can be followed by many users
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'following_id', 'follower_id')
                    ->withTimestamps();
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withTimestamps();
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }


    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_courses')
                    ->withPivot(['role_id', 'rating', 'comment', 'status'])
                    ->withTimestamps();
    }
    
    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(UserActivityLog::class);
    }

    public function userChallenges()
    {
        return $this->hasMany(UserChallenge::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\CustomResetPasswordNotification($token));
    }
}
