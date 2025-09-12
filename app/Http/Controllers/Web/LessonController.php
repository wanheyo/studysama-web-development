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
                }])
                ->with(['userProgressions' => function ($query) {
                $query->whereHas('userCourse', function ($subQuery) {
                    $subQuery->where('user_id', auth()->id())
                            ->where('status', 1); // only active user_course
                });
            }]);
        }])
        ->where('course_id', $course_id)
        ->where('status', 1)
        ->orderByRaw('CASE WHEN order_index IS NULL THEN 1 ELSE 0 END, order_index ASC')
        ->orderBy('id', 'ASC')
        ->get();

        $totalLessons = $lessons->count();
        $totalResources = 0;
        $totalChecked   = 0;
        $totalComments  = 0;
        $totalCompletedLessons = 0;

        foreach ($lessons as $lesson) {
            $lessonResourceCount = $lesson->resources->count();
            $lessonCheckedCount  = $lesson->resources->sum(
                fn($resource) => $resource->userProgressions->where('status', 1)->count()
            );

            $totalResources += $lessonResourceCount;
            $totalChecked   += $lessonCheckedCount;
            $totalComments  += $lesson->resources->sum(fn($resource) => $resource->comments->count());

            if ($lessonResourceCount > 0 && $lessonCheckedCount === $lessonResourceCount) {
                $totalCompletedLessons++;
            }
        }

        $totalCompletedResources = $totalChecked;

        $courseProgress = $totalResources > 0
            ? round(($totalChecked / $totalResources) * 100, 1)
            : 0;

        // dd($totalResources);

        return view('course.lesson.lesson_list', compact(
            'course',
            'lessons',
            'totalLessons',
            'totalResources',
            'totalChecked',
            'totalCompletedResources',
            'totalComments',
            'totalCompletedLessons',
            'courseProgress'
        ));

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

    public function reorder_lesson(Request $request)
    {
        $validated = $request->validate([
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|integer|exists:lessons,id',
            'lessons.*.order_index' => 'required|integer',
        ]);

        foreach ($validated['lessons'] as $lessonData) {
            Lesson::where('id', $lessonData['id'])
                ->update(['order_index' => $lessonData['order_index']]);
        }

        return response()->json(['success' => true]);
    }
}
