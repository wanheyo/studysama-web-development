<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Resource;
use App\Models\UserBadge;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function find_course(Request $request)
    {
        // Get all active topics
        $topics = DB::table('topics as t')
            ->where('t.status', 1)
            ->select('t.*')
            ->get();

        // Start building the query
        $coursesQuery = DB::table('courses as c')
            ->join('user_courses as uc', function($join) {
                $join->on('uc.course_id', '=', 'c.id')
                    ->where('uc.role_id', 1); // Tutors only
            })
            ->join('users as u', 'uc.user_id', '=', 'u.id')
            ->where('c.status', 1)
            ->select([
                'c.*',
                'u.username as tutor_username',
                'u.id as tutor_id',
                'u.image as tutor_image'
            ]);

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $coursesQuery->where(function($query) use ($searchTerm) {
                $query->where('c.name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('c.desc', 'like', '%'.$searchTerm.'%');
            });
        }

        // Topic filter
        if ($request->filled('topics')) {
            $coursesQuery->whereExists(function($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('topic_courses as tc')
                    ->whereColumn('tc.course_id', 'c.id')
                    ->whereIn('tc.topic_id', $request->topics);
            });
        }

        // Rating filter
        if ($request->filled('ratings')) {
            $coursesQuery->where(function($query) use ($request) {
                foreach ($request->ratings as $rating) {
                    $query->orWhereBetween('c.average_rating', [$rating, $rating + 0.99]);
                }
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'most_popular':
                    $coursesQuery->orderBy('c.total_joined', 'desc');
                    break;
                case 'least_popular':
                    $coursesQuery->orderBy('c.total_joined', 'asc');
                    break;
                case 'newest':
                    $coursesQuery->orderBy('c.created_at', 'desc');
                    break;
                case 'oldest':
                    $coursesQuery->orderBy('c.created_at', 'asc');
                    break;
            }
        } else {
            $coursesQuery->orderBy('c.created_at', 'desc');
        }

        // For AJAX requests
        if ($request->ajax()) {
            $courses = $coursesQuery->get();
            
            foreach ($courses as $course) {
                $course->topics = DB::table('topic_courses as tc')
                    ->join('topics as t', 'tc.topic_id', '=', 't.id')
                    ->where('tc.course_id', $course->id)
                    ->select('t.id', 't.name', 't.desc')
                    ->get();
            }

            return response()->json([
                'courses' => view('course.partials.course_items', compact('courses'))->render()
            ]);
        }

        // Initial page load
        $courses = $coursesQuery->get();

        foreach ($courses as $course) {
            $course->topics = DB::table('topic_courses as tc')
                ->join('topics as t', 'tc.topic_id', '=', 't.id')
                ->where('tc.course_id', $course->id)
                ->select('t.id', 't.name', 't.desc')
                ->get();
        }

        return view('course.find_course', compact('courses', 'topics'));
    }

    public function my_course(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user

        // Get all active topics
        $topics = DB::table('topics as t')
            ->where('t.status', 1)
            ->select('t.*')
            ->get();

        // Start building the query
        // $coursesQuery = DB::table('courses as c')
        //     ->join('user_courses as uc', function($join) {
        //         $join->on('uc.course_id', '=', 'c.id')
        //             ->where('uc.role_id', 1); // Tutors only
        //     })
        //     ->join('users as u', 'uc.user_id', '=', 'u.id')
        //     ->where('c.status', 1)
        //     ->select([
        //         'c.*',
        //         'u.username as tutor_username',
        //         'u.id as tutor_id',
        //         'u.image as tutor_image'
        //     ]);

        // Build query for courses joined by the user
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


        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $coursesQuery->where(function ($query) use ($searchTerm) {
                $query->where('c.name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('c.desc', 'like', '%' . $searchTerm . '%');
            });
        }

        // Topic filter
        if ($request->filled('topics')) {
            $coursesQuery->whereExists(function ($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('topic_courses as tc')
                    ->whereColumn('tc.course_id', 'c.id')
                    ->whereIn('tc.topic_id', $request->topics);
            });
        }

        // Rating filter
        if ($request->filled('ratings')) {
            $coursesQuery->where(function ($query) use ($request) {
                foreach ($request->ratings as $rating) {
                    $query->orWhereBetween('c.average_rating', [$rating, $rating + 0.99]);
                }
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'most_popular':
                    $coursesQuery->orderBy('c.total_joined', 'desc');
                    break;
                case 'least_popular':
                    $coursesQuery->orderBy('c.total_joined', 'asc');
                    break;
                case 'newest':
                    $coursesQuery->orderBy('c.created_at', 'desc');
                    break;
                case 'oldest':
                    $coursesQuery->orderBy('c.created_at', 'asc');
                    break;
            }
        } else {
            $coursesQuery->orderBy('c.created_at', 'desc');
        }

        // Get the result
        $courses = $coursesQuery->get();

        // Append topics to each course
        foreach ($courses as $course) {
            $course->topics = DB::table('topic_courses as tc')
                ->join('topics as t', 'tc.topic_id', '=', 't.id')
                ->where('tc.course_id', $course->id)
                ->select('t.id', 't.name', 't.desc')
                ->get();
        }

        $type = $request->get('type', 'created');

        if ($type == 'created') {
            $view = view('course.partials.course_created_items', compact('courses'))->render();
        } else {
            $view = view('course.partials.course_joined_items', compact('courses'))->render();
        }

        if ($request->ajax()) {
            return response()->json([
                'courses' => $view
            ]);
        }

        // For AJAX requests, return partial view
        // if ($request->ajax()) {
        //     return response()->json([
        //         'created_courses' => view('course.partials.course_created_items', compact('courses'))->render(),
        //         'joined_courses' => view('course.partials.course_joined_items', compact('courses'))->render(),
        //     ]);
        // }

        // For normal page load
        return view('course.my_course', compact('courses', 'topics'));
    }


    public function show_add_course(Request $request)
    {
        $topics = DB::table('topics as t')
            ->where('t.status', 1)
            ->select('t.*')
            ->get();

        // dd($topics);
        return view('course.add_course', compact('topics'));
    }

    public function add_course(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:128',
            'desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'topic' => 'array',
            // 'topic.*' => 'exists:topics,id',
            'topic' => 'nullable|exists:topics,id',
            // 'availability' => 'nullable|in:1,2',
        ]);

        $course = new Course();
        $course->name = $validated['name'];
        $course->desc = $validated['desc'] ?? null;
        $course->status = 2; // Default to 2 (under review)

        // Handle image upload
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('uploads/course_picture', $filename, 'public');
            $course->image = $filename;
        }

        $course->save();

        // Add user courses
        DB::table('user_courses')->insert([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Attach topic to pivot table
        if (!empty($validated['topic'])) {
            DB::table('topic_courses')->insert([
                'topic_id' => $validated['topic'],
                'course_id' => $course->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('course.my_course')->with('success', 'Course submitted to review, please wait for approval.');
    }

    public function show_edit_course(Request $request, $course_id)
    {
        $course_id = Crypt::decrypt($course_id);

        $course = Course::find($course_id);

        $course->topics = DB::table('topic_courses as tc')
            ->join('topics as t', 'tc.topic_id', '=', 't.id')
            ->where('tc.course_id', $course->id)
            ->select('t.id', 't.name', 't.desc')
            ->get();
        
        $topics = DB::table('topics as t')
            ->where('t.status', 1)
            ->select('t.*')
            ->get();

        // dd($topics);
        return view('course.edit_course', compact('course', 'topics'));
    }

    public function edit_course(Request $request, $course_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:128',
            'desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'topic' => 'array',
            // 'topic.*' => 'exists:topics,id',
            'topic' => 'nullable|exists:topics,id',
            'delete' => 'nullable|boolean',
            // 'availability' => 'nullable|in:1,2',
        ]);

        $course_id = Crypt::decrypt($course_id);
        $course = Course::find($course_id);

        // Handle soft delete (status = 0)
        if ($validated['delete'] ?? false) {
            $course->status = 0;
            $course->updated_at = now();
            $course->save();

            return redirect()->route('course.my_course')->with('success', 'Course has been deleted.');
        }

        $course->name = $validated['name'];
        $course->desc = $validated['desc'] ?? $course->desc;
        // $course->status = 2; // Default to 2 (under review)

        if ($request->input('delete_image')) {
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }
            $course->image = null;
        }


        // Handle image upload
        if ($request->hasFile('image')) {

            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('uploads/course_picture', $filename, 'public');

            if($course->image) {
                if(Storage::disk('public')->exists($course->image)) {
                    Storage::disk('public')->delete($course->image);
                }
            }
            
            $course->image = $filename;
        }

        $course->updated_at = now();
        $course->save();

        // Add user courses
        // DB::table('user_courses')->insert([
        //     'user_id' => auth()->id(),
        //     'course_id' => $course->id,
        //     'role_id' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Attach topic to pivot table
        if (!empty($validated['topic'])) {
            $topic_courses = DB::table('topic_courses')
                ->where('course_id', $course_id)->first();

            if ($topic_courses) {
                DB::table('topic_courses')
                    ->where('course_id', $course_id)
                    ->update([
                        'topic_id' => $validated['topic'],
                        'updated_at' => now(),
                ]);
            } else {
                DB::table('topic_courses')->insert([
                    'topic_id' => $validated['topic'],
                    'course_id' => $course->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('course.my_course')->with('success', 'Course has been updated.');
    }

    public function delete_course(Request $request, $course_id)
    {
        $validated = $request->validate([
            // 'name' => 'required|string|max:128',
            // 'desc' => 'nullable|string',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'topic' => 'nullable|exists:topics,id',
            'status' => 'required|in:0',
        ]);

        $course_id = Crypt::decrypt($course_id);
        $course = Course::find($course_id);

        $course->status = $validated['status'];
        // $course->updated_at = now();
        $course->save();

            return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully',
            'status' => $course->status
        ]);
    }

    public function course_detail(Request $request, $course_id)
    {
        $course_id = Crypt::decrypt($course_id);
        // \Log::info('Current user:', ['user' => Auth::user()]);
        // \Log::info('Auth check status:', [
        //     'is_authenticated' => Auth::check(),
        //     'guard' => config('auth.defaults.guard'),
        //     'session_id' => session()->getId()
        // ]);

        // $course = null;
        $course = Course::where('id', $course_id)
            // ->where('status', 1)
            ->firstOrFail();

        $topics = DB::table('topic_courses as tc')
            ->join('topics as t', 'tc.topic_id', '=', 't.id')
            ->where('tc.course_id', $course_id)
            ->select('t.*')
            ->get();

        $user_courses = DB::table('user_courses as uc')
            ->join('courses as c', 'uc.course_id', '=', 'c.id')
            ->where('c.id', $course_id)
            ->select('uc.*')
            ->get();

        $tutor = User::join('user_courses as uc', 'uc.user_id', '=', 'users.id')
            ->where('uc.course_id', $course_id)
            ->where('uc.role_id', 1)
            ->select('users.*')
            ->firstOrFail();

        $tutor_follow = DB::table('user_follow')
            ->where('user_follower_id', $tutor->id)
            ->get();

        $tutor_courses = DB::table('courses as c')
            ->join('user_courses as uc', 'uc.course_id', '=', 'c.id')
            ->join('users as u', 'uc.user_id', '=', 'u.id')
            ->where('c.status', 1)
            ->where('uc.user_id', $tutor->id)
            ->distinct()
            ->select('c.*', 'uc.role_id as role_id')
            ->get();
        
        // dd($tutor);

        $course_comments = DB::table('user_courses as uc')
            ->join('users as u', 'uc.user_id', '=', 'u.id')
            ->where('uc.course_id', $course_id)
            // ->where('uc.status', 1)
            ->where('uc.rating', '!=', null)
            ->select('uc.*', 'u.*', 'uc.created_at as comment_created_at', 'uc.updated_at as comment_updated_at', 'uc.status as uc_status')
            ->get();

        // dd($course_comments);

        // NEW: Fetch current user's review for this course (even if user_course inactive)
        $user_review = null;
        if (Auth::check()) {
            $user_review = DB::table('user_courses')
                ->where('course_id', $course_id)
                ->where('user_id', Auth::id())
                ->whereNotNull('rating')
                ->first();
        }

        if (!$course) {
            abort(404); // or redirect with a message
        }

        // dd($user_review);

        return view('course.course_detail', compact('course', 'topics', 'user_courses', 'tutor', 'tutor_follow', 'tutor_courses', 'course_comments', 'user_review'));
    }

    public function join_leave_course(Request $request)
    {
        $validatedData = $request->validate([
            'course_id' => 'required|integer|exists:courses,id',
            'status' => 'nullable|integer', // 0 = leaving, 1 = joining
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }

        try {
            DB::transaction(function () use ($validatedData, $user) {
                if ($validatedData['status'] == 0) {
                    // Leaving
                    $userCourse = UserCourse::where('user_id', $user->id)
                        ->where('course_id', $validatedData['course_id'])
                        ->where('status', 1)
                        ->first();
                        
                    if ($userCourse) {
                        $userCourse->status = 0;
                        $userCourse->updated_at = now();
                        $userCourse->save();
                    }

                    $course = Course::find($validatedData['course_id']);
                    if ($course) {
                        $course->total_joined = max(0, $course->total_joined - 1); // prevent negative
                        $course->save();
                    }

                } elseif ($validatedData['status'] == 1) {
                    // Joining
                    $userCourse = UserCourse::create([
                        'user_id' => $user->id,
                        'course_id' => $validatedData['course_id'],
                        'role_id' => 3,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $course = Course::find($validatedData['course_id']);
                    if ($course) {
                        $course->total_joined = $course->total_joined + 1;
                        $course->save();
                    }

                    // Transfer old rating
                    $allUserCourse = UserCourse::where('user_id', $user->id)
                        ->where('course_id', $validatedData['course_id'])
                        ->get();

                    foreach ($allUserCourse as $auc) {
                        if ($auc->rating !== null) {
                            $userCourse->rating = $auc->rating;
                            $userCourse->comment_review = $auc->comment_review ?? null;
                            $userCourse->save();

                            $auc->rating = null;
                            $auc->comment_review = null;
                            $auc->save();
                        }
                    }

                    // Check and assign badge
                    $userBadge = UserBadge::where('user_id', $user->id)
                        ->where('status', 1)
                        ->where('badge_id', 1)
                        ->first();

                    if (!$userBadge) {
                        UserBadge::create([
                            'user_id' => $user->id,
                            'badge_id' => 1,
                            'status' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });

            $action = $validatedData['status'] == 0 ? 'left' : 'joined';
            return redirect()->back()->with('success', "You have successfully {$action} the course.");

        } catch (\Exception $e) {
            \Log::error('Course join/leave failed', [
                'user_id' => $user->id ?? null,
                'course_id' => $validatedData['course_id'],
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()->with('error', 'Failed to process your request. Please try again.');
        }
    }


    public function update_review(Request $request)
    {
        $validatedData = $request->validate([
            'user_course_id' => 'required|integer|exists:user_courses,id',
            'rating' => 'nullable|numeric|min:1|max:5',
            'comment_review' => 'nullable|string|max:500',
            'action' => 'required|string|in:update,delete',
        ]);

        // dd($validatedData);

        $userCourse = UserCourse::where('id', $validatedData['user_course_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($validatedData['action'] === 'delete') {
            $userCourse->rating = null;
            $userCourse->comment_review = null;
        } else {
            $userCourse->rating = $validatedData['rating'];
            $userCourse->comment_review = $validatedData['comment_review'];
        }

        $userCourse->updated_at = now();
        $userCourse->save();

        // Recalculate average rating
        $course = Course::find($userCourse->course_id);
        if ($course) {
            $averageRating = UserCourse::where('course_id', $course->id)
                ->where('status', 1)
                ->whereNotNull('rating')
                ->avg('rating');

            // $course->average_rating = $averageRating !== null ? round($averageRating, 2) : 5.0;
            if ($averageRating !== null) {
                $course->average_rating = round($averageRating, 2);
            } else {
                $course->average_rating = 5.0;
            }
            $course->save();
        }

        if ($validatedData['action'] === 'delete') {
            return redirect()->back()->with('success', 'Your review has been deleted.');
        } else {
            return redirect()->back()->with('success', 'Your review has been submitted!');
        }
    }

    public function delete_review(Request $request)
    {
        $validatedData = $request->validate([
            'user_course_id' => 'required|integer|exists:user_courses,id',
        ]);

        dd($validatedData);

        $userCourse = UserCourse::where('id', $validatedData['user_course_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $userCourse->rating = null;
        $userCourse->comment_review = null;
        $userCourse->updated_at = now();
        $userCourse->save();

        // Recalculate course rating
        $course = Course::find($userCourse->course_id);
        if ($course) {
            $averageRating = UserCourse::where('course_id', $course->id)
                ->where('status', 1)
                ->whereNotNull('rating')
                ->avg('rating');

            $course->average_rating = $averageRating ? round($averageRating, 2) : null;
            $course->save();
        }

        return redirect()->back()->with('success', 'Your review has been deleted.');
    }

    // ADMIN SIDE
    public function admin_find_course(Request $request)
    {
        // Get all active topics
        $topics = DB::table('topics as t')
            ->where('t.status', 1)
            ->select('t.*')
            ->get();

        // Start building the query
        $coursesQuery = DB::table('courses as c')
            ->join('user_courses as uc', function($join) {
                $join->on('uc.course_id', '=', 'c.id')
                    ->where('uc.role_id', 1); // Tutors only
            })
            ->join('users as u', 'uc.user_id', '=', 'u.id')
            ->where('c.status', '!=', 0)
            ->select([
                'c.*',
                'u.username as tutor_username',
                'u.id as tutor_id',
                'u.image as tutor_image'
            ]);

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $coursesQuery->where(function($query) use ($searchTerm) {
                $query->where('c.name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('c.desc', 'like', '%'.$searchTerm.'%');
            });
        }

        // Topic filter
        if ($request->filled('topics')) {
            $coursesQuery->whereExists(function($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('topic_courses as tc')
                    ->whereColumn('tc.course_id', 'c.id')
                    ->whereIn('tc.topic_id', $request->topics);
            });
        }

        // Rating filter
        if ($request->filled('ratings')) {
            $coursesQuery->where(function($query) use ($request) {
                foreach ($request->ratings as $rating) {
                    $query->orWhereBetween('c.average_rating', [$rating, $rating + 0.99]);
                }
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'most_popular':
                    $coursesQuery->orderBy('c.total_joined', 'desc');
                    break;
                case 'least_popular':
                    $coursesQuery->orderBy('c.total_joined', 'asc');
                    break;
                case 'newest':
                    $coursesQuery->orderBy('c.created_at', 'desc');
                    break;
                case 'oldest':
                    $coursesQuery->orderBy('c.created_at', 'asc');
                    break;
            }
        } else {
            $coursesQuery->orderBy('c.created_at', 'desc');
        }

        // For AJAX requests
        if ($request->ajax()) {
            $courses = $coursesQuery->get();
            
            foreach ($courses as $course) {
                $course->topics = DB::table('topic_courses as tc')
                    ->join('topics as t', 'tc.topic_id', '=', 't.id')
                    ->where('tc.course_id', $course->id)
                    ->select('t.id', 't.name', 't.desc')
                    ->get();
            }

            return response()->json([
                'courses' => view('course.partials.course_items', compact('courses'))->render()
            ]);
        }

        // Initial page load
        $courses = $coursesQuery->get();

        foreach ($courses as $course) {
            $course->topics = DB::table('topic_courses as tc')
                ->join('topics as t', 'tc.topic_id', '=', 't.id')
                ->where('tc.course_id', $course->id)
                ->select('t.id', 't.name', 't.desc')
                ->get();

            $course->lessons = Lesson::where('course_id', $course->id)
                ->where('status', 1)
                ->get();

            foreach ($course->lessons as $lesson) {
                $lesson->resources = Resource::where('lesson_id', $lesson->id)
                    ->where('status', 1)
                    ->get();
            }
        }

        return view('admin.course.find_course', compact('courses', 'topics'));
    }

    public function admin_edit_course(Request $request, $course_id)
    {
        $validated = $request->validate([
            // 'name' => 'required|string|max:128',
            // 'desc' => 'nullable|string',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'topic' => 'nullable|exists:topics,id',
            'status' => 'required|in:0,1,2',
        ]);

        $course_id = Crypt::decrypt($course_id);
        $course = Course::find($course_id);

        $course->status = $validated['status'];
        // $course->updated_at = now();
        $course->save();

            return response()->json([
            'success' => true,
            'message' => 'Course status updated successfully',
            'status' => $course->status
        ]);
    }

    public function admin_course_statistics(Request $request)
    {
        // Get all active topics
        $topics = DB::table('topics as t')
            ->where('t.status', 1)
            ->select('t.*')
            ->get();

        // Start building the query
        $coursesQuery = DB::table('courses as c')
            ->join('user_courses as uc', function($join) {
                $join->on('uc.course_id', '=', 'c.id')
                    ->where('uc.role_id', 1); // Tutors only
            })
            ->join('users as u', 'uc.user_id', '=', 'u.id')
            ->where('c.status', '!=', 0)
            ->select([
                'c.*',
                'u.username as tutor_username',
                'u.id as tutor_id',
                'u.image as tutor_image'
            ]);

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $coursesQuery->where(function($query) use ($searchTerm) {
                $query->where('c.name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('c.desc', 'like', '%'.$searchTerm.'%');
            });
        }

        // Topic filter
        if ($request->filled('topics')) {
            $coursesQuery->whereExists(function($query) use ($request) {
                $query->select(DB::raw(1))
                    ->from('topic_courses as tc')
                    ->whereColumn('tc.course_id', 'c.id')
                    ->whereIn('tc.topic_id', $request->topics);
            });
        }

        // Rating filter
        if ($request->filled('ratings')) {
            $coursesQuery->where(function($query) use ($request) {
                foreach ($request->ratings as $rating) {
                    $query->orWhereBetween('c.average_rating', [$rating, $rating + 0.99]);
                }
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'most_popular':
                    $coursesQuery->orderBy('c.total_joined', 'desc');
                    break;
                case 'least_popular':
                    $coursesQuery->orderBy('c.total_joined', 'asc');
                    break;
                case 'newest':
                    $coursesQuery->orderBy('c.created_at', 'desc');
                    break;
                case 'oldest':
                    $coursesQuery->orderBy('c.created_at', 'asc');
                    break;
            }
        } else {
            $coursesQuery->orderBy('c.created_at', 'desc');
        }

        // For AJAX requests
        if ($request->ajax()) {
            $courses = $coursesQuery->get();
            
            foreach ($courses as $course) {
                $course->topics = DB::table('topic_courses as tc')
                    ->join('topics as t', 'tc.topic_id', '=', 't.id')
                    ->where('tc.course_id', $course->id)
                    ->select('t.id', 't.name', 't.desc')
                    ->get();
            }

            return response()->json([
                'courses' => view('course.partials.course_items', compact('courses'))->render()
            ]);
        }

        // Initial page load
        $courses = $coursesQuery->get();

        foreach ($courses as $course) {
            $course->topics = DB::table('topic_courses as tc')
                ->join('topics as t', 'tc.topic_id', '=', 't.id')
                ->where('tc.course_id', $course->id)
                ->select('t.id', 't.name', 't.desc')
                ->get();

            $course->lessons = Lesson::where('course_id', $course->id)
                ->where('status', 1)
                ->get();

            foreach ($course->lessons as $lesson) {
                $lesson->resources = Resource::where('lesson_id', $lesson->id)
                    ->where('status', 1)
                    ->get();
            }
        }

        $topicCourseCounts = DB::table('topic_courses as tc')
            ->join('topics as t', 'tc.topic_id', '=', 't.id')
            ->join('courses as c', 'tc.course_id', '=', 'c.id')
            ->where('c.status', '!=', 0)
            ->select('t.name', DB::raw('COUNT(tc.course_id) as course_count'))
            ->groupBy('tc.topic_id', 't.name')
            ->get();

        // MONTHLY COURSE TOTALS (e.g., Jan, Feb, ...)
        $monthlyCourses = DB::table('courses as c')
            ->join('user_courses as uc', fn($join) =>
                $join->on('uc.course_id', '=', 'c.id')->where('uc.role_id', 1)
            )
            ->where('c.status', '!=', 0)
            ->select([
                DB::raw("DATE_FORMAT(c.created_at, '%b %Y') as label"),
                DB::raw("YEAR(c.created_at) as year_number"),
                DB::raw("MONTH(c.created_at) as month_number"),
                DB::raw("COUNT(*) as total")
            ])
            ->groupBy(
                DB::raw("DATE_FORMAT(c.created_at, '%b %Y')"),
                DB::raw("YEAR(c.created_at)"),
                DB::raw("MONTH(c.created_at)")
            )
            ->orderByRaw("YEAR(c.created_at), MONTH(c.created_at)")
            ->get();

        
        // WEEKLY COURSE TOTALS (last 7 days)
        $weeklyCourses = DB::table('courses as c')
            ->join('user_courses as uc', fn($join) => 
                $join->on('uc.course_id', '=', 'c.id')->where('uc.role_id', 1)
            )
            ->where('c.status', '!=', 0)
            ->whereBetween('c.created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->select([
                DB::raw("DATE_FORMAT(c.created_at, '%a') as label"),
                DB::raw("DATE(c.created_at) as group_date"),
                DB::raw("COUNT(*) as total")
            ])
            ->groupBy(DB::raw("DATE_FORMAT(c.created_at, '%a')"), DB::raw("DATE(c.created_at)"))
            ->orderBy('group_date')
            ->get();



        // DAILY COURSE TOTALS (last 24 hours, by hour)
        $dailyCourses = DB::table('courses as c')
            ->join('user_courses as uc', fn($join) =>
                $join->on('uc.course_id', '=', 'c.id')->where('uc.role_id', 1)
            )
            ->where('c.status', '!=', 0)
            ->whereBetween('c.created_at', [Carbon::now()->subHours(23), Carbon::now()])
            ->select(DB::raw("HOUR(c.created_at) as label"), DB::raw("COUNT(*) as total"))
            ->groupBy(DB::raw("HOUR(c.created_at)"))
            ->orderBy(DB::raw("HOUR(c.created_at)"))
            ->get();



        return view('admin.course.statistics_course', compact('courses', 'topics', 'topicCourseCounts', 'monthlyCourses', 'weeklyCourses', 'dailyCourses'));
    }
}
