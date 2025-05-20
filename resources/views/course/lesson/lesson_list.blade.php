@extends('layout.master')
@section('title', 'Lessons')
@section('css')
    <!-- apexcharts css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/apexcharts/apexcharts.css')}}">
@endsection
@section('main-content')

    @php
        $isTutor = auth()->user()
            ->userCourses()
            ->where('course_id', $course->id)
            ->where('role_id', 1)
            ->exists();
    @endphp

    <div class="container-fluid">

        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Lessons - {{ $course->name }}</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone  ph-stack f-s-16"></i> Course
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course.find_course') }}" class="f-s-14 f-w-500">Find Courses</a>
                    </li>
                    <li>
                        <a href="{{ route('course.course_detail', ['course_id' => $course->id]) }}" class="f-s-14 f-w-500">Course Details</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Lessons</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- File manager start -->
        <div class="row">
            <div class="col-lg-4 col-xxl-3">
                <div class="card">
                    <div class="card-header">
                        {{-- <h5>Lesson List</h5> --}}
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>Lesson List</h5>
                            {{-- <button class="btn btn-light-primary b-r-22"
                                    data-bs-target="#folderModal"
                                    data-bs-toggle="modal"
                                    type="button">Create Lesson
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="horizontal-tab-wrapper">
                            <ul id="lesson-list" class="filemenu-list mt-3 tabs">
                                @if ($lessons->isNotEmpty())
                                    @foreach ($lessons as $index => $lesson)
                                        <li class="tab-link {{ $index == 0 ? 'active' : '' }}" data-tab="{{ $lesson->id }}">
                                            <i class="ti ti-folder-filled fs-5 pe-2"></i> <span class="flex-grow-1">{{ $lesson->name }}</span>
                                            {{-- {{ $lesson->resources->count() }} Resources --}}
                                        </li>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted my-4">
                                        <i class="ti ti-folder-off fs-2"></i>
                                        <p class="mt-2">No lesson have been added to this course yet.</p>
                                    </div>
                                @endif
                                

                                {{-- <li class="tab-link" data-tab="2"><i class="ti ti-star fs-5 pe-2"></i><span
                                        class="flex-grow-1">Starred</span></li>
                                <li class="tab-link" data-tab="3"><i
                                        class="ti ti-trash fs-5 pe-2 "></i><span
                                        class="flex-grow-1">Recycle Bin </span>
                                    2+
                                </li>
                                <li class="tab-link" data-tab="4"><i
                                        class="ti ti-rotate-clockwise fs-5 pe-2"></i><span
                                        class="flex-grow-1"> Recent</span></li> --}}

                                <li class="app-divider-v dashed p-0 m-2"></li>
                                @if ($isTutor)
                                    <li data-bs-target="#lessonAddModal" data-bs-toggle="modal" class="my-3 border border-dashed rounded-pill hover-effect">
                                        <i class="ti ti-folder-plus fs-5 pe-2"></i>
                                        <span class="flex-grow-1">Create New Lesson</span>
                                    </li>
                                @endif
                                <li><i class="ti ti-help fs-5 pe-2"></i><span
                                        class="flex-grow-1">Help</span>
                                </li>
                                {{-- <li><i class="ti ti-adjustments-alt fs-5 pe-2"></i> <span
                                        class="flex-grow-1">Settings</span>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Overview</h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            {{-- <div id="polar2"></div> --}}
                        </div>
                        <div class="file-manager-sidebar mb-4"> 
                            <div class="d-flex align-items-center position-relative">
                        <span class="text-light-primary h-40 w-40 d-flex-center b-r-10 position-absolute">
                            <i class="ph-bold ph-folder f-s-20"></i>
                        </span>
                            <div class="flex-grow-1 ms-5">
                                <h6 class="mb-0">Lesson</h6>
                                {{-- <p class="text-secondary mb-0">{{ $totalLessons ?? 0}} Created</p> --}}
                            </div>
                            <p class="text-secondary f-w-500 mb-0">{{ $totalLessons ?? 0}} Created</p>
                            </div>
                        </div>
                        <div class="file-manager-sidebar mb-4">
                            <div class="d-flex align-items-center position-relative">
                        <span class="text-light-success h-40 w-40 d-flex-center b-r-10 position-absolute">
                          <i class="ph-bold  ph-file f-s-22"></i>
                        </span>
                                <div class="flex-grow-1 ms-5  ">
                                    <h6 class="mb-0">Resource</h6>
                                    {{-- <p class="text-secondary mb-0">{{ $totalResources ?? 0 }} Shared</p> --}}
                                </div>
                                <p class="text-secondary f-w-500 mb-0">{{ $totalResources ?? 0 }} Shared</p>
                            </div>
                        </div>
                        <div class="file-manager-sidebar mb-4">
                            <div class="d-flex align-items-center position-relative">
                        <span class="text-light-danger h-40 w-40 d-flex-center b-r-10 position-absolute">
                          <i class="ph-bold  ph-chat-circle-dots f-s-20"></i>
                        </span>
                                <div class="flex-grow-1 ms-5  ">
                                    <h6 class="mb-0">Comment</h6>
                                    
                                    {{-- <p class="text-secondary mb-0">{{ $totalComments ?? 0 }} Chit Chat</p> --}}
                                </div>
                                <p class="text-secondary f-w-500 mb-0">{{ $totalComments ?? 0 }} Made</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="card">
                    <div class="card-header">
                        <h5>File Upload</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class=" mb-1 text-dark">Uploading 59 photos</h6>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-secondary">Photoes 01</p>
                                    <span class="text-primary">65%</span>
                                </div>
                                <div class="progress h-5">
                                    <div aria-valuemax="100" aria-valuemin="0"
                                         aria-valuenow="20"
                                         class="progress-bar bg-primary h-5" role="progressbar"
                                         style="width: 65%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class=" mb-1 text-dark">Uploading 7 videos</h6>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-secondary">Museum</p>
                                    <span class="text-primary">25%</span>
                                </div>
                                <div class="progress h-5">
                                    <div aria-valuemax="100" aria-valuemin="0"
                                         aria-valuenow="20"
                                         class="progress-bar bg-primary h-5" role="progressbar"
                                         style="width: 25%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class=" mb-1 text-dark">Uploading 12 Documents</h6>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-secondary">My Work</p>
                                    <span class="text-primary">90%</span>
                                </div>
                                <div class="progress h-5">
                                    <div aria-valuemax="100" aria-valuemin="0"
                                         aria-valuenow="20"
                                         class="progress-bar bg-primary h-5" role="progressbar"
                                         style="width: 90%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="col-lg-8 col-xxl-9">
                <div class="content-wrapper">
                    <!-- tab-1  -->
                    @if ($lessons->isNotEmpty())
                        @foreach ($lessons as $index => $lesson)
                            <div class="tabs-content {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $lesson->id }}">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5>Resources</h5>
                                            @if ($isTutor)
                                                <div class="d-flex flex-column flex-md-row gap-2">
                                                    <button class="btn btn-light-primary b-r-22"
                                                            data-bs-target="#lessonEditModal"
                                                            data-bs-toggle="modal"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-lesson-name="{{ $lesson->name }}"
                                                            data-lesson-desc="{{ $lesson->desc }}"
                                                            data-lesson-learn-outcome="{{ $lesson->learn_outcome }}"
                                                            type="button"><i class="ti ti-edit"></i> Edit Lesson
                                                    </button>
                                                    <button class="btn btn-primary b-r-22"
                                                            data-bs-target="#resourceAddModal"
                                                            data-bs-toggle="modal"
                                                            onclick="prepareResourceModal({{ $lesson->id }})"
                                                            type="button"><i class="ti ti-file-upload"></i> Add New Resource
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="card-body p-4" id="newFolder">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="card card-light-primary">
                                                    <div class ="card-header">
                                                        <h4 class="mb-0">{{ $lesson->name }}</h4>
                                                    </div>
                                                    <div class="card-body resource-details-content">
                                                        <div class="mb-3">
                                                            <h6>Description</h6>
                                                            <p class="text-secondary f-s-16">{{ $lesson->desc ?? 'This is lesson ' . $lesson->name }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Learning Outcome</h6>
                                                            <p class="text-secondary f-s-16">{{ $lesson->learn_outcome ?? 'No learning outcome included' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($lesson->resources->isNotEmpty())
                                                @foreach ($lesson->resources as $resource)
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 col-xxl-4">
                                                        <div class="card hover-effect card-light-{{ $resource->category == 1 ? 'info' : 'success' }}">
                                                            <div class="card-body position-relative">
                                                                <!-- Dropdown -->
                                                                <div class="dropdown folder-dropdown" style="position: absolute; right: 15px; top: 15px;">
                                                                    <a aria-expanded="true" class="" data-bs-toggle="dropdown" role="button">
                                                                        <i class="ti ti-dots-vertical"></i>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item view-item-btn" href="#">
                                                                            <i class="ti ti-file-export text-primary"></i> View</a>
                                                                        </li>
                                                                        <li><a class="dropdown-item edit-folder-list" data-bs-toggle="modal" href="#" role="button">
                                                                            <i class="ti ti-edit text-success"></i> Edit</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                    
                                                                <!-- Category ribbon -->
                                                                <div class="ribbon-side side-left ribbon-{{ $resource->category == 1 ? 'info' : 'success' }}">
                                                                    {{ $resource->category == 1 ? 'Note' : 'Assignment' }}
                                                                </div>
                                                        
                                                                <!-- Fixed-size thumbnail container -->
                                                                <div class="thumbnail-container mt-5">
                                                                    @if($resource->resourceFile)
                                                                        <!-- File preview -->
                                                                        @if(in_array(strtolower($resource->resourceFile->type), ['jpg', 'jpeg', 'png', 'gif', 'svg']))
                                                                            <!-- Image with fixed-size container -->
                                                                            <div class="thumbnail-image-wrapper">
                                                                                <img src="{{ asset('storage/uploads/resource_file/' . $resource->resourceFile->name) }}" 
                                                                                    class="thumbnail-image" 
                                                                                    alt="{{ $resource->name }}">
                                                                            </div>
                                                                            <div class="thumbnail-badge">
                                                                                <i class="ph-bold ph-file-image" style="color: white;"></i> {{ $resource->resourceFile->type }}
                                                                            </div>
                                                                        @elseif(strtolower($resource->resourceFile->type) === 'pdf')
                                                                            <!-- PDF thumbnail -->
                                                                            <div class="thumbnail-image-wrapper bg-danger-light">
                                                                                <i class="ph-bold ph-file-pdf"></i>
                                                                                <span class="thumbnail-label">PDF</span>
                                                                                <div class="thumbnail-badge">
                                                                                    <i class="ph-bold ph-file-pdf" style="color: white;"></i> {{ $resource->resourceFile->type }}
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <!-- Other file types -->
                                                                            <div class="thumbnail-image-wrapper bg-primary-light">
                                                                                <i class="ph-bold ph-file"></i>
                                                                                <span class="thumbnail-label"> {{ strtoupper($resource->resourceFile->type) }}</span>
                                                                                <div class="thumbnail-badge">
                                                                                    <i class="ph-bold ph-file" style="color: white;"></i> {{ $resource->resourceFile->type }}
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @elseif($resource->link)
                                                                        <!-- Link preview -->
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
                                                                                    <div class="thumbnail-badge">
                                                                                        <i class="ph-bold ph-play-circle" style="color: white;"></i> YouTube
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="web-preview">
                                                                                    <i class="ph-bold ph-youtube-logo"></i>
                                                                                    <span class="web-domain">YouTube Link</span>
                                                                                </div>
                                                                            @endif
                                                                        @else
                                                                            <!-- Enhanced web preview -->
                                                                            <div class="web-preview">
                                                                                @php
                                                                                    $domain = parse_url($resource->link, PHP_URL_HOST);
                                                                                    $cleanDomain = str_replace('www.', '', $domain);
                                                                                    $favicon = "https://www.google.com/s2/favicons?domain=".$domain;
                                                                                @endphp
                                                                                <img src="{{ $favicon }}" class="web-favicon" alt="Website icon">
                                                                                <span class="web-domain">{{ $cleanDomain ?? 'Web Link' }}</span>
                                                                                <div class="web-screenshot" style="background-image: url('https://api.screenshotone.com/take?url={{ urlencode($resource->link) }}&width=400&height=225&cache=true')">
                                                                                    <!-- Fallback if screenshot fails -->
                                                                                    {{-- <div class="web-screenshot-fallback">
                                                                                        <i class="ph-bold ph-globe"></i>
                                                                                    </div> --}}
                                                                                </div>
                                                                                <div class="thumbnail-badge">
                                                                                    <i class="ph-bold ph-globe" style="color: white;"></i> Website
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                        <!-- Default icon when no file or link -->
                                                                        <div class="thumbnail-default bg-secondary-light">
                                                                            <i class="ph-bold ph-question"></i>
                                                                            <span class="thumbnail-label">UNKNOWN</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                
                                                                <!-- Resource name -->
                                                                <p class="resource-name">{{ $resource->name }}</p>
                                                            </div>
                                                            <div class="card-footer code-footer d-flex justify-content-between align-items-center">
                                                                <div class="resource-stats">
                                                                    <span><i class="ti ti-eye"></i> {{ $resource->total_visit ?? 0 }}</span>
                                                                    <span><i class="ti ti-download"></i> {{ $resource->resourceFile->total_download ?? 0 }}</span>
                                                                    <span><i class="ti ti-message"></i> {{ $resource->comments->count() }}</span>
                                                                </div>
                                                                <button type="button" class="btn btn-light-{{ $resource->category == 1 ? 'info' : 'success' }} icon-btn b-r-22 hover-icon-white" 
                                                                        data-bs-target="#resourceDetailModal" 
                                                                        data-bs-toggle="modal"
                                                                        data-resource-id="{{ $resource->id }}"
                                                                        data-resource-name="{{ $resource->name }}"
                                                                        data-resource-description="{{ $resource->desc ?? '' }}"
                                                                        data-resource-category="{{ $resource->category }}"
                                                                        data-resource-type="{{ $resource->resourceFile ? $resource->resourceFile->type : 'link' }}"
                                                                        data-resource-file-name ="{{ $resource->resourceFile ? $resource->resourceFile->name : '' }}"
                                                                        data-resource-path="{{ $resource->resourceFile ? asset('storage/uploads/resource_file/' . $resource->resourceFile->name) : $resource->link }}"
                                                                        data-resource-views="{{ $resource->total_visit ?? 0 }}"
                                                                        data-resource-downloads="{{ $resource->resourceFile->total_download ?? 0 }}"
                                                                        data-resource-comments="{{ $resource->comments->count() }}"
                                                                        data-resource-created="{{ $resource->created_at->format('M d, Y') }}">
                                                                    <i class="ti ti-chevron-up text-{{ $resource->category == 1 ? 'info' : 'success' }}"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-center text-muted my-4">
                                                    <i class="ti ti-folder-off fs-2"></i>
                                                    <p class="mt-2">No resources have been added to this lesson yet.</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
                            <div class="text-center text-muted">
                                <i class="ti ti-folder-off fs-2"></i>
                                <p class="mt-2">No lesson have been added to this course yet.</p>
                            </div>
                        </div>
                    @endif



                    <!-- resourceDetailModal modal start -->
                    <div aria-hidden="true" aria-labelledby="resourceDetailModalLabel" class="modal fade" id="resourceDetailModal" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title text-white" id="resourceDetailModalLabel">Resource Details</h5>
                                    <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal" type="button"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="row">
                                        <!-- Left Column - Preview and Actions -->
                                        <div class="col-md-5">
                                            <div class="card mb-4">
                                                <div class="card-body text-center">
                                                    <div id="resourcePreview" class="mb-3" style="min-height: 250px;">
                                                        <!-- Preview will be inserted here by JavaScript -->
                                                    </div>
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a id="downloadBtn" href="#" class="btn btn-primary" download>
                                                            <i class="ti ti-download me-1"></i> Download
                                                        </a>
                                                        @if ($isTutor)
                                                            <button class="btn btn-light-primary" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#resourceEditModal"
                                                                    data-resource-id="">
                                                                <i class="ti ti-edit"></i> Edit
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Stats Card -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row text-center">
                                                        <div class="col-4">
                                                            <div class="p-2">
                                                                <i class="ti ti-eye fs-5 text-primary"></i>
                                                                <h6 class="mt-2 mb-0" id="viewsCount">0</h6>
                                                                <p class="text-muted mb-0 fs-11">Views</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="p-2">
                                                                <i class="ti ti-download fs-5 text-success"></i>
                                                                <h6 class="mt-2 mb-0" id="downloadsCount">0</h6>
                                                                <p class="text-muted mb-0 fs-11">Downloads</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="p-2">
                                                                <i class="ti ti-message fs-5 text-info"></i>
                                                                <h6 class="mt-2 mb-0" id="commentsCount">0</h6>
                                                                <p class="text-muted mb-0 fs-11">Comments</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Right Column - Details and Comments -->
                                        <div class="col-md-7">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h4 id="resourceName" class="mb-2">Resource Name</h4>
                                                    <p class="text-muted mb-3" id="resourceCreated">Uploaded on Jan 1, 2023</p>
                                                    <div class="mb-3">
                                                        <h6 class="mb-2">Description</h6>
                                                        <p id="resourceDescription" class="text-muted">No description available</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Comments Section -->
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">Comments</h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- Comment Form -->
                                                    <form id="commentForm">
                                                        @csrf
                                                        <input type="hidden" name="resource_id" id="commentResourceId">
                                                        <div class="d-flex mb-4">
                                                            <img src="{{ auth()->user()->image ? asset('storage/uploads/profile_picture/' . auth()->user()->image) : asset('assets/images/avtar/woman.jpg') }}" 
                                                                class="rounded-circle me-3" width="40" height="40" alt="User">
                                                            <div class="flex-grow-1">
                                                                <div class="input-group">
                                                                    <input type="text" name="content" class="form-control" placeholder="Add a comment..." required>
                                                                    <button class="btn btn-primary" type="submit">Post</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    
                                                    <!-- Comments List -->
                                                    <div id="commentsList" class="overflow-auto" style="max-height: 300px;">
                                                        <div class="text-center py-3" id="noComments">
                                                            <i class="ti ti-message-off fs-5 text-muted"></i>
                                                            <p class="text-muted mt-2">No comments yet</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>                            
                    <!-- resourceDetailModal modal end  -->

                    <!--lessonAddModal modal start-->
                    <div aria-hidden="true" aria-labelledby="lessonAddModalLabel" class="modal fade"
                        id="lessonAddModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="lessonAddModalLabel">New Lesson</h1>
                                    <button aria-label="Close" class="btn-close m-0"
                                            data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <form id="lessonForm" method="POST" action="{{ route('course.lesson.add_lesson.post', $course->id) }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="resent-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- Updated Form inside Modal -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Lesson Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="name" placeholder="Title" type="text" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Description (Optional)</label>
                                                        <textarea class="form-control" name="desc" placeholder="Description"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Learning Outcome (Optional)</label>
                                                        <textarea class="form-control" name="learn_outcome" placeholder="Learning Outcomes"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {{-- <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button> --}}
                                        <button class="btn btn-light-primary" id="lessonadd" type="submit">Add New Lesson</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--lessonAddModal modal end -->

                    <!--lessonEditModal modal start-->
                    <div aria-hidden="true" aria-labelledby="lessonEditModalLabel" class="modal fade"
                    id="lessonEditModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="lessonEditModalLabel">Edit Lesson</h1>
                                    <button aria-label="Close" class="btn-close m-0"
                                            data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <form id="updateLessonForm" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="resent-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="formFieldsWrapper">
                                                        <div class="mb-3">
                                                            <label class="form-label">Lesson Name <span class="text-danger">*</span></label>
                                                            <input class="form-control" id="editLessonName" name="name" placeholder="Title" type="text" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Description (Optional)</label>
                                                            <textarea class="form-control" id="editLessonDesc" name="desc" placeholder="Description"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Learning Outcome (Optional)</label>
                                                            <textarea class="form-control" id="editLessonLearnOutcome" name="learn_outcome" placeholder="Learning Outcomes"></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Delete confirmation section - updated -->
                                                    <div id="deleteConfirmWrapper" class="w-100 d-none mb-3">
                                                        <label class="form-label">Type the lesson name to confirm deletion:</label>
                                                        <input type="text" id="deleteConfirmInput" class="form-control" placeholder="Type lesson name here...">
                                                        <small class="text-danger d-none" id="deleteConfirmError">Name does not match. Try again.</small>
                                                        <!-- The Confirm Delete button will be added here programmatically -->
                                                    </div>
                                                    
                                                    <!-- Hidden delete flag field -->
                                                    {{-- <input type="hidden" name="delete" id="deleteFlag" value="0"> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- The Confirm Delete button will be added here programmatically -->
                                        <button type="button" class="btn btn-danger d-none" id="confirmDeleteBtn">Confirm Delete</button>
                                        <button type="button" class="btn btn-danger" id="deleteLessonBtn">Delete Lesson</button>
                                        <button type="button" class="btn btn-secondary d-none" id="cancelDeleteBtn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--lessonEditModal modal end -->

                    <!--resourceAddModal modal start-->
                    <div aria-hidden="true" aria-labelledby="resourceAddModalLabel" class="modal fade" id="resourceAddModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="resourceAddModalLabel">New Resource</h1>
                                    <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal" type="button"></button>
                                </div>
                                <form id="resourceForm" method="POST" action="{{ route('resource.add_resource') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="resent-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <input type="hidden" name="lesson_id" id="lesson_id" value="">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Resource Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="name" name="name" placeholder="Resource name" type="text" required>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Description (Optional)</label>
                                                        <textarea class="form-control" id="desc" name="desc" placeholder="Description" rows="3"></textarea>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                                        <select class="form-select" id="category" name="category" required>
                                                            <option value="">Select Category</option>
                                                            <option value="1">Note</option>
                                                            <option value="2">Assignment</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Resource Type <span class="text-danger">*</span></label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="resource_type" id="type_file" value="file" checked>
                                                            <label class="form-check-label" for="type_file">
                                                                Upload File
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="resource_type" id="type_link" value="link">
                                                            <label class="form-check-label" for="type_link">
                                                                Provide Link/URL
                                                            </label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3" id="file_upload_section">
                                                        <label class="form-label">Upload File <span class="text-danger">*</span></label>
                                                        <div class="dropzone-container border rounded p-3">
                                                            <input type="file" name="file" id="file" class="form-control">
                                                            <input type="hidden" name="file_name" id="file_name">
                                                            <input type="hidden" name="file_type" id="file_type">
                                                            <div class="text-center text-muted mt-2">
                                                                <small>Supported formats: jpg, jpeg, png, gif, bmp, tiff, doc, docx, pdf, txt, rtf, odt, zip, rar, 7z (Max: 5MB)</small>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3" id="link_section" style="display: none;">
                                                        <label class="form-label">Resource Link/URL <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="link" name="link" placeholder="https://example.com/resource" type="url">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Add Resource</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--resourceAddModal modal end -->

                    <!--resourceEditModal modal start-->
                    <div aria-hidden="true" aria-labelledby="resourceEditModalLabel" class="modal fade" id="resourceEditModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="resourceEditModalLabel">Edit Resource</h1>
                                    <button aria-label="Close" class="btn-close m-0" data-bs-dismiss="modal" type="button"></button>
                                </div>
                                <form id="updateResourceForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">
                                        <div class="resent-form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div id="resourceEditFormWrapper">
                                                        <input type="hidden" name="resource_id" id="edit_resource_id" value="">
                                                        <input type="hidden" name="file_id" id="edit_file_id" value="">
                                                        <input type="hidden" name="delete" id="delete_flag" value="0">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Resource Name <span class="text-danger">*</span></label>
                                                            <input class="form-control" id="editResourceName" name="name" placeholder="Resource name" type="text" required>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Description (Optional)</label>
                                                            <textarea class="form-control" id="editResourceDescription" name="desc" placeholder="Description" rows="3"></textarea>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Category <span class="text-danger">*</span></label>
                                                            <select class="form-select" id="editResourceCategory" name="category" required>
                                                                <option value="">Select Category</option>
                                                                <option value="1">Note</option>
                                                                <option value="2">Assignment</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Resource Type <span class="text-danger">*</span></label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="resource_type" id="resourceType_file" value="file" checked>
                                                                <label class="form-check-label" for="resourceType_file">
                                                                    Upload File
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="resource_type" id="resourceType_link" value="link">
                                                                <label class="form-check-label" for="resourceType_link">
                                                                    Provide Link/URL
                                                                </label>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3" id="resource_file_upload_section">
                                                            <label class="form-label">Upload File <span class="text-muted">(Leave empty to keep existing file)</span></label>
                                                            <div class="dropzone-container border rounded p-3">
                                                                <input type="file" name="file" id="edit_resource_file" class="form-control">
                                                                <div class="text-center text-muted mt-2">
                                                                    <small>Supported formats: jpg, jpeg, png, gif, bmp, tiff, doc, docx, pdf, txt, rtf, odt, zip, rar, 7z (Max: 5MB)</small>
                                                                    <div class="input-group mt-3">
                                                                        <span class="input-group-text b-r-left text-bg-primary" id="basic-addon1">Existing file</span>
                                                                        <input type="text" class="form-control b-r-right" placeholder="No file uploaded" aria-label="Existing file"
                                                                            aria-describedby="basic-addon1" id="existing_file_info" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-3" id="resource_link_section" style="display: none;">
                                                            <label class="form-label">Resource Link/URL <span class="text-danger">*</span></label>
                                                            <input class="form-control" id="editResourceLink" name="link" placeholder="https://example.com/resource" type="url">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" id="deleteResourceBtn">Delete Resource</button>
                                        <button type="button" class="btn btn-danger d-none" id="confirmDeleteResourceBtn">Confirm Delete</button>
                                        <button type="button" class="btn btn-secondary d-none" id="cancelDeleteResourceBtn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="saveResourceChangesBtn">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--resourceEditModal modal end -->

                    <!-- rename modal  -->
                    <div aria-hidden="true" aria-labelledby="renameModalLabel" class="modal fade"
                        id="renameModal"
                        tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="renameModalLabel">Folder
                                        Rename</h1>
                                    <button aria-label="Close" class="btn-close m-0"
                                            data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="rename-form">
                                        <div class="row">
                                            <div class="col-12">
                                                <form id="renameForm">
                                                    <div class="mb-3">
                                                        <label class="form-label">Folder Name</label>
                                                        <input class="form-control" id="titlename"
                                                            placeholder="Title" type="text">
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal"
                                            type="button">Close
                                    </button>
                                    <button class="btn btn-light-primary" id="renamekey" type="button">
                                        Save
                                        changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- rename modal end  -->

                    <!-- delete-modal start  -->
                    <div aria-hidden="true" class="modal fade" id="apiDeletModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <img alt="" class="img-fluid"
                                        src="{{asset('../assets/images/icons/delete-icon.png')}}">
                                    <div class="text-center">
                                        <h4 class="text-danger f-w-600">Are You Sure?</h4>
                                        <p class="text-secondary f-s-16">You won't be able to revert
                                            this!</p>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal"
                                                type="button">Close
                                        </button>
                                        <button class="btn btn-light-primary" id="confirmDelete"
                                                type="button">Yes,Delet it
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- delete-modal-end-->

                    <!-- recent modal start  -->
                    <div aria-hidden="true" aria-labelledby="resentModalLabel" class="modal fade"
                        id="resentModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h1 class="modal-title fs-5 text-white" id="resentModalLabel">New
                                        File</h1>
                                    <button aria-label="Close" class="btn-close m-0"
                                            data-bs-dismiss="modal"
                                            type="button"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="resent-form">
                                        <div class="row">
                                            <div class="col-12">
                                                <form id="resentForm">
                                                    <div class="mb-3">
                                                        <label class="form-label">File Name</label>
                                                        <input class="form-control" id="recentname"
                                                            placeholder="Title" type="text">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal"
                                            type="button">Close
                                    </button>
                                    <button class="btn btn-light-primary" id="resentkey" type="button">
                                        Add New
                                        File
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- recent modal end  -->
                    
                </div>
            </div>
        </div>
        <!-- File manager end -->

        <!-- Resource card thumbnail style -->
        <style>
            /* Thumbnail container styles */
            .thumbnail-container {
                width: 100%;
                height: 140px; /* Fixed height */
                margin: 15px 0;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
                border-radius: 8px;
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
                border-radius: 8px;
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
            
            /* Resource name styling */
            .resource-name {
                font-size: 1rem;
                text-align: center;
                margin-top: 10px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            /* Stats styling */
            .resource-stats {
                display: flex;
                gap: 10px;
                font-size: 0.8rem;
            }
            
            .resource-stats span {
                display: flex;
                align-items: center;
                gap: 3px;
            }


            /* Modal styles */
            .web-preview {
                background-color: #f8f9fa;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
            }
            
            #resourcePreview {
                border: 1px solid #e9ecef;
                border-radius: 8px;
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            #commentsList {
                scrollbar-width: thin;
                scrollbar-color: #dee2e6 #f8f9fa;
            }
            
            #commentsList::-webkit-scrollbar {
                width: 6px;
            }
            
            #commentsList::-webkit-scrollbar-track {
                background: #f8f9fa;
            }
            
            #commentsList::-webkit-scrollbar-thumb {
                background-color: #dee2e6;
                border-radius: 6px;
            }

            .swal2-toast {
                width: auto !important;
                max-width: 100% !important;
                padding: 0.625em !important;
            }

            .dropzone-container {
                min-height: 100px;
                border: 2px dashed #ddd;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                transition: border-color 0.3s;
                cursor: pointer;
            }
            
            .dropzone-container:hover, .dropzone-container.border-primary {
                border-color: #3085d6 !important;
            }
            
            .dropzone-container input[type="file"] {
                width: 100%;
                padding: 10px;
            }
        </style>

    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function() {
            // Toggle between file upload and link sections
            $('input[name="resource_type"]').change(function() {
                if ($(this).val() === 'file') {
                    $('#file_upload_section').show();
                    $('#link_section').hide();
                    $('#link').removeAttr('required');
                    $('#file').attr('required', 'required');
                } else {
                    $('#file_upload_section').hide();
                    $('#link_section').show();
                    $('#file').removeAttr('required');
                    $('#link').attr('required', 'required');
                }
            });

            // When a file is selected, capture file name and type
            $('#file').change(function() {
                if (this.files && this.files[0]) {
                    var file = this.files[0];
                    $('#file_name').val(file.name);
                    $('#file_type').val(file.type);
                }
            });

            // Make the dropzone area support drag and drop
            const dropzoneContainer = document.querySelector('.dropzone-container');
            const fileInput = document.querySelector('#file');

            if (dropzoneContainer) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropzoneContainer.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzoneContainer.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzoneContainer.addEventListener(eventName, unhighlight, false);
                });

                function highlight() {
                    dropzoneContainer.classList.add('border-primary');
                }

                function unhighlight() {
                    dropzoneContainer.classList.remove('border-primary');
                }

                dropzoneContainer.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    fileInput.files = files;
                    
                    // Trigger change event on file input
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            }

            // Reset form when modal is closed
            $('#resourceAddModal').on('hidden.bs.modal', function() {
                $('#resourceForm')[0].reset();
                $('#file_upload_section').show();
                $('#link_section').hide();
                // Remove any validation styling
                $('.is-invalid').removeClass('is-invalid');
            });
        });

        function prepareResourceModal(lessonId) {
            // Set the lesson_id in the form
            $('#lesson_id').val(lessonId);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Toast notifications
            @if(session('success'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: "{{ session('success') }}",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: 'auto',
                    });
                }, 100);
            @endif
        
            @if(session('error'))
                setTimeout(() => {
                    Swal.fire({
                        icon: 'error',
                        title: "{{ session('error') }}",
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        width: 'auto',
                    });
                }, 100);
            @endif


            // Edit lesson modal
            const lessonEditModal = document.getElementById('lessonEditModal');
            let currentLessonName = '';

            lessonEditModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Extract data from button
                const lessonId = button.getAttribute('data-lesson-id');
                currentLessonName = button.getAttribute('data-lesson-name');
                const lessonDesc = button.getAttribute('data-lesson-desc');
                const lessonOutcome = button.getAttribute('data-lesson-learn-outcome');

                // Populate form fields - Using currentLessonName instead of undefined lessonName
                document.getElementById('editLessonName').value = currentLessonName || '';
                document.getElementById('editLessonDesc').value = lessonDesc || '';
                document.getElementById('editLessonLearnOutcome').value = lessonOutcome || '';

                // Set form action dynamically for update functionality
                const updateLessonform = document.getElementById('updateLessonForm');
                updateLessonform.action = `/course/course_detail/update_lesson/${lessonId}`; 
                updateLessonform.method = 'POST';
                
                // Store the lesson ID for delete functionality
                updateLessonform.dataset.lessonId = lessonId;

                // Reset UI elements
                document.getElementById('deleteConfirmInput').value = '';
                document.getElementById('deleteConfirmWrapper').classList.add('d-none');
                document.getElementById('deleteConfirmError').classList.add('d-none');
                document.getElementById('formFieldsWrapper').classList.remove('d-none');

                document.getElementById('deleteLessonBtn').classList.remove('d-none');
                document.getElementById('cancelDeleteBtn').classList.add('d-none');
                document.getElementById('saveChangesBtn').classList.remove('d-none');

                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

                // Add event listener for the new button
                confirmDeleteBtn.addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent any default action
                    
                    const input = document.getElementById('deleteConfirmInput');
                    const error = document.getElementById('deleteConfirmError');
                    
                    if (input.value.trim() === currentLessonName.trim()) {
                        submitDeleteForm();
                    } else {
                        error.classList.remove('d-none');
                    }
                });
            });

            // Handle delete click
            document.getElementById('deleteLessonBtn').addEventListener('click', function () {
                // Remove required attribute before hiding
                document.getElementById('editLessonName').removeAttribute('required');

                // Hide form fields
                document.getElementById('formFieldsWrapper').classList.add('d-none');
                
                // Hide save changes button
                document.getElementById('saveChangesBtn').classList.add('d-none');

                // Show delete confirm
                document.getElementById('deleteConfirmWrapper').classList.remove('d-none');

                // Toggle buttons
                this.classList.add('d-none');
                document.getElementById('confirmDeleteBtn').classList.remove('d-none');
                document.getElementById('cancelDeleteBtn').classList.remove('d-none');
            });

            // Handle delete confirmation (enter key)
            document.getElementById('deleteConfirmInput').addEventListener('keyup', function (e) {
                const input = this;
                const error = document.getElementById('deleteConfirmError');

                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault(); // Prevent form submission/page refresh
                    
                    if (input.value.trim() === currentLessonName.trim()) {
                        submitDeleteForm();
                    } else {
                        error.classList.remove('d-none');
                    }
                }
            });

            // Cancel delete mode
            document.getElementById('cancelDeleteBtn').addEventListener('click', function () {
                // Show form fields
                document.getElementById('formFieldsWrapper').classList.remove('d-none');
                
                // Show save changes button
                document.getElementById('saveChangesBtn').classList.remove('d-none');

                // Re-add required attribute
                document.getElementById('editLessonName').setAttribute('required', 'required');

                // Hide confirm input
                document.getElementById('deleteConfirmWrapper').classList.add('d-none');
                document.getElementById('confirmDeleteBtn').classList.add('d-none');
                document.getElementById('deleteConfirmError').classList.add('d-none');

                // Toggle buttons
                this.classList.add('d-none');
                document.getElementById('deleteLessonBtn').classList.remove('d-none');
            });

            // Function to submit delete form with the separate route
            function submitDeleteForm() {
                const lessonId = document.getElementById('updateLessonForm').dataset.lessonId;
                
                // Create a new form for deletion
                const deleteForm = document.createElement('form');
                deleteForm.method = 'POST';
                deleteForm.action = `/course/course_detail/delete_lesson/${lessonId}`;
                deleteForm.style.display = 'none';
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                document.querySelector('input[name="_token"]')?.value;
                
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    deleteForm.appendChild(csrfInput);
                }
                
                // Append form to body, submit it, then remove it
                document.body.appendChild(deleteForm);
                deleteForm.submit();
                document.body.removeChild(deleteForm);
            }

            // Resource detail modal
            const resourceModal = document.getElementById('resourceDetailModal');
            let commentFormSubmitHandler = null; // Store the reference to the event handler
            
            resourceModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                console.log('relatedTarget:', button); // Check if null or undefined

                // Extract all data attributes
                const resourceData = {
                    id: button.getAttribute('data-resource-id'),
                    name: button.getAttribute('data-resource-name'),
                    description: button.getAttribute('data-resource-description'),
                    category: button.getAttribute('data-resource-category'),
                    type: button.getAttribute('data-resource-type'),
                    fileName: button.getAttribute('data-resource-file-name'),
                    path: button.getAttribute('data-resource-path'),
                    views: button.getAttribute('data-resource-views'),
                    downloads: button.getAttribute('data-resource-downloads'),
                    comments: button.getAttribute('data-resource-comments'),
                    created: button.getAttribute('data-resource-created')
                };
                
                // Update modal header
                resourceModal.querySelector('.modal-title').textContent = resourceData.name;
                
                // Update stats
                document.getElementById('viewsCount').textContent = resourceData.views;
                document.getElementById('downloadsCount').textContent = resourceData.downloads;
                document.getElementById('commentsCount').textContent = resourceData.comments;
                
                // Update resource info
                document.getElementById('resourceName').textContent = resourceData.name;
                document.getElementById('resourceDescription').textContent = resourceData.description || 'No description available';
                document.getElementById('resourceCreated').textContent = `Uploaded on ${resourceData.created}`;
                
                // Set download link
                const downloadBtn = document.getElementById('downloadBtn');
                downloadBtn.href = resourceData.path;
                downloadBtn.download = resourceData.name + '.' + resourceData.type;
                downloadBtn.innerHTML = `<i class="ti ti-download me-1"></i> Download`;

                // Set edit button
                const editBtn = document.querySelector('#resourceDetailModal button[data-bs-target="#resourceEditModal"]');

                if (editBtn) {
                    editBtn.setAttribute('data-resource-id', resourceData.id);
                    editBtn.setAttribute('data-resource-name', resourceData.name);
                    editBtn.setAttribute('data-resource-description', resourceData.description);
                    editBtn.setAttribute('data-resource-category', resourceData.category);
                    editBtn.setAttribute('data-resource-type', resourceData.type);
                    editBtn.setAttribute('data-resource-file-name', resourceData.fileName);
                    editBtn.setAttribute('data-resource-path', resourceData.path);
                    editBtn.setAttribute('data-resource-views', resourceData.views);
                    editBtn.setAttribute('data-resource-downloads', resourceData.downloads);
                    editBtn.setAttribute('data-resource-comments', resourceData.comments);
                    editBtn.setAttribute('data-resource-created', resourceData.created);
                }

                
                // Handle preview based on type
                const previewContainer = document.getElementById('resourcePreview');
                previewContainer.innerHTML = '';
                
                if (resourceData.type === 'link') {
                    if (resourceData.path.includes('youtube.com') || resourceData.path.includes('youtu.be')) {
                        // YouTube embed
                        const videoId = resourceData.path.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/)[1];
                        previewContainer.innerHTML = `
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/${videoId}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen></iframe>
                            </div>
                        `;

                        downloadBtn.innerHTML = '<i class="ti ti-link me-1"></i> Open On YouTube';
                    } else {
                        // Regular website link
                        previewContainer.innerHTML = `
                            <div class="web-preview h-100 d-flex flex-column align-items-center justify-content-center p-3 rounded" 
                                style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                <i class="ph-bold ph-globe text-primary mb-2" style="font-size: 3rem;"></i>
                                <h5 class="mb-2">External Link</h5>
                                <div style="width: 100%; max-width: 250px;">
                                    <a href="${resourceData.path}" 
                                    target="_blank" 
                                    class="text-truncate d-block small"
                                    style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; color: #0d6efd; text-decoration: none;">
                                    ${resourceData.path}
                                    </a>
                                </div>
                                <small class="text-muted mt-2">Click to open in new tab</small>
                            </div>
                        `;

                        downloadBtn.innerHTML = '<i class="ti ti-link me-1"></i> Open Link';
                    }
                } else if (['jpg', 'jpeg', 'png', 'gif', 'svg'].includes(resourceData.type.toLowerCase())) {
                    // Image preview
                    previewContainer.innerHTML = `
                        <div class="text-center">
                            <img src="${resourceData.path}" 
                                class="img-fluid rounded" 
                                style="max-height: 250px;"
                                alt="${resourceData.name}">
                        </div>
                    `;
                } else if (resourceData.type.toLowerCase() === 'pdf') {
                    // PDF preview
                    previewContainer.innerHTML = `
                        <div class="ratio ratio-16x9">
                            <iframe src="${resourceData.path}#view=fitH" 
                                    class="w-100 h-100"></iframe>
                        </div>
                    `;
                } else {
                    // Default file preview
                    previewContainer.innerHTML = `
                        <div class="text-center py-4">
                            <i class="ph-bold ph-file text-primary" style="font-size: 3rem;"></i>
                            <h5 class="mt-2">${resourceData.name}</h5>
                            <p class="text-muted">${resourceData.type.toUpperCase()} File</p>
                        </div>
                    `;
                }

                // Set resource ID for comment form
                document.getElementById('commentResourceId').value = resourceData.id;
                
                // Clear existing comments immediately
                const commentsList = document.getElementById('commentsList');
                commentsList.innerHTML = '';
                
                // Show a loading spinner
                commentsList.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading comments...</p>
                    </div>
                `;

                // Load comments for this specific resource
                loadComments(resourceData.id);
                
                // Remove any existing event listener on comment form before adding a new one
                const commentForm = document.getElementById('commentForm');
                if (commentFormSubmitHandler) {
                    commentForm.removeEventListener('submit', commentFormSubmitHandler);
                }
                
                // Create new event handler for this specific resource
                commentFormSubmitHandler = function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const currentResourceId = formData.get('resource_id');
                    
                    // Show loading indicator on the button
                    const submitBtn = commentForm.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Posting...';
                    
                    fetch('/course/comment/store_comment', {
                        method: 'POST',
                        credentials: 'include', // Crucial for cookies
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            // 'Authorization': 'Bearer ' + localStorage.getItem('auth_token') // If using Sanctum
                        },
                        body: JSON.stringify({
                            resource_id: currentResourceId,
                            content: formData.get('content')
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.success) {
                            // Clear input field
                            const commentInput = document.querySelector('#commentForm input[name="content"]');
                            const commentContent = commentInput.value;
                            commentInput.value = '';
                            
                            // Update counts
                            const commentsCount = document.getElementById('commentsCount');
                            const currentCount = parseInt(commentsCount.textContent) || 0;
                            const newCount = currentCount + 1;
                            commentsCount.textContent = newCount;
                            
                            // Remove "no comments" message if it exists
                            const noComments = document.getElementById('noComments');
                            if (noComments) {
                                noComments.remove();
                            }
                            
                            // Add the new comment to the list
                            const commentsList = document.getElementById('commentsList');
                            
                            // Get current user info from the form area
                            const userImg = commentForm.querySelector('img').src;
                            
                            // Use the correct property names from the backend response
                            const commentText = data.comment ? data.comment.content : commentContent;
                            const commentId = data.comment ? data.comment.id : new Date().getTime();
                            const userName = data.comment ? data.comment.user_name : "Current User";
                            const userImage = data.comment ? data.comment.user_image : userImg;
                            const createdAt = data.comment ? data.comment.created_at : 'Just now';
                            
                            const newCommentHtml = `
                                <div class="d-flex mb-3" id="comment-${commentId}">
                                    <img src="${userImage}" 
                                        class="rounded-circle me-3" width="40" height="40" alt="User">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">${userName}</h6>
                                            <small class="text-muted mr-2"> ${createdAt}</small>
                                        </div>
                                        <p class="mb-1">${commentText}</p>
                                        <div class="d-flex gap-2">
                                            <a href="#" class="text-muted fs-12">Like</a>
                                            <a href="#" class="text-muted fs-12">Reply</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            // Prepend to show newest comments at the top
                            commentsList.insertAdjacentHTML('afterbegin', newCommentHtml);
                            
                            // Add highlight animation to new comment
                            setTimeout(() => {
                                const newComment = document.getElementById(`comment-${commentId}`);
                                if (newComment) {
                                    newComment.style.transition = 'background-color 1s ease';
                                    newComment.style.backgroundColor = '#f0f8ff';
                                    setTimeout(() => {
                                        newComment.style.backgroundColor = 'transparent';
                                    }, 1500);
                                }
                            }, 100);
                        } else {
                            // Show error if the server returned success: false
                            alert('Failed to post comment. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to post comment. Please try again.');
                    })
                    .finally(() => {
                        // Restore button state
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
                };
                
                // Add the new event listener
                commentForm.addEventListener('submit', commentFormSubmitHandler);
            });
            
            // Handle modal close - optional cleanup
            resourceModal.addEventListener('hidden.bs.modal', function() {
                // Clear comments when modal is closed to avoid confusion
                document.getElementById('commentsList').innerHTML = '';
            });
            
            // Function to load comments for a specific resource
            function loadComments(resourceId) {
                fetch(`/course/comment/resource/${resourceId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('commentsCount').textContent = data.comments.length;

                        const commentsList = document.getElementById('commentsList');
                        commentsList.innerHTML = ''; // Clear loading spinner

                        if (data.comments && data.comments.length > 0) {
                            // Sort comments by most recent first (if needed)
                            data.comments.sort((a, b) => {
                                // Assuming created_at is a string that can be compared
                                return new Date(b.created_at_raw || b.created_at) - new Date(a.created_at_raw || a.created_at);
                            });
                            
                            data.comments.forEach(comment => {
                                const commentHtml = `
                                    <div class="d-flex mb-3" id="comment-${comment.id}">
                                        <img src="${comment.user_image}" 
                                            class="rounded-circle me-3" width="40" height="40" alt="User">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">${comment.user_name}</h6>
                                                <small class="text-muted mr-2"> ${comment.created_at}</small>
                                            </div>
                                            <p class="mb-1">${comment.content}</p>
                                            <div class="d-flex gap-2">
                                                <a href="#" class="text-muted fs-12">Like</a>
                                                <a href="#" class="text-muted fs-12">Reply</a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                commentsList.insertAdjacentHTML('beforeend', commentHtml);
                            });
                        } else {
                            // Show "No comments" message if empty
                            commentsList.innerHTML = `
                                <div class="text-center py-3" id="noComments">
                                    <i class="ti ti-message-off fs-5 text-muted"></i>
                                    <p class="text-muted mt-2">No comments yet</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading comments:', error);
                        const commentsList = document.getElementById('commentsList');
                        commentsList.innerHTML = `
                            <div class="text-center py-3 text-danger">
                                <i class="ti ti-alert-circle fs-5"></i>
                                <p class="mt-2">Failed to load comments</p>
                            </div>
                        `;
                    });
            }

            // Handle resource edit modal
            const resourceEditModal = document.getElementById('resourceEditModal');
            if (!resourceEditModal) return;

            // Initialize modal when shown
            resourceEditModal.addEventListener('shown.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (!button) return;
                
                // Extract all data attributes
                const resourceData = {
                    id: button.getAttribute('data-resource-id'),
                    name: button.getAttribute('data-resource-name'),
                    description: button.getAttribute('data-resource-description'),
                    category: button.getAttribute('data-resource-category'),
                    type: button.getAttribute('data-resource-type'),
                    fileId: button.getAttribute('data-resource-file-id'),
                    fileName: button.getAttribute('data-resource-file-name'),
                    path: button.getAttribute('data-resource-path'),
                    link: button.getAttribute('data-resource-link'),
                    views: button.getAttribute('data-resource-views'),
                    downloads: button.getAttribute('data-resource-downloads')
                };
                
                // Update modal header
                resourceEditModal.querySelector('.modal-title').textContent = "Edit Resource: " + resourceData.name;
                
                // Fill hidden fields
                document.getElementById('edit_resource_id').value = resourceData.id || '';
                document.getElementById('edit_file_id').value = resourceData.fileId || '';
                document.getElementById('delete_flag').value = '0'; // Reset delete flag
                
                // Fill basic inputs
                document.getElementById('editResourceName').value = resourceData.name || '';
                document.getElementById('editResourceDescription').value = resourceData.description || '';
                document.getElementById('editResourceCategory').value = resourceData.category || '';
                
                // Reset UI for delete
                document.getElementById('deleteResourceBtn').classList.remove('d-none');
                document.getElementById('confirmDeleteResourceBtn').classList.add('d-none');
                document.getElementById('cancelDeleteResourceBtn').classList.add('d-none');
                document.getElementById('saveResourceChangesBtn').classList.remove('d-none');
                
                // Determine and set resource type
                if (resourceData.type === 'link') {
                    // Select link radio
                    document.getElementById('resourceType_link').checked = true;
                    
                    // Show/hide appropriate sections
                    document.getElementById('resource_file_upload_section').style.display = 'none';
                    document.getElementById('resource_link_section').style.display = 'block';
                    
                    // Set link value
                    document.getElementById('editResourceLink').value = resourceData.link || resourceData.path || '';
                } else {
                    // Default to file type
                    document.getElementById('resourceType_file').checked = true;
                    
                    // Show/hide appropriate sections
                    document.getElementById('resource_file_upload_section').style.display = 'block';
                    document.getElementById('resource_link_section').style.display = 'none';
                    
                    // Show file name as information
                    document.getElementById('existing_file_info').value = resourceData.fileName || 'No file uploaded';
                }
                
                // Set form action URL
                const updateResourceForm = document.getElementById('updateResourceForm');
                updateResourceForm.action = `/course/resource/update_resource/${resourceData.id}`;
            });
            
            // Handle resource type radio change
            document.querySelectorAll('input[name="resource_type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'file') {
                        document.getElementById('resource_file_upload_section').style.display = 'block';
                        document.getElementById('resource_link_section').style.display = 'none';
                    } else if (this.value === 'link') {
                        document.getElementById('resource_file_upload_section').style.display = 'none';
                        document.getElementById('resource_link_section').style.display = 'block';
                    }
                });
            });
            
            // Handle delete button click
            const deleteResourceBtn = document.getElementById('deleteResourceBtn');
            const confirmDeleteResourceBtn = document.getElementById('confirmDeleteResourceBtn');
            const cancelDeleteResourceBtn = document.getElementById('cancelDeleteResourceBtn');
            const saveResourceChangesBtn = document.getElementById('saveResourceChangesBtn');
            
            deleteResourceBtn.addEventListener('click', function() {
                // Show confirmation and hide regular buttons
                this.classList.add('d-none');
                confirmDeleteResourceBtn.classList.remove('d-none');
                cancelDeleteResourceBtn.classList.remove('d-none');
                saveResourceChangesBtn.classList.add('d-none');
            });
            
            // Handle cancel delete
            cancelDeleteResourceBtn.addEventListener('click', function() {
                // Restore regular buttons
                deleteResourceBtn.classList.remove('d-none');
                confirmDeleteResourceBtn.classList.add('d-none');
                cancelDeleteResourceBtn.classList.add('d-none');
                saveResourceChangesBtn.classList.remove('d-none');
            });
            
            // Handle confirm delete
            confirmDeleteResourceBtn.addEventListener('click', function() {
                // Set delete flag and submit form
                document.getElementById('delete_flag').value = '1';
                document.getElementById('updateResourceForm').submit();
            });
        });
    </script>    

    <!--customizer-->
    <div id="customizer"></div>

    <!-- apexcharts-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Tooltip js  -->
    <script src="{{asset('assets/js/tooltips_popovers.js')}}"></script>

    <!-- sweetalert js-->
    <script src="{{asset('assets/vendor/sweetalert/sweetalert.js')}}"></script>

    <!--js-->
    {{-- <script src="{{asset('assets/js/filemanager.js')}}"></script> --}}
    <script src="{{asset('assets/js/course/lesson/lesson_list.js')}}"></script>

@endsection
