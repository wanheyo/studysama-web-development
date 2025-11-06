<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Resource;
use App\Models\ResourceFile;
use App\Models\UserProgression;
use App\Models\Comment;
use App\Models\ForumPost;
use App\Models\ForumReply;
use App\Models\Report;
use App\Models\SystemNotification;
use Illuminate\Http\Request;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    private function calculateCourseProgress($courseId)
    {
        $lessons = Lesson::with([
            'resources' => function ($query) {
                $query->where('status', 1)
                    ->with(['resourceFile' => function ($query) {
                        $query->where('status', 1);
                    }])
                    ->with(['comments' => function ($query) {
                        $query->where('status', 1)
                            ->with(['userCourse.user']);
                    }])
                    ->with(['userProgressions' => function ($query) {
                        $query->whereHas('userCourse', function ($subQuery) {
                            $subQuery->where('user_id', auth()->id())
                                    ->where('status', 1);
                        });
                    }]);
            }
        ])
        ->where('course_id', $courseId)
        ->where('status', 1)
        ->orderByRaw('CASE WHEN order_index IS NULL THEN 1 ELSE 0 END, order_index ASC')
        ->orderBy('id', 'ASC')
        ->get();

        $totalResources = 0;
        $totalChecked   = 0;
        $totalCompletedLessons = 0;

        foreach ($lessons as $lesson) {
            $lessonResourceCount = $lesson->resources->count();
            $lessonCheckedCount  = $lesson->resources->sum(
                fn($resource) => $resource->userProgressions->where('status', 1)->count()
            );

            $totalResources += $lessonResourceCount;
            $totalChecked   += $lessonCheckedCount;

            if ($lessonResourceCount > 0 && $lessonCheckedCount === $lessonResourceCount) {
                $totalCompletedLessons++;
            }
        }

        return $totalResources > 0
            ? round(($totalChecked / $totalResources) * 100, 1)
            : 0;
    }

    public function homepage(Request $request)
    {
        $user = auth()->user();

        $coursesQuery = DB::table('courses as c')
            ->join('user_courses as uc', function ($join) use ($user) {
                $join->on('uc.course_id', '=', 'c.id')
                    ->where('uc.user_id', '=', $user->id)
                    ->where('uc.status', '!=', 0); // ✅ filter out inactive user-course entries
            })
            ->join('user_courses as tutor_uc', function ($join) {
                $join->on('tutor_uc.course_id', '=', 'c.id')
                    ->where('tutor_uc.role_id', '=', 1); // get the actual tutor
            })
            ->join('users as u', 'tutor_uc.user_id', '=', 'u.id') // get tutor user info
            ->where('c.status', '!=', 0)
            ->where('uc.user_id', $user->id)
            ->select(
                'c.*',
                'uc.role_id as role_id', // role of logged-in user
                'u.username as tutor_username',
                'u.id as tutor_id',
                'u.image as tutor_image'
            )
            ->distinct();

        // Get the result
        $courses = $coursesQuery->get();

        // Append topics to each course
        foreach ($courses as $course) {
            $course->topics = DB::table('topic_courses as tc')
                ->join('topics as t', 'tc.topic_id', '=', 't.id')
                ->where('tc.course_id', $course->id)
                ->select('t.id', 't.name', 't.desc')
                ->get();

            $course->progress = $this->calculateCourseProgress($course->id);
        }
        
        // Logic to show the homepage
        return view('main.homepage', compact('user', 'courses'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $courses = Course::where('name', 'LIKE', "%{$query}%")->where('status', 1)->limit(5)->get();
        $users = User::where('username', 'LIKE', "%{$query}%")->where('status', 1)->limit(5)->get();

        return response()->view('main.partials.search_result', compact('courses', 'users'));
    }

    public function admin_homepage(Request $request)
    {
        $user = auth()->user();

        $users = User::all();

        $user_activity_logs = UserActivityLog::all();

        $courses = Course::from('courses as c')
        ->join('user_courses as uc', function($join) {
            $join->on('uc.course_id', '=', 'c.id')
                ->where('uc.role_id', 1); // Tutors only
        })
        ->join('users as u', 'uc.user_id', '=', 'u.id')
        ->select([
            'c.*',
            'c.status as course_status',
            'u.username as tutor_username',
            'u.id as tutor_id',
            'u.image as tutor_image'
        ])
        ->get();


        // $coursesQuery = DB::table('courses as c')
        //     ->join('user_courses as uc', 'uc.course_id', '=', 'c.id') // current user's enrollment
        //     ->join('user_courses as tutor_uc', function ($join) {
        //         $join->on('tutor_uc.course_id', '=', 'c.id')
        //             ->where('tutor_uc.role_id', '=', 1); // get the actual tutor
        //     })
        //     ->join('users as u', 'tutor_uc.user_id', '=', 'u.id') // get tutor user info
        //     ->where('c.status', '!=', 0)
        //     ->where('uc.user_id', $user->id)
        //     ->select(
        //         'c.*',
        //         'uc.role_id as role_id', // role of logged-in user
        //         'u.username as tutor_username',
        //         'u.id as tutor_id',
        //         'u.image as tutor_image'
        //     )
        //     ->distinct();

        // // Get the result
        // $courses = $coursesQuery->get();

        // // Append topics to each course
        // foreach ($courses as $course) {
        //     $course->topics = DB::table('topic_courses as tc')
        //         ->join('topics as t', 'tc.topic_id', '=', 't.id')
        //         ->where('tc.course_id', $course->id)
        //         ->select('t.id', 't.name', 't.desc')
        //         ->get();
        // }
        
        // Logic to show the homepage
        return view('admin.main.homepage', compact('user', 'users', 'user_activity_logs', 'courses'));
    }

    public function create_notification($noti_type, $parent_type, $title, $content, $parent_id = null)
    {
        $user_id = 0;
        if($parent_type === 'forum_reply') {
            $forum_reply = ForumReply::find($parent_id);
            if($forum_reply) {
                $user_id = $forum_reply->userCourse()->user_id;
            }
        } else if($parent_type === 'forum_post') {
            $forum_post = ForumPost::find($parent_id);
            if($forum_post) {
                $user_id = $forum_post->userCourse()->user_id;
            }
        } else if($parent_type === 'course') {
            $course = Course::find($parent_id);
            if($course) {
                $tutor_user_course = $course->userCourses()->where('role_id', 1)->first();
                if($tutor_user_course) {
                    $user_id = $tutor_user_course->user_id;
                }
            }
        } 
        else if($parent_type === 'resource') {
            $resource = Resource::find($parent_id);
            if($resource) {
                $lesson = $resource->lesson;
                if($lesson) {
                    $user_course = $lesson->course->userCourses()->where('role_id', 1)->first();
                    if($user_course) {
                        $user_id = $user_course->user_id;
                    }
                }
            }
        } else if($parent_type === 'lesson') {
            $lesson = Lesson::find($parent_id);
            if($lesson) {
                $user_course = $lesson->course->userCourses()->where('role_id', 1)->first();
                if($user_course) {
                    $user_id = $user_course->user_id;
                }
            }
        } else if($parent_type === 'user') {
            $user = User::find($parent_id);
            if($user) {
                $user_id = $user->id;
            }
        }

        $notification = new SystemNotification();
        $notification->user_id = $user_id;
        $notification->noti_type = $noti_type;
        $notification->parent_type = $parent_type;
        $notification->title = $title;
        $notification->content = $content;
        $notification->parent_id = $parent_id ?? 0;
        $notification->is_read = false;
        $notification->status = 1;
        $notification->save();

        return $notification;
    }

    public function submit_report(Request $request)
    {
        $request->validate([
            'reported_id' => 'required|integer',
            'reported_type' => 'required|string', // e.g., 'forum_post', 'forum_reply', etc.
            'reason' => 'nullable|string',
        ]);

        $report = Report::create([
            'user_id' => auth()->id(),
            'reported_id' => $request->reported_id,
            'reported_type' => $request->reported_type,
            'reason' => $request->reason ?? null,
            'status' => 1,
        ]);

        $this->create_notification('report', $report->reported_type, 'Report received', 'Reported by ' . auth()->user()->username . ' for your ' . $report->reported_type, $report->reported_id);

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }
}
