<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function sign_in(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function sign_up(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:16|unique:users',
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

        return redirect()->intended('/');
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
            ->join('user_courses as uc', 'uc.course_id', '=', 'c.id')
            ->join('users as u', 'uc.user_id', '=', 'u.id')
            ->where('c.status', 1)
            ->where('uc.user_id', $user->id)
            ->distinct()
            ->select('c.*', 'uc.role_id as role_id')
            ->get();

        // dd($user_follow);
        return view('user.my_profile', compact('user', 'user_follow', 'courses'));
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
}