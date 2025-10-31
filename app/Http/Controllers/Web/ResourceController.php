<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\UserCourse;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserProgression;
use App\Models\Comment;
use App\Models\Resource;
use App\Models\ResourceFile;
use App\Models\ForumPost;
use App\Models\ForumReply;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

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

    // public function add_resource(Request $request)
    // {
    //     try {
    //         // Validate input
    //         $validatedData = $request->validate([
    //             'name' => 'required|string|max:255',
    //             'desc' => 'nullable|string|max:500',
    //             'category' => 'required|integer',
    //             'link' => 'nullable|string|max:255',
    //             'lesson_id' => 'required|integer|exists:lessons,id',
                
    //             'file_name' => 'nullable|string|max:255',
    //             'file_type' => 'nullable|string|max:255',
    //             'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,tiff,doc,docx,pdf,txt,rtf,odt,zip,rar,7z|max:5120',
    //         ]);

    //         // Get authenticated user
    //         $user = Auth::user();
            
    //         // Check if the user exists
    //         if (!$user) {
    //             return redirect()->back()->with('error', 'User not authenticated');
    //         }

    //         DB::beginTransaction();
            
    //         try {
    //             $resource_file = null;
    //             $resourceFilePath = null;

    //             // Handle file upload if present
    //             if ($request->hasFile('file')) {
    //                 $file = $request->file('file');
    //                 $originalName = $file->getClientOriginalName();
    //                 // $fileType = $file->getClientMimeType();
    //                 $fileType = $file->getClientOriginalExtension(); // Just 'pdf', 'docx', etc.
                    
    //                 // Store the file
    //                 // $request->file('profile_image')->storeAs('uploads/profile_picture', $filename, 'public');
    //                 $resourceFilePath = $file->store('uploads/resource_file', 'public');
    //                 $storedFileName = basename($resourceFilePath); // Extract the filename only

    //                 // Create resource file record
    //                 $resource_file = ResourceFile::create([
    //                     'name' => $storedFileName,
    //                     'type' => $fileType,
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }

    //             // Create resource record
    //             $resource = Resource::create([
    //                 'name' => $validatedData['name'],
    //                 'desc' => $validatedData['desc'] ?? null,
    //                 'category' => $validatedData['category'],
    //                 'link' => $validatedData['link'] ?? null,
    //                 'lesson_id' => $validatedData['lesson_id'],
    //                 'file_id' => $resource_file->id ?? null,
    //                 'status' => 1, // Assuming active status
    //                 'total_visit' => 0
    //             ]);

    //             DB::commit();
                
    //             // Flash success message to the session
    //             session()->flash('success', 'Resource added successfully');
                
    //             // Redirect back to the lesson page
    //             return redirect()->back();
                
    //         } catch (\Exception $e) {
    //             DB::rollBack();
                
    //             // Log the error
    //             \Log::error('Resource creation failed', [
    //                 'error' => $e->getMessage(),
    //                 'trace' => $e->getTraceAsString(),
    //             ]);
                
    //             return redirect()->back()->with('error', 'Failed to add resource. ' . $e->getMessage())->withInput();
    //         }
    //     } catch (ValidationException $e) {
    //         // Handle validation errors
    //         return redirect()->back()->withErrors($e->errors())->withInput();
    //     } catch (\Exception $e) {
    //         // Log the error
    //         \Log::error('Resource creation failed', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);
            
    //         return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
    //     }
    // }

    public function add_resource(Request $request)
    {
        try {
            // Define supported file types for better error messages
            $supportedTypes = 'jpg, jpeg, png, gif, bmp, tiff, doc, docx, pdf, txt, rtf, odt, zip, rar, 7z, mp4, mov, avi, mkv, wmv, webm, mp3, wav, m4a, aac, flac';
            
            // Manual file checks BEFORE validation to provide custom error messages
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileExtension = strtolower($file->getClientOriginalExtension());
                $fileSizeInMB = round($file->getSize() / 1024 / 1024, 2); // Convert bytes to MB
                $maxSizeInMB = 100;
                
                $allowedExtensions = [
                    // Documents & archives
                    'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff',
                    'doc', 'docx', 'pdf', 'txt', 'rtf', 'odt',
                    'zip', 'rar', '7z',

                    // Video formats
                    'mp4', 'mov', 'avi', 'mkv', 'wmv', 'webm',

                    // Audio formats
                    'mp3', 'wav', 'm4a', 'aac', 'flac',
                ];
                
                // Check file type
                if (!in_array($fileExtension, $allowedExtensions)) {
                    // return redirect()->back()
                    //     ->with('error', "The file type '.{$fileExtension}' is not supported.")
                    //     ->withInput();

                    return response()->json([
                        'success' => false,
                        'message' => 'The file type .' . $fileExtension . ' is not supported.'
                    ]);
                }
                
                // Check file size
                if ($fileSizeInMB > $maxSizeInMB) {
                    // return redirect()->back()
                    //     ->with('error', "The uploaded file is too large ({$fileSizeInMB}MB). Maximum file size allowed is {$maxSizeInMB}MB.")
                    //     ->withInput();
                    return response()->json([
                        'success' => false,
                        'message' => 'The uploaded file is too large (' . $fileSizeInMB . 'MB). Maximum file size allowed is {$maxSizeInMB}MB.'
                    ]);
                }
            }
            
            // Validate input with custom messages (after manual file checks)
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string|max:500',
                'category' => 'required|integer',
                'link' => 'nullable|string|max:255',
                'lesson_id' => 'required|integer|exists:lessons,id',
                
                'file_name' => 'nullable|string|max:255',
                'file_type' => 'nullable|string|max:255',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,tiff,doc,docx,pdf,txt,rtf,odt,zip,rar,7z,mp4,mov,avi,mkv,wmv,webm,mp3,wav,m4a,aac,flac|max:102400', // 100MB
            ], [
                // Custom validation messages
                'file.mimes' => 'The uploaded file type is not supported.',
                'file.max' => 'The file size must not exceed 100MB.',
                'lesson_id.exists' => 'The selected lesson does not exist.',
                'category.required' => 'Please select a category.',
                'name.required' => 'Resource name is required.',
            ]);

            // Get authenticated user
            $user = Auth::user();
            
            // Check if the user exists
            if (!$user) {
                // return redirect()->back()->with('error', 'User not authenticated');
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.'
                ]);
            }

            // Duplicate check — resource name must be unique per lesson
            $existingResource = Resource::where('lesson_id', $validatedData['lesson_id'])
                ->where('name', $validatedData['name'])
                ->where('status', 1)
                ->first();

            if ($existingResource) {
                // return redirect()->back()->with('error', 'A resource with this name already exists in this lesson.')->withInput();
                return response()->json([
                    'success' => false,
                    'message' => 'A resource with this name already exists in this lesson.'
                ]);
            }

            DB::beginTransaction();
            
            try {
                $resource_file = null;
                $resourceFilePath = null;

                // Handle file upload if present
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $originalName = $file->getClientOriginalName();
                    $fileType = $file->getClientOriginalExtension(); // Just 'pdf', 'docx', etc.
                    
                    // Store the file
                    $resourceFilePath = $file->store('uploads/resource_file', 'public');
                    $storedFileName = basename($resourceFilePath); // Extract the filename only

                    // Create resource file record
                    $resource_file = ResourceFile::create([
                        'name' => $storedFileName,
                        'type' => $fileType,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Create resource record
                $resource = Resource::create([
                    'name' => $validatedData['name'],
                    'desc' => $validatedData['desc'] ?? null,
                    'category' => $validatedData['category'],
                    'link' => $validatedData['link'] ?? null,
                    'lesson_id' => $validatedData['lesson_id'],
                    'file_id' => $resource_file->id ?? null,
                    'status' => 1, // Assuming active status
                    'total_visit' => 0
                ]);

                DB::commit();
                
                // return redirect()->back()->with('success', 'Resource added successfully');
                return response()->json([
                    'success' => true,
                    'message' => 'Resource added successfully!'
                ]);

                
            } catch (\Exception $e) {
                DB::rollBack();
                
                // Log the error
                \Log::error('Resource creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                
                // return redirect()->back()->with('error', 'Failed to add resource. ' . $e->getMessage())->withInput();
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add resource.'
                ]);
            }
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Resource creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
            return response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred. Please try again.'
                ]);
        }
    }

    public function update_resource(Request $request, $resource_id)
    {
        try {
            // Check if delete flag is set
            if ($request->has('delete') && $request->input('delete') == 1) {
                return $this->delete_resource($resource_id);
            }

            // Validate input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string|max:500',
                'category' => 'required|integer',
                'link' => 'nullable|string|max:255',
                'file_id' => 'nullable|integer',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,tiff,doc,docx,pdf,txt,rtf,odt,zip,rar,7z|max:5120',
                'lesson_id' => 'required|integer|exists:lessons,id',
            ]);

            $user = Auth::user();

            // Check if the user exists
            if (!$user) {
                return redirect()->back()->with('error', 'User not authenticated: 401');
                // return response()->json([
                //     'success' => false,
                //     'message' => 'User not authenticated.'
                // ]);
            }

            // Find the resource to update
            $resource = Resource::find($resource_id);

            // Check if the resource exists
            if (!$resource) {
                return redirect()->back()->with('error', 'Resource not found: 404');
                // return response()->json([
                //     'success' => false,
                //     'message' => 'Resource not found.'
                // ]);
            }

            // Check for duplicate name (any active resource with same name)
            $existingResource = Resource::where('lesson_id', $validatedData['lesson_id'])
                ->where('name', $validatedData['name'])
                ->where('id', '!=', $resource_id) // exclude the same record
                ->where('status', 1)
                ->first();

            if ($existingResource) {
                return redirect()->back()->with('error', 'A resource with this name already exists.');
                // return response()->json([
                //     'success' => false,
                //     'message' => 'A resource with this name already exists.'
                // ]);
            }

            $resource_file = null;
            $resource_type = $request->input('resource_type', 'file');

            // Handle resource type: file
            // if ($resource_type === 'file') {
            //     // If a new file is uploaded
            //     if ($request->hasFile('file')) {
            //         \Log::info('File uploaded successfully: ' . $request->file('file')->getClientOriginalName());

            //         // Store the file
            //         $resourceFilePath = $request->file('file')->store('uploads/resource_file', 'public');
            //         // $fileType = $request->file('file')->getClientMimeType();
            //         $fileType = $request->file('file')->getClientOriginalExtension(); // Just 'pdf', 'docx', etc.
            //         $storedFileName = basename($resourceFilePath); // Extract the filename only

            //         // Update existing file record or create new one
            //         if (!empty($resource->file_id)) {
            //             $resource_file = ResourceFile::find($resource->file_id);
                        
            //             if ($resource_file) {
            //                 // Delete the old file if it exists
            //                 if (Storage::disk('public')->exists($resource_file->name)) {
            //                     Storage::disk('public')->delete($resource_file->name);
            //                 }
                            
            //                 $resource_file->name = $storedFileName;
            //                 $resource_file->type = $fileType;
            //                 $resource_file->status = 1;
            //                 $resource_file->updated_at = now();
            //                 $resource_file->save();
            //             } else {
            //                 // Create new file record if original was not found
            //                 $resource_file = ResourceFile::create([
            //                     'name' => $resourceFilePath,
            //                     'type' => $fileType,
            //                     'status' => 1,
            //                     'created_at' => now(),
            //                     'updated_at' => now(),
            //                 ]);
            //             }
            //         } else {
            //             // Create new file record
            //             $resource_file = ResourceFile::create([
            //                 'name' => $resourceFilePath,
            //                 'type' => $fileType,
            //                 'status' => 1,
            //                 'created_at' => now(),
            //                 'updated_at' => now(),
            //             ]);
            //         }
            //     }
                
            //     // Remove link if switching from link to file
            //     $resource->link = null;
                
            // } 
            // // Handle resource type: link
            // else if ($resource_type === 'link') {
            //     // If switching from file to link, update the file status to inactive
            //     if (!empty($resource->file_id)) {
            //         $resource_file = ResourceFile::find($resource->file_id);
            //         if ($resource_file) {
            //             $resource_file->status = 0;
            //             $resource_file->updated_at = now();
            //             $resource_file->save();
            //         }
            //     }
                
            //     $resource->file_id = null;
            //     $resource->link = $validatedData['link'];
            // }

            // Update the resource
            $resource->name = $validatedData['name'];
            $resource->desc = $validatedData['desc'] ?? null;
            $resource->category = $validatedData['category'];
            $resource->status = 1; // Active
            $resource->updated_at = now();
            
            // Update file_id only if we're dealing with a file type resource and have a file
            // if ($resource_type === 'file' && $resource_file) {
            //     $resource->file_id = $resource_file->id;
            // }
            
            // Save the changes
            $resource->save();

            // Return a success response
            return redirect()->back()->with('success', 'Resource updated successfully');
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Resource updated successfully!'
            // ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Resource update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(), 
            ]);

            // Return an error response
            return redirect()->back()->with('error', 'Resource update failed: ' . $e->getMessage());
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Resource update failed.'
            // ]);
        }
    }

    public function delete_resource($resource_id)
    {
        try {
            $user = Auth::user();

            // Check if the user exists
            if (!$user) {
                return redirect()->back()->with('error', 'User not authenticated: 401');
            }

            // Find the resource to update
            $resource = Resource::find($resource_id);

            // Check if the resource exists
            if (!$resource) {
                return redirect()->back()->with('error', 'Resource not found: 404');
            }

            // Set status to 0 (soft delete)
            $resource->status = 0;
            $resource->updated_at = now();
            $resource->save();

            // Also set file status to 0 if there's an associated file
            if (!empty($resource->file_id)) {
                $resource_file = ResourceFile::find($resource->file_id);
                if ($resource_file) {
                    $resource_file->status = 0;
                    $resource_file->updated_at = now();
                    $resource_file->save();
                }
            }

            return redirect()->back()->with('success', 'Resource deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Resource delete failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Resource deletion failed: ' . $e->getMessage());
        }
    }

    // public function toggle_progression(Request $request)
    // {
    //     $request->validate([
    //         'resource_id' => 'required|exists:resources,id',
    //         'course_id'   => 'required|exists:courses,id',
    //         'status'      => 'required|in:0,1',
    //     ]);

    //     $userCourse = UserCourse::where('course_id', $request->course_id)
    //         ->where('user_id', auth()->id())
    //         ->where('status', 1)
    //         ->first();

    //     if (!$userCourse) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No active course enrollment found for this user.',
    //         ], 404);
    //     }


    //     $progression = UserProgression::updateOrCreate(
    //         [
    //             'user_course_id' => $userCourse->id,
    //             'resource_id'    => $request->resource_id,
    //         ],
    //         [
    //             'status' => $request->status, // 1 = checked, 0 = unchecked
    //         ]
    //     );

    //     return response()->json([
    //         'success' => true,
    //         'progression' => $progression,
    //     ]);
    // }

    public function toggle_progression(Request $request)
    {
        $data = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'course_id'   => 'required|exists:courses,id',
            'status'      => 'required|in:0,1',
        ]);

        // find resource
        $resource = Resource::findOrFail($data['resource_id']);

        // ensure user_course exists
        $userCourse = UserCourse::where('course_id', $data['course_id'])
            ->where('user_id', auth()->id())
            ->where('status', 1)
            ->first();

        if (! $userCourse) {
            return response()->json([
                'success' => false,
                'message' => 'No active enrollment found for this user/course.'
            ], 404);
        }

        // create/update progression
        $progression = UserProgression::updateOrCreate(
            [
                'user_course_id' => $userCourse->id,
                'resource_id'    => $resource->id,
            ],
            [
                'status' => $data['status'],
            ]
        );

        // --- Compute lesson-level counts
        $lessonId = $resource->lesson_id; // assumes resources table has lesson_id
        $lessonResourceIds = Resource::where('lesson_id', $lessonId)
            ->where('status', 1)
            ->pluck('id');

        $lessonTotal = $lessonResourceIds->count();

        $lessonChecked = UserProgression::whereIn('resource_id', $lessonResourceIds)
            ->where('user_course_id', $userCourse->id)
            ->where('status', 1)
            ->count();

        // --- Compute course-level counts
        $lessonIdsInCourse = Lesson::where('course_id', $data['course_id'])
            ->where('status', 1)
            ->pluck('id');

        $courseResourceIds = Resource::whereIn('lesson_id', $lessonIdsInCourse)
            ->where('status', 1)
            ->pluck('id');

        $courseTotal = $courseResourceIds->count();

        $courseChecked = UserProgression::whereIn('resource_id', $courseResourceIds)
            ->where('user_course_id', $userCourse->id)
            ->where('status', 1)
            ->count();

        $lessonPercentage = $lessonTotal > 0 ? round(($lessonChecked / $lessonTotal) * 100, 1) : 0;
        $coursePercentage = $courseTotal > 0 ? round(($courseChecked / $courseTotal) * 100, 1) : 0;

        return response()->json([
            'success' => true,
            'progression' => $progression,
            'lesson' => [
                'id' => $lessonId,
                'checked' => (int)$lessonChecked,
                'total' => (int)$lessonTotal,
                'percentage' => $lessonPercentage,
            ],
            'course' => [
                'checked' => (int)$courseChecked,
                'total' => (int)$courseTotal,
                'percentage' => $coursePercentage,
            ],
            'overview' => [
                'completedLessons' => Lesson::where('course_id', $data['course_id'])
                    ->where('status', 1)
                    ->get()
                    ->filter(function ($lesson) use ($userCourse) {
                        $lessonResourceIds = $lesson->resources()->where('status', 1)->pluck('id');
                        $total = $lessonResourceIds->count();
                        $checked = UserProgression::whereIn('resource_id', $lessonResourceIds)
                            ->where('user_course_id', $userCourse->id)
                            ->where('status', 1)
                            ->count();
                        return $total > 0 && $total === $checked; // only completed if ALL resources done
                    })->count(),
                'totalLessons' => Lesson::where('course_id', $data['course_id'])
                    ->where('status', 1)
                    ->count(),
                'completedResources' => (int)$courseChecked,
                'totalResources' => (int)$courseTotal,
            ]
        ]);
    }

    public function resource_tutor_statistics(Request $request, $resource_id) {
        $resource_id = Crypt::decrypt($resource_id);

        $resource = Resource::where('id', $resource_id)
            ->where('status', 1)
            ->firstOrFail();

        $students = UserCourse::with(['user', 
            'userProgressions' => function ($query) use ($resource_id) {
                $query->where('resource_id', $resource_id);
            }])
            ->where('status', 1)
            ->where('role_id', 3)
            ->where('course_id', $resource->lesson->course_id)
            ->get();

        // Stats
        $totalStudents = $students->count();
        $completedStudents = 0;
        
        foreach ($students as $student) {
            $completedCount = $student->userProgressions->where('status', 1)->count();
            if ($completedCount > 0) {
                $completedStudents++;
            }
            $student->progress_percentage = $completedCount > 0 ? 100 : 0;
        }

        $inProgressStudents = $totalStudents - $completedStudents;

        return view('course.lesson.resource.resource_tutor_statistics', compact(
            'resource',
            'students',
            'totalStudents',
            'completedStudents',
            'inProgressStudents'
        ));
    }

    public function forum(Request $request, $resource_id) {
        $resource_id = Crypt::decrypt($resource_id);

        $resource = Resource::where('id', $resource_id)
            ->where('status', 1)
            ->with([
                'lesson' => function ($query) {
                    $query->where('status', 1)
                        ->with('course');
                },
                'resourceFile',
                'forumPosts' => function ($query) {
                    $query->where('status', 1)
                        ->with([
                            'resourceFile',
                            'userCourse.user',
                            'forumReplies' => function ($replyQuery) {
                                $replyQuery->whereNull('forum_reply_id')
                                    ->with(['userCourse.user', 'childrens']);
                            }

                        ]);
                }
            ])
            ->firstOrFail();

        foreach ($resource->forumPosts as $post) {
            $post->total_replies_count = $this->count_all_replies($post->forumReplies);
        }

        // Get the logged-in user ID (once)
        $userId = auth()->id();

        // Loop through all posts and replies to check Ex-Student status
        foreach ($resource->forumPosts as $post) {
            // Check if the poster has rejoined the course
            if ($post->userCourse) {
                $post->userCourse->is_ex_student = !$this->hasRejoinedCourse(
                    $post->userCourse->course_id,
                    $post->userCourse->user_id
                ) && $post->userCourse->status == 0;
            }

            // Now check for all replies recursively
            foreach ($post->forumReplies as $reply) {
                $this->setExStudentFlagRecursive($reply);
            }
        }

        return view('course.lesson.resource.forum', compact('resource'));
    }

    private function setExStudentFlagRecursive($reply)
    {
        if ($reply->userCourse) {
            $reply->userCourse->is_ex_student = !$this->hasRejoinedCourse(
                $reply->userCourse->course_id,
                $reply->userCourse->user_id
            ) && $reply->userCourse->status == 0;
        }

        // Recurse for children replies
        if (!empty($reply->childrens)) {
            foreach ($reply->childrens as $child) {
                $this->setExStudentFlagRecursive($child);
            }
        }
    }

    private function hasRejoinedCourse($courseId, $userId)
    {
        return UserCourse::where('course_id', $courseId)
            ->where('user_id', $userId)
            ->where('status', 1)
            ->exists();
    }

    // helper function for forum
    private function count_all_replies($replies)
    {
        $count = 0;
        foreach ($replies as $reply) {
            $count++;
            if ($reply->childrens->isNotEmpty()) {
                $count += $this->count_all_replies($reply->childrens);
            }
        }
        return $count;
    }

    public function sort_replies(Request $request)
    {
        $postId = $request->query('post_id');
        $sortOrder = $request->query('sort', 'latest');

        $post = ForumPost::with([
            'forumReplies.childrens.userCourse.user',
            'forumReplies.userCourse.user',
            'resource.lesson.course'
        ])->findOrFail($postId);

        // Only get top-level replies (no parent)
        $topReplies = $post->forumReplies->whereNull('forum_reply_id');

        // Apply sorting
        $replies = $sortOrder === 'oldest'
            ? $topReplies->sortBy('created_at')
            : $topReplies->sortByDesc('created_at');

        // Render each top-level reply partial
        $html = '';
        foreach ($replies as $reply) {
            $html .= view('course.lesson.resource.partials.forum_reply', [
                'reply' => $reply,
                'resource' => $post->resource,
                'post' => $post,
                'sortOrder' => $sortOrder
            ])->render();
        }

        return response($html);
    }

    public function add_post(Request $request)
    {
        try {
            // Define supported file types for better error messages
            $supportedTypes = 'jpg, jpeg, png, gif, bmp, tiff, doc, docx, pdf, txt, rtf, odt, zip, rar, 7z';
            
            // Manual file checks BEFORE validation to provide custom error messages
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileExtension = strtolower($file->getClientOriginalExtension());
                $fileSizeInMB = round($file->getSize() / 1024 / 1024, 2); // Convert bytes to MB
                $maxSizeInMB = 5;
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'doc', 'docx', 'pdf', 'txt', 'rtf', 'odt', 'zip', 'rar', '7z'];
                
                // Check file type
                if (!in_array($fileExtension, $allowedExtensions)) {
                    return redirect()->back()
                        ->with('error', "The file type '.{$fileExtension}' is not supported.")
                        ->withInput();
                }
                
                // Check file size
                if ($fileSizeInMB > $maxSizeInMB) {
                    return redirect()->back()
                        ->with('error', "The uploaded file is too large ({$fileSizeInMB}MB). Maximum file size allowed is {$maxSizeInMB}MB.")
                        ->withInput();
                }
            }
            
            // Validate input with custom messages (after manual file checks)
            $validatedData = $request->validate([
                'title' => 'required|string|max:300',
                'content' => 'required|string',
                'course_id' => 'required|integer|exists:courses,id',
                'resource_id' => 'required|integer|exists:resources,id',
                
                'file_name' => 'nullable|string|max:255',
                'file_type' => 'nullable|string|max:255',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,tiff,doc,docx,pdf,txt,rtf,odt,zip,rar,7z|max:5120',
            ], [
                // Custom validation messages
                'file.mimes' => 'The uploaded file type is not supported.',
                'file.max' => 'The file size must not exceed 5MB.',
                'course_id.exists' => 'The selected course does not exist.',
                'resource_id.exists' => 'The selected resource does not exist.',
                'title.required' => 'Post title is required.',
                'content.required' => 'Post content is required.',
            ]);

            // Get authenticated user
            $user = Auth::user();
            
            // Check if the user exists
            if (!$user) {
                return redirect()->back()->with('error', 'User not authenticated');
            }

            $user_course = $user->userCourses()
                ->where('course_id', $validatedData['course_id'])
                ->where('status', 1)
                ->first();

            DB::beginTransaction();
            
            try {
                $resource_file = null;
                $resourceFilePath = null;

                // Handle file upload if present
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $originalName = $file->getClientOriginalName();
                    $fileType = $file->getClientOriginalExtension(); // Just 'pdf', 'docx', etc.
                    
                    // Store the file
                    $resourceFilePath = $file->store('uploads/resource_file', 'public');
                    $storedFileName = basename($resourceFilePath); // Extract the filename only

                    // Create resource file record
                    $resource_file = ResourceFile::create([
                        'name' => $storedFileName,
                        'type' => $fileType,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Create forumPost record
                $forumPost = ForumPost::create([
                    'user_course_id' => $user_course->id,
                    'resource_id' => $validatedData['resource_id'],
                    'title' => $validatedData['title'],
                    'content' => $validatedData['content'],
                    'resource_file_id' => $resource_file->id ?? null,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();
                
                // Flash success message to the session
                session()->flash('success', 'Post added successfully');
                
                // Redirect back to the lesson page
                return redirect()->back();
                
            } catch (\Exception $e) {
                DB::rollBack();
                
                // Log the error
                \Log::error('Post creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                
                return redirect()->back()->with('error', 'Failed to add post. ' . $e->getMessage())->withInput();
            }
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Post creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
        }
    }

    public function update_post(Request $request, $post_id)
    {
        $post_id = Crypt::decrypt($post_id);

        $post = ForumPost::where('id', $post_id)
            ->where('status', 1)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->updated_at = now();
        $post->save();

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    public function delete_post($post_id)
    {
        $id = Crypt::decrypt($post_id);
        $post = ForumPost::findOrFail($id);

        if (!$post) {
            return back()->with('error', 'Post not found.');
        }
        
        $post->status = 0;
        $post->updated_at = now();
        $post->save();

        return back()->with('success', 'Post deleted successfully.');
    }


    public function add_reply(Request $request)
    {
        try {
            // Define supported file types for better error messages
            $supportedTypes = 'jpg, jpeg, png, gif, bmp, tiff, doc, docx, pdf, txt, rtf, odt, zip, rar, 7z';
            
            // Manual file checks BEFORE validation to provide custom error messages
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileExtension = strtolower($file->getClientOriginalExtension());
                $fileSizeInMB = round($file->getSize() / 1024 / 1024, 2); // Convert bytes to MB
                $maxSizeInMB = 5;
                
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'doc', 'docx', 'pdf', 'txt', 'rtf', 'odt', 'zip', 'rar', '7z'];
                
                // Check file type
                if (!in_array($fileExtension, $allowedExtensions)) {
                    return redirect()->back()
                        ->with('error', "The file type '.{$fileExtension}' is not supported.")
                        ->withInput();
                }
                
                // Check file size
                if ($fileSizeInMB > $maxSizeInMB) {
                    return redirect()->back()
                        ->with('error', "The uploaded file is too large ({$fileSizeInMB}MB). Maximum file size allowed is {$maxSizeInMB}MB.")
                        ->withInput();
                }
            }
            
            // Validate input with custom messages (after manual file checks)
            $validatedData = $request->validate([
                'content' => 'required|string',
                'course_id' => 'required|integer|exists:courses,id',
                'forum_post_id' => 'required|integer|exists:forum_posts,id',
                'forum_reply_id' => 'nullable|integer|exists:forum_replies,id',
                
                'file_name' => 'nullable|string|max:255',
                'file_type' => 'nullable|string|max:255',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,tiff,doc,docx,pdf,txt,rtf,odt,zip,rar,7z|max:5120',
            ], [
                // Custom validation messages
                'file.mimes' => 'The uploaded file type is not supported.',
                'file.max' => 'The file size must not exceed 5MB.',
                'course_id.exists' => 'The selected course does not exist.',
                'forum_post_id.exists' => 'The selected post does not exist.',
                'forum_reply_id.exists' => 'The selected reply does not exist.',
                'content.required' => 'Post content is required.',
            ]);

            // Get authenticated user
            $user = Auth::user();
            
            // Check if the user exists
            if (!$user) {
                return redirect()->back()->with('error', 'User not authenticated');
            }

            $user_course = $user->userCourses()
                ->where('course_id', $validatedData['course_id'])
                ->where('status', 1)
                ->first();

            DB::beginTransaction();
            
            try {
                $resource_file = null;
                $resourceFilePath = null;

                // Handle file upload if present
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $originalName = $file->getClientOriginalName();
                    $fileType = $file->getClientOriginalExtension(); // Just 'pdf', 'docx', etc.
                    
                    // Store the file
                    $resourceFilePath = $file->store('uploads/resource_file', 'public');
                    $storedFileName = basename($resourceFilePath); // Extract the filename only

                    // Create resource file record
                    $resource_file = ResourceFile::create([
                        'name' => $storedFileName,
                        'type' => $fileType,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Create forumReply record
                $forumReply = ForumReply::create([
                    'user_course_id' => $user_course->id,
                    'forum_post_id' => $validatedData['forum_post_id'],
                    'content' => $validatedData['content'],
                    'forum_reply_id' => $validatedData['forum_reply_id'] ?? null,
                    'resource_file_id' => $resource_file->id ?? null,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();
                
                // Flash success message to the session
                session()->flash('success', 'Reply added successfully');
                
                // Redirect back to the lesson page
                return redirect()->back();
                
            } catch (\Exception $e) {
                DB::rollBack();
                
                // Log the error
                \Log::error('Reply creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                
                return redirect()->back()->with('error', 'Failed to add reply. ' . $e->getMessage())->withInput();
            }
        } catch (ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Reply creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
        }
    }

    public function update_reply(Request $request, $reply_id)
    {
        $replyId = Crypt::decrypt($reply_id);
        $reply = ForumReply::findOrFail($replyId);

        if ($reply->userCourse?->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $reply->content = $request->input('content');
        $reply->save();

        return redirect()->back()->with('success', 'Reply updated successfully!');
        // return response()->json([
        //     'success' => true,
        //     'new_content' => nl2br(e($reply->content)),
        //     'message' => 'Reply updated successfully.'
        // ]);
    }

    public function delete_reply($reply_id)
    {
        $replyId = Crypt::decrypt($reply_id);
        $reply = ForumReply::findOrFail($replyId);

        if ($reply->userCourse?->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $reply->status = 0;
        $reply->save();

        return back()->with('success', 'Reply deleted successfully.');
    }



}
