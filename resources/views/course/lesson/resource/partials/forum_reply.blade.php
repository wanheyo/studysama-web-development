<div class="reply-box mb-3 p-3 border">
    <div class="d-flex">
        <img src="{{ $reply->userCourse?->user?->image ? asset('storage/uploads/profile_picture/' . $reply->userCourse?->user?->image) : asset('assets/images/avtar/4.png') }}"
            class="rounded-circle avatar-md me-3" alt="avatar">

        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h6 class="mb-0 fw-semibold">
                        {{ '@' . $reply->userCourse?->user?->username ?? '@Unknown' }}
                    </h6>
                    <small class="post-meta">
                        <i class="ph ph-clock me-1"></i>
                        {{ $reply->created_at->diffForHumans() }} • 
                        {{ $reply->created_at->format('j M, Y g:i A') }}
                        @if($reply->updated_at && $reply->updated_at != $reply->created_at && $reply->status !== 0)
                            (<strong>Edited: </strong>
                            {{ $reply->updated_at->diffForHumans() }})
                        @endif
                    </small>
                </div>

                @if($reply->status !== 0)
                    <!-- Dots Action Button -->
                    <div class="dropdown">
                        <button type="button"
                            class="btn btn-light btn-sm rounded-circle shadow-sm border-0 p-2 d-flex align-items-center justify-content-center"
                            id="replyActions{{ $reply->id }}"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="ph ph-bold ph-dots-three-outline-vertical text-secondary fs-6"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="replyActions{{ $reply->id }}">
                            @if($reply->userCourse?->user_id === auth()->id())
                                <li>
                                    <button class="dropdown-item btn-edit-reply"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#replyEditModal"
                                        data-reply-id="{{ encrypt($reply->id) }}"
                                        data-reply-content="{{ $reply->content }}">
                                        Edit
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item text-danger btn-delete-reply"
                                        data-reply-id="{{ encrypt($reply->id) }}">
                                        Delete
                                    </button>
                                </li>
                            @else
                                <li>
                                    <button class="dropdown-item text-danger btn-report-reply"
                                        data-reply-id="{{ encrypt($reply->id) }}">
                                        Report
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>

            @if($reply->status === 0)
                <span class="badge bg-danger mb-2">This reply is deleted {{ $reply->created_at->diffForHumans() }}</span>
            @else
                <p class="mb-2" style="line-height: 1.6;">{!! nl2br(e($reply->content)) !!}</p>

                @if($reply->resourceFile)
                    <div class="my-3 pt-3 border-top">
                        <div class="d-flex align-items-center mb-2">
                            <i class="ph ph-paperclip me-2 text-muted"></i>
                            <small class="text-muted fw-semibold">Attachment</small>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @php
                                $file = $reply->resourceFile;
                                $icon = str_ends_with($file['name'], '.pdf') ? 'ph-file-pdf text-danger' : 
                                    (str_ends_with($file['name'], '.doc') || str_ends_with($file['name'], '.docx') ? 'ph-file-doc text-primary' : 
                                    'ph-file text-secondary');
                            @endphp

                            <a href="{{ asset('storage/uploads/resource_file/' . $file['name']) }}" 
                            target="_blank" 
                            class="attachment-badge d-inline-flex align-items-center text-decoration-none px-3 py-2 border"
                            style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <i class="ph {{ $icon }} me-2 flex-shrink-0"></i>
                                <span class="text-truncate d-inline-block" style="max-width: 180px;">{{ $file['name'] }}</span>
                            </a>
                        </div>

                    </div>
                @endif

                <button class="btn btn-sm btn-outline-primary btn-reply mt-2" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#replyForm{{ $reply->id }}" 
                        aria-expanded="false" 
                        aria-controls="replyForm{{ $reply->id }}">
                    <i class="ph ph-arrow-bend-up-left me-1"></i>Reply
                </button>
            @endif

            {{-- Collapsible Reply Form --}}
            <div class="collapse mt-3" id="replyForm{{ $reply->id }}">
                <div class="card card-body text-secondary border">
                    <form id="forumReplyFormCollapse{{ $reply->id }}" method="POST" action="{{ route('resource.add_reply') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $resource->lesson->course->id }}">
                        <input type="hidden" name="forum_post_id" value="{{ $post->id }}">
                        <input type="hidden" name="forum_reply_id" value="{{ $reply->id }}"> {{-- Parent Reply ID --}}
                        
                        <div class="mb-3">
                            <label for="replyContent{{ $reply->id }}" class="form-label">
                                Your Reply to <span class="text-muted fst-italic">"{{ Str::limit(strip_tags($reply->content), 50) }}"</span>
                            </label>
                            <textarea class="form-control" 
                                id="replyContent{{ $reply->id }}" 
                                name="content" 
                                rows="3" 
                                placeholder="Write your reply here..."
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="replyAttachment{{ $reply->id }}" class="form-label">
                                <i class="ph ph-paperclip me-1"></i>Attach Files (Optional)
                            </label>
                            <input type="file" name="file" id="replyAttachment{{ $reply->id }}" class="form-control">
                            <input type="hidden" name="file_name">
                            <input type="hidden" name="file_type">
                            <small class="text-muted d-block mt-2">
                                <i class="ph ph-info me-1"></i>Supported formats: PDF, DOCX, PPTX, JPG, PNG (Max 10MB per file)
                            </small>   
                        </div>

                        <div class="d-flex gap-2">  
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ph ph-paper-plane-right me-1"></i>Submit Reply
                            </button>
                            <button type="button" 
                                    class="btn btn-danger btn-sm cancel-reply-btn" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#replyForm{{ $reply->id }}">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Recursive call: render children --}}
    @if($reply->childrens && $reply->childrens->count())
        @php
            $sortedChildren = isset($sortOrder) && $sortOrder === 'oldest'
                ? $reply->childrens->sortBy('created_at')
                : $reply->childrens->sortByDesc('created_at');
        @endphp

        <div class="ms-4 ms-md-5 mt-3 ps-3 ps-md-4 border-start border-secondary-light border-2">
            @foreach($sortedChildren as $childReply)
                @include('course.lesson.resource.partials.forum_reply', [
                    'reply' => $childReply,
                    'resource' => $resource,
                    'post' => $post,
                    'sortOrder' => $sortOrder ?? 'latest'
                ])
            @endforeach
        </div>
    @endif
    
</div>
