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
use Illuminate\Support\Facades\Storage;

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

    public function add_resource(Request $request)
    {
        try {
            // Validate input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'desc' => 'nullable|string|max:500',
                'category' => 'required|integer',
                'link' => 'nullable|string|max:255',
                'lesson_id' => 'required|integer|exists:lessons,id',
                
                'file_name' => 'nullable|string|max:255',
                'file_type' => 'nullable|string|max:255',
                'file' => 'nullable|file|mimes:jpg,jpeg,png,gif,bmp,tiff,doc,docx,pdf,txt,rtf,odt,zip,rar,7z|max:5120',
            ]);

            // Get authenticated user
            $user = Auth::user();
            
            // Check if the user exists
            if (!$user) {
                return redirect()->back()->with('error', 'User not authenticated');
            }

            DB::beginTransaction();
            
            try {
                $resource_file = null;
                $resourceFilePath = null;

                // Handle file upload if present
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $originalName = $file->getClientOriginalName();
                    // $fileType = $file->getClientMimeType();
                    $fileType = $file->getClientOriginalExtension(); // Just 'pdf', 'docx', etc.
                    
                    // Store the file
                    // $request->file('profile_image')->storeAs('uploads/profile_picture', $filename, 'public');
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
                
                // Flash success message to the session
                session()->flash('success', 'Resource added successfully');
                
                // Redirect back to the lesson page
                return redirect()->back();
                
            } catch (\Exception $e) {
                DB::rollBack();
                
                // Log the error
                \Log::error('Resource creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                
                return redirect()->back()->with('error', 'Failed to add resource. ' . $e->getMessage())->withInput();
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
            
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
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
            ]);

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

            $resource_file = null;
            $resource_type = $request->input('resource_type', 'file');

            // Handle resource type: file
            if ($resource_type === 'file') {
                // If a new file is uploaded
                if ($request->hasFile('file')) {
                    \Log::info('File uploaded successfully: ' . $request->file('file')->getClientOriginalName());

                    // Store the file
                    $resourceFilePath = $request->file('file')->store('uploads/resource_file', 'public');
                    // $fileType = $request->file('file')->getClientMimeType();
                    $fileType = $request->file('file')->getClientOriginalExtension(); // Just 'pdf', 'docx', etc.
                    $storedFileName = basename($resourceFilePath); // Extract the filename only

                    // Update existing file record or create new one
                    if (!empty($resource->file_id)) {
                        $resource_file = ResourceFile::find($resource->file_id);
                        
                        if ($resource_file) {
                            // Delete the old file if it exists
                            if (Storage::disk('public')->exists($resource_file->name)) {
                                Storage::disk('public')->delete($resource_file->name);
                            }
                            
                            $resource_file->name = $storedFileName;
                            $resource_file->type = $fileType;
                            $resource_file->status = 1;
                            $resource_file->updated_at = now();
                            $resource_file->save();
                        } else {
                            // Create new file record if original was not found
                            $resource_file = ResourceFile::create([
                                'name' => $resourceFilePath,
                                'type' => $fileType,
                                'status' => 1,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    } else {
                        // Create new file record
                        $resource_file = ResourceFile::create([
                            'name' => $resourceFilePath,
                            'type' => $fileType,
                            'status' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
                
                // Remove link if switching from link to file
                $resource->link = null;
                
            } 
            // Handle resource type: link
            else if ($resource_type === 'link') {
                // If switching from file to link, update the file status to inactive
                if (!empty($resource->file_id)) {
                    $resource_file = ResourceFile::find($resource->file_id);
                    if ($resource_file) {
                        $resource_file->status = 0;
                        $resource_file->updated_at = now();
                        $resource_file->save();
                    }
                }
                
                $resource->file_id = null;
                $resource->link = $validatedData['link'];
            }

            // Update the resource
            $resource->name = $validatedData['name'];
            $resource->desc = $validatedData['desc'] ?? null;
            $resource->category = $validatedData['category'];
            $resource->status = 1; // Active
            $resource->updated_at = now();
            
            // Update file_id only if we're dealing with a file type resource and have a file
            if ($resource_type === 'file' && $resource_file) {
                $resource->file_id = $resource_file->id;
            }
            
            // Save the changes
            $resource->save();

            // Return a success response
            return redirect()->back()->with('success', 'Resource updated successfully');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Resource update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Return an error response
            return redirect()->back()->with('error', 'Resource update failed: ' . $e->getMessage());
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
}
