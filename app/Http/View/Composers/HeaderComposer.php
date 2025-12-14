<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\SystemNotification;
use App\Models\ForumReply;
use App\Models\ForumPost;
use App\Models\Report;
use App\Models\Resource;
use App\Models\Lesson;
use App\Models\Course;


class HeaderComposer
{
    public function compose(View $view)
    {
        $notifications = [];

        if (auth()->check()) {
            $notifications = SystemNotification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->with(['parentable' => function ($morphTo) {
                    $morphTo->morphWith([
                        ForumPost::class => ['userCourse.user', 'reports'],
                        ForumReply::class => ['userCourse.user', 'reports'],
                        Resource::class => ['lesson.course.userCourses.user', 'reports'],
                        Lesson::class => ['course.userCourses.user', 'reports'],
                        Course::class => ['userCourses.user', 'reports'],
                        User::class => ['reports'],
                    ]);

                    $morphTo->morphWithCount([
                        ForumPost::class => ['reports'],
                        ForumReply::class => ['reports'],
                        Resource::class => ['reports'],
                        Lesson::class => ['reports'],
                        Course::class => ['reports'],
                        User::class => ['reports'],
                    ]);
                }])
                ->get();
        }

        $view->with('headerNotifications', $notifications);
    }
}
