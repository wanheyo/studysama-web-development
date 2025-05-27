<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function homepage(Request $request)
    {
        $user = auth()->user();

        $coursesQuery = DB::table('courses as c')
            ->join('user_courses as uc', 'uc.course_id', '=', 'c.id') // current user's enrollment
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

        $coursesQuery = DB::table('courses as c')
            ->join('user_courses as uc', 'uc.course_id', '=', 'c.id') // current user's enrollment
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
        }
        
        // Logic to show the homepage
        return view('admin.main.homepage', compact('user', 'courses'));
    }
}
