<?php

namespace App\Services;

use App\Models\SystemNotification;
use App\Models\ForumPost;
use App\Models\ForumReply;
use App\Models\Resource;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Create a system notification dynamically for various parent types.
     */
    public function create($noti_type, $parent_type, $title, $content, $parent_id = null)
    {
        $user_id = null;

        switch ($parent_type) {
            case 'forum_reply':
                if($noti_type === 'reply'){
                    $forum_reply = ForumReply::find($parent_id);
                    if($forum_reply->forum_reply_id){
                        $parent_reply = ForumReply::find($forum_reply->forum_reply_id);
                        $user_id = $parent_reply?->userCourse?->user_id;
                    } else {
                        $forum_post = ForumPost::find($forum_reply->forum_post_id);
                        $user_id = $forum_post?->userCourse?->user_id;
                    }
                    break;
                } else if ($noti_type === 'report') {
                    $forum_reply = ForumReply::find($parent_id);
                    $user_id = $forum_reply?->userCourse?->user_id;
                    break;
                }

            case 'forum_post':
                $forum_post = ForumPost::find($parent_id);
                $user_id = $forum_post?->userCourse?->user_id;
                break;

            case 'course':
                $course = Course::find($parent_id);
                $user_id = $course?->userCourses()->where('role_id', 1)->first()?->user_id;
                break;

            case 'resource':
                $resource = Resource::find($parent_id);
                $user_id = $resource?->lesson?->course?->userCourses()
                    ->where('role_id', 1)->first()?->user_id;
                break;

            case 'lesson':
                $lesson = Lesson::find($parent_id);
                $user_id = $lesson?->course?->userCourses()
                    ->where('role_id', 1)->first()?->user_id;
                break;

            case 'user':
                $user_id = User::find($parent_id)?->id;
                break;
        }

        if (!$user_id) {
            Log::warning("Notification not created — no user found for parent_type={$parent_type}, parent_id={$parent_id}");
            return null;
        }

        return SystemNotification::create([
            'user_id'     => $user_id,
            'noti_type'   => $noti_type,
            'parent_type' => $parent_type,
            'title'       => $title,
            'content'     => $content,
            'parent_id'   => $parent_id ?? 0,
            'is_read'     => false,
            'status'      => 1,
        ]);
    }
}
