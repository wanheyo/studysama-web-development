<?php

namespace App\Models;

use App\Models\Report;
use App\Models\ForumPost;
use App\Models\ForumReply;
use App\Models\UserCourse;
use App\Models\ResourceFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_course_id',
        'forum_post_id',
        'content',
        'status',
        'forum_reply_id',
        'resource_file_id',
    ];

    // The reply belongs to a forum post
    public function forumPost()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    // The reply belongs to a user in a course
    public function userCourse()
    {
        return $this->belongsTo(UserCourse::class);
    }

    // Optional file attached to the reply
    public function resourceFile()
    { 
        return $this->belongsTo(ResourceFile::class);
    }

    // Self-referencing: parent reply
    public function parent()
    {
        return $this->belongsTo(ForumReply::class, 'forum_reply_id');
    }

    // Self-referencing: child replies
    public function childrens()
    {
        return $this->hasMany(ForumReply::class, 'forum_reply_id');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reported');
    }

}
