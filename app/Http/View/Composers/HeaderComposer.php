<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\SystemNotification;
use App\Models\ForumReply;
use App\Models\ForumPost;
use App\Models\Report;

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
                        Report::class => ['user'],
                        ForumPost::class => ['userCourse.user'],
                        ForumReply::class => ['userCourse.user'],
                    ]);
                }])
                ->get();
        }

        $view->with('headerNotifications', $notifications);
    }
}
