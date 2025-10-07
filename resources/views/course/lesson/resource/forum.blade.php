@extends('layout.master')
@section('title', 'Forum')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/apexcharts/apexcharts.css') }}">
    <style>
        .forum-sidebar {
            position: sticky;
            top: 20px;
        }
        .post-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }
        .post-card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .list-group-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
            border-left-color: #0d6efd;
            transform: translateX(3px);
        }
        .list-group-item.active {
            border-left-color: #0d6efd;
            background-color: #e7f1ff;
        }
        .reply-box {
            background: #ffffff;
            border-radius: 12px;
            transition: all 0.2s ease;
        }
        .reply-box:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .nested-reply {
            background: #f8f9fa;
            border-radius: 10px;
        }
        .avatar-lg {
            width: 48px;
            height: 48px;
            object-fit: cover;
        }
        .avatar-md {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
            object-fit: cover;
        }
        .attachment-badge {
            padding: 6px 12px;
            border-radius: 8px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }
        .attachment-badge:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .post-meta {
            color: #6c757d;
            font-size: 0.875rem;
        }
        .reply-form {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
        }
        .btn-reply {
            font-size: 0.875rem;
            padding: 4px 12px;
            border-radius: 6px;
        }
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #6c757d;
        }
        .tabs-content {
            display: none;   /* hide all by default */
        }
        .tabs-content.active {
            display: block;  /* only show the active one */
        }


        /* Thumbnail container styles */
            .thumbnail-container {
                width: 100%;
                height: 200px; /* Fixed height */
                /* margin: 15px 0; */
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
                /* border-radius: 8px; */
                background-color: #f8f9fa;
            }
            
            /* Image thumbnail wrapper */
            .thumbnail-image-wrapper {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Actual image styling */
            .thumbnail-image {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }
            
            /* Default thumbnail style (for non-images) */
            .thumbnail-default {
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: white;
                /* border-radius: 8px; */
            }
            
            .thumbnail-default i {
                font-size: 3rem;
                margin-bottom: 8px;
            }
            
            .thumbnail-label {
                font-size: 0.8rem;
                font-weight: 600;
                text-transform: uppercase;
            }
            
            /* Badge for YouTube thumbnails */
            .thumbnail-badge {
                position: absolute;
                bottom: 8px;
                right: 8px;
                background: rgba(0,0,0,0.7);
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 0.7rem;
            }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title fw-bold">Forum - {{ $resource->name }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone ph-book f-s-16"></i> Course
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course.find_course') }}" class="f-s-14 f-w-500">Find Courses</a>
                    </li>
                    <li>
                        <a href="{{ route('course.course_detail', ['course_id' => encrypt($resource->lesson->course->id)]) }}" class="f-s-14 f-w-500">{{ $resource->lesson->course->name }}</a>
                    </li>
                    <li>
                        <a href="{{ route('course.lesson.lesson_list', ['course_id' => encrypt($resource->lesson->course->id)]) }}" class="f-s-14 f-w-500">Lessons</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Forum</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <div class="row g-3">
            <!-- Forum Post List (Left Sidebar) -->
            <div class="col-lg-4 col-xxl-3">
                <div class="forum-sidebar">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0">
                            <div class="thumbnail-container position-relative">
                                @if($resource->resourceFile)
                                    @php
                                        $type = strtolower($resource->resourceFile->type);
                                        $filePath = asset('storage/uploads/resource_file/' . $resource->resourceFile->name);
                                    @endphp

                                    {{-- Image --}}
                                    @if(in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                                        <div class="thumbnail-image-wrapper">
                                            <img src="{{ $filePath }}" 
                                                class="thumbnail-image" 
                                                alt="{{ $resource->name }}">
                                        </div>

                                    {{-- PDF --}}
                                    @elseif($type === 'pdf')
                                        <div class="thumbnail-image-wrapper">
                                            <iframe src="{{ $filePath }}#view=fitH" 
                                                    class="w-100 h-100 rounded" 
                                                    style="border: none;"></iframe>
                                        </div>

                                    {{-- Word, Excel, PowerPoint --}}
                                    @elseif(in_array($type, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']))
                                        <div class="thumbnail-image-wrapper">
                                            <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($filePath) }}" 
                                                    class="w-100 h-100 rounded" 
                                                    style="border: none;"></iframe>
                                        </div>

                                    {{-- Other files --}}
                                    @else
                                        <div class="thumbnail-image-wrapper bg-primary-light d-flex flex-column align-items-center justify-content-center">
                                            <i class="ph-bold ph-file" style="font-size: 2rem;"></i>
                                            <span class="thumbnail-label">{{ strtoupper($type) }}</span>
                                        </div>
                                    @endif

                                    {{-- Action Buttons --}}
                                    <div class="thumbnail-actions position-absolute top-0 end-0 m-2">
                                        <button class="btn btn-sm btn-dark me-1" data-bs-toggle="modal" data-bs-target="#previewModal{{ $resource->id }}">
                                            <i class="ph-bold ph-arrows-out-simple"></i>
                                        </button>
                                        <a href="{{ $filePath }}" download class="btn btn-sm btn-primary">
                                            <i class="ph-bold ph-download-simple"></i>
                                        </a>
                                    </div>

                                {{-- LINK PREVIEW --}}
                                @elseif($resource->link)
                                    @if(str_contains($resource->link, 'youtube.com') || str_contains($resource->link, 'youtu.be'))
                                        @php
                                            $videoId = '';
                                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $resource->link, $matches)) {
                                                $videoId = $matches[1];
                                            }
                                        @endphp

                                        @if($videoId)
                                            <div class="thumbnail-image-wrapper">
                                                <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg" 
                                                    class="thumbnail-image" 
                                                    alt="YouTube thumbnail">
                                            </div>
                                        @endif

                                        <div class="thumbnail-actions position-absolute top-0 end-0 m-2">
                                            <button class="btn btn-sm btn-dark me-1" data-bs-toggle="modal" data-bs-target="#previewModal{{ $resource->id }}">
                                                <i class="ph-bold ph-arrows-out-simple"></i>
                                            </button>
                                            <a href="{{ $resource->link }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="ph-bold ph-link-simple"></i>
                                            </a>
                                        </div>
                                    @else
                                        {{-- Other external link --}}
                                        @php
                                            $domain = parse_url($resource->link, PHP_URL_HOST);
                                            $cleanDomain = str_replace('www.', '', $domain);
                                            $favicon = "https://www.google.com/s2/favicons?domain=".$domain;
                                        @endphp
                                        <div class="web-preview">
                                            <div class="web-screenshot" 
                                                style="background-image: url('https://api.screenshotone.com/take?url={{ urlencode($resource->link) }}&width=400&height=225&cache=true')">
                                            </div>
                                            <div class="d-flex align-items-center mt-2">
                                                <img src="{{ $favicon }}" class="web-favicon me-2" alt="Website icon">
                                                <span class="web-domain">{{ $cleanDomain ?? 'Website' }}</span>
                                            </div>
                                        </div>

                                        <div class="thumbnail-actions position-absolute top-0 end-0 m-2">
                                            <a href="{{ $resource->link }}" target="_blank" class="btn btn-sm btn-dark">
                                                <i class="ph-bold ph-arrows-out-simple"></i>
                                            </a>
                                        </div>
                                    @endif

                                {{-- UNKNOWN --}}
                                @else
                                    <div class="thumbnail-default bg-secondary-light d-flex flex-column align-items-center justify-content-center">
                                        <i class="ph-bold ph-question" style="font-size: 2rem;"></i>
                                        <span class="thumbnail-label">UNKNOWN</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-0 pt-4 pb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="ph ph-chats-circle me-2 text-primary"></i>Discussion Topics
                                </h5>
                            </div>
                            <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" 
                                    data-bs-toggle="modal" data-bs-target="#postAddModal">
                                <i class="ph ph-plus-circle me-2"></i>
                                Create New Post
                            </button>
                        </div>
                        <div class="card-body p-0 my-3">
                            @if($resource->forumPosts && $resource->forumPosts->isNotEmpty())
                                <div class="list-group list-group-flush">
                                    @foreach($resource->forumPosts->sortByDesc('created_at') as $index => $post)
                                        <a class="list-group-item list-group-item-action border-0 py-3 px-3 tab-link {{ $loop->first ? 'active' : '' }}"
                                            data-tab="{{ $post->id }}" data-id="{{ $post->id }}">
                                            <div class="d-flex justify-content-between">
                                                <!-- Left: Title + Author + Date -->
                                                <div class="flex-grow-1 me-3">
                                                    <h6 class="mb-1 fw-semibold text-dark">{{ $post->title }}</h6>
                                                    <small class="text-muted d-block mt-1">
                                                        by <strong>{{ '@' . $post->userCourse?->user?->username ?? '@Unknown' }}</strong> • 
                                                        {{-- {{ \Carbon\Carbon::parse($post->created_at)->format('j M, Y g:i A') }} --}}
                                                        {{ $post->created_at->diffForHumans() }}
                                                    </small>
                                                </div>

                                                <!-- Right: Reply count + arrow -->
                                                <div class="d-flex flex-column align-items-end">
                                                    <span class="badge bg-light text-primary border border-primary px-2 py-1 mb-2">
                                                        <i class="ph ph-chat-circle me-1"></i>{{ $post->total_replies_count ?? 0 }} replies
                                                    </span>
                                                    <i class="ph ph-caret-right text-muted"></i>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="ph ph-chat-circle-dots" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="mt-2 mb-0">No discussions yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Tab 1: Posts & Replies (Main Content) -->
            <div class="col-lg-8 col-xxl-9">
                @if($resource->forumPosts && $resource->forumPosts->isNotEmpty())
                    @foreach($resource->forumPosts->sortByDesc('created_at') as $index => $post)
                        <div class="card shadow-sm border-0 mb-4 post-card tabs-content {{ $loop->first ? 'active' : '' }}" id="tab-{{ $post->id }}">
                            <!-- Post Header -->
                            <div class="rounded-top bg-gradient bg-primary text-white border-0 py-3 px-4 align-items-center">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="ph ph-article me-2 fs-5"></i>
                                        <h5 class="fw-bold mb-0 text-white">{{ $post->title }}</h5>
                                    </div>

                                    <!-- Action Button -->
                                    <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm border-0 p-2 d-flex align-items-center justify-content-center"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ph ph-bold ph-dots-three-outline-vertical text-primary f-s-20"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><a class="dropdown-item" href="#">Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </div>


                            <!-- Post Content -->
                            <div class="card-body p-4">
                                <p class="text-dark mb-3" style="line-height: 1.7;">{{ $post->content }}</p>

                                @if($post->resourceFile)
                                    <div class="mt-4 pt-3 border-top">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ph ph-paperclip me-2 text-muted"></i>
                                            <small class="text-muted fw-semibold">Attachment</small>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            @php
                                                $file = $post->resourceFile;
                                                $icon = str_ends_with($file['name'], '.pdf') ? 'ph-file-pdf text-danger' : 
                                                    (str_ends_with($file['name'], '.doc') || str_ends_with($file['name'], '.docx') ? 'ph-file-doc text-primary' : 
                                                    'ph-file text-secondary');
                                            @endphp
                                            
                                            <a href="{{ asset('storage/uploads/resource_file/' . $file['name']) }}" target="_blank" class="attachment-badge d-inline-flex align-items-center text-decoration-none">
                                                <i class="ph {{ $icon }} me-2"></i>
                                                <span>{{ $file['name'] }}</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <hr>

                                <p class="text-muted d-block mt-1">
                                    <div class="row align-items-center">
                                        <div class="col-6 d-flex align-items-center">
                                            <img src="{{ $post->userCourse?->user?->image ? asset('storage/uploads/profile_picture/' . $post->userCourse?->user?->image) : asset('assets/images/avtar/4.png') }}"
                                                class="rounded-circle avatar-md me-2" alt="avatar">
                                            <strong>{{ '@' . $post->userCourse?->user?->username ?? '@Unknown' }}</strong>
                                        </div>
                                        <div class="col-6 text-end d-flex justify-content-end align-items-center">
                                            <span>
                                                {{ $post->created_at->diffForHumans() }} • 
                                                {{ \Carbon\Carbon::parse($post->created_at)->format('j M, Y g:i A') }}
                                            </span>
                                        </div>    
                                    </div>                   
                                </p>
                            </div>

                            <!-- Replies Section -->
                            <div class="card-footer border-0 bg-light p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="ph ph-chats me-2 text-primary"></i>
                                        <h6 class="mb-0 fw-bold">{{ $post->total_replies_count }} Replies</h6>
                                    </div>

                                    <!-- Sort Button (AJAX toggle) -->
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary sort-toggle"
                                            data-post-id="{{ $post->id }}"
                                            data-sort="latest"
                                            {{ $post->total_replies_count > 0 ? '' : 'disabled' }}>
                                        <i class="ph ph-arrows-down-up me-1"></i>
                                        Sort: Latest
                                    </button>
                                </div>

                                <!-- Replies Container (will be replaced via AJAX) -->
                                <div id="replies-container-{{ $post->id }}">
                                    @forelse($post->forumReplies->whereNull('forum_reply_id')->sortByDesc('created_at') as $reply)
                                        @include('course.lesson.resource.partials.forum_reply', [
                                            'reply' => $reply,
                                            'resource' => $resource,
                                            'post' => $post,
                                            'sortOrder' => 'latest'
                                        ])
                                    @empty
                                        <div class="text-center py-4">
                                            <i class="ph ph-chat-circle-dots text-muted" style="font-size: 2.5rem; opacity: 0.3;"></i>
                                            <p class="text-muted mt-2 mb-0">No replies yet. Be the first to reply!</p>
                                        </div>
                                    @endforelse
                                </div>

                                <!-- Reply Form -->
                                <div class="reply-form mt-4">
                                    <h6 class="mb-3 fw-bold">
                                        <i class="ph ph-pencil-simple me-2 text-primary"></i>Post Your Reply
                                    </h6>
                                    <form id="forumReplyForm" method="POST" action="{{ route('resource.add_reply') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="course_id" id="course_id" value="{{ $resource->lesson->course->id }}">
                                        <input type="hidden" name="forum_post_id" id="forum_post_id" value="{{ $post->id }}">
                                        <div class="mb-3">
                                            <textarea class="form-control" id="content" name="content" rows="3" placeholder="Share your thoughts..." required></textarea>
                                        </div>
                                            <div class="mb-3" id="file_upload_section">
                                            {{-- fw-semibold --}}
                                            <label class="form-label text-secondary"> 
                                                <i class="ph ph-paperclip me-2 text-primary"></i>Attachments <span class="text-muted">(Optional)</span>
                                            </label>
                                            {{-- <input class="form-control" type="file" multiple> --}}
                                            <input type="file" name="file" id="file" class="form-control">
                                            <input type="hidden" name="file_name" id="file_name">
                                            <input type="hidden" name="file_type" id="file_type">
                                            <small class="text-muted d-block mt-2">
                                                <i class="ph ph-info me-1"></i>Supported formats: PDF, DOCX, PPTX, JPG, PNG (Max 10MB per file)
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary" id="replyadd">
                                                <i class="ph ph-paper-plane-tilt me-2"></i>Submit Reply
                                            </button>
                                            <button type="button" class="btn btn-light">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                        <div class="text-center text-muted">
                            <i class="ti ti-folder-off fs-2"></i>
                            <p class="mt-2">No discussions have been created for this resource yet.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Post Modal -->
    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title fw-bold" id="createPostModalLabel">
                        <i class="ph ph-plus-circle me-2"></i>Create New Discussion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ph ph-text-aa me-2 text-primary"></i>Title
                            </label>
                            <input type="text" class="form-control form-control-lg" placeholder="Enter a descriptive title for your post" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="ph ph-article me-2 text-primary"></i>Content
                            </label>
                            <textarea class="form-control" rows="5" placeholder="What's on your mind? Share your thoughts, questions, or ideas..." required style="resize: none;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="ph ph-paperclip me-2 text-primary"></i>Attachments <span class="text-muted">(Optional)</span>
                            </label>
                            <input class="form-control" type="file" multiple>
                            <small class="text-muted d-block mt-2">
                                <i class="ph ph-info me-1"></i>Supported formats: PDF, DOCX, PPTX, JPG, PNG (Max 10MB per file)
                            </small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ph ph-x me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary">
                        <i class="ph ph-check-circle me-2"></i>Create Post
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!--postAddModal modal start-->
    <div aria-hidden="true" aria-labelledby="postAddModalLabel" class="modal fade"
        id="postAddModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5 text-white" id="postAddModalLabel">New Post</h1>
                    <button aria-label="Close" class="btn-close m-0"
                            data-bs-dismiss="modal"
                            type="button"></button>
                </div>
                <form id="forumPostForm" method="POST" action="{{ route('resource.add_post') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="resent-form">
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="course_id" id="course_id" value="{{ $resource->lesson->course->id }}">
                                    <input type="hidden" name="resource_id" id="resource_id" value="{{ $resource->id }}">

                                    <!-- Form inside Modal -->
                                    <div class="mb-3">
                                        <label class="form-label">Title <span class="text-danger">*</span></label>
                                        <input class="form-control" id="title" name="title" placeholder="Enter a descriptive title for your post" type="text" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Content <span class="text-danger">*</span></label></label>
                                        <textarea class="form-control" id="content" name="content" placeholder="What's on your mind? Share your thoughts, questions, or ideas..." required></textarea>
                                    </div>
                                    <div class="mb-3" id="file_upload_section">
                                        {{-- fw-semibold --}}
                                        <label class="form-label"> 
                                            <i class="ph ph-paperclip me-2 text-primary"></i>Attachments <span class="text-muted">(Optional)</span>
                                        </label>
                                        {{-- <input class="form-control" type="file" multiple> --}}
                                        <input type="file" name="file" id="file" class="form-control">
                                        <input type="hidden" name="file_name" id="file_name">
                                        <input type="hidden" name="file_type" id="file_type">
                                        <small class="text-muted d-block mt-2">
                                            <i class="ph ph-info me-1"></i>Supported formats: PDF, DOCX, PPTX, JPG, PNG (Max 10MB per file)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                        <button class="btn btn-primary" id="postadd" type="submit">Create Post</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <!--forumPostAdd modal end -->

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal{{ $resource->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">{{ $resource->name }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body d-flex justify-content-center align-items-center">
                    @if($resource->resourceFile)
                        @if(in_array($type, ['jpg','jpeg','png','gif','svg']))
                            <img src="{{ $filePath }}" class="img-fluid rounded">
                        @elseif($type === 'pdf')
                            <iframe src="{{ $filePath }}#view=fitH" class="w-100 h-100" style="border:none;"></iframe>
                        @elseif(in_array($type, ['doc','docx','xls','xlsx','ppt','pptx']))
                            <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($filePath) }}" class="w-100 h-100" style="border:none;"></iframe>
                        @else
                            <p class="text-white">Preview not available for {{ strtoupper($type) }} files.</p>
                        @endif
                    @elseif($resource->link)
                        @if(!empty($videoId))
                            <div class="ratio ratio-16x9 w-100">
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                            </div>
                        @else
                            <iframe src="{{ $resource->link }}" class="w-100 h-100" style="border:none;"></iframe>
                        @endif
                    @endif
                </div>
                <div class="modal-footer border-0">
                    @if($resource->resourceFile)
                        <a href="{{ $filePath }}" download class="btn btn-primary">
                            <i class="ph-bold ph-download-simple me-1"></i> Download
                        </a>
                    @elseif($resource->link)
                        <a href="{{ $resource->link }}" target="_blank" class="btn btn-primary">
                            <i class="ph-bold ph-link-simple me-1"></i> Open Link
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sortButtons = document.querySelectorAll('.sort-toggle');

            sortButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const postId = this.dataset.postId;
                    const currentSort = this.dataset.sort;
                    const newSort = currentSort === 'latest' ? 'oldest' : 'latest';
                    const repliesContainer = document.querySelector(`#replies-container-${postId}`);

                    this.disabled = true;
                    this.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Sorting...`;

                    fetch(`{{ route('resource.sort_replies') }}?post_id=${postId}&sort=${newSort}`)
                        .then(response => response.text())
                        .then(html => {
                            repliesContainer.innerHTML = html;
                            this.dataset.sort = newSort;
                            this.innerHTML = `<i class="ph ph-arrows-down-up me-1"></i> Sort: ${newSort.charAt(0).toUpperCase() + newSort.slice(1)}`;
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Something went wrong while sorting replies.');
                        })
                        .finally(() => this.disabled = false);
                });
            });
        });

        // Smooth scroll to post when clicked in sidebar
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all items
                document.querySelectorAll('.list-group-item').forEach(i => i.classList.remove('active'));
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Smooth scroll to target
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    
                    // Add highlight animation
                    target.style.animation = 'highlight 1s ease';
                    setTimeout(() => {
                        target.style.animation = '';
                    }, 1000);
                }
            });
        });

        // Add highlight animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes highlight {
                0%, 100% { box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
                50% { box-shadow: 0 8px 25px rgba(13, 110, 253, 0.25); }
            }
        `;
        document.head.appendChild(style);

        //  **------tab link js**
        $(document).on('click', '.tab-link', function () {
            var tabID = $(this).attr('data-tab');

            $(this).addClass('active').siblings().removeClass('active');

            $('#tab-' + tabID).addClass('active').siblings('.tabs-content').removeClass('active');
        });
    </script>

    <!--customizer-->
    <div id="customizer"></div>

    <!-- apexcharts-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!--js-->
    {{-- <script src="{{asset('assets/js/filemanager.js')}}"></script> --}}
@endsection