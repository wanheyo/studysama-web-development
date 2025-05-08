<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Comment;
use App\Models\Resource;
use App\Models\ResourceFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ResourceController extends Controller
{
    // Web API
    public function get_comments($resource_id)
    {
        $resource = Resource::findOrFail($resource_id);
        
        $comments = $resource->comments()
            ->with('userCourse.user')
            ->where('status', 1)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->comment_text,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user_name' => $comment->userCourse->user->username,
                    'user_image' => $comment->userCourse->user->image 
                        ? asset('storage/uploads/profile_picture/' . $comment->userCourse->user->image)
                        : asset('assets/images/avtar/woman.jpg')
                ];
            });

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    public function store_comment(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'content' => 'required|string|max:500'
        ]);

        // Get the current user's user_course_id
        $userCourseId = Auth::user()->userCourses()->firstOrFail()->id;

        $comment = Comment::create([
            'user_course_id' => $userCourseId,
            'resource_id' => $request->resource_id,
            'comment_text' => $request->content,
            'status' => 1
        ]);

        // Return the newly created comment with user data
        $comment->load('userCourse.user');

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->comment_text,
                'created_at' => $comment->created_at->diffForHumans(),
                'user_name' => $comment->userCourse->user->username,
                'user_image' => $comment->userCourse->user->image 
                    ? asset('storage/uploads/profile_picture/' . $comment->userCourse->user->image)
                    : asset('assets/images/avtar/woman.jpg')
            ]
        ]);
    }
}
