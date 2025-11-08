<?php

namespace App\Models;

use App\Models\Report;
use App\Models\Resource;
use App\Models\ForumReply;
use App\Models\UserCourse;
use App\Models\ResourceFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_course_id',
        'resource_id',
        'title',
        'content',
        'pinned',
        'status',
        'resource_file_id',
    ];

    // A forum post belongs to a user in a course
    public function userCourse()
    {
        return $this->belongsTo(UserCourse::class);
    }

    // A forum post belongs to a resource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    // Optional file attached to the post
    public function resourceFile()
    {
        return $this->belongsTo(ResourceFile::class);
    }

    // A forum post can have many replies
    public function forumReplies()
    {
        return $this->hasMany(ForumReply::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reported');
    }
}
