<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class LessonController extends Controller
{
    public function lesson_list(Request $request, $course_id)
    {
        $course = Course::where('id', $course_id)
            ->where('status', 1)
            ->firstOrFail();

        $lessons = Lesson::with(['resources' => function ($query) {
                $query->where('status', 1)
                ->with(['resourceFile' => function ($query) {
                    $query->where('status', 1);
                }])
                ->with(['comments' => function ($query) {
                    $query->where('status', 1)
                    ->with(['userCourse.user']);
                }]);
            }])
            ->where('course_id', $course_id)
            ->where('status', 1)
            ->get();

        // dd($lessons);

        // $resourceFiles = Resource::with(['resourceFile'])
        //     ->where('status', 1)
        //     ->get();

        // dd($lessons);

        return view('course.lesson.lesson_list', compact('course', 'lessons'));
    }
}
