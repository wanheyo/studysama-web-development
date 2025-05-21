<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class LessonController extends Controller
{
    public function lesson_list(Request $request, $course_id)
    {
        $course_id = Crypt::decrypt($course_id);

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

        $totalLessons = $lessons->count();
        $totalResources = 0;
        $totalComments = 0;

        foreach($lessons as $lesson) {
            
            $totalResources = $lesson->resources->count() + $totalResources;
            $totalComments = $lesson->resources->sum(function ($resource) {
                return $resource->comments->count();
            }) + $totalComments;
        }

        return view('course.lesson.lesson_list', compact('course', 'lessons', 'totalLessons', 'totalResources', 'totalComments'));
    }

    public function add_lesson(Request $request, $course_id)
    {
        $course = Course::where('id', $course_id)
            ->where('status', 1)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:128',
            'desc' => 'nullable|string',
            'learn_outcome' => 'nullable|string',
        ]);

        $lesson = new Lesson();
        $lesson->course_id = $course_id;
        $lesson->name = $validated['name'];
        $lesson->desc = $validated['desc'];
        $lesson->learn_outcome = $validated['learn_outcome'];
        $lesson->status = 1;
        $lesson->created_at = now();
        $lesson->updated_at = now();
        $lesson->save();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Lesson added successfully!',
        //     'lesson' => $lesson
        // ]);
        return redirect()->back()->with('success', 'Lesson added successfully!');
    }

    public function update_lesson(Request $request, $lesson_id)
    {
        $lesson = Lesson::where('id', $lesson_id)
            ->where('status', 1)
            ->firstOrFail();

        // // If deletion is triggered
        // if ($request->delete == '1') {
        //     $lesson->status = 0; // Soft delete
        //     $lesson->updated_at = now();
        //     $lesson->save();

        //     return redirect()->back()->with('success', 'Lesson deleted successfully!');
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:128',
            'desc' => 'nullable|string',
            'learn_outcome' => 'nullable|string',
        ]);

        $lesson->name = $validated['name'];
        $lesson->desc = $validated['desc'];
        $lesson->learn_outcome = $validated['learn_outcome'];
        $lesson->updated_at = now();
        $lesson->save();

        return redirect()->back()->with('success', 'Lesson updated successfully!');
    }

    public function delete_lesson(Request $request, $lesson_id)
    {
        $lesson = Lesson::where('id', $lesson_id)
            ->where('status', 1)
            ->firstOrFail();

        // Soft delete the lesson
        $lesson->status = 0;
        $lesson->updated_at = now();
        $lesson->save();

        return redirect()->back()->with('success', 'Lesson deleted successfully!');
    }
}
