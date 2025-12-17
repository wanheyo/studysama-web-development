<?php

namespace App\Http\Controllers\Web;

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
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use function PHPUnit\Framework\isNull;
use Illuminate\Validation\ValidationException;

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
                    ->where('uc.status', '!=', 0); // filter out inactive user-course entries
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

        $user_activity_logs = UserActivityLog::with('user')
            // ->latest()
            // ->take(10)
            ->get();

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

        $pending_reports = Report::with([
            'user', // reporter
            'admin', // admin who handled the report
            'reported' => function (MorphTo $morphTo) { // reported entity
                $morphTo->morphWith([
                    Lesson::class     => ['course', 'reports'], 
                    ForumReply::class => ['forumPost', 'reports'],
                    ForumPost::class  => ['userCourse.user', 'reports'],
                    Resource::class   => ['lesson.course', 'reports'],
                    User::class       => ['reports'],
                    Course::class     => ['reports'],
                ]);
            }])
            ->where('status', 1) // Assuming 1 = Pending
            ->latest()
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
        return view('admin.main.homepage', compact('user', 'users', 'user_activity_logs', 'courses', 'pending_reports'));
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

            // Check if user already submitted report for this content
            $alreadyReported = Report::where('user_id', auth()->id())
                ->where('reported_id', $reported_id)
                ->where('reported_type', $validated['reported_type'])
                ->where('status', 1)
                ->exists();

            $report_type = $validated['reported_type'] === 'user' ? 'user' : 'content';

            if ($alreadyReported) {
                return redirect()->back()->with('error', 'You have already reported this ' . $report_type . '.');
            }

            $activeReports = 0;

            $activeReports = Report::where('reported_type', $validated['reported_type'])
                ->where('reported_id', $reported_id)
                ->where('status', 1)
                ->count();

            if ($activeReports >= 5) {
                return redirect()->back()->with('error',
                    "This content already has $activeReports active report(s). " .
                    "Please avoid submitting duplicate reports for the same ' . $report_type . '.'"
                );
            }

            $report = Report::create([
                'user_id' => auth()->id(),
                'reported_id' => $reported_id,
                'reported_type' => $validated['reported_type'],
                'reason' => $validated['reason'] ?? null,
                'status' => 1,
            ]);

            // IF 1 ACTIVE REPORT FOR forum_post, forum_reply, SET STATUS TO 2 (pending review, hidden from public)
            // IF 5 OR MORE ACTIVE REPORTS FOR resource, lesson, course, user, SET STATUS TO 2 (pending review, hidden from public)

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
            } 
            // else if ($validated['reported_type'] === 'resource') {
            //     $resource = Resource::find($reported_id);
            //     if (!$resource) {
            //         return redirect()->back()->with('error', 'Resource not found.');
            //     }
            //     $resource->update(['status' => 2]);
            // } else if ($validated['reported_type'] === 'lesson') {
            //     $lesson = Lesson::find($reported_id);
            //     if (!$lesson) {
            //         return redirect()->back()->with('error', 'Lesson not found.');
            //     }
            //     $lesson->update(['status' => 2]);
            // } else if ($validated['reported_type'] === 'course') {
            //     $course = Course::find($reported_id);
            //     if (!$course) {
            //         return redirect()->back()->with('error', 'Course not found.');
            //     }
            //     $course->update(['status' => 2]);
            // }
            else if ($validated['reported_type'] === 'resource') {
                $resource = Resource::find($reported_id);
                if (!$resource) {
                    return redirect()->back()->with('error', 'Resource not found.');
                }

                if ($activeReports >= 4) {
                    $resource->update(['status' => 2]);
                }

                // $resource->update(['status' => 2]); // Optional: keep if you still want to hide on first report
            } else if ($validated['reported_type'] === 'lesson') {
                $lesson = Lesson::find($reported_id);
                if (!$lesson) {
                    return redirect()->back()->with('error', 'Lesson not found.');
                }

                if ($activeReports >= 4) {
                    $lesson->update(['status' => 2]);
                }

                // $lesson->update(['status' => 2]);
            } else if ($validated['reported_type'] === 'course') {
                $course = Course::find($reported_id);
                if (!$course) {
                    return redirect()->back()->with('error', 'Course not found.');
                }

                if ($activeReports >= 4) {
                    $course->update(['status' => 2]);
                }

                // $course->update(['status' => 2]);
            } else if ($validated['reported_type'] === 'user') {
                $user = User::find($reported_id);
                if (!$user) {
                    return redirect()->back()->with('error', 'User not found.');
                }

                if ($activeReports >= 4) {
                    $user->update(['status' => 2]);
                }

                // $user->update(['status' => 2]);
            }
            else {
                return redirect()->back()->with('error', 'Invalid report type.');
            }

            if ($activeReports >= 4) {
                if($validated['reported_type'] === 'resource' || $validated['reported_type'] === 'lesson' || $validated['reported_type'] === 'course') {
                    $this->notificationService->create(
                        'report',
                        $report->reported_type,
                        'Report Received',
                        'This content was automatically hidden after reaching 5 reports. It was reported by ' . auth()->user()->username . ' for your ' . $report->reported_type,
                        $reported_id,
                        $report->id
                    );
                } else if($validated['reported_type'] === 'user') {
                    $this->notificationService->create(
                        'report',
                        $report->reported_type,
                        'Report Received',
                        'Your account was automatically hidden after reaching 5 reports. It was reported by ' . auth()->user()->username,
                        $reported_id,
                        $report->id
                    );
                } else {
                    $this->notificationService->create(
                        'report',
                        $report->reported_type,
                        'Report Received',
                        'Reported by ' . auth()->user()->username . ' for your ' . $report->reported_type,
                        $reported_id,
                        $report->id
                    );
                }
            } else {
                if($validated['reported_type'] === 'user') {
                    $this->notificationService->create(
                        'report',
                        $report->reported_type,
                        'Report Received',
                        'Reported by ' . auth()->user()->username . ' for your account',
                        $reported_id,
                        $report->id
                    );
                } else {
                    $this->notificationService->create(
                        'report',
                        $report->reported_type,
                        'Report Received',
                        'Reported by ' . auth()->user()->username . ' for your ' . $report->reported_type,
                        $reported_id,
                        $report->id
                    );
                }
            }

            return redirect()->back()->with('success', 'Report submitted successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong while submitting the report.');
        }
    }

    public function report_pending(Request $request)
    {
        $user = auth()->user();

        // Use 'with' to eager load the 'reported' relationship
        $pending_reports = Report::with([
            'user', // reporter
            'admin', // admin who handled the report
            'reported' => function (MorphTo $morphTo) { // reported entity
                $morphTo->morphWith([
                    Lesson::class     => ['course', 'reports'], 
                    ForumReply::class => ['forumPost', 'reports'],
                    ForumPost::class  => ['userCourse.user', 'reports'],
                    Resource::class   => ['lesson.course', 'reports'],
                    User::class       => ['reports'],
                    Course::class     => ['reports'],
                ]);
            }])
            ->where('status', 1) // Assuming 1 = Pending
            ->latest()
            ->get();
        
        // dd($pending_reports);

        return view('admin.reports.pending', compact('user', 'pending_reports'));
    }

    public function report_resolved(Request $request)
    {
        $user = auth()->user();

        // Use 'with' to eager load the 'reported' relationship
        $resolved_reports = Report::with([
            'user', // reporter
            'admin', // admin who handled the report
            'reported' => function (MorphTo $morphTo) { // reported entity
                $morphTo->morphWith([
                    Lesson::class     => ['course', 'reports'], 
                    ForumReply::class => ['forumPost', 'reports'],
                    ForumPost::class  => ['userCourse.user', 'reports'],
                    Resource::class   => ['lesson.course', 'reports'],
                    User::class       => ['reports'],
                    Course::class     => ['reports'],
                ]);
            }])
            ->where('status', 2) // Assuming 2 = Resolved
            ->latest()
            ->get();
        
        // dd($resolved_reports);

        return view('admin.reports.resolved', compact('user', 'resolved_reports'));
    }

    public function report_dismissed(Request $request)
    {
        $user = auth()->user();

        // Use 'with' to eager load the 'reported' relationship
        $dismissed_reports = Report::with([
            'user', // reporter
            'admin', // admin who handled the report
            'reported' => function (MorphTo $morphTo) { // reported entity
                $morphTo->morphWith([
                    Lesson::class     => ['course', 'reports'], 
                    ForumReply::class => ['forumPost', 'reports'],
                    ForumPost::class  => ['userCourse.user', 'reports'],
                    Resource::class   => ['lesson.course', 'reports'],
                    User::class       => ['reports'],
                    Course::class     => ['reports'],
                ]);
            }])
            ->where('status', 0) // Assuming 0 = Dismissed
            ->latest()
            ->get();
        
        // dd($dismissed_reports);

        return view('admin.reports.dismissed', compact('user', 'dismissed_reports'));
    }

    // public function update_report_status(Request $request)
    // {
    //     // Report Status: 1 = Pending, 2 = Resolved (Content Hidden), 0 = Dismissed (Content Active)
    //     // Content Status: 1 = Active, 0 = Inactive/Banned

    //     try {
    //         $validated = $request->validate([
    //             'report_id' => 'required|integer|exists:reports,id',
    //             'status'    => 'required|in:0,1,2', // Added 1 incase you want to revert to pending
    //             'remark'    => 'nullable|string',
    //         ]);

    //         $report = Report::findOrFail($validated['report_id']);
    //         $content = $report->reported; // The actual User, Course, Lesson, etc.

    //         // 1. Handle Content Visibility (Polymorphic Magic)
    //         if ($content) {
    //             if ($validated['status'] == 2) {
    //                 // Resolved -> Ban/Hide the content
    //                 // Checks if the model actually has a 'status' column before updating
    //                 $content->update(['status' => 0]); 
    //             } elseif ($validated['status'] == 0) {
    //                 // Dismissed -> Restore/Activate the content
    //                 $content->update(['status' => 1]); 
    //             }
    //         }

    //         // 2. Prepare Notification Message
    //         $noti_content = null;
    //         if ($validated['status'] == 2) {
    //             $noti_content = $report->reported_type === 'user' 
    //                 ? 'Your account has been deactivated due to a violation report. Remark by admin: "' . $validated['remark'] . '". If you believe this was a mistake, please contact support.' 
    //                 : 'Your ' . class_basename($report->reported_type) . ' has been removed due to a violation report. Remark by admin: "' . $validated['remark'] . '". If you believe this was a mistake, please contact support.';
    //         } elseif ($validated['status'] == 0) {
    //             $noti_content = $report->reported_type === 'user'
    //                 ? 'Your account has been reviewed and reactivated. Remark by admin: "' . $validated['remark'] . '".'
    //                 : 'Your ' . class_basename($report->reported_type) . ' was reviewed and the content has been restored. Remark by admin: "' . $validated['remark'] . '".';
    //         }

    //         // 3. Send Notification (Only if status changed to Resolved or Dismissed)
    //         if ($noti_content && $validated['status'] != 1) {
    //             $this->notificationService->create(
    //                 'report',
    //                 $report->reported_type,
    //                 'Report Update',
    //                 $noti_content,
    //                 $report->reported_id,
    //                 $report->id
    //             );
    //         }

    //         // 4. Update the Report Record
    //         $report->update([
    //             'status'       => $validated['status'],
    //             'admin_id'     => auth()->id(),
    //             'remark'       => $validated['remark'] ?? null,
    //             'updated_at'   => now(),
    //         ]);

    //         return redirect()->back()->with('success', 'Report processed successfully.');

    //     } catch (ValidationException $e) {
    //         return redirect()->back()->withErrors($e->validator)->withInput();
    //     } catch (Exception $e) {
    //         // Log::error($e); // Good practice to log the error
    //         return redirect()->back()->with('error', 'Error updating report: ' . $e->getMessage());
    //     }
    // }

    public function update_report_status(Request $request)
    {
        try {
            $validated = $request->validate([
                'report_id' => 'required|integer|exists:reports,id',
                'status'    => 'required|in:0,1,2',
                'remark'    => 'nullable|string',
            ]);

            // 1. Fetch the primary report to identify the target content
            $primaryReport = Report::findOrFail($validated['report_id']);
            $content = $primaryReport->reported; 

            // 2. Handle Content Visibility (Polymorphic)
            // We do this ONCE for the content item.
            if ($content) {
                if ($validated['status'] == 2) {
                    // Resolved -> Ban/Hide the content
                    $content->update(['status' => 0]); 
                } elseif ($validated['status'] == 0) {
                    // Dismissed -> Restore/Activate the content
                    $content->update(['status' => 1]); 
                }
            }

            // 3. Prepare Notification Message (Send ONCE)
            // We send this based on the action taken on the CONTENT, not the number of reports.
            $noti_content = null;
            if ($validated['status'] == 2) {
                $noti_content = $primaryReport->reported_type === 'user' 
                    ? 'Your account has been deactivated due to a violation report. Remark: "' . $validated['remark'] . '". Contact support if this is an error.' 
                    : 'Your ' . class_basename($primaryReport->reported_type) . ' has been removed due to a violation report. Remark: "' . $validated['remark'] . '".';
            } elseif ($validated['status'] == 0) {
                $noti_content = $primaryReport->reported_type === 'user'
                    ? 'Your account has been reviewed and reactivated. Remark: "' . $validated['remark'] . '".'
                    : 'Your ' . class_basename($primaryReport->reported_type) . ' was reviewed and restored. Remark: "' . $validated['remark'] . '".';
            }

            // Send notification only if status is Resolved(2) or Dismissed(0)
            // We use $primaryReport to get the ID/Type, ensuring we only send 1 notification.
            if ($noti_content && $validated['status'] != 1) {
                $this->notificationService->create(
                    'report',
                    $primaryReport->reported_type,
                    'Report Update',
                    $noti_content,
                    $primaryReport->reported_id,
                    $primaryReport->id
                );
            }

            // 4. Batch Update ALL Pending Reports for this Content
            // This is the magic part. We find all reports for this content that are currently Pending (1)
            // and update them all to the new status.
            
            $affectedRows = Report::where('reported_type', $primaryReport->reported_type)
                ->where('reported_id', $primaryReport->reported_id)
                ->where('status', 1) // Only update Pending ones. Don't touch previously resolved ones.
                ->update([
                    'status'       => $validated['status'],
                    'admin_id'     => auth()->id(),
                    'remark'       => $validated['remark'] ?? null, // Apply same remark to all
                    'updated_at'   => now(),
                ]);

            $msg = $validated['status'] == 2 ? 'Content hidden.' : 'Content restored.';
            return redirect()->back()->with('success', $msg . ' ' . $affectedRows . ' pending report(s) were updated.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error updating report: ' . $e->getMessage());
        }
    }
}
