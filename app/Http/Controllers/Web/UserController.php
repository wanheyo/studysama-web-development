<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\UserPoint;
use App\Models\UserFollow;
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

            if(Auth::user()->isAdmin() || Auth::user()->isSuperadmin()) {
                return redirect()->intended(route('main.admin.homepage'));
            } else {
                return redirect()->intended(route('main.homepage'));
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
}