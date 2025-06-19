<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\UserPoint;
use App\Models\UserFollow;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Resource;
use App\Models\UserBadge;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Models\UserActivityLog;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserController extends Controller
{
    public function sign_in(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $login_type => $request->login,
            'password' => $request->password,
            'status' => 1 // ✅ Only allow active users
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            if ($request->wantsJson()) {
                $token = $request->user()->createToken('api-token')->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'user' => Auth::user()
                ]);
            }

            if (Auth::user()->isAdmin() || Auth::user()->isSuperadmin()) {
                return redirect()->intended(route('main.admin.homepage'));
            } else {
                return redirect()->intended(route('main.homepage'));
            }
        }

        // 🔍 Additional check if account exists but status is not active
        $userModel = \App\Models\User::where($login_type, $request->login)->first();
        if ($userModel) {
            if ($userModel->status == 0) {
                return back()->withErrors([
                    'login' => 'This account has been deleted.',
                ])->onlyInput('login');
            } elseif ($userModel->status == 2) {
                return back()->withErrors([
                    'login' => 'Your account is under review. Please wait for approval.',
                ])->onlyInput('login');
            }
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }


    public function sign_up(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:4|max:16|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['username'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user); // auto-login after registration

        return redirect()->intended(route('main.homepage'));
    }

    public function check_username(Request $request)
    {
        $username = $request->query('username');

        $isAvailable = !User::where('username', $username)->exists();

        return response()->json(['available' => $isAvailable]);
    }


    public function sign_out(Request $request)
    {
        // dd('logout');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/sign_in');
    }

    public function my_profile(Request $request)
    {
        $user = Auth::user();

        $user_follow = DB::table('user_follow')
            ->where('user_follower_id', $user->id)
            ->get();

        $courses = DB::table('courses as c')
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
            ->where('c.status', 1)
            ->where('uc.user_id', $user->id)
            ->select(
                'c.*',
                'uc.role_id as role_id', // role of logged-in user
                'u.username as tutor_username',
                'u.id as tutor_id',
                'u.image as tutor_image'
            )
            ->distinct()
            ->get();

        foreach ($courses as $course) {
            $course->topics = DB::table('topic_courses as tc')
                ->join('topics as t', 'tc.topic_id', '=', 't.id')
                ->where('tc.course_id', $course->id)
                ->select('t.id', 't.name', 't.desc')
                ->get();
        }

        // Users that this user is following (followed users)
        $following = DB::table('user_follow')
            ->join('users', 'users.id', '=', 'user_follow.user_followed_id')
            ->where('user_follow.user_follower_id', $user->id)
            ->where('user_follow.status', 1)
            ->select('users.id', 'users.username', 'users.name', 'users.image')
            ->get();

        // Users who follow this user (followers)
        $followers = DB::table('user_follow')
            ->join('users', 'users.id', '=', 'user_follow.user_follower_id')
            ->where('user_follow.user_followed_id', $user->id)
            ->where('user_follow.status', 1)
            ->select('users.id', 'users.username', 'users.name', 'users.image')
            ->get();

        $user_points = DB::table('user_activity_logs')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(5);

        if ($request->ajax()) {
            return view('user.partials.user_activity_log', compact('user_points'))->render();
        }
        
        // Leaderboard: MCQ activity
        $mcq = User::join('user_activity_logs', 'user_activity_logs.user_id', '=', 'users.id')
            ->where('user_activity_logs.activity_type', 'mcq')
            ->where('users.id', $user->id)
            ->selectRaw('SUM(user_activity_logs.xp_earned) as total_xp, SUM(user_activity_logs.points_earned) as total_points')
            ->first();

        // Leaderboard: Flashcard activity
        $flashcard = User::join('user_activity_logs', 'user_activity_logs.user_id', '=', 'users.id')
            ->where('user_activity_logs.activity_type', 'flashcard')
            ->where('users.id', $user->id)
            ->selectRaw('SUM(user_activity_logs.xp_earned) as total_xp, SUM(user_activity_logs.points_earned) as total_points')
            ->first();

        // Leaderboard: WSP activity
        $wsp = User::join('user_activity_logs', 'user_activity_logs.user_id', '=', 'users.id')
            ->where('user_activity_logs.activity_type', 'wsp')
            ->where('users.id', $user->id)
            ->selectRaw('SUM(user_activity_logs.xp_earned) as total_xp, SUM(user_activity_logs.points_earned) as total_points')
            ->first();


        // dd($user_follow);
        return view('user.my_profile', compact('user', 'user_follow', 'courses', 'following', 'followers', 'user_points', 'mcq', 'flashcard', 'wsp'));
    }

    public function show_edit_profile(Request $request)
    {
        $user = User::with(['socialLinks' => function ($q) {
            $q->where('status', 1);
        }])->find(auth()->id());

        return view('user.edit_profile', compact('user'));
    }

    public function edit_profile(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:16|unique:users,username,' . auth()->id(),
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'name' => 'required|string|max:128',
            'bio' => 'nullable|string',
            'phone_num' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'social_links' => 'nullable|array',
            'social_links.*.name' => 'required_with:social_links|string|max:255',
            'social_links.*.link' => 'required_with:social_links|url|max:255',
        ]);

        $user = auth()->user();

        // Profile Image Upload
        if ($request->hasFile('profile_image')) {
            if ($user->image && Storage::disk('public')->exists('uploads/profile_picture/' . $user->image)) {
                Storage::disk('public')->delete('uploads/profile_picture/' . $user->image);
            }

            $filename = uniqid() . '.' . $request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->storeAs('uploads/profile_picture', $filename, 'public');
            $user->image = $filename;
        }

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'bio' => $request->bio,
            'phone_num' => $request->phone_num ? '+60' . $request->phone_num : null,
        ]);

        // Save Social Links (using your model)
        if ($request->has('social_links')) {
            foreach ($request->social_links as $linkData) {
                if (!empty($linkData['id'])) {
                    $socialLink = $user->socialLinks()->where('id', $linkData['id'])->first();
                    if ($socialLink) {
                        if (isset($linkData['delete']) && $linkData['delete']) {
                            $socialLink->update([
                                'status' => 0,
                                'updated_at' => now(),
                            ]);
                        } else {
                            $socialLink->update([
                                'name' => $linkData['name'],
                                'link' => $linkData['link'],
                                'status' => 1,
                            ]);
                        }
                    }
                } else {
                    // It's a new link
                    if (!empty($linkData['name']) && !empty($linkData['link'])) {
                        $user->socialLinks()->create([
                            'name' => $linkData['name'],
                            'link' => $linkData['link'],
                            'status' => 1,
                        ]);
                    }
                }
            }
        }        

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function show_profile(Request $request, $user_id, $shared = 0)
    {
        $user_id = Crypt::decrypt($user_id);
        
        $user = User::find($user_id);

        if(!$user || $user->status == 0) {
            abort(404);
        }

        if ($shared == 0 && Auth::check() && $user_id === Auth::user()->id) {
            return redirect()->route('user.my_profile');
        }

        $user_follow = DB::table('user_follow')
            ->where('user_follower_id', $user->id)
            ->get();

        $courses = DB::table('courses as c')
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
            ->where('c.status', 1)
            ->where('uc.user_id', $user->id)
            ->select(
                'c.*',
                'uc.role_id as role_id', // role of logged-in user
                'u.username as tutor_username',
                'u.id as tutor_id',
                'u.image as tutor_image'
            )
            ->distinct()
            ->get();

        foreach ($courses as $course) {
            $course->topics = DB::table('topic_courses as tc')
                ->join('topics as t', 'tc.topic_id', '=', 't.id')
                ->where('tc.course_id', $course->id)
                ->select('t.id', 't.name', 't.desc')
                ->get();
        }

        // Users that this user is following (followed users)
        $following = DB::table('user_follow')
            ->join('users', 'users.id', '=', 'user_follow.user_followed_id')
            ->where('user_follow.user_follower_id', $user->id)
            ->where('user_follow.status', 1)
            ->select('users.id', 'users.username', 'users.name', 'users.image')
            ->get();

        // Users who follow this user (followers)
        $followers = DB::table('user_follow')
            ->join('users', 'users.id', '=', 'user_follow.user_follower_id')
            ->where('user_follow.user_followed_id', $user->id)
            ->where('user_follow.status', 1)
            ->select('users.id', 'users.username', 'users.name', 'users.image')
            ->get();

        $user_points = DB::table('user_activity_logs')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(5);

        if ($request->ajax()) {
            return view('user.partials.user_activity_log', compact('user_points'))->render();
        }
        
        // Leaderboard: MCQ activity
        $mcq = User::join('user_activity_logs', 'user_activity_logs.user_id', '=', 'users.id')
            ->where('user_activity_logs.activity_type', 'mcq')
            ->where('users.id', $user->id)
            ->selectRaw('SUM(user_activity_logs.xp_earned) as total_xp, SUM(user_activity_logs.points_earned) as total_points')
            ->first();

        // Leaderboard: Flashcard activity
        $flashcard = User::join('user_activity_logs', 'user_activity_logs.user_id', '=', 'users.id')
            ->where('user_activity_logs.activity_type', 'flashcard')
            ->where('users.id', $user->id)
            ->selectRaw('SUM(user_activity_logs.xp_earned) as total_xp, SUM(user_activity_logs.points_earned) as total_points')
            ->first();

        // Leaderboard: WSP activity
        $wsp = User::join('user_activity_logs', 'user_activity_logs.user_id', '=', 'users.id')
            ->where('user_activity_logs.activity_type', 'wsp')
            ->where('users.id', $user->id)
            ->selectRaw('SUM(user_activity_logs.xp_earned) as total_xp, SUM(user_activity_logs.points_earned) as total_points')
            ->first();

        // dd($user_follow);
        return view('user.profile', compact('user', 'user_follow', 'courses', 'following', 'followers', 'user_points', 'mcq', 'flashcard', 'wsp'));
    }

    public function update_follow(Request $request, $user_followed_id)
    {
        try {
            $user_followed_id = Crypt::decrypt($user_followed_id);
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated',
                ], 401);
            }

            $user_follow = UserFollow::where('user_follower_id', $user->id)
                ->where('user_followed_id', $user_followed_id)
                ->where('status', 1)
                ->first();

            $user_followed = User::findOrFail($user_followed_id);

            if ($user_follow) {
                $user_follow->status = 0;
                $user_follow->updated_at = now();
                $user_follow->save();

                $user_followed->total_follower -= 1;
                $user_followed->save();

                return response()->json([
                    'success' => true,
                    'following' => false,
                    'totalFollower' => $user_followed->total_follower,
                ]);
            } else {
                UserFollow::updateOrCreate(
                    [
                        'user_follower_id' => $user->id,
                        'user_followed_id' => $user_followed_id,
                    ],
                    [
                        'status' => 1,
                        'created_at' => now(),
                    ]
                );

                $user_followed->total_follower += 1;
                $user_followed->save();

                return response()->json([
                    'success' => true,
                    'following' => true,
                    'totalFollower' => $user_followed->total_follower,
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Follow toggle failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Process failed',
            ], 500);
        }
    }


    function calculateLevelFromXP($xp) {
        // Solve: 100 * (n-1)*n / 2 <= xp
        $a = 50;  // (100 / 2)
        $b = -50;
        $c = -$xp;

        // Quadratic formula: n = [-b ± sqrt(b² - 4ac)] / 2a
        $discriminant = pow($b, 2) - (4 * $a * $c);
        $n = 1;

        if ($discriminant >= 0) {
            $sqrtDiscriminant = sqrt($discriminant);
            $n = (-$b + $sqrtDiscriminant) / (2 * $a);
        }

        return floor($n); // Return the current level
    }

    function xpForLevel($level) {
        return 100 * ($level - 1) * $level / 2;
    }

    public function update_user_points(Request $request) {
        $user = Auth::user();

        $validated = $request->validate([
            'user_activity_log_id' => 'nullable|integer|exists:user_activity_logs,id',
            'activity_type' => 'required|string',
            'xp_earned' => 'required|integer|min:0',
            'max_xp' => 'required|integer|min:0',
            'points_earned' => 'required|integer|min:0',
            'token_used' => 'nullable|integer|min:0',
            'topic' => 'nullable|string',
            'file_name' => 'nullable|string',
        ]);

        // Create or update user activity log
        if (isset($validated['user_activity_log_id'])) {
            $activity = UserActivityLog::find($validated['user_activity_log_id']);
            $activity->fill([
                'xp_earned' => $validated['xp_earned'],
                'max_xp' => $validated['max_xp'],
                'points_earned' => $validated['points_earned'],
                'topic' => $validated['topic'] ?? $activity->topic,
                'file_name' => $validated['file_name'] ?? $activity->file_name,
                'completed_at' => now(),
                'updated_at' => now(),
            ]);
            $activity->save();
        } else {
            $activity = UserActivityLog::create([
                'user_id' => $user->id,
                'activity_type' => $validated['activity_type'],
                'xp_earned' => $validated['xp_earned'],
                'max_xp' => $validated['max_xp'],
                'points_earned' => $validated['points_earned'],
                'token_used' => $validated['token_used'] ?? 0,
                'topic' => $validated['topic'] ?? null,
                'file_name' => $validated['file_name'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $user_point = UserPoint::where('user_id', $user->id)->first();

        if (!$user_point) {
            $user_point = new UserPoint();
            $user_point->user_id = $user->id;
            $user_point->save();
        } 

        // Add xp and points
        $user_point->xp += $validated['xp_earned'];
        $user_point->total_points += $validated['points_earned'];
        $user_point->level = $this->calculateLevelFromXP($user_point->xp);

        $nextLevel = $user_point->level + 1;
        $xpToNextLevel = $this->xpForLevel($nextLevel) - $user_point->xp;

        // Handle streak (optional - simple version)
        $today = now()->startOfDay();
        $lastDate = $user_point->last_streak_date ? $user_point->last_streak_date->startOfDay() : null;

        if (!$lastDate || $today->diffInDays($lastDate) > 1) {
            // reset streak
            $user_point->current_streak = 1;
        } elseif ($today->diffInDays($lastDate) == 1) {
            $user_point->current_streak += 1;
        }

        // update longest streak
        if ($user_point->current_streak > $user_point->longest_streak) {
            $user_point->longest_streak = $user_point->current_streak;
        }

        $user_point->last_streak_date = now();
        $user_point->save();


        // dd($user_point, $nextLevel, $xpToNextLevel);

        return response()->json([
            'status' => 'success',
            'xp' => $user_point->xp,
            'level' => $user_point->level,
            'points' => $user_point->total_points,
            'current_streak' => $user_point->current_streak,
            'next_level' => $nextLevel,
            'xp_to_next_level' => $xpToNextLevel
        ]);
    }

    // ADMIN SIDE
    public function admin_find_user(Request $request)
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

        $users = User::where('status', '!=', 0)
            ->where('role', '!=', 'Superadmin')
            ->with([
                'userPoints',
            ])
            ->withCount(['following' => function ($query) {
                $query->where('user_follow.status', '!=', 0); // only count active following
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        
        // dd($users);

        return view('admin.user.find_user', compact('courses', 'topics', 'users'));
    }

    public function admin_edit_user(Request $request, $user_id)
    {
        $validated = $request->validate([
            // 'name' => 'required|string|max:128',
            // 'desc' => 'nullable|string',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'topic' => 'nullable|exists:topics,id',
            'status' => 'required|in:0,1,2',
        ]);

        $user_id = Crypt::decrypt($user_id);
        $user = User::find($user_id);

        $user->status = $validated['status'];
        // $course->updated_at = now();
        $user->save();

            return response()->json([
            'success' => true,
            'message' => 'User status updated successfully',
            'status' => $user->status
        ]);
    }

    public function admin_user_statistics(Request $request)
    {
        // Get all users (excluding superadmin and inactive)
        $users = User::where('status', '!=', 0)
            ->where('role', '!=', 'Superadmin')
            ->with(['userPoints'])
            ->withCount(['following' => function ($query) {
                $query->where('user_follow.status', '!=', 0);
            }])
            ->get();

        // User role distribution for pie chart
        $roleDistribution = User::where('status', '!=', 0)
            ->where('role', '!=', 'Superadmin')
            ->select('role', DB::raw('COUNT(*) as user_count'))
            ->groupBy('role')
            ->get();

        // MONTHLY USER REGISTRATION TRENDS
        $monthlyUsers = User::where('status', '!=', 0)
            ->where('role', '!=', 'Superadmin')
            ->select([
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as label"),
                DB::raw("YEAR(created_at) as year_number"),
                DB::raw("MONTH(created_at) as month_number"),
                DB::raw("COUNT(*) as total")
            ])
            ->groupBy(
                DB::raw("DATE_FORMAT(created_at, '%b %Y')"),
                DB::raw("YEAR(created_at)"),
                DB::raw("MONTH(created_at)")
            )
            ->orderByRaw("YEAR(created_at), MONTH(created_at)")
            ->get();

        // WEEKLY USER REGISTRATION (last 7 days)
        $weeklyUsers = User::where('status', '!=', 0)
            ->where('role', '!=', 'Superadmin')
            ->whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->select([
                DB::raw("DATE_FORMAT(created_at, '%a') as label"),
                DB::raw("DATE(created_at) as group_date"),
                DB::raw("COUNT(*) as total")
            ])
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%a')"), DB::raw("DATE(created_at)"))
            ->orderBy('group_date')
            ->get();

        // DAILY USER REGISTRATION (last 24 hours, by hour)
        $dailyUsers = User::where('status', '!=', 0)
            ->where('role', '!=', 'Superadmin')
            ->whereBetween('created_at', [Carbon::now()->subHours(23), Carbon::now()])
            ->select(DB::raw("HOUR(created_at) as label"), DB::raw("COUNT(*) as total"))
            ->groupBy(DB::raw("HOUR(created_at)"))
            ->orderBy(DB::raw("HOUR(created_at)"))
            ->get();

        // User engagement stats (users with high followers, ratings, etc.)
        $topUsers = User::where('status', '!=', 0)
            ->where('role', '!=', 'Superadmin')
            ->orderBy('total_follower', 'desc')
            ->take(10)
            ->get();

        // Average user metrics
        $avgStats = User::where('status', '!=', 0)
            ->where('role', '!=', 'Superadmin')
            ->select([
                DB::raw('AVG(total_follower) as avg_followers'),
                DB::raw('AVG(average_rating) as avg_rating'),
                DB::raw('COUNT(*) as total_users')
            ])
            ->first();

        return view('admin.user.statistics_user', compact(
            'users', 
            'roleDistribution', 
            'monthlyUsers', 
            'weeklyUsers', 
            'dailyUsers', 
            'topUsers', 
            'avgStats'
        ));
    }
}