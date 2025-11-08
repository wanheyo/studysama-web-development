<?php

namespace App\Http\Controllers\Web;

use App\Services\NotificationService;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Resource;
use App\Models\ForumPost;
use App\Models\ForumReply;
use App\Models\ResourceFile;
use Illuminate\Http\Request;
use App\Models\UserActivityLog;
use App\Models\UserProgression;
use App\Models\SystemNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isNull;

class MainController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

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

    // public function create_notification($noti_type, $parent_type, $title, $content, $parent_id = null)
    // {
    //     $user_id = null;

    //     switch ($parent_type) {
    //         case 'forum_reply':
    //             $forum_reply = ForumReply::find($parent_id);
    //             $user_id = $forum_reply?->userCourse?->user_id;
    //             break;

    //         case 'forum_post':
    //             $forum_post = ForumPost::find($parent_id);
    //             $user_id = $forum_post?->userCourse?->user_id;
    //             break;

    //         case 'course':
    //             $course = Course::find($parent_id);
    //             $user_id = $course?->userCourses()
    //                 ->where('role_id', 1)
    //                 ->first()?->user_id;
    //             break;

    //         case 'resource':
    //             $resource = Resource::find($parent_id);
    //             $user_id = $resource?->lesson?->course
    //                 ?->userCourses()
    //                 ->where('role_id', 1)
    //                 ->first()?->user_id;
    //             break;

    //         case 'lesson':
    //             $lesson = Lesson::find($parent_id);
    //             $user_id = $lesson?->course
    //                 ?->userCourses()
    //                 ->where('role_id', 1)
    //                 ->first()?->user_id;
    //             break;

    //         case 'user':
    //             $user_id = User::find($parent_id)?->id;
    //             break;
    //     }

    //     if (!$user_id) {
    //         \Log::warning("Notification not created — no user found for parent_type={$parent_type}, parent_id={$parent_id}");
    //         return null;
    //     }

    //     return SystemNotification::create([
    //         'user_id' => $user_id,
    //         'noti_type' => $noti_type,
    //         'parent_type' => $parent_type,
    //         'title' => $title,
    //         'content' => $content,
    //         'parent_id' => $parent_id ?? 0,
    //         'is_read' => false,
    //         'status' => 1,
    //     ]);
    // }


    public function submit_report(Request $request)
    {
        try {
            $validated = $request->validate([
                'reported_id' => 'required|string', // encrypted, so string
                'reported_type' => 'required|string', // e.g., 'forum_post', 'forum_reply'
                'reason' => 'nullable|string',
            ]);

            try {
                $reported_id = Crypt::decrypt($validated['reported_id']);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Invalid report ID.');
            }

            $report = Report::create([
                'user_id' => auth()->id(),
                'reported_id' => $reported_id,
                'reported_type' => $validated['reported_type'],
                'reason' => $validated['reason'] ?? null,
                'status' => 1,
            ]);

            if ($validated['reported_type'] === 'forum_post') {
                $forum_post = ForumPost::find($reported_id);
                if (!$forum_post) {
                    return redirect()->back()->with('error', 'Forum post not found.');
                }
                $forum_post->update(['status' => 2]);
            } elseif ($validated['reported_type'] === 'forum_reply') {
                $forum_reply = ForumReply::find($reported_id);
                if (!$forum_reply) {
                    return redirect()->back()->with('error', 'Forum reply not found.');
                }
                $forum_reply->update(['status' => 2]);
            } else {
                return redirect()->back()->with('error', 'Invalid report type.');
            }

            // $this->create_notification(
            $this->notificationService->create(
                'report',
                $report->reported_type,
                'Report received',
                'Reported by ' . auth()->user()->username . ' for your ' . $report->reported_type,
                $reported_id
            );

            return redirect()->back()->with('success', 'Report submitted successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while submitting the report.');
        }
    }

}
