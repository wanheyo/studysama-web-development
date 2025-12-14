<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Report;
use App\Models\Resource;
use App\Models\ForumPost;

use App\Models\ForumReply;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Http\View\Composers\HeaderComposer;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Limit password reset attempts to 5 per minute
        RateLimiter::for('reset-password', function () {
            return Limit::perMinute(5)->by(request()->input('email'));
        });

        Relation::enforceMorphMap([
            'report' => Report::class,
            'forum_reply' => ForumReply::class,
            'forum_post'  => ForumPost::class,
            'resource'    => Resource::class,
            'lesson'      => Lesson::class,
            'course'      => Course::class,
            'user'        => User::class,
            // You can add more later, e.g.:
            // 'course'      => \App\Models\Course::class,
            // 'lesson'      => \App\Models\Lesson::class,
        ]);

        View::composer('layout.header', HeaderComposer::class);
    }
}
