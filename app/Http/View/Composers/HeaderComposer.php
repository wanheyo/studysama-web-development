<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\SystemNotification;

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
                ->get();
        }

        $view->with('headerNotifications', $notifications);
    }
}
