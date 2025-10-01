<div class="reply-box mb-3 p-3 border">
    <div class="d-flex">
        <img src="{{ $reply->userCourse?->user?->image ? asset('storage/uploads/profile_picture/' . $reply->userCourse?->user?->image) : asset('assets/images/avtar/4.png') }}" class="rounded-circle avatar-md me-3" alt="avatar">

        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h6 class="mb-0 fw-semibold">
                        {{ '@' . $reply->userCourse?->user?->username ?? '@Unknown' }}
                    </h6>
                    <small class="post-meta">
                        <i class="ph ph-clock me-1"></i>
                        {{ $reply->created_at->format('j M, Y g:i A') }}
                    </small>
                </div>
            </div>

            <p class="mb-2" style="line-height: 1.6;">{!! nl2br(e($reply->content)) !!}</p>

            {{-- Attachments --}}
            @if($reply->attachments)
                <div class="mt-3">
                    <small class="text-muted d-flex align-items-center mb-2">
                        <i class="ph ph-paperclip me-1"></i>Attachments
                    </small>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($reply->attachments as $file)
                            @php
                                $icon = str_ends_with($file['name'], '.pdf') ? 'ph-file-pdf text-danger' :
                                        (str_ends_with($file['name'], '.doc') || str_ends_with($file['name'], '.docx') ? 'ph-file-doc text-primary' : 'ph-file text-secondary');
                            @endphp
                            <span class="attachment-badge d-inline-flex align-items-center">
                                <i class="ph {{ $icon }} me-1"></i>
                                <small>{{ $file['name'] }}</small>
                            </span>
                        @endforeach
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

            {{-- Collapsible Reply Form --}}
            <div class="collapse mt-3" id="replyForm{{ $reply->id }}">
                <div class="card card-body text-secondary border">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                        <input type="hidden" name="forum_id" value="{{ $reply->forum_id ?? $reply->id }}">
                        
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
                            <input type="file" 
                                class="form-control" 
                                id="replyAttachment{{ $reply->id }}" 
                                name="attachments[]" 
                                multiple>
                            <small class="text-muted">You can attach multiple files</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ph ph-paper-plane-right me-1"></i>Submit Reply
                            </button>
                            <button type="button" 
                                    class="btn btn-secondary btn-sm" 
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
        <div class="ms-4 ms-md-5 mt-3 ps-3 ps-md-4 border-start border-secondary-light border-2">
            @foreach($reply->childrens as $childReply)
                @include('course.lesson.resource.partials.forum_reply', ['reply' => $childReply])
            @endforeach
        </div>
    @endif
</div>